<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SpamWord;

class SpamWordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Profanity - Küfür ve hakaret içeren kelimeler
        $profanityWords = [
            ['word' => 'amk', 'weight' => 3, 'category' => 'profanity'],
            ['word' => 'mk', 'weight' => 2, 'category' => 'profanity'],
            ['word' => 'orospu', 'weight' => 5, 'category' => 'profanity'],
            ['word' => 'piç', 'weight' => 4, 'category' => 'profanity'],
            ['word' => 'göt', 'weight' => 3, 'category' => 'profanity'],
            ['word' => 'sik', 'weight' => 4, 'category' => 'profanity'],
            ['word' => 'kahpe', 'weight' => 4, 'category' => 'profanity'],
            ['word' => 'puşt', 'weight' => 4, 'category' => 'profanity'],
            ['word' => 'ibne', 'weight' => 4, 'category' => 'profanity'],
            ['word' => 'gerizekalı', 'weight' => 2, 'category' => 'profanity'],
            ['word' => 'salak', 'weight' => 2, 'category' => 'profanity'],
            ['word' => 'aptal', 'weight' => 2, 'category' => 'profanity'],
        ];

        // Scam - Dolandırıcılık içeren kelimeler
        $scamWords = [
            ['word' => 'hızlı para', 'weight' => 4, 'category' => 'scam'],
            ['word' => 'kolay kazanç', 'weight' => 4, 'category' => 'scam'],
            ['word' => 'evden çalış', 'weight' => 3, 'category' => 'scam'],
            ['word' => 'günde 500 tl', 'weight' => 5, 'category' => 'scam'],
            ['word' => 'garantili kazanç', 'weight' => 4, 'category' => 'scam'],
            ['word' => 'borsa tavsiyesi', 'weight' => 3, 'category' => 'scam'],
            ['word' => 'kripto', 'weight' => 2, 'category' => 'scam'],
            ['word' => 'forex', 'weight' => 3, 'category' => 'scam'],
            ['word' => 'yatırım fırsatı', 'weight' => 3, 'category' => 'scam'],
            ['word' => 'mlm', 'weight' => 4, 'category' => 'scam'],
            ['word' => 'network marketing', 'weight' => 4, 'category' => 'scam'],
            ['word' => 'piramit', 'weight' => 4, 'category' => 'scam'],
        ];

        // Commercial - Ticari spam
        $commercialWords = [
            ['word' => 'satılık', 'weight' => 2, 'category' => 'commercial'],
            ['word' => 'kiralık', 'weight' => 2, 'category' => 'commercial'],
            ['word' => 'reklam', 'weight' => 3, 'category' => 'commercial'],
            ['word' => 'indirim', 'weight' => 2, 'category' => 'commercial'],
            ['word' => 'kampanya', 'weight' => 2, 'category' => 'commercial'],
            ['word' => 'promosyon', 'weight' => 2, 'category' => 'commercial'],
            ['word' => 'fırsat', 'weight' => 1, 'category' => 'commercial'],
            ['word' => 'ucuz', 'weight' => 1, 'category' => 'commercial'],
            ['word' => 'sıfır km', 'weight' => 2, 'category' => 'commercial'],
            ['word' => 'taksi', 'weight' => 1, 'category' => 'commercial'],
            ['word' => 'emlak', 'weight' => 2, 'category' => 'commercial'],
            ['word' => 'araba', 'weight' => 1, 'category' => 'commercial'],
        ];

        // Inappropriate - Uygunsuz içerik
        $inappropriateWords = [
            ['word' => 'seks', 'weight' => 4, 'category' => 'inappropriate'],
            ['word' => 'porno', 'weight' => 5, 'category' => 'inappropriate'],
            ['word' => 'escort', 'weight' => 5, 'category' => 'inappropriate'],
            ['word' => 'masaj', 'weight' => 2, 'category' => 'inappropriate'],
            ['word' => 'özel masaj', 'weight' => 4, 'category' => 'inappropriate'],
            ['word' => 'çıplak', 'weight' => 3, 'category' => 'inappropriate'],
            ['word' => 'soyun', 'weight' => 3, 'category' => 'inappropriate'],
            ['word' => 'erotic', 'weight' => 4, 'category' => 'inappropriate'],
            ['word' => 'pijama', 'weight' => 1, 'category' => 'inappropriate'],
            ['word' => 'telefon sohbet', 'weight' => 4, 'category' => 'inappropriate'],
            ['word' => 'görüntülü sohbet', 'weight' => 4, 'category' => 'inappropriate'],
        ];

        // Tüm kelimeleri birleştir
        $allWords = array_merge($profanityWords, $scamWords, $commercialWords, $inappropriateWords);

        // Spam kelimelerini veritabanına ekle
        foreach ($allWords as $wordData) {
            SpamWord::updateOrCreate(
                ['word' => $wordData['word']],
                [
                    'weight' => $wordData['weight'],
                    'category' => $wordData['category'],
                    'is_active' => true
                ]
            );
        }

        $this->command->info('Spam words seeded successfully: ' . count($allWords) . ' words added.');
    }
}
