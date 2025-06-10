<?php

namespace App\Rules;

use App\Services\RecaptchaService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RecaptchaRule implements ValidationRule
{
    protected $action;
    protected $recaptchaService;

    public function __construct(string $action = null)
    {
        $this->action = $action;
        $this->recaptchaService = app(RecaptchaService::class);
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // reCAPTCHA devre dışıysa geç
        if (!$this->recaptchaService->isEnabled()) {
            return;
        }

        // Token boşsa hata ver
        if (empty($value)) {
            $fail('reCAPTCHA doğrulaması gereklidir.');
            return;
        }

        // IP adresini al
        $ip = request()->ip();

        // reCAPTCHA doğrulaması yap
        $result = $this->recaptchaService->verify($value, $this->action, $ip);

        if (!$result['success']) {
            $message = match($result['message']) {
                'Score too low' => 'Güvenlik doğrulaması başarısız. Lütfen tekrar deneyin.',
                'Action mismatch' => 'Güvenlik doğrulaması geçersiz.',
                default => 'reCAPTCHA doğrulaması başarısız. Lütfen tekrar deneyin.'
            };

            $fail($message);
        }
    }
}
