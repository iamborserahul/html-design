<?php
/**
 * Database Seeder Runner
 * 
 * Usage: php database/seed.php [--fresh]
 * --fresh: Truncate all tables before seeding
 */

require_once __DIR__ . '/../config/database.php';

$fresh = in_array('--fresh', $argv ?? []);

$pdo = getDB();

echo "============================================\n";
echo "  Khodiyar Steel Industries - Seeder\n";
echo "============================================\n\n";

// Disable foreign key checks
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

$seederDir = __DIR__ . '/seeders';
$seederFiles = glob($seederDir . '/*.php');
sort($seederFiles);

if (empty($seederFiles)) {
    echo "No seeder files found in $seederDir\n";
    exit(1);
}

foreach ($seederFiles as $file) {
    $filename = basename($file);

    if ($fresh) {
        $tableName = getTableNameFromSeeder($filename);
        if ($tableName !== null) {
            echo "[TRUNCATE] Truncating table: $tableName\n";
            $pdo->exec("TRUNCATE TABLE `$tableName`");
        }
    }
}

// If --fresh, truncate all known tables
if ($fresh) {
    $tables = [
        'users',
        'product_categories',
        'products',
        'product_images',
        'product_specs',
        'product_features',
        'hero_slides',
        'testimonials',
        'faqs',
        'team_members',
        'stats_counters',
        'site_settings',
        'inquiries',
        'gallery_items',
    ];
    foreach ($tables as $table) {
        echo "[TRUNCATE] $table\n";
        $pdo->exec("TRUNCATE TABLE `$table`");
    }
    echo "\n";
}

// Re-enable foreign key checks
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

echo "Starting seed...\n\n";

foreach ($seederFiles as $file) {
    $filename = basename($file);
    echo "[SEEDING] $filename...\n";

    require_once $file;

    $className = getClassNameFromSeeder($filename);
    if (class_exists($className)) {
        $seeder = new $className();
        $seeder->run($pdo);
        echo "[DONE] $filename\n\n";
    } else {
        echo "[ERROR] Class $className not found in $filename\n";
    }
}

echo "============================================\n";
echo "  All seeders completed successfully!\n";
echo "============================================\n";

function getClassNameFromSeeder(string $filename): string {
    // Remove number prefix and .php extension, convert to PascalCase
    $name = preg_replace('/^\d+_/', '', $filename);
    $name = pathinfo($name, PATHINFO_FILENAME);
    return $name;
}

function getTableNameFromSeeder(string $filename): ?string {
    $className = getClassNameFromSeeder($filename);
    $tableMap = [
        'UserSeeder' => 'users',
        'CategorySeeder' => 'product_categories',
        'ProductSeeder' => null, // multiple tables
        'HeroSlideSeeder' => 'hero_slides',
        'TestimonialSeeder' => 'testimonials',
        'FAQSeeder' => 'faqs',
        'TeamMemberSeeder' => 'team_members',
        'StatCounterSeeder' => 'stats_counters',
        'SiteSettingSeeder' => 'site_settings',
        'InquirySeeder' => 'inquiries',
    ];
    return $tableMap[$className] ?? null; // return null for ProductSeeder (multi-table)
}
