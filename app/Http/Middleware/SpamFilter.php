<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\SpamDetectionService;
use Illuminate\Support\Facades\Log;

class SpamFilter
{
    protected $spamDetection;

    public function __construct(SpamDetectionService $spamDetection)
    {
        $this->spamDetection = $spamDetection;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Sadece POST işlemlerini kontrol et
        if ($request->isMethod('post') && $request->has('content')) {
            $content = $request->input('content');
            $userId = auth()->id();

            // İçeriği analiz et
            $analysis = $this->spamDetection->analyzeContent($content, $userId);

            // Spam skorunu loglayalım
            Log::info('Spam Analysis', [
                'user_id' => $userId,
                'score' => $analysis['score'],
                'status' => $analysis['status'],
                'reasons' => $analysis['reasons']
            ]);

            // Eğer score çok yüksekse isteği reddet
            if ($analysis['score'] >= SpamDetectionService::QUARANTINE_THRESHOLD) {
                return response()->json([
                    'error' => 'İçeriğiniz otomatik spam filtresine takıldı. Lütfen içeriğinizi gözden geçirin.',
                    'score' => $analysis['score'],
                    'reasons' => $analysis['reasons']
                ], 422);
            }

            // Spam analiz sonuçlarını request'e ekle
            $request->merge(['spam_analysis' => $analysis]);
        }

        return $next($request);
    }
}
