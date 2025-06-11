<?php

namespace App\Services;

use App\Models\SpamWord;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;

class SpamDetectionService
{
    // Spam skorları
    const SPAM_THRESHOLD = 70;
    const SUSPICIOUS_THRESHOLD = 40;
    const QUARANTINE_THRESHOLD = 90;

    /**
     * İçeriği spam için analiz et
     */
    public function analyzeContent($content, $userId = null)
    {
        $score = 0;
        $reasons = [];

        // 1. Yasaklı kelime kontrolü
        $wordAnalysis = $this->checkSpamWords($content);
        $score += $wordAnalysis['score'];
        if (!empty($wordAnalysis['reasons'])) {
            $reasons = array_merge($reasons, $wordAnalysis['reasons']);
        }

        // 2. URL/Link spam kontrolü
        $urlAnalysis = $this->checkUrlSpam($content);
        $score += $urlAnalysis['score'];
        if (!empty($urlAnalysis['reasons'])) {
            $reasons = array_merge($reasons, $urlAnalysis['reasons']);
        }

        // 3. Tekrarlayan karakter/kelime kontrolü
        $repetitionAnalysis = $this->checkRepetition($content);
        $score += $repetitionAnalysis['score'];
        if (!empty($repetitionAnalysis['reasons'])) {
            $reasons = array_merge($reasons, $repetitionAnalysis['reasons']);
        }

        // 4. CAPS LOCK kontrolü
        $capsAnalysis = $this->checkCapsLock($content);
        $score += $capsAnalysis['score'];
        if (!empty($capsAnalysis['reasons'])) {
            $reasons = array_merge($reasons, $capsAnalysis['reasons']);
        }

        // 5. Emoji/Özel karakter fazlalığı
        $emojiAnalysis = $this->checkExcessiveEmojis($content);
        $score += $emojiAnalysis['score'];
        if (!empty($emojiAnalysis['reasons'])) {
            $reasons = array_merge($reasons, $emojiAnalysis['reasons']);
        }

        // 6. Kullanıcı davranış kontrolü
        if ($userId) {
            $behaviorAnalysis = $this->checkUserBehavior($userId);
            $score += $behaviorAnalysis['score'];
            if (!empty($behaviorAnalysis['reasons'])) {
                $reasons = array_merge($reasons, $behaviorAnalysis['reasons']);
            }
        }

        return [
            'score' => min($score, 100), // Maksimum 100
            'reasons' => $reasons,
            'status' => $this->getSpamStatus($score),
            'is_spam' => $score >= self::SPAM_THRESHOLD
        ];
    }

    /**
     * Yasaklı kelime kontrolü
     */
    private function checkSpamWords($content)
    {
        $score = 0;
        $reasons = [];
        $spamWords = SpamWord::getActiveWords();

        $contentLower = mb_strtolower($content, 'UTF-8');

        foreach ($spamWords as $spamWord) {
            $wordLower = mb_strtolower($spamWord->word, 'UTF-8');
            if (mb_strpos($contentLower, $wordLower) !== false) {
                $score += $spamWord->weight * 10;
                $reasons[] = "Yasaklı kelime tespit edildi: {$spamWord->word} (Kategori: {$spamWord->category})";
            }
        }

        return ['score' => $score, 'reasons' => $reasons];
    }

    /**
     * URL/Link spam kontrolü
     */
    private function checkUrlSpam($content)
    {
        $score = 0;
        $reasons = [];

        // URL sayısını kontrol et
        $urlCount = preg_match_all('/(?:http[s]?:\/\/|www\.|[a-zA-Z0-9-]+\.[a-zA-Z]{2,})/i', $content);
        
        if ($urlCount > 2) {
            $score += 30;
            $reasons[] = "Çok fazla URL/link içeriyor ({$urlCount} adet)";
        } elseif ($urlCount > 0) {
            $score += 10;
            $reasons[] = "URL/link içeriyor";
        }

        // Şüpheli domain kontrolü
        $suspiciousDomains = ['bit.ly', 'tinyurl.com', 'short.link', 'gg.gg'];
        foreach ($suspiciousDomains as $domain) {
            if (stripos($content, $domain) !== false) {
                $score += 25;
                $reasons[] = "Şüpheli kısaltma servisi kullanıyor: {$domain}";
            }
        }

        return ['score' => $score, 'reasons' => $reasons];
    }

