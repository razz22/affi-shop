<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'DailyShop',
            'site_tagline' => 'Your Daily Dose of Amazon Deals',
            'contact_email' => 'hello@dailyshop.local',
            'footer_text' => 'DailyShop is an independent site. As an Amazon Associate we earn from qualifying purchases.',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
