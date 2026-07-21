<?php

class ExtraServicesSeeder {
    public function run($pdo) {
        $services = [
            [
                'Bathroom Rack',
                'BR',
                'Utility Storage',
                'assets/service_br01.png',
                'Wall-mounted & free-standing formats',
                'Mild steel or stainless steel tube',
                'Powder-coated & chrome-look finishes',
                'KD or semi-KD export packing',
                10,
                1
            ],
            [
                'Towel Hanger',
                'TH',
                'Accessories',
                'assets/service_th01.png',
                'Bars, rails, hooks & ladder formats',
                'Tube, rod & pressed plate build',
                'Concealed or bracket-mounted',
                'Sanitaryware & hotel spec options',
                20,
                1
            ],
            [
                'Luggage Trolley',
                'LT',
                'Hospitality',
                'assets/service_lt01.png',
                'Arched tubular steel/stainless frame',
                'Carpeted or rubber platform',
                'Heavy-duty casters with brakes',
                'Knock-down design for shipping',
                30,
                1
            ],
            [
                'Bed Side Table',
                'BST',
                'Bedroom',
                'assets/service_bst01.png',
                'Steel tube frame with wood/glass tops',
                'Open shelf, drawer or cabinet setup',
                'Adjustable feet, casters or locks',
                'Hostel, home & project bedroom fit',
                40,
                1
            ],
            [
                'Clothes Rack',
                'CR',
                'Garment Rail',
                'assets/service_cr01.png',
                'Welded or bolt-together frame build',
                'Single/double rail with shoe shelf',
                'Load-rated rail for commercial use',
                'Flat-pack export packing available',
                50,
                1
            ]
        ];

        $stmt = $pdo->prepare("INSERT INTO extra_services (title, prefix, subtitle, image, spec_1, spec_2, spec_3, spec_4, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($services as $s) {
            try {
                $stmt->execute($s);
            } catch (PDOException $e) {
                echo "  [SKIP] {$s[0]}: {$e->getMessage()}\n";
            }
        }
        echo "Seeded: ExtraServicesSeeder\n";
    }
}
