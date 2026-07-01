<?php

class CategorySeeder {
    public function run($pdo) {
        $categories = [
            ['Metal Beds & Bunks', 'metal-beds-bunks', 'High-quality metal beds and bunk beds for residential and commercial use.', 'fa-couch', 1],
            ['Steel Cupboards', 'steel-cupboards', 'Durable steel cupboards and wardrobes for home and office.', 'fa-wardrobe', 2],
            ['Dining & Bathroom', 'dining-bathroom', 'Premium dining sets and bathroom vanities made from finest steel.', 'fa-utensils', 3],
            ['Doors & Security Gates', 'doors-security-gates', 'Strong and stylish main entrance doors and security gates.', 'fa-door-closed', 4],
            ['Hospital Equipment', 'hospital-equipment', 'Reliable steel hospital furniture and medical equipment.', 'fa-hospital-user', 5],
            ['Outdoor Furniture', 'outdoor-furniture', 'Weather-resistant steel outdoor furniture for gardens and patios.', 'fa-umbrella', 6],
        ];

        $stmt = $pdo->prepare("INSERT INTO product_categories (name, slug, description, icon, sort_order, status) VALUES (?, ?, ?, ?, ?, 1)");
        foreach ($categories as $cat) {
            $stmt->execute($cat);
        }
        echo "Seeded: CategorySeeder\n";
    }
}
