<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsappGroup;
use App\Http\Requests\WhatsappGroupRequest;
use Illuminate\Support\Facades\Auth;

class WhatsappController extends Controller
{
    /**
     * Display a listing of WhatsApp groups.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Admin ise tüm grupları göster
        if ($user && $user->is_admin && request()->route()->getPrefix() === 'admin') {
            $groups = WhatsappGroup::all();
        } else {
            // Normal kullanıcılar sadece kendi şehirlerindeki aktif grupları görebilir
            $query = WhatsappGroup::where('is_active', true);
            
            if ($user && $user->current_city) {
                $query->where('city', $user->current_city);
            } else {
                // Şehir bilgisi olmayan kullanıcılar hiçbir grup göremez
                $query->where('id', 0); // Hiçbir sonuç döndürmez
            }
            
            $groups = $query->get();
        }
        
        return view('whatsapp.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Bu işlem için yetkiniz bulunmamaktadır.');
        }
        return view('whatsapp.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WhatsappGroupRequest $request)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Bu işlem için yetkiniz bulunmamaktadır.');
        }
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $group = WhatsappGroup::create($data);
        return redirect()->route('whatsapp.index')->with('success', 'Grup başarıyla eklendi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WhatsappGroup $whatsapp)
    {
        return view('whatsapp.show', ['group' => $whatsapp]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WhatsappGroup $whatsapp)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Bu işlem için yetkiniz bulunmamaktadır.');
        }
        return view('whatsapp.edit', ['group' => $whatsapp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WhatsappGroupRequest $request, WhatsappGroup $whatsapp)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Bu işlem için yetkiniz bulunmamaktadır.');
        }
        $whatsapp->update($request->validated());
        return redirect()->route('whatsapp.index')->with('success', 'Grup başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WhatsappGroup $whatsapp)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Bu işlem için yetkiniz bulunmamaktadır.');
        }
        $whatsapp->delete();
        return redirect()->route('whatsapp.index')->with('success', 'Grup başarıyla silindi.');
    }
}
