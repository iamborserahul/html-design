<?php

class CreateTestimonials
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS testimonials (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            designation VARCHAR(255),
            company VARCHAR(255),
            image VARCHAR(255),
            content TEXT NOT NULL,
            rating TINYINT(1) DEFAULT 5,
            sort_order INT DEFAULT 0,
            status TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS testimonials;";
    }
}
