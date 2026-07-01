<?php

class CreateProducts
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            category_id INT,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            short_description VARCHAR(500),
            description TEXT,
            price DECIMAL(10,2),
            sale_price DECIMAL(10,2),
            sku VARCHAR(100),
            unit VARCHAR(50),
            stock INT DEFAULT 0,
            featured_image VARCHAR(255),
            status TINYINT(1) DEFAULT 1,
            featured TINYINT(1) DEFAULT 0,
            meta_title VARCHAR(255),
            meta_description VARCHAR(500),
            meta_keywords VARCHAR(500),
            sort_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES product_categories(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS products;";
    }
}
