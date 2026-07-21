<?php

class PartnerSeeder {
    public function run($pdo) {
        $partners = [
            ['Apex Hospital Group', 'fa-solid fa-hospital', 1],
            ['Royal Palace Hotels', 'fa-solid fa-hotel', 2],
            ['Gujarat Infra Ltd', 'fa-solid fa-building-shield', 3],
            ['Luxury Living Co.', 'fa-solid fa-couch', 4],
            ['Elite Academy Group', 'fa-solid fa-graduation-cap', 5],
            ['Surat Steel Hub', 'fa-solid fa-warehouse', 6],
        ];

        $stmt = $pdo->prepare("INSERT INTO partners (name, icon, sort_order, status) VALUES (?, ?, ?, 1)");
        foreach ($partners as $p) {
            $stmt->execute($p);
        }
        echo "Seeded: PartnerSeeder\n";
    }
}
