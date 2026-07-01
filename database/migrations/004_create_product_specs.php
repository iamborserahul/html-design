<?php

class CreateProductSpecs
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS product_specs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product_id INT NOT NULL,
            label VARCHAR(255) NOT NULL,
            value VARCHAR(255) NOT NULL,
            sort_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS product_specs;";
    }
}
