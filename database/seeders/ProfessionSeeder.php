<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professions = [
            'Doktor',
            'Hemşire',
            'Öğretmen',
            'Mühendis',
            'Avukat',
            'Polis',
            'Asker',
            'Muhasebeci',
            'Bankacı',
            'Pazarlama Uzmanı',
            'İnsan Kaynakları Uzmanı',
            'Grafik Tasarımcı',
            'Web Tasarımcı',
            'Yazılım Geliştirici',
            'Sistem Yöneticisi',
            'Veri Analisti',
            'Proje Yöneticisi',
            'Satış Temsilcisi',
            'Müşteri Hizmetleri',
            'Lojistik Uzmanı',
            'İnşaat Mühendisi',
            'Makine Mühendisi',
            'Elektrik Mühendisi',
            'Bilgisayar Mühendisi',
            'Endüstri Mühendisi',
            'Gıda Mühendisi',
            'Ziraat Mühendisi',
            'Veteriner',
            'Eczacı',
            'Diş Hekimi',
            'Fizyoterapist',
            'Psikolog',
            'Diyetisyen',
            'Berber',
            'Kuaför',
            'Estetisyen',
            'Masaj Terapisti',
            'Şef',
            'Aşçı',
            'Garson',
            'Kasiyer',
            'Güvenlik Görevlisi',
            'Temizlik Görevlisi',
            'Şoför',
            'Kurye',
            'Tamirci',
            'Elektrikçi',
            'Tesisatçı',
            'Boyacı',
            'Marangoz',
            'Terzi',
            'Ayakkabı Tamircisi',
            'Saat Tamircisi',
            'Cep Telefonu Tamircisi',
            'Oto Tamircisi',
            'Lastikçi',
            'Yedek Parça Satıcısı',
            'Market Sahibi',
            'Restoran Sahibi',
            'Cafe Sahibi',
            'Otel Sahibi',
            'Emlak Uzmanı',
            'Sigorta Uzmanı',
            'Turizm Rehberi',
            'Çevirmen',
            'Gazeteci',
            'Fotoğrafçı',
            'Video Editörü',
            'Ses Teknisyeni',
            'Müzisyen',
            'Sanatçı',
            'Sporcu',
            'Antrenör',
            'Pilot',
            'Hostes',
            'Kaptan',
            'Makinist',
            'İtfaiyeci',
            'Paramedik',
            'Ambulans Şoförü',
            'Serbest Meslek',
            'Emekli',
            'Öğrenci',
            'Ev Hanımı',
            'İşsiz',
            'Diğer'
        ];

        foreach ($professions as $profession) {
            DB::table('professions')->insertOrIgnore([
                'name' => $profession,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
