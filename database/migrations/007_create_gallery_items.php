<?php

class CreateGalleryItems
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS gallery_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255),
            category VARCHAR(100),
            image VARCHAR(255) NOT NULL,
            description TEXT,
            sort_order INT DEFAULT 0,
            status TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS gallery_items;";
    }
}
