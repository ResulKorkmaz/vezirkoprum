<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Http\Requests\MessageSendRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $messages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->paginate(10);
        return view('messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        return view('messages.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageSendRequest $request)
    {
        $data = $request->validated();
        $data['sender_id'] = Auth::id();
        $message = Message::create($data);
        return redirect()->route('messages.show', $message->id)->with('success', 'Mesaj gönderildi.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $message = Message::findOrFail($id);
        
        // Manuel authorization kontrolü
        if (Auth::id() !== $message->sender_id && Auth::id() !== $message->receiver_id) {
            abort(403, 'Bu mesajı görüntüleme yetkiniz yok.');
        }
        
        if (!$message->is_read && $message->receiver_id === Auth::id()) {
            $message->update(['is_read' => true, 'read_at' => now()]);
        }
        return view('messages.show', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        
        // Manuel authorization kontrolü
        if (Auth::id() !== $message->sender_id && Auth::id() !== $message->receiver_id) {
            abort(403, 'Bu mesajı silme yetkiniz yok.');
        }
        
        $message->delete();
        return redirect()->route('messages.index')->with('success', 'Mesaj silindi.');
    }

    /**
     * Bulk delete messages
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:messages,id'
        ]);

        $messageIds = $request->message_ids;
        $userId = Auth::id();
        
        // Sadece kullanıcının kendi mesajlarını silebilir
        $messages = Message::whereIn('id', $messageIds)
            ->where(function($query) use ($userId) {
                $query->where('sender_id', $userId)
                      ->orWhere('receiver_id', $userId);
            })
            ->get();

        $deletedCount = $messages->count();
        
        if ($deletedCount === 0) {
            return redirect()->route('messages.index')->with('error', 'Silme yetkiniz olmayan mesajlar seçildi.');
        }

        // Mesajları sil
        Message::whereIn('id', $messages->pluck('id'))->delete();

        return redirect()->route('messages.index')->with('success', "{$deletedCount} mesaj silindi.");
    }
}
