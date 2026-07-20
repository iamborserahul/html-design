<?php

class SiteSettingSeeder {
    public function run($pdo) {
        $settings = [
            // General
            ['site_name', 'Khodiyar Steel Industries', 'general', 'text', 'Site Name'],
            ['site_tagline', 'High-End Steel Furniture & Precision Metal Products', 'general', 'text', 'Site Tagline'],
            ['site_email', 'info@khodiyarsteel.com', 'general', 'email', 'Site Email'],
            ['site_phone', '+91 90999 99266', 'general', 'text', 'Site Phone'],
            ['site_phone_secondary', '+91 73598 40800', 'general', 'text', 'Secondary Phone'],
            ['site_address', 'Block no 9, Rd Number 5, Udhana GIDC, Surat, Gujarat 394210', 'general', 'textarea', 'Site Address'],
            ['working_hours', 'Mon-Sat: 9:00 AM - 6:00 PM', 'general', 'text', 'Working Hours'],
            // Social
            ['facebook_url', '#', 'social', 'text', 'Facebook URL'],
            ['instagram_url', '#', 'social', 'text', 'Instagram URL'],
            ['twitter_url', '#', 'social', 'text', 'Twitter URL'],
            ['youtube_url', '#', 'social', 'text', 'YouTube URL'],
            ['tiktok_url', '#', 'social', 'text', 'TikTok URL'],
            // SEO
            ['meta_title', 'Khodiyar Steel – High-End Steel Furniture & Precision Metal Products', 'seo', 'text', 'Meta Title'],
            ['meta_description', 'Transforming spaces with high-end steel furniture and premium storage solutions.', 'seo', 'textarea', 'Meta Description'],
            ['meta_keywords', 'steel furniture, metal beds, steel cupboards, hospital furniture, outdoor furniture', 'seo', 'text', 'Meta Keywords'],
            // Footer
            ['footer_about_text', 'Khodiyar Steel - manufacturing excellence in high-end steel furniture and modern storage solutions since 1998.', 'footer', 'textarea', 'Footer About'],
            ['footer_copyright_text', '© Copyright 2026 by Khodiyar Steel. All Rights Reserved.', 'footer', 'text', 'Footer Copyright'],
            // Logo & Favicon
            ['site_logo', 'assets/logo.png', 'logo', 'text', 'Site Logo'],
            ['site_favicon', 'assets/logo.png', 'logo', 'text', 'Site Favicon'],
        ];

        $stmt = $pdo->prepare("INSERT INTO site_settings (`key`, `value`, `group`, type, label) VALUES (?, ?, ?, ?, ?)");
        foreach ($settings as $s) {
            try {
                $stmt->execute($s);
            } catch (PDOException $e) {
                echo "  [SKIP] {$s[0]}: {$e->getMessage()}\n";
            }
        }
        echo "Seeded: SiteSettingSeeder\n";
    }
}
