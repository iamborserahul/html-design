<?php

class CreateAboutSections
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS about_sections (
            id INT AUTO_INCREMENT PRIMARY KEY,
            type VARCHAR(50) NOT NULL DEFAULT 'mission',
            icon VARCHAR(100) DEFAULT 'fa-bullseye',
            title VARCHAR(255) NOT NULL,
            content TEXT,
            sort_order INT DEFAULT 0,
            status TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS about_sections;";
    }
}
