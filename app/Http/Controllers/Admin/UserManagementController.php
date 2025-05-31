<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BannedUser;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserManagementController extends Controller
{
    /**
     * Kullanıcı listesi
     */
    public function index(Request $request)
    {
        $query = User::with(['profession', 'suspendedBy']);

        // Arama filtreleri
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('unique_user_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_suspended', false);
                    break;
                case 'suspended':
                    $query->where('is_suspended', true);
                    break;
                case 'admin':
                    $query->where('is_admin', true);
                    break;
            }
        }

        if ($request->filled('city')) {
            $query->where('current_city', $request->city);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);
        $cities = array_keys(config('turkiye.cities', []));

        return view('admin.users.index', compact('users', 'cities'));
    }

    /**
     * Kullanıcı detayları
     */
    public function show(User $user)
    {
        $user->load(['profession', 'suspendedBy', 'sentMessages', 'receivedMessages']);
        
        // Yasaklı kullanıcı kayıtları
        $bannedRecords = BannedUser::where('email', $user->email)->get();
        
        return view('admin.users.show', compact('user', 'bannedRecords'));
    }

    /**
     * Kullanıcı düzenleme formu
     */
    public function edit(User $user)
    {
        $professions = Profession::orderBy('name')->get();
        $cities = array_keys(config('turkiye.cities', []));
        
        return view('admin.users.edit', compact('user', 'professions', 'cities'));
    }

    /**
     * Kullanıcı güncelleme
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profession_id' => 'nullable|exists:professions,id',
            'retirement_detail' => 'nullable|string|max:255',
            'current_city' => 'nullable|string',
            'current_district' => 'nullable|string',
            'birth_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'bio' => 'nullable|string|max:1000',
            'show_phone' => 'boolean',
            'is_admin' => 'boolean',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $user->update($request->only([
            'name', 'email', 'profession_id', 'retirement_detail', 'current_city', 'current_district',
            'birth_year', 'bio', 'show_phone', 'is_admin', 'admin_notes'
        ]));

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Kullanıcı bilgileri başarıyla güncellendi.');
    }

    /**
     * Şifre sıfırlama formu
     */
    public function showResetPasswordForm(User $user)
    {
        return view('admin.users.reset-password', compact('user'));
    }

    /**
     * Şifre sıfırlama
     */
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Yeni şifre gereklidir.',
            'password.min' => 'Şifre en az 8 karakter olmalıdır.',
            'password.confirmed' => 'Şifre onayı eşleşmiyor.',
        ]);

        $user->resetPassword($request->password);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Kullanıcının şifresi başarıyla sıfırlandı.');
    }

    /**
     * Askıya alma formu
     */
    public function showSuspendForm(User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users.show', $user)
                ->with('error', 'Admin kullanıcılar askıya alınamaz.');
        }

        return view('admin.users.suspend', compact('user'));
    }

    /**
     * Kullanıcıyı askıya al
     */
    public function suspend(Request $request, User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users.show', $user)
                ->with('error', 'Admin kullanıcılar askıya alınamaz.');
        }

        $request->validate([
            'reason' => 'required|string|max:1000',
            'duration' => 'required|in:3_months,permanent',
        ], [
            'reason.required' => 'Askıya alma sebebi gereklidir.',
            'duration.required' => 'Askı süresi seçilmelidir.',
        ]);

        $until = null;
        if ($request->duration === '3_months') {
            $until = now()->addMonths(3);
        }

        $user->suspend($request->reason, auth()->id(), $until);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Kullanıcı başarıyla askıya alındı.');
    }

    /**
     * Askıyı kaldır
     */
    public function unsuspend(User $user)
    {
        $user->unsuspend();

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Kullanıcının askısı başarıyla kaldırıldı.');
    }

    /**
     * Kalıcı yasaklama formu
     */
    public function showBanForm(User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users.show', $user)
                ->with('error', 'Admin kullanıcılar yasaklanamaz.');
        }

        return view('admin.users.ban', compact('user'));
    }

    /**
     * Kullanıcıyı kalıcı yasakla
     */
    public function ban(Request $request, User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users.show', $user)
                ->with('error', 'Admin kullanıcılar yasaklanamaz.');
        }

        $request->validate([
            'reason' => 'required|string|max:1000',
        ], [
            'reason.required' => 'Yasaklama sebebi gereklidir.',
        ]);

        // Yasaklı kullanıcılar listesine ekle
        BannedUser::banUser($user, $request->reason, auth()->id());

        // Kullanıcıyı askıya al (süresiz)
        $user->suspend($request->reason, auth()->id());

        // Kullanıcının verilerini arşivle
        $user->archiveUserData('Kalıcı yasaklama: ' . $request->reason);

        // Kullanıcı adını sakla
        $userName = $user->name;

        // Kullanıcıyı sil
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', '1 kullanıcı (' . $userName . ') kalıcı olarak yasaklandı ve hesabı silindi.');
    }

    /**
     * Yasaklı kullanıcılar listesi
     */
    public function bannedUsers()
    {
        $bannedUsers = BannedUser::with('bannedBy')
            ->orderBy('banned_at', 'desc')
            ->paginate(20);

        return view('admin.users.banned', compact('bannedUsers'));
    }

    /**
     * Yasaklı kullanıcı detayları
     */
    public function showBannedUser(BannedUser $bannedUser)
    {
        return view('admin.users.banned-show', compact('bannedUser'));
    }

    /**
     * Yasağı kaldır
     */
    public function unban(BannedUser $bannedUser)
    {
        $bannedUser->delete();

        return redirect()->route('admin.users.banned')
            ->with('success', 'Kullanıcının yasağı başarıyla kaldırıldı.');
    }

    /**
     * Kullanıcı silme formu
     */
    public function showDeleteForm(User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users.show', $user)
                ->with('error', 'Admin kullanıcılar silinemez.');
        }

        return view('admin.users.delete', compact('user'));
    }

    /**
     * Kullanıcıyı sil
     */
    public function destroy(Request $request, User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users.show', $user)
                ->with('error', 'Admin kullanıcılar silinemez.');
        }

        $request->validate([
            'admin_password' => 'required|string',
            'reason' => 'required|string|max:1000',
        ], [
            'admin_password.required' => 'Admin şifresi gereklidir.',
            'reason.required' => 'Silme sebebi gereklidir.',
        ]);

        // Admin şifresini doğrula
        if (!Hash::check($request->admin_password, auth()->user()->password)) {
            return back()->withErrors(['admin_password' => 'Admin şifresi yanlış.']);
        }

        // Kullanıcının verilerini arşivle
        $user->archiveUserData('Kullanıcı silindi: ' . $request->reason);

        // Kullanıcıyı sil
        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', '1 kullanıcı (' . $userName . ') başarıyla silindi.');
    }

    /**
     * Toplu silme formu
     */
    public function showBulkDeleteForm(Request $request)
    {
        $userIds = $request->input('user_ids', []);
        
        if (empty($userIds)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Silinecek kullanıcı seçilmedi.');
        }

        $users = User::whereIn('id', $userIds)
            ->where('is_admin', false) // Admin kullanıcıları hariç tut
            ->get();

        if ($users->isEmpty()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Silinebilir kullanıcı bulunamadı.');
        }

        return view('admin.users.bulk-delete', compact('users'));
    }

    /**
     * Toplu silme işlemi
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'admin_password' => 'required|string',
            'reason' => 'required|string|max:1000',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ], [
            'admin_password.required' => 'Admin şifresi gereklidir.',
            'reason.required' => 'Silme sebebi gereklidir.',
            'user_ids.required' => 'Silinecek kullanıcılar seçilmelidir.',
        ]);

        // Admin şifresini doğrula
        if (!Hash::check($request->admin_password, auth()->user()->password)) {
            return back()->withErrors(['admin_password' => 'Admin şifresi yanlış.']);
        }

        $users = User::whereIn('id', $request->user_ids)
            ->where('is_admin', false) // Admin kullanıcıları hariç tut
            ->get();

        $deletedCount = 0;
        $deletedNames = [];
        
        foreach ($users as $user) {
            // Kullanıcının verilerini arşivle
            $user->archiveUserData('Toplu silme: ' . $request->reason);
            $deletedNames[] = $user->name;
            $user->delete();
            $deletedCount++;
        }

        $message = $deletedCount . ' kullanıcı başarıyla silindi.';
        
        // Eğer 5'ten az kullanıcı silindiyse isimlerini de göster
        if ($deletedCount <= 5 && !empty($deletedNames)) {
            $message .= ' (' . implode(', ', $deletedNames) . ')';
        }

        return redirect()->route('admin.users.index')
            ->with('success', $message);
    }
}