    /**
     * Tekrarlayan karakter/kelime kontrolü
     */
    private function checkRepetition($content)
    {
        $score = 0;
        $reasons = [];

        // Tekrarlayan karakterler (aaaaaa gibi)
        if (preg_match('/(.)\1{4,}/', $content)) {
            $score += 20;
            $reasons[] = "Tekrarlayan karakterler tespit edildi";
        }

        // Aynı kelimenin tekrarı
        $words = explode(' ', $content);
        $wordCounts = array_count_values($words);
        foreach ($wordCounts as $word => $count) {
            if ($count > 3 && strlen($word) > 2) {
                $score += $count * 5;
                $reasons[] = "Aynı kelime çok tekrar ediyor: '{$word}' ({$count} kez)";
            }
        }

        return ['score' => $score, 'reasons' => $reasons];
    }

    /**
     * CAPS LOCK kontrolü
     */
    private function checkCapsLock($content)
    {
        $score = 0;
        $reasons = [];

        $upperCount = preg_match_all('/[A-ZÇĞIİÖŞÜ]/', $content);
        $totalLetters = preg_match_all('/[a-zA-ZçğıiöşüÇĞIİÖŞÜ]/', $content);

        if ($totalLetters > 0) {
            $capsPercentage = ($upperCount / $totalLetters) * 100;
            
            if ($capsPercentage > 70) {
                $score += 25;
                $reasons[] = "Çok fazla büyük harf kullanımı (%{$capsPercentage})";
            } elseif ($capsPercentage > 50) {
                $score += 15;
                $reasons[] = "Fazla büyük harf kullanımı (%{$capsPercentage})";
            }
        }

        return ['score' => $score, 'reasons' => $reasons];
    }

    /**
     * Emoji/Özel karakter kontrolü
     */
    private function checkExcessiveEmojis($content)
    {
        $score = 0;
        $reasons = [];

        // Emoji sayısını kontrol et
        $emojiCount = preg_match_all('/[\x{1F600}-\x{1F64F}]|[\x{1F300}-\x{1F5FF}]|[\x{1F680}-\x{1F6FF}]|[\x{1F1E0}-\x{1F1FF}]/u', $content);
        
        if ($emojiCount > 10) {
            $score += 20;
            $reasons[] = "Çok fazla emoji kullanımı ({$emojiCount} adet)";
        }

        // Özel karakterler
        $specialCharCount = preg_match_all('/[!@#$%^&*()_+={}\[\]|\\:";\'<>?,.\/`~]/', $content);
        if ($specialCharCount > 20) {
            $score += 15;
            $reasons[] = "Çok fazla özel karakter ({$specialCharCount} adet)";
        }

        return ['score' => $score, 'reasons' => $reasons];
    }

    /**
     * Kullanıcı davranış kontrolü
     */
    private function checkUserBehavior($userId)
    {
        $score = 0;
        $reasons = [];

        // Son 1 saatte kaç post attı
        $recentPosts = Post::where('user_id', $userId)
            ->where('created_at', '>', Carbon::now()->subHour())
            ->count();

        if ($recentPosts > 5) {
            $score += 30;
            $reasons[] = "Son 1 saatte çok fazla post ({$recentPosts} adet)";
        } elseif ($recentPosts > 3) {
            $score += 15;
            $reasons[] = "Son 1 saatte hızlı post atıyor ({$recentPosts} adet)";
        }

        // Bugün kaç post attı
        $todayPosts = Post::getUserDailyPostCount($userId);
        if ($todayPosts > 10) {
            $score += 20;
            $reasons[] = "Bugün çok fazla post ({$todayPosts} adet)";
        }

        // Kullanıcı ne kadar yeni
        $user = User::find($userId);
        if ($user && $user->created_at > Carbon::now()->subDay()) {
            $score += 25;
            $reasons[] = "Çok yeni kullanıcı hesabı";
        }

        return ['score' => $score, 'reasons' => $reasons];
    }

    /**
     * Spam skoruna göre durum belirle
     */
    private function getSpamStatus($score)
    {
        if ($score >= self::QUARANTINE_THRESHOLD) {
            return 'quarantined';
        } elseif ($score >= self::SPAM_THRESHOLD) {
            return 'spam';
        } elseif ($score >= self::SUSPICIOUS_THRESHOLD) {
            return 'suspicious';
        }

        return 'clean';
    }

    /**
     * Postu otomatik olarak işle
     */
    public function processPost(Post $post)
    {
        $analysis = $this->analyzeContent($post->content, $post->user_id);

        if ($analysis['score'] >= self::QUARANTINE_THRESHOLD) {
            $post->quarantine($analysis['reasons']);
        } elseif ($analysis['score'] >= self::SPAM_THRESHOLD) {
            $post->markAsSpam($analysis['reasons']);
        } elseif ($analysis['score'] >= self::SUSPICIOUS_THRESHOLD) {
            $post->markAsSuspicious($analysis['score'], $analysis['reasons']);
        } else {
            $post->markAsClean();
        }

        return $analysis;
    }
} 