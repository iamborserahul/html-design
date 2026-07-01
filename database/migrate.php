<?php

require_once __DIR__ . '/../config/database.php';

$pdo = getDB();
$migrationsDir = __DIR__ . '/migrations';

$fresh = in_array('--fresh', $argv ?? []);
$status = in_array('--status', $argv ?? []);

$pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL UNIQUE,
    batch INT NOT NULL,
    executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

if ($status) {
    echo "Migration Status\n";
    echo str_repeat('=', 60) . "\n";

    $stmt = $pdo->query("SELECT migration, batch, executed_at FROM migrations ORDER BY migration");
    $run = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $runMigrations = array_column($run, 'migration');

    $files = glob($migrationsDir . '/*.php');
    sort($files);

    if (empty($files)) {
        echo "No migration files found.\n";
        exit;
    }

    printf("%-45s %-10s %s\n", 'Migration', 'Ran?', 'Date');
    echo str_repeat('-', 60) . "\n";

    foreach ($files as $file) {
        $name = basename($file);
        $idx = array_search($name, $runMigrations);
        if ($idx !== false) {
            $row = $run[$idx];
            printf("%-45s %-10s %s\n", $name, 'YES', $row['executed_at']);
        } else {
            printf("%-45s %-10s %s\n", $name, 'NO', '-');
        }
    }

    echo str_repeat('=', 60) . "\n";
    echo count($run) . " migration(s) run, " . (count($files) - count($run)) . " pending.\n";
    exit;
}

if ($fresh) {
    echo "Running --fresh: dropping all tables...\n";

    $files = glob($migrationsDir . '/*.php');
    sort($files);
    $files = array_reverse($files);

    foreach ($files as $file) {
        $class = getMigrationClass($file);
        if ($class && method_exists($class, 'down')) {
            $sql = $class->down();
            $pdo->exec($sql);
            echo "  Dropped: " . basename($file) . "\n";
        }
    }

    $pdo->exec("DELETE FROM migrations");
    echo "All tables dropped. Re-running migrations...\n\n";
}

$files = glob($migrationsDir . '/*.php');
sort($files);

$stmt = $pdo->query("SELECT migration FROM migrations");
$runMigrations = $stmt->fetchAll(PDO::FETCH_COLUMN);

$batch = (int) $pdo->query("SELECT COALESCE(MAX(batch), 0) FROM migrations")->fetchColumn();
$batch++;

$count = 0;

foreach ($files as $file) {
    $name = basename($file);

    if (in_array($name, $runMigrations)) {
        echo "  SKIPPED: {$name} (already run)\n";
        continue;
    }

    $class = getMigrationClass($file);

    if (!$class || !method_exists($class, 'up')) {
        echo "  WARNING: {$name} has no valid migration class, skipping.\n";
        continue;
    }

    $sql = $class->up();
    $pdo->exec($sql);

    $insert = $pdo->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?)");
    $insert->execute([$name, $batch]);

    echo "  MIGRATED: {$name}\n";
    $count++;
}

echo "\nDone. {$count} migration(s) run in batch #{$batch}.\n";

function getMigrationClass($file)
{
    require_once $file;

    $basename = basename($file, '.php');
    $parts = explode('_', $basename, 2);
    if (!isset($parts[1])) {
        return null;
    }

    $className = str_replace(' ', '', ucwords(str_replace('_', ' ', $parts[1])));

    if (class_exists($className)) {
        return new $className();
    }

    return null;
}
