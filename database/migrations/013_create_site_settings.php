<?php

class CreateSiteSettings
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS site_settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            `key` VARCHAR(255) NOT NULL UNIQUE,
            `value` TEXT,
            `group` VARCHAR(100) DEFAULT 'general',
            type VARCHAR(50) DEFAULT 'text',
            label VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS site_settings;";
    }
}
