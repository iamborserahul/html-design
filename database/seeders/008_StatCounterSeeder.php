<?php

class StatCounterSeeder {
    public function run($pdo) {
        $counters = [
            ['Established', 1998, '', 'fa-calendar-check', 1],
            ['Projects Delivered', 15000, '+', 'fa-layer-group', 2],
            ['Active Dealers', 500, '+', 'fa-handshake', 3],
            ['Years Experience', 25, '+', 'fa-award', 4],
        ];

        $stmt = $pdo->prepare("INSERT INTO stats_counters (label, value, suffix, icon, sort_order, status) VALUES (?, ?, ?, ?, ?, 1)");
        foreach ($counters as $c) {
            $stmt->execute($c);
        }
        echo "Seeded: StatCounterSeeder\n";
    }
}
