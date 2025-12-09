<?php

namespace App\Services;

use App\Models\AppSettings;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsService
{
    public function getAllSettings()
    {
        return Cache::rememberForever('app_settings', function () {
            return AppSettings::all()->pluck('value', 'key');
        });
    }

    public function updateSettings(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key === 'logo' && $value instanceof \Illuminate\Http\UploadedFile) {
                // Overwrite the existing brand logo in public/images
                $value->move(public_path('images'), 'brand-logo.png');
                $value = '/images/brand-logo.png?v=' . time(); // Add version parameter for cache busting
            }

            if ($key === 'favicon' && $value instanceof \Illuminate\Http\UploadedFile) {
                // Overwrite the existing favicon in public root
                $value->move(public_path(), 'favicon.ico');
                $value = '/favicon.ico?v=' . time();
            }

            AppSettings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Cache::forget('app_settings');
    }

    public function getSetting($key, $default = null)
    {
        $settings = $this->getAllSettings();
        return $settings[$key] ?? $default;
    }

    public function suggestColorsFromLogo($logoPath)
    {
        // Placeholder for color extraction logic
        // In a real scenario, we'd use a library like ColorThief
        // For now, we'll return 2 preset palettes
        return [
            [
                'primary' => '#3b82f6',
                'secondary' => '#1f2937',
                'background' => '#111827',
                'text' => '#d1d5db',
            ],
            [
                'primary' => '#10b981',
                'secondary' => '#065f46',
                'background' => '#064e3b',
                'text' => '#ecfdf5',
            ]
        ];
    }

    public function suggestFonts($storeType)
    {
        $suggestions = [
            'abarrotes' => ['Roboto', 'Open Sans', 'Lato'],
            'salon_belleza' => ['Playfair Display', 'Montserrat', 'Lato'],
            'restaurante' => ['Merriweather', 'Raleway', 'Oswald'],
            'ropa' => ['Nunito', 'Poppins', 'Roboto'],
            'tecnologia' => ['Inter', 'Roboto Mono', 'Fira Sans'],
            'general' => ['Inter', 'system-ui', 'Segoe UI']
        ];

        return $suggestions[$storeType] ?? $suggestions['general'];
    }
}
