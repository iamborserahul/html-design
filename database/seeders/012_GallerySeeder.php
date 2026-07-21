<?php

class GallerySeeder {
    public function run($pdo) {
        $items = [
            ['Sofa Bunk Bed', 'Metal Beds & Bunks', 'bucharest-sofa-bunk-01.webp', 'Innovative space-saving sofa-to-bunk design.', 1],
            ['Platform Bed 7201', 'Metal Beds & Bunks', 'metal-bed-7201-01.webp', 'Modern luxury platform bed frame.', 2],
            ['Heavy Duty Tubular Bed', 'Metal Beds & Bunks', 'metal-bed-7202-01.webp', 'Durable double-arch steel bed frame.', 3],
            ['Nature Bunk Bed', 'Metal Beds & Bunks', 'nature-bunk-bed-01.webp', 'Eco-friendly design sturdy bunk bed.', 4],
            ['Origami Bunk Bed', 'Metal Beds & Bunks', 'origami-bunk-bed-01.webp', 'Sleek minimalist steel bunk bed layout.', 5],
            ['Vladivostok Bunk Bed', 'Metal Beds & Bunks', 'vladivostok-bunk-bed-01.webp', 'Compact and safe double-decker bunk bed.', 6],
            ['Household Wardrobe', 'Steel Cupboards', 'household-wardrobe-02.webp', 'Classic family wardrobe with deep shelves.', 7],
            ['Industrial Cabinet', 'Steel Cupboards', 'industrial-tool-cabinet-new.jpg', 'Heavy duty storage solution.', 8],
            ['Structural Mirror Frame', 'Steel Cupboards', 'structural-mirror-frame-03.webp', 'Contemporary metal frame accents.', 9],
            ['Dining Set DS-301', 'Dining & Bathroom', 'dining-set-ds301-02.webp', 'Tempered glass top steel dining table.', 10],
            ['Modular Vanity Cabinet', 'Dining & Bathroom', 'modular-vanity-cabinet-01.webp', 'Elegant bathroom vanity storage.', 11],
            ['Fire Safety Door', 'Doors & Security Gates', 'fire-safety-door-03.webp', 'Industrial-grade fire safety steel door.', 12],
            ['Main Entrance Gate', 'Doors & Security Gates', 'main-entrance-gate-01.webp', 'Secure wrought-iron luxury gate.', 13],
            ['Garden Steel Gazebo', 'Outdoor Furniture', 'garden-steel-gazebo-02.webp', 'All-weather luxury garden gazebo pavilion.', 14],
            ['Poolside Recliner', 'Outdoor Furniture', 'poolside-recliner-chair-01.webp', 'Ergonomic rust-free outdoor recliner.', 15],
            ['Precision Metal Frame', 'Outdoor Furniture', 'precision-metal-frame-01.webp', 'Custom architectural steel structures.', 16],
        ];

        $stmt = $pdo->prepare("INSERT INTO gallery_items (title, category, image, description, sort_order, status) VALUES (?, ?, ?, ?, ?, 1)");
        foreach ($items as $item) {
            $stmt->execute($item);
        }
        echo "Seeded: GallerySeeder\n";
    }
}
