<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Company Information
            [
                'key' => 'site_name',
                'value' => 'Simba Doors and Windows',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Quality Design Excellence in Doors & Windows',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'company_description',
                'value' => 'Simba Doors and Windows is a leading provider of high-quality designed doors and windows in Tanzania, with over 30 years of experience.',
                'type' => 'textarea',
                'group' => 'general',
            ],
            [
                'key' => 'logo',
                'value' => 'images/logo.svg',
                'type' => 'image',
                'group' => 'general',
            ],
            [
                'key' => 'favicon',
                'value' => 'images/favicon.png',
                'type' => 'image',
                'group' => 'general',
            ],

            // Contact Information
            [
                'key' => 'contact_address',
                'value' => 'Dar es Salaam, Tanzania',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@simbadoors.co.tz',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+255 XXX XXX XXX',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'business_hours',
                'value' => 'Mon-Fri 8:00 - 17:00 / Sat 9:00 - 13:00',
                'type' => 'text',
                'group' => 'contact',
            ],

            // Social Media Links
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/simbadoors',
                'type' => 'text',
                'group' => 'social',
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/simbadoors',
                'type' => 'text',
                'group' => 'social',
            ],
            [
                'key' => 'linkedin_url',
                'value' => 'https://linkedin.com/company/simbadoors',
                'type' => 'text',
                'group' => 'social',
            ],

            // Homepage Content
            [
                'key' => 'home_hero_title',
                'value' => 'Exceptional Doors & Windows Design',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'home_hero_subtitle',
                'value' => 'Unlock Your Dream Home',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'home_hero_description',
                'value' => 'Delivering high-quality designed doors and windows that uniquely add value and artistic beauty to your structure for over 30 years.',
                'type' => 'textarea',
                'group' => 'homepage',
            ],

            // SEO Settings
            [
                'key' => 'meta_title',
                'value' => 'Simba Doors and Windows | Premium Door & Window Solutions in Tanzania',
                'type' => 'text',
                'group' => 'seo',
            ],
            [
                'key' => 'meta_description',
                'value' => 'Leading manufacturer of high-quality doors and windows in Tanzania. Over 30 years of experience in delivering exceptional designs.',
                'type' => 'textarea',
                'group' => 'seo',
            ],
            [
                'key' => 'meta_keywords',
                'value' => 'doors, windows, security doors, interior doors, aluminum windows, Tanzania, Dar es Salaam',
                'type' => 'text',
                'group' => 'seo',
            ],

            // Company Statistics
            [
                'key' => 'years_experience',
                'value' => '30',
                'type' => 'text',
                'group' => 'statistics',
            ],
            [
                'key' => 'completed_projects',
                'value' => '1000',
                'type' => 'text',
                'group' => 'statistics',
            ],
            [
                'key' => 'customer_satisfaction',
                'value' => '98',
                'type' => 'text',
                'group' => 'statistics',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
