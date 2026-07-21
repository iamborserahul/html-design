<?php

class CreateExtraServices
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS extra_services (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            prefix VARCHAR(50) DEFAULT '',
            subtitle VARCHAR(255) DEFAULT '',
            image VARCHAR(255) DEFAULT '',
            spec_1 VARCHAR(255) DEFAULT '',
            spec_2 VARCHAR(255) DEFAULT '',
            spec_3 VARCHAR(255) DEFAULT '',
            spec_4 VARCHAR(255) DEFAULT '',
            sort_order INT DEFAULT 0,
            status TINYINT DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS extra_services;";
    }
}
