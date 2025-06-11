<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SiteSettingsController extends Controller
{
    /**
     * Display the site settings.
     */
    public function index()
    {
        $groupedSettings = SiteSetting::getGroupedSettings();
        
        return view('admin.settings.index', compact('groupedSettings'));
    }

    /**
     * Update the site settings.
     */
    public function update(Request $request)
    {
        try {
            $settings = $request->input('settings', []);

            foreach ($settings as $key => $value) {
                // Boolean değerler için özel işlem
                if ($request->has("settings.{$key}") || $this->isBooleanSetting($key)) {
                    SiteSetting::set($key, $value);
                }
            }

            // Boolean settings that are unchecked won't be in the request
            $this->handleUncheckedBooleans($request);

            return redirect()->back()->with('success', 'Site ayarları başarıyla güncellendi!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ayarlar güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Create a new setting.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|unique:site_settings,key',
            'value' => 'nullable|string',
            'type' => 'required|in:text,textarea,boolean,number,select',
            'group' => 'required|string',
            'label' => 'required|string',
            'description' => 'nullable|string',
            'options' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->only(['key', 'value', 'type', 'group', 'label', 'description', 'sort_order']);
        
        // Options alanını JSON'a çevir
        if ($request->options) {
            $data['options'] = json_decode($request->options, true);
        }

        SiteSetting::create($data);

        return redirect()->back()->with('success', 'Yeni ayar başarıyla oluşturuldu!');
    }

    /**
     * Delete a setting.
     */
    public function destroy($id)
    {
        $setting = SiteSetting::findOrFail($id);
        $setting->delete();

        return redirect()->back()->with('success', 'Ayar başarıyla silindi!');
    }

    /**
     * Initialize default settings.
     */
    public function initializeDefaults()
    {
        $defaultSettings = [
            // Genel Ayarlar
            [
                'key' => 'site_name',
                'value' => 'Vezirköprü Platformu',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Adı',
                'description' => 'Sitenin başlığında görünecek isim',
                'sort_order' => 1,
            ],
            [
                'key' => 'site_description',
                'value' => 'Vezirköprü\'de yaşayanların buluşma noktası',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Site Açıklaması',
                'description' => 'SEO ve sosyal medya için site açıklaması',
                'sort_order' => 2,
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@vezirkoprum.com.tr',
                'type' => 'text',
                'group' => 'general',
                'label' => 'İletişim E-postası',
                'description' => 'Site iletişim e-posta adresi',
                'sort_order' => 3,
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'general',
                'label' => 'Bakım Modu',
                'description' => 'Site bakım modunu aktif/pasif yapar',
                'sort_order' => 4,
            ],

            // Görünüm Ayarları
            [
                'key' => 'posts_per_page',
                'value' => '10',
                'type' => 'number',
                'group' => 'appearance',
                'label' => 'Sayfa Başına Gönderi',
                'description' => 'Ana sayfada gösterilecek gönderi sayısı',
                'sort_order' => 1,
            ],
            [
                'key' => 'allow_guest_posts',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'appearance',
                'label' => 'Misafir Gönderileri',
                'description' => 'Giriş yapmayan kullanıcıların gönderi görmesine izin ver',
                'sort_order' => 2,
            ],

            // SEO Ayarları
            [
                'key' => 'seo_title',
                'value' => 'Vezirköprü Hemşehrileri - Samsun Vezirköprü İlçesi Sosyal Platform',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'SEO Başlığı',
                'description' => 'Arama motorlarında görünecek ana başlık',
                'sort_order' => 1,
            ],
            [
                'key' => 'seo_description',
                'value' => 'Vezirköprü ilçesinde yaşayan, Vezirköprü\'den olan ve Vezirköprü\'ye gönül vermiş herkesin buluşma noktası. Samsun\'un bu güzel ilçesinden haberler, etkinlikler, iş ilanları ve sosyal paylaşımlar.',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'SEO Açıklaması',
                'description' => 'Arama motorlarında görünecek site açıklaması (max 160 karakter)',
                'sort_order' => 2,
            ],
            [
                'key' => 'seo_keywords',
                'value' => 'Vezirköprü, Samsun Vezirköprü, Vezirköprü haber, Vezirköprü sosyal medya, Vezirköprü WhatsApp, Vezirköprü hemşehri, Vezirköprü iş ilanları, Vezirköprü etkinlik',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'SEO Anahtar Kelimeler',
                'description' => 'Virgülle ayrılmış anahtar kelimeler',
                'sort_order' => 3,
            ],
            [
                'key' => 'google_analytics_id',
                'value' => '',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'Google Analytics ID',
                'description' => 'Google Analytics izleme kodu (GA-XXXXXXXXX)',
                'sort_order' => 4,
            ],

            // Sosyal Medya
            [
                'key' => 'facebook_url',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Facebook sayfası bağlantısı',
                'sort_order' => 1,
            ],
            [
                'key' => 'instagram_url',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Instagram profili bağlantısı',
                'sort_order' => 2,
            ],
            [
                'key' => 'twitter_url',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Twitter profili bağlantısı',
                'sort_order' => 3,
            ],
        ];

        foreach ($defaultSettings as $setting) {
            SiteSetting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        Cache::forget('site_settings');

        return redirect()->back()->with('success', 'Varsayılan ayarlar başarıyla yüklendi!');
    }

    /**
     * Check if a setting is boolean type.
     */
    private function isBooleanSetting($key)
    {
        $setting = SiteSetting::where('key', $key)->first();
        return $setting && $setting->type === 'boolean';
    }

    /**
     * Handle unchecked boolean settings.
     */
    private function handleUncheckedBooleans(Request $request)
    {
        $booleanSettings = SiteSetting::where('type', 'boolean')->pluck('key');
        
        foreach ($booleanSettings as $key) {
            if (!$request->has("settings.{$key}")) {
                SiteSetting::set($key, '0');
            }
        }
    }
}
