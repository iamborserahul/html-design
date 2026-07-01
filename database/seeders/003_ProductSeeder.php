<?php

class ProductSeeder {
    public function run($pdo) {
        // ---- Product 1: Platform Bed (7201) ----
        $pdo->prepare("INSERT INTO products (category_id, name, slug, short_description, description, price, sku, unit, stock, featured_image, status, featured, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,1,?,?)")->execute([
            1,
            'Platform Bed (7201)',
            'platform-bed-7201',
            'Modern steel platform bed with elegant finish and sturdy construction.',
            'The Platform Bed (7201) combines contemporary design with industrial strength. Crafted from heavy-gauge steel with a powder-coated finish, this bed frame requires no box spring and offers ample under-bed storage. Perfect for modern bedrooms seeking durability and style.',
            185.00,
            'KSM-BED-7201',
            'Unit',
            50,
            'assets/metal-bed-7201-01.webp',
            1,
            1,
            1
        ]);
        $pid1 = $pdo->lastInsertId();

        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid1, 'assets/metal-bed-7201-01.webp', 'Platform Bed 7201 - Front View', 1]);
        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid1, 'assets/metal-bed-7201-02.webp', 'Platform Bed 7201 - Side View', 2]);
        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid1, 'assets/metal-bed-7201-03.webp', 'Platform Bed 7201 - Detail', 3]);

        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid1, 'Material', 'Heavy-Gauge Steel', 1]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid1, 'Dimensions', '78" x 60" x 14"', 2]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid1, 'Weight Capacity', '500 kg', 3]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid1, 'Finish', 'Powder Coated', 4]);

        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid1, 'No box spring required', 'fa-bed', 1]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid1, 'Under-bed storage space', 'fa-box', 2]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid1, 'Rust-resistant powder coating', 'fa-shield-alt', 3]);

        // ---- Product 2: Adjustable Folding Bed ----
        $pdo->prepare("INSERT INTO products (category_id, name, slug, short_description, description, price, sku, unit, stock, featured_image, status, featured, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,1,?,?)")->execute([
            1,
            'Adjustable Folding Bed',
            'adjustable-folding-bed',
            'Space-saving folding bed with adjustable positions for versatile use.',
            'The Adjustable Folding Bed is designed for maximum space efficiency. Easily foldable and adjustable to multiple positions, it serves as a comfortable sleeping solution for guests, offices, and compact living spaces. Built with a reinforced steel frame and premium mattress.',
            145.00,
            'KSM-AFB-101',
            'Unit',
            35,
            'assets/adjustable-folding-bed-01.webp',
            1,
            0,
            2
        ]);
        $pid2 = $pdo->lastInsertId();

        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid2, 'assets/adjustable-folding-bed-01.webp', 'Folding Bed - Folded', 1]);
        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid2, 'assets/adjustable-folding-bed-02.webp', 'Folding Bed - Opened', 2]);

        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid2, 'Material', 'Reinforced Steel Frame', 1]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid2, 'Dimensions (Open)', '75" x 36" x 18"', 2]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid2, 'Dimensions (Folded)', '36" x 30" x 8"', 3]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid2, 'Weight Capacity', '250 kg', 4]);

        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid2, '3-position adjustable backrest', 'fa-cog', 1]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid2, 'Easy fold-and-store mechanism', 'fa-compress-alt', 2]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid2, 'Includes 4-inch foam mattress', 'fa-mattress-pillow', 3]);

        // ---- Product 3: Bucharest Sofa Bunk Bed ----
        $pdo->prepare("INSERT INTO products (category_id, name, slug, short_description, description, price, sku, unit, stock, featured_image, status, featured, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,1,?,?)")->execute([
            1,
            'Bucharest Sofa Bunk Bed',
            'bucharest-sofa-bunk-bed',
            'Innovative sofa-cum-bunk bed with built-in storage and study table.',
            'The Bucharest Sofa Bunk Bed is a multi-functional marvel. By day it serves as a stylish sofa, and by night it converts into a comfortable bunk bed. Features built-in storage drawers and a pull-out study table, making it perfect for kids\' rooms and space-saving interiors.',
            320.00,
            'KSM-BSB-202',
            'Unit',
            20,
            'assets/bucharest-bunk-bed-01.webp',
            1,
            1,
            3
        ]);
        $pid3 = $pdo->lastInsertId();

        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid3, 'assets/bucharest-bunk-bed-01.webp', 'Bucharest Bunk - Sofa Mode', 1]);
        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid3, 'assets/bucharest-bunk-bed-02.webp', 'Bucharest Bunk - Bed Mode', 2]);
        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid3, 'assets/bucharest-bunk-bed-03.webp', 'Bucharest Bunk - Storage', 3]);

        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid3, 'Material', 'Premium Steel + Plywood', 1]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid3, 'Dimensions', '82" x 48" x 72"', 2]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid3, 'Mattress Size', '75" x 36" (Twin)', 3]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid3, 'Warranty', '5 Years', 4]);

        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid3, 'Sofa-to-bunk convertible design', 'fa-couch', 1]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid3, 'Built-in storage drawers', 'fa-drawer', 2]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid3, 'Pull-out study table included', 'fa-desk', 3]);

        // ---- Product 4: Sliding Almirah ----
        $pdo->prepare("INSERT INTO products (category_id, name, slug, short_description, description, price, sku, unit, stock, featured_image, status, featured, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,1,?,?)")->execute([
            2,
            'Sliding Almirah',
            'sliding-almirah',
            'Elegant steel almirah with sliding doors and ample storage space.',
            'The Sliding Almirah offers sleek modern storage with smooth-glide doors. Made from high-grade steel with a premium powder-coated finish, it features adjustable shelves, hanging rods, and internal drawers. Designed to maximize wardrobe space while adding a contemporary touch to any room.',
            280.00,
            'KSM-SA-301',
            'Unit',
            30,
            'assets/sliding-almirah-01.webp',
            1,
            1,
            1
        ]);
        $pid4 = $pdo->lastInsertId();

        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid4, 'assets/sliding-almirah-01.webp', 'Sliding Almirah - Closed', 1]);
        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid4, 'assets/sliding-almirah-02.webp', 'Sliding Almirah - Open', 2]);

        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid4, 'Material', 'High-Grade Steel', 1]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid4, 'Dimensions', '72" x 48" x 20"', 2]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid4, 'Finish', 'Premium Powder Coated', 3]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid4, 'Warranty', '10 Years', 4]);

        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid4, 'Smooth ball-bearing sliding doors', 'fa-door-open', 1]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid4, 'Adjustable shelves and hanging rod', 'fa-sliders-h', 2]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid4, 'Anti-rust treatment', 'fa-shield-virus', 3]);

        // ---- Product 5: Household Wardrobe ----
        $pdo->prepare("INSERT INTO products (category_id, name, slug, short_description, description, price, sku, unit, stock, featured_image, status, featured, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,1,?,?)")->execute([
            2,
            'Household Wardrobe',
            'household-wardrobe',
            'Spacious steel wardrobe with hinged doors and smart organization.',
            'The Household Wardrobe combines classic design with modern functionality. This spacious steel wardrobe features hinged doors with magnetic locks, multiple compartments, deep drawers, and a full-length mirror option. Ideal for family bedrooms requiring durable and organized clothing storage.',
            350.00,
            'KSM-HW-401',
            'Unit',
            25,
            'assets/household-wardrobe-01.webp',
            1,
            0,
            2
        ]);
        $pid5 = $pdo->lastInsertId();

        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid5, 'assets/household-wardrobe-01.webp', 'Wardrobe - Front View', 1]);
        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid5, 'assets/household-wardrobe-02.webp', 'Wardrobe - Interior', 2]);
        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid5, 'assets/household-wardrobe-03.webp', 'Wardrobe - Drawers', 3]);

        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid5, 'Material', 'High-Grade Steel', 1]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid5, 'Dimensions', '84" x 60" x 22"', 2]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid5, 'Finish', 'Textured Powder Coat', 3]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid5, 'Warranty', '10 Years', 4]);

        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid5, 'Magnetic door latch system', 'fa-magnet', 1]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid5, 'Full-length mirror on door', 'fa-mirror', 2]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid5, '3 deep drawers for accessories', 'fa-drawer', 3]);

        // ---- Product 6: Dining Set DS-301 ----
        $pdo->prepare("INSERT INTO products (category_id, name, slug, short_description, description, price, sku, unit, stock, featured_image, status, featured, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,1,?,?)")->execute([
            3,
            'Dining Set DS-301',
            'dining-set-ds-301',
            'Contemporary steel dining set with tempered glass top and cushioned chairs.',
            'The Dining Set DS-301 brings sophistication to your dining space. Featuring a sturdy steel frame with a tempered glass table top and four upholstered chairs, this set is perfect for modern families. The powder-coated steel ensures long-lasting beauty while being easy to clean and maintain.',
            420.00,
            'KSM-DS-301',
            'Set',
            15,
            'assets/dining-set-ds-301-01.webp',
            1,
            1,
            1
        ]);
        $pid6 = $pdo->lastInsertId();

        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid6, 'assets/dining-set-ds-301-01.webp', 'Dining Set - Full View', 1]);
        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid6, 'assets/dining-set-ds-301-02.webp', 'Dining Set - Table Detail', 2]);
        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid6, 'assets/dining-set-ds-301-03.webp', 'Dining Set - Chair Detail', 3]);

        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid6, 'Material', 'Steel + Tempered Glass', 1]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid6, 'Table Dimensions', '48" x 30" x 30"', 2]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid6, 'Seating Capacity', '4 Persons', 3]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid6, 'Warranty', '5 Years', 4]);

        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid6, 'Tempered glass top for easy cleaning', 'fa-glass-water', 1]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid6, 'Ergonomic cushioned chairs', 'fa-chair', 2]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid6, 'Scratch-resistant table surface', 'fa-ban', 3]);

        // ---- Product 7: Main Entrance Security Gate ----
        $pdo->prepare("INSERT INTO products (category_id, name, slug, short_description, description, price, sku, unit, stock, featured_image, status, featured, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,1,?,?)")->execute([
            4,
            'Main Entrance Security Gate',
            'main-entrance-security-gate',
            'Heavy-duty steel security gate with elegant wrought-iron design.',
            'The Main Entrance Security Gate is engineered for both security and curb appeal. Crafted from heavy-gauge steel with intricate wrought-iron detailing, this gate features a dual-locking system, corrosion-resistant finish, and reinforced hinges. Custom sizes available to fit any entrance.',
            550.00,
            'KSM-DSG-501',
            'Unit',
            10,
            'assets/security-gate-01.webp',
            1,
            0,
            1
        ]);
        $pid7 = $pdo->lastInsertId();

        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid7, 'assets/security-gate-01.webp', 'Security Gate - Front', 1]);
        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid7, 'assets/security-gate-02.webp', 'Security Gate - Detail', 2]);

        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid7, 'Material', 'Heavy-Gauge Steel', 1]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid7, 'Dimensions', '72" x 48" (customizable)', 2]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid7, 'Finish', 'Wrought Iron Powder Coated', 3]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid7, 'Warranty', '15 Years', 4]);

        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid7, 'Dual-lock security system', 'fa-lock', 1]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid7, 'Weather-resistant powder coating', 'fa-cloud-sun', 2]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid7, 'Reinforced hinges with ball bearings', 'fa-cog', 3]);

        // ---- Product 8: Garden Steel Gazebo ----
        $pdo->prepare("INSERT INTO products (category_id, name, slug, short_description, description, price, sku, unit, stock, featured_image, status, featured, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,1,?,?)")->execute([
            6,
            'Garden Steel Gazebo',
            'garden-steel-gazebo',
            'Spacious steel gazebo with polycarbonate roof for outdoor entertaining.',
            'The Garden Steel Gazebo transforms your outdoor space into an elegant entertainment area. Made from corrosion-resistant steel with a weatherproof polycarbonate roof, it provides shade and shelter for garden gatherings. Features include decorative lattice panels, integrated gutter system, and mosquito netting options.',
            780.00,
            'KSM-GG-601',
            'Unit',
            8,
            'assets/garden-gazebo-01.webp',
            1,
            1,
            1
        ]);
        $pid8 = $pdo->lastInsertId();

        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid8, 'assets/garden-gazebo-01.webp', 'Gazebo - Front View', 1]);
        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid8, 'assets/garden-gazebo-02.webp', 'Gazebo - Interior', 2]);
        $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([$pid8, 'assets/garden-gazebo-03.webp', 'Gazebo - Detail', 3]);

        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid8, 'Material', 'Corrosion-Resistant Steel', 1]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid8, 'Dimensions', '120" x 96" x 108"', 2]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid8, 'Roof Material', 'Polycarbonate + Steel', 3]);
        $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([$pid8, 'Warranty', '10 Years', 4]);

        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid8, 'UV-protected polycarbonate roof', 'fa-sun', 1]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid8, 'Integrated gutter drainage system', 'fa-water', 2]);
        $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([$pid8, 'Decorative steel lattice panels', 'fa-border-all', 3]);

        echo "Seeded: ProductSeeder\n";
    }
}
