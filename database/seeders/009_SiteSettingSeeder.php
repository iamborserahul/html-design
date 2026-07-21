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
            // About Us
            ['about_tagline', 'ABOUT US', 'about', 'text', 'About Tagline'],
            ['about_title', 'Built on Strength.<br>Driven by Quality.', 'about', 'text', 'About Title'],
            ['about_description', "<p>Founded in 1998 by Vimal Sakariya, Khodiyar Steel Industries began with a clear vision: to manufacture durable, high-quality steel furniture that customers could trust. What started as a small manufacturing operation serving the Indian market has grown into an established metal furniture manufacturer with more than 25 years of industry experience.</p>\n<p>Today, Khodiyar Steel Industries is a trusted manufacturing partner for distributors, importers, retailers, institutions, and project buyers globally, with a production capacity of up to 10,000 metal beds per month.</p>", 'about', 'textarea', 'About Description'],
            ['about_image_1', 'assets/metal-bed-7201-01.webp', 'about', 'text', 'About Image 1'],
            ['about_image_2', 'assets/origami-bunk-bed-02.webp', 'about', 'text', 'About Image 2'],
            // Extra Services
            ['services_subtitle', 'UTILITY RANGE', 'services', 'text', 'Services Subtitle'],
            ['services_title', 'Bathroom & Utility Metal Products', 'services', 'text', 'Services Title'],
            ['services_description', "<p>A focused development catalogue for bathroom racks, towel hangers, luggage trolleys, bedside tables, and clothes racks manufactured by Khodiyar Steel Industries.</p>\n<p>Designed for bulk buyers, hotel projects, bathroom brands, furniture distributors, and OEM/private-label supply.</p>", 'services', 'textarea', 'Services Description'],
            ['services_catalogue_url', 'ksi/Khodiyar_Bathroom_Utility_Metal_Products_Catalogue.pdf', 'services', 'text', 'Services Catalogue PDF'],
            ['services_contact_name', 'Mr. Manthan Sakariya (CEO)', 'services', 'text', 'Services Contact Name'],
            ['services_contact_phone', '+91 73598 40800', 'services', 'text', 'Services Contact Phone'],
            ['services_contact_email', 'info@khodiyarsteel.com', 'services', 'text', 'Services Contact Email'],
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
