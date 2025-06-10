<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    protected $secretKey;
    protected $siteKey;
    protected $enabled;
    protected $scoreThreshold;
    protected $timeout;

    public function __construct()
    {
        $this->secretKey = config('recaptcha.secret_key');
        $this->siteKey = config('recaptcha.site_key');
        $this->enabled = config('recaptcha.enabled');
        $this->scoreThreshold = config('recaptcha.score_threshold');
        $this->timeout = config('recaptcha.timeout');
    }

    /**
     * reCAPTCHA token'ını doğrula
     */
    public function verify(string $token, ?string $action = null, ?string $ip = null): array
    {
        // reCAPTCHA devre dışıysa başarılı dön
        if (!$this->enabled || empty($this->secretKey)) {
            return [
                'success' => true,
                'score' => 1.0,
                'action' => $action,
                'message' => 'reCAPTCHA disabled'
            ];
        }

        try {
            $response = Http::timeout($this->timeout)
                ->asForm()
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $this->secretKey,
                    'response' => $token,
                    'remoteip' => $ip
                ]);

            $result = $response->json();

            if (!$response->successful() || !$result) {
                Log::warning('reCAPTCHA API request failed', [
                    'status' => $response->status(),
                    'response' => $result
                ]);

                return [
                    'success' => false,
                    'score' => 0.0,
                    'action' => $action,
                    'message' => 'reCAPTCHA verification failed'
                ];
            }

            $success = $result['success'] ?? false;
            $score = $result['score'] ?? 0.0;
            $responseAction = $result['action'] ?? '';

            // Test keys için action kontrolünü atla
            $isTestKey = $this->siteKey === '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI';

            // Action kontrolü (eğer belirtilmişse ve test key değilse)
            if ($action && $responseAction !== $action && !$isTestKey) {
                Log::warning('reCAPTCHA action mismatch', [
                    'expected' => $action,
                    'received' => $responseAction
                ]);

                return [
                    'success' => false,
                    'score' => $score,
                    'action' => $responseAction,
                    'message' => 'Action mismatch'
                ];
            }

            // Score kontrolü
            if ($success && $score < $this->scoreThreshold) {
                // Test keys için score kontrolünü atla
                if (!$isTestKey) {
                    Log::warning('reCAPTCHA score too low', [
                        'score' => $score,
                        'threshold' => $this->scoreThreshold,
                        'action' => $action
                    ]);

                    return [
                        'success' => false,
                        'score' => $score,
                        'action' => $responseAction,
                        'message' => 'Score too low'
                    ];
                }
            }

            return [
                'success' => $success,
                'score' => $score,
                'action' => $responseAction,
                'message' => $success ? 'Verification successful' : 'Verification failed'
            ];

        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification error', [
                'error' => $e->getMessage(),
                'action' => $action
            ]);

            return [
                'success' => false,
                'score' => 0.0,
                'action' => $action,
                'message' => 'Verification error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Site key'i al
     */
    public function getSiteKey(): string
    {
        return $this->siteKey;
    }

    /**
     * reCAPTCHA aktif mi?
     */
    public function isEnabled(): bool
    {
        return $this->enabled && !empty($this->secretKey) && !empty($this->siteKey);
    }

    /**
     * Score threshold'u al
     */
    public function getScoreThreshold(): float
    {
        return $this->scoreThreshold;
    }
} 