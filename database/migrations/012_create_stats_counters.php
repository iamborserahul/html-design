<?php

class CreateStatsCounters
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS stats_counters (
            id INT AUTO_INCREMENT PRIMARY KEY,
            label VARCHAR(255) NOT NULL,
            value INT NOT NULL,
            suffix VARCHAR(20),
            icon VARCHAR(100),
            sort_order INT DEFAULT 0,
            status TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS stats_counters;";
    }
}
