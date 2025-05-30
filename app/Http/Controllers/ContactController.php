<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Form validasyonu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'Ad soyad alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'subject.required' => 'Konu alanı zorunludur.',
            'message.required' => 'Mesaj alanı zorunludur.',
            'message.max' => 'Mesaj en fazla 2000 karakter olabilir.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Sistem kullanıcısını bul veya oluştur
            $systemUser = User::firstOrCreate(
                ['email' => 'system@vezirkoprum.com.tr'],
                [
                    'name' => 'Sistem',
                    'email' => 'system@vezirkoprum.com.tr',
                    'password' => bcrypt('system_password_' . time()),
                    'email_verified_at' => now(),
                    'is_admin' => false,
                ]
            );

            // Admin kullanıcıları bul (email'i admin@ ile başlayanlar veya is_admin=true olanlar)
            $adminUsers = User::where('email', 'like', 'admin%')
                             ->orWhere('is_admin', true)
                             ->get();

            // Eğer admin bulunamazsa, ilk kullanıcıyı admin olarak kabul et
            if ($adminUsers->isEmpty()) {
                $adminUsers = User::orderBy('id')->limit(1)->get();
            }

            $contactData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'sent_at' => now()->format('d.m.Y H:i')
            ];

            $messageContent = "İletişim Formu Mesajı\n\n";
            $messageContent .= "Ad Soyad: {$contactData['name']}\n";
            $messageContent .= "E-posta: {$contactData['email']}\n";
            $messageContent .= "Konu: {$contactData['subject']}\n\n";
            $messageContent .= "Mesaj:\n{$contactData['message']}\n\n";
            $messageContent .= "---\n";
            $messageContent .= "Gönderim Tarihi: {$contactData['sent_at']}\n";
            $messageContent .= "IP Adresi: {$contactData['ip_address']}\n";

            // Her admin kullanıcısına mesaj gönder
            foreach ($adminUsers as $admin) {
                Message::create([
                    'sender_id' => $systemUser->id, // Sistem kullanıcısı olarak gönder
                    'receiver_id' => $admin->id,
                    'subject' => "İletişim Formu: {$contactData['subject']}",
                    'content' => $messageContent,
                    'is_read' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Mesajınız başarıyla gönderildi!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Contact form error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Mesaj gönderilirken bir hata oluştu.'
            ], 500);
        }
    }
}
