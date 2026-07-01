<?php

class CreateTeamMembers
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS team_members (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            designation VARCHAR(255) NOT NULL,
            bio TEXT,
            image VARCHAR(255),
            email VARCHAR(255),
            phone VARCHAR(50),
            sort_order INT DEFAULT 0,
            status TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS team_members;";
    }
}
