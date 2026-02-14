<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'site_title' => 'InayaFleet360',
                'site_description' => 'InayaFleet360',
                'admin_title' => 'InayaFleet360',
                'admin_description' => 'All-in-One Fleet & Transport Automation System',
                'site_logo' => null,
                'site_copyright_text' => '© 2026 Transport Management System. All rights reserved.',
                'admin_logo' => null,
                'status' => 1,
                'created_by' => 1,
                'default_language' => 'en',
                'available_languages' => 'en',
                'auto_translate' => 0,
                'translation_cache_duration' => 3600,
                // Email Settings (default values)
                'mail_mailer' => 'smtp',
                'mail_host' => 'smtp.mailtrap.io',
                'mail_port' => 2525,
                'mail_username' => null,
                'mail_password' => null,
                'mail_encryption' => 'tls',
                'mail_from_address' => 'noreply@example.com',
                'mail_from_name' => 'TMS',
            ]
        );
    }
}
