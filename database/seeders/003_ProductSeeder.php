<?php

class ProductSeeder {
    public function run($pdo) {
        // Helper function to insert product and its details
        $insertProduct = function($data) use ($pdo) {
            $pdo->prepare("INSERT INTO products (category_id, name, slug, short_description, description, price, sku, unit, stock, featured_image, status, featured, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)")->execute([
                $data['category_id'],
                $data['name'],
                $data['slug'],
                $data['short_description'],
                $data['description'],
                $data['price'],
                $data['sku'],
                $data['unit'],
                $data['stock'],
                $data['featured_image'],
                1, // status
                $data['featured'],
                $data['sort_order']
            ]);
            $pid = $pdo->lastInsertId();

            if (!empty($data['images'])) {
                foreach ($data['images'] as $idx => $img) {
                    $pdo->prepare("INSERT INTO product_images (product_id, image, alt_text, sort_order) VALUES (?,?,?,?)")->execute([
                        $pid, $img, $data['name'] . ' - Image ' . ($idx + 1), $idx + 1
                    ]);
                }
            }

            if (!empty($data['specs'])) {
                foreach ($data['specs'] as $idx => $spec) {
                    $pdo->prepare("INSERT INTO product_specs (product_id, label, value, sort_order) VALUES (?,?,?,?)")->execute([
                        $pid, $spec[0], $spec[1], $idx + 1
                    ]);
                }
            }

            if (!empty($data['features'])) {
                foreach ($data['features'] as $idx => $feat) {
                    $pdo->prepare("INSERT INTO product_features (product_id, feature, icon, sort_order) VALUES (?,?,?,?)")->execute([
                        $pid, $feat[0], $feat[1], $idx + 1
                    ]);
                }
            }
        };

        // ---- 1. Platform Bed (7201) ----
        $insertProduct([
            'category_id' => 1,
            'name' => 'Platform Bed (7201)',
            'slug' => 'platform-bed-7201',
            'short_description' => 'Modern steel platform bed with elegant finish and sturdy construction.',
            'description' => 'The Platform Bed (7201) combines contemporary design with industrial strength. Crafted from heavy-gauge steel with a powder-coated finish, this bed frame requires no box spring and offers ample under-bed storage. Perfect for modern bedrooms seeking durability and style.',
            'price' => 185.00,
            'sku' => 'KSM-BED-7201',
            'unit' => 'Unit',
            'stock' => 50,
            'featured_image' => 'assets/metal-bed-7201-01.webp',
            'featured' => 1,
            'sort_order' => 1,
            'images' => ['assets/metal-bed-7201-01.webp', 'assets/metal-bed-7201-02.webp', 'assets/metal-bed-7201-03.webp'],
            'specs' => [
                ['Material', 'Heavy-Gauge Steel'],
                ['Dimensions', '78" x 60" x 14"'],
                ['Weight Capacity', '500 kg'],
                ['Finish', 'Powder Coated']
            ],
            'features' => [
                ['No box spring required', 'fa-bed'],
                ['Under-bed storage space', 'fa-box'],
                ['Rust-resistant powder coating', 'fa-shield-alt']
            ]
        ]);

        // ---- 2. Adjustable Folding Bed ----
        $insertProduct([
            'category_id' => 1,
            'name' => 'Adjustable Folding Bed',
            'slug' => 'adjustable-folding-bed',
            'short_description' => 'Space-saving folding bed with adjustable positions for versatile use.',
            'description' => 'The Adjustable Folding Bed is designed for maximum space efficiency. Easily foldable and adjustable to multiple positions, it serves as a comfortable sleeping solution for guests, offices, and compact living spaces. Built with a reinforced steel frame and premium mattress.',
            'price' => 145.00,
            'sku' => 'KSM-AFB-101',
            'unit' => 'Unit',
            'stock' => 35,
            'featured_image' => 'assets/adjustable-bed.png',
            'featured' => 0,
            'sort_order' => 2,
            'images' => ['assets/adjustable-bed.png', 'assets/adjustable-bad2.png'],
            'specs' => [
                ['Material', 'Reinforced Steel Frame'],
                ['Dimensions (Open)', '75" x 36" x 18"'],
                ['Dimensions (Folded)', '36" x 30" x 8"'],
                ['Weight Capacity', '250 kg']
            ],
            'features' => [
                ['3-position adjustable backrest', 'fa-cog'],
                ['Easy fold-and-store mechanism', 'fa-compress-alt'],
                ['Includes 4-inch foam mattress', 'fa-mattress-pillow']
            ]
        ]);

        // ---- 3. Bucharest Sofa Bunk Bed ----
        $insertProduct([
            'category_id' => 1,
            'name' => 'Bucharest Sofa Bunk Bed',
            'slug' => 'bucharest-sofa-bunk-bed',
            'short_description' => 'Innovative sofa-cum-bunk bed with built-in storage and study table.',
            'description' => 'The Bucharest Sofa Bunk Bed is a multi-functional marvel. By day it serves as a stylish sofa, and by night it converts into a comfortable bunk bed. Features built-in storage drawers and a pull-out study table, making it perfect for kids\' rooms and space-saving interiors.',
            'price' => 320.00,
            'sku' => 'KSM-BSB-202',
            'unit' => 'Unit',
            'stock' => 20,
            'featured_image' => 'assets/bucharest-sofa-bunk-01.webp',
            'featured' => 1,
            'sort_order' => 3,
            'images' => ['assets/bucharest-sofa-bunk-01.webp', 'assets/bucharest-sofa-bunk-02.webp', 'assets/bucharest-sofa-bunk-03.webp'],
            'specs' => [
                ['Material', 'Premium Steel + Plywood'],
                ['Dimensions', '82" x 48" x 72"'],
                ['Mattress Size', '75" x 36" (Twin)'],
                ['Warranty', '5 Years']
            ],
            'features' => [
                ['Sofa-to-bunk convertible design', 'fa-couch'],
                ['Built-in storage drawers', 'fa-drawer'],
                ['Pull-out study table included', 'fa-desk']
            ]
        ]);

        // ---- 4. Vladivostok Bunk Bed ----
        $insertProduct([
            'category_id' => 1,
            'name' => 'Vladivostok Bunk Bed',
            'slug' => 'vladivostok-bunk-bed',
            'short_description' => 'Compact and safe double-decker bunk bed with robust steel safety rails.',
            'description' => 'The Vladivostok Bunk Bed is built for absolute safety and structural longevity. Designed with reinforced steel columns, circular posts, and extra-high guard rails, this bed provides a secure double-deck sleeping layout suitable for homes, hostels, and student housing.',
            'price' => 290.00,
            'sku' => 'KSM-VBB-203',
            'unit' => 'Unit',
            'stock' => 15,
            'featured_image' => 'assets/vladivostok-bunk-bed-01.webp',
            'featured' => 0,
            'sort_order' => 4,
            'images' => ['assets/vladivostok-bunk-bed-01.webp', 'assets/vladivostok-bunk-bed-02.webp', 'assets/vladivostok-bunk-bed-03.webp'],
            'specs' => [
                ['Material', 'Reinforced Circular Steel'],
                ['Dimensions', '78" x 38" x 65"'],
                ['Guard Rail Height', '15 inches'],
                ['Ladder Type', 'Integrated Vertical']
            ],
            'features' => [
                ['High-altitude boundary safety bars', 'fa-shield-halved'],
                ['Anti-squeak rubber dampeners', 'fa-volume-mute'],
                ['Industrial scratch-proof powder coat', 'fa-paint-roller']
            ]
        ]);

        // ---- 5. Origami Bunk Bed ----
        $insertProduct([
            'category_id' => 1,
            'name' => 'Origami Bunk Bed',
            'slug' => 'origami-bunk-bed',
            'short_description' => 'Sleek minimalist steel bunk bed layout with convertible single beds option.',
            'description' => 'The Origami Bunk Bed features clean lines and a highly versatile framework. It can be easily split into two independent single beds as your needs change. Constructed using premium sheet metal and tubular carbon steel with odorless, fire-safe organic coatings.',
            'price' => 310.00,
            'sku' => 'KSM-OBB-204',
            'unit' => 'Unit',
            'stock' => 18,
            'featured_image' => 'assets/origami-bunk-bed-01.webp',
            'featured' => 1,
            'sort_order' => 5,
            'images' => ['assets/origami-bunk-bed-01.webp', 'assets/origami-bunk-bed-02.webp', 'assets/origami-bunk-bed-03.webp'],
            'specs' => [
                ['Material', 'Premium Sheet & Carbon Steel'],
                ['Dimensions', '79" x 40" x 68"'],
                ['Convertible', 'Splits into 2 single beds'],
                ['Finish', 'Baked Epoxy Powder']
            ],
            'features' => [
                ['Convertible dual-bed framework', 'fa-arrows-split-up-and-left'],
                ['Odorless, organic coatings', 'fa-leaf'],
                ['Child-safe rounded profiles', 'fa-child']
            ]
        ]);

        // ---- 6. Nature Bunk Bed ----
        $insertProduct([
            'category_id' => 1,
            'name' => 'Nature Bunk Bed',
            'slug' => 'nature-bunk-bed',
            'short_description' => 'Eco-friendly design sturdy bunk bed with modern aesthetic.',
            'description' => 'Inspired by natural simplicity, the Nature Bunk Bed features durable structural panels with organic styling. Combining the warmth of design details with the absolute strength of steel frames, it offers a secure and beautiful addition to family bedrooms.',
            'price' => 330.00,
            'sku' => 'KSM-NBB-205',
            'unit' => 'Unit',
            'stock' => 12,
            'featured_image' => 'assets/nature-bunk-bed-01.webp',
            'featured' => 0,
            'sort_order' => 6,
            'images' => ['assets/nature-bunk-bed-01.webp', 'assets/nature-bunk-bed-02.webp', 'assets/nature-bunk-bed-03.webp'],
            'specs' => [
                ['Material', 'High-Strength Tubular Steel'],
                ['Dimensions', '78" x 39" x 70"'],
                ['Style', 'Modern Eco-Aesthetic'],
                ['Warranty', '5 Years']
            ],
            'features' => [
                ['Heavy-duty load capacity columns', 'fa-weight-hanging'],
                ['Easy-climb slip-resistant ladder', 'fa-ladder'],
                ['Toxics-free electrostatic coating', 'fa-shield-virus']
            ]
        ]);

        // ---- 7. Double Arch Tubular Bed (7202) ----
        $insertProduct([
            'category_id' => 1,
            'name' => 'Double Arch Tubular Bed (7202)',
            'slug' => 'double-arch-tubular-bed-7202',
            'short_description' => 'Heavy-duty circular steel tube bed frame with elegant double-arch headboard.',
            'description' => 'The Double Arch Tubular Bed (7202) is engineered for commercial-grade durability and clean style. It features a high-grade circular steel tube headboard and footboard, noise-free seamless welding, and thick thermal powder-coated protection.',
            'price' => 195.00,
            'sku' => 'KSM-TAB-7202',
            'unit' => 'Unit',
            'stock' => 40,
            'featured_image' => 'assets/metal-bed-7202-01.webp',
            'featured' => 0,
            'sort_order' => 7,
            'images' => ['assets/metal-bed-7202-01.webp', 'assets/metal-bed-7202-02.webp', 'assets/metal-bed-7202-03.webp'],
            'specs' => [
                ['Material', 'Circular Carbon Steel Tubes'],
                ['Tube Wall Thickness', '2.0 mm'],
                ['Dimensions', '78" x 60" x 18"'],
                ['Finish', '7-Tank Pretreated Powder Coating']
            ],
            'features' => [
                ['Double-arch reinforced headboard', 'fa-heading'],
                ['Noise-free carbon-dioxide welding', 'fa-compress'],
                ['Scratch-proof adjustable feet', 'fa-circle-dot']
            ]
        ]);

        // ---- 8. Sliding Almirah ----
        $insertProduct([
            'category_id' => 2,
            'name' => 'Sliding Almirah',
            'slug' => 'sliding-almirah',
            'short_description' => 'Elegant steel almirah with sliding doors and ample storage space.',
            'description' => 'The Sliding Almirah offers sleek modern storage with smooth-glide doors. Made from high-grade steel with a premium powder-coated finish, it features adjustable shelves, hanging rods, and internal drawers. Designed to maximize wardrobe space while adding a contemporary touch to any room.',
            'price' => 280.00,
            'sku' => 'KSM-SA-301',
            'unit' => 'Unit',
            'stock' => 30,
            'featured_image' => 'assets/sliding-almirah-01.webp',
            'featured' => 1,
            'sort_order' => 8,
            'images' => ['assets/sliding-almirah-01.webp', 'assets/sliding-almirah-02.webp', 'assets/sliding-almirah-03.webp'],
            'specs' => [
                ['Material', 'High-Grade Steel'],
                ['Dimensions', '72" x 48" x 20"'],
                ['Finish', 'Premium Powder Coated'],
                ['Warranty', '10 Years']
            ],
            'features' => [
                ['Smooth ball-bearing sliding doors', 'fa-door-open'],
                ['Adjustable shelves and hanging rod', 'fa-sliders-h'],
                ['Anti-rust treatment', 'fa-shield-virus']
            ]
        ]);

        // ---- 9. Household Wardrobe ----
        $insertProduct([
            'category_id' => 2,
            'name' => 'Household Wardrobe',
            'slug' => 'household-wardrobe',
            'short_description' => 'Spacious steel wardrobe with hinged doors and smart organization.',
            'description' => 'The Household Wardrobe combines classic design with modern functionality. This spacious steel wardrobe features hinged doors with magnetic locks, multiple compartments, deep drawers, and a full-length mirror option. Ideal for family bedrooms requiring durable and organized clothing storage.',
            'price' => 350.00,
            'sku' => 'KSM-HW-401',
            'unit' => 'Unit',
            'stock' => 25,
            'featured_image' => 'assets/household-wardrobe-02.webp',
            'featured' => 0,
            'sort_order' => 9,
            'images' => ['assets/household-wardrobe-02.webp', 'assets/household-wardrobe-021.webp'],
            'specs' => [
                ['Material', 'High-Grade Steel'],
                ['Dimensions', '84" x 60" x 22"'],
                ['Finish', 'Textured Powder Coat'],
                ['Warranty', '10 Years']
            ],
            'features' => [
                ['Magnetic door latch system', 'fa-magnet'],
                ['Full-length mirror on door', 'fa-mirror'],
                ['3 deep drawers for accessories', 'fa-drawer']
            ]
        ]);

        // ---- 10. Office Locker Cabinet ----
        $insertProduct([
            'category_id' => 2,
            'name' => 'Office Locker Cabinet',
            'slug' => 'office-locker-cabinet',
            'short_description' => 'Heavy-duty multi-door steel office locker cabinet featuring individual secure key latches.',
            'description' => 'The Office Locker Cabinet offers secure personal storage compartments for corporate offices, warehouses, schools, and health facilities. Features individual locks, ventilation louvers, and label slots on every door.',
            'price' => 220.00,
            'sku' => 'KSM-OLC-402',
            'unit' => 'Unit',
            'stock' => 20,
            'featured_image' => 'assets/office-locker-cabinet-01.webp',
            'featured' => 0,
            'sort_order' => 10,
            'images' => ['assets/office-locker-cabinet-01.webp'],
            'specs' => [
                ['Material', 'Cold-Rolled Sheet Metal'],
                ['Dimensions', '71" x 35" x 18"'],
                ['Door Options', '6, 9 or 12 Doors'],
                ['Finish', 'Industrial Light Grey Powder']
            ],
            'features' => [
                ['Secure individual latch keys', 'fa-key'],
                ['Laser-cut door ventilation louvers', 'fa-wind'],
                ['Integrated plastic name index slots', 'fa-id-card']
            ]
        ]);

        // ---- 11. Industrial Tool Cabinet ----
        $insertProduct([
            'category_id' => 2,
            'name' => 'Industrial Tool Cabinet',
            'slug' => 'industrial-tool-cabinet',
            'short_description' => 'Ultra-sturdy heavy-duty tool storage cabinet with drawer dividers.',
            'description' => 'Engineered for workshops and industrial environments, the Tool Cabinet features reinforced steel construction, ball-bearing drawer sliders, and central lock safety to hold up to 800kg of machinery and tools.',
            'price' => 390.00,
            'sku' => 'KSM-ITC-501',
            'unit' => 'Unit',
            'stock' => 15,
            'featured_image' => 'assets/industrial-tool-cabinet-01.webp',
            'featured' => 0,
            'sort_order' => 11,
            'images' => ['assets/industrial-tool-cabinet-01.webp', 'assets/industrial-tool-cabinet-new.jpg'],
            'specs' => [
                ['Material', 'High-Strength Carbon Steel'],
                ['Load Capacity', '800 kg total'],
                ['Dimensions', '55" x 30" x 24"'],
                ['Finish', 'Corrosion-Resistant Epoxy']
            ],
            'features' => [
                ['Reinforced central locking system', 'fa-lock-open'],
                ['High-load ball-bearing drawers', 'fa-sliders'],
                ['Integrated dividers for accessories', 'fa-cubes']
            ]
        ]);

        // ---- 12. Dining Set DS-301 ----
        $insertProduct([
            'category_id' => 3,
            'name' => 'Dining Set DS-301',
            'slug' => 'dining-set-ds-301',
            'short_description' => 'Contemporary steel dining set with tempered glass top and cushioned chairs.',
            'description' => 'The Dining Set DS-301 brings sophistication to your dining space. Featuring a sturdy steel frame with a tempered glass table top and four upholstered chairs, this set is perfect for modern families. The powder-coated steel ensures long-lasting beauty while being easy to clean and maintain.',
            'price' => 420.00,
            'sku' => 'KSM-DS-301',
            'unit' => 'Set',
            'stock' => 15,
            'featured_image' => 'assets/dining-set-ds301-01.webp',
            'featured' => 1,
            'sort_order' => 12,
            'images' => ['assets/dining-set-ds301-01.webp', 'assets/dining-set-ds301-02.webp', 'assets/dining-set-ds301-03.webp'],
            'specs' => [
                ['Material', 'Steel + Tempered Glass'],
                ['Table Dimensions', '48" x 30" x 30"'],
                ['Seating Capacity', '4 Persons'],
                ['Warranty', '5 Years']
            ],
            'features' => [
                ['Tempered glass top for easy cleaning', 'fa-glass-water'],
                ['Ergonomic cushioned chairs', 'fa-chair'],
                ['Scratch-resistant table surface', 'fa-ban']
            ]
        ]);

        // ---- 13. Modular Vanity Cabinet ----
        $insertProduct([
            'category_id' => 3,
            'name' => 'Modular Vanity Cabinet',
            'slug' => 'modular-vanity-cabinet',
            'short_description' => 'Waterproof steel bathroom vanity cupboard with integrated ceramic basin.',
            'description' => 'The Modular Vanity Cabinet provides a luxury modern storage layout for high-end bathrooms. Built using rust-proof sheet steel with powder coating, this cabinet features soft-closing hinges and ample interior space.',
            'price' => 240.00,
            'sku' => 'KSM-MVC-302',
            'unit' => 'Unit',
            'stock' => 22,
            'featured_image' => 'assets/modular-vanity-cabinet-01.webp',
            'featured' => 0,
            'sort_order' => 13,
            'images' => ['assets/modular-vanity-cabinet-01.webp', 'assets/modular-vanity-cabinet-02.webp', 'assets/modular-vanity-cabinet-03.webp'],
            'specs' => [
                ['Material', 'Rust-Proof Galvanized Steel'],
                ['Basin Material', 'Premium Vitreous Ceramic'],
                ['Dimensions', '32" x 24" x 20"'],
                ['Finish', 'Waterproof High-Gloss Coat']
            ],
            'features' => [
                ['Waterproof and humidity resistant', 'fa-droplet-slash'],
                ['Premium soft-close door dampers', 'fa-door-closed'],
                ['High-gloss paint finish', 'fa-sparkles']
            ]
        ]);

        // ---- 14. Main Entrance Security Gate ----
        $insertProduct([
            'category_id' => 4,
            'name' => 'Main Entrance Security Gate',
            'slug' => 'main-entrance-security-gate',
            'short_description' => 'Heavy-duty steel security gate with elegant wrought-iron design.',
            'description' => 'The Main Entrance Security Gate is engineered for both security and curb appeal. Crafted from heavy-gauge steel with intricate wrought-iron detailing, this gate features a dual-locking system, corrosion-resistant finish, and reinforced hinges. Custom sizes available to fit any entrance.',
            'price' => 550.00,
            'sku' => 'KSM-DSG-501',
            'unit' => 'Unit',
            'stock' => 10,
            'featured_image' => 'assets/main-entrance-gate-01.webp',
            'featured' => 0,
            'sort_order' => 14,
            'images' => ['assets/main-entrance-gate-01.webp', 'assets/main-entrance-gate-02.webp', 'assets/main-entrance-gate-03.webp'],
            'specs' => [
                ['Material', 'Heavy-Gauge Steel'],
                ['Dimensions', '72" x 48" (customizable)'],
                ['Finish', 'Wrought Iron Powder Coated'],
                ['Warranty', '15 Years']
            ],
            'features' => [
                ['Dual-lock security system', 'fa-lock'],
                ['Weather-resistant powder coating', 'fa-cloud-sun'],
                ['Reinforced hinges with ball bearings', 'fa-cog']
            ]
        ]);

        // ---- 15. Fire Safety Door ----
        $insertProduct([
            'category_id' => 4,
            'name' => 'Fire Safety Door',
            'slug' => 'fire-safety-door',
            'short_description' => 'Certified high-temperature fire resistant steel door with panic bar.',
            'description' => 'The Fire Safety Door is designed to withstand extreme thermal conditions for commercial and institutional emergency exits. Features premium thermal insulation core and heavy-duty panic exit push hardware.',
            'price' => 450.00,
            'sku' => 'KSM-FSD-502',
            'unit' => 'Unit',
            'stock' => 12,
            'featured_image' => 'assets/fire-safety-door-03.webp',
            'featured' => 0,
            'sort_order' => 15,
            'images' => ['assets/fire-safety-door-03.webp'],
            'specs' => [
                ['Material', 'Galvanized Steel + Mineral Core'],
                ['Fire Rating', '120 Minutes'],
                ['Dimensions', '80" x 36" x 2"'],
                ['Hardware', 'Panic Push Bar + Heavy Lock']
            ],
            'features' => [
                ['UL-certified fire rating insulation', 'fa-fire-shield'],
                ['Quick-release emergency push bar', 'fa-door-open'],
                ['Smoke-tight expanding perimeter seal', 'fa-smog']
            ]
        ]);

        // ---- 16. ICU Fowler Bed ----
        $insertProduct([
            'category_id' => 5,
            'name' => 'ICU Fowler Bed',
            'slug' => 'icu-fowler-bed',
            'short_description' => 'Advanced mechanical ICU ward bed with dual backrest and knee adjustments.',
            'description' => 'Designed for critical healthcare setups, the ICU Fowler Bed offers smooth crank-operated adjustments for head elevation and knee fatigue relief, complete with collapsible safety side rails.',
            'price' => 520.00,
            'sku' => 'KSM-IFB-601',
            'unit' => 'Unit',
            'stock' => 10,
            'featured_image' => 'assets/icu-fowler-bed-01.webp',
            'featured' => 1,
            'sort_order' => 16,
            'images' => ['assets/icu-fowler-bed-01.webp'],
            'specs' => [
                ['Material', 'Structural Carbon Steel + ABS Panel'],
                ['Adjustment', 'Dual Crank (Backrest & Knee)'],
                ['Casters', '4" Anti-Dust Swivel with Brake'],
                ['Weight Limit', '250 kg']
            ],
            'features' => [
                ['Collapsible ABS safety side barriers', 'fa-ban'],
                ['Detachable head and foot panels', 'fa-rotate'],
                ['IV stand infusion socket mounts', 'fa-syringe']
            ]
        ]);

        // ---- 17. Semi-Fowler Bed ----
        $insertProduct([
            'category_id' => 5,
            'name' => 'Semi-Fowler Bed',
            'slug' => 'semi-fowler-bed',
            'short_description' => 'Hospital ward bed with single crank adjustable backrest system.',
            'description' => 'The Semi-Fowler Bed is a simple, highly durable solution for patient recovery rooms. Features robust steel wire mesh platform and a single manually operated backrest angle controller.',
            'price' => 380.00,
            'sku' => 'KSM-SFB-602',
            'unit' => 'Unit',
            'stock' => 15,
            'featured_image' => 'assets/semi-fowler-bed-01.webp',
            'featured' => 0,
            'sort_order' => 17,
            'images' => ['assets/semi-fowler-bed-01.webp'],
            'specs' => [
                ['Material', 'Powder-Coated Tubular Steel'],
                ['Adjustment', 'Single Manual Crank (Backrest)'],
                ['Dimensions', '78" x 35" x 22"'],
                ['Finish', 'Antimicrobial Powder Coating']
            ],
            'features' => [
                ['Manual head elevation adjust crank', 'fa-wrench'],
                ['Durable wire-grid sleeping surface', 'fa-border-all'],
                ['Heavy-duty steel legs with rubber tips', 'fa-socks']
            ]
        ]);

        // ---- 18. Ward Bed ----
        $insertProduct([
            'category_id' => 5,
            'name' => 'Ward Patient Bed',
            'slug' => 'ward-patient-bed',
            'short_description' => 'Standard non-adjustable flat mattress hospital patient bed.',
            'description' => 'Built for general recovery rooms and clinics, this flat metal bed offers absolute stability and easy cleaning with standard antiseptic solutions.',
            'price' => 280.00,
            'sku' => 'KSM-WPB-603',
            'unit' => 'Unit',
            'stock' => 25,
            'featured_image' => 'assets/ward-bed-01.webp',
            'featured' => 0,
            'sort_order' => 18,
            'images' => ['assets/ward-bed-01.webp'],
            'specs' => [
                ['Material', 'Mild Steel Tubular Columns'],
                ['Sleeping surface', 'Perforated Sheet Steel Panel'],
                ['Dimensions', '75" x 36" x 20"'],
                ['Finish', 'Infection-Safe Powder Coat']
            ],
            'features' => [
                ['Completely flat and stable design', 'fa-grip-lines'],
                ['Easy-disinfect surface structure', 'fa-hand-sparkles'],
                ['Integrated IV pole corner slots', 'fa-plus']
            ]
        ]);

        // ---- 19. Emergency Stretcher ----
        $insertProduct([
            'category_id' => 5,
            'name' => 'Emergency Stretcher',
            'slug' => 'emergency-stretcher',
            'short_description' => 'Mobile patient transfer stretcher trolley with side protection guard rails.',
            'description' => 'Designed for fast emergency department patient transfers. Equipped with central braking wheels, oxygen cylinder carriage, and collapsible side protection gates.',
            'price' => 310.00,
            'sku' => 'KSM-EST-604',
            'unit' => 'Unit',
            'stock' => 8,
            'featured_image' => 'assets/stretcher-01.webp',
            'featured' => 0,
            'sort_order' => 19,
            'images' => ['assets/stretcher-01.webp'],
            'specs' => [
                ['Material', 'High-Grade Tubular Steel Frame'],
                ['Mobility', '4 swivel caster wheels with brakes'],
                ['Guard Rails', 'Collapsible steel tubes'],
                ['Finish', 'Antimicrobial powder coating']
            ],
            'features' => [
                ['Central safety locks on wheels', 'fa-lock-open'],
                ['Integrated oxygen tank base mount', 'fa-capsules'],
                ['Tear-proof waterproof mattress top', 'fa-shield-halved']
            ]
        ]);

        // ---- 20. Bedside Locker ----
        $insertProduct([
            'category_id' => 5,
            'name' => 'Hospital Bedside Locker',
            'slug' => 'hospital-bedside-locker',
            'short_description' => 'Compact hospital bedside storage cabinet with top drawer.',
            'description' => 'The Bedside Locker holds patient personal belongings and medical supplies next to ward beds. Crafted from anti-corrosive sheet metal with easy-wipe top surfaces.',
            'price' => 120.00,
            'sku' => 'KSM-HBL-605',
            'unit' => 'Unit',
            'stock' => 30,
            'featured_image' => 'assets/bedside-locker-01.webp',
            'featured' => 0,
            'sort_order' => 20,
            'images' => ['assets/bedside-locker-01.webp'],
            'specs' => [
                ['Material', 'Anti-Corrosive Sheet Metal'],
                ['Layout', '1 drawer, 1 lower cabinet compartment'],
                ['Dimensions', '32" x 16" x 16"'],
                ['Finish', 'Infection-Safe Powder Coat']
            ],
            'features' => [
                ['Smooth-glide upper drawer slider', 'fa-sliders'],
                ['Antiseptic chemical wipe compatibility', 'fa-circle-check'],
                ['Sturdy rubber-capped leveling feet', 'fa-shield']
            ]
        ]);

        // ---- 21. Garden Steel Gazebo ----
        $insertProduct([
            'category_id' => 6,
            'name' => 'Garden Steel Gazebo',
            'slug' => 'garden-steel-gazebo',
            'short_description' => 'Spacious steel gazebo with polycarbonate roof for outdoor entertaining.',
            'description' => 'The Garden Steel Gazebo transforms your outdoor space into an elegant entertainment area. Made from corrosion-resistant steel with a weatherproof polycarbonate roof, it provides shade and shelter for garden gatherings. Features include decorative lattice panels, integrated gutter system, and mosquito netting options.',
            'price' => 780.00,
            'sku' => 'KSM-GG-601',
            'unit' => 'Unit',
            'stock' => 8,
            'featured_image' => 'assets/garden-steel-gazebo-02.webp',
            'featured' => 1,
            'sort_order' => 21,
            'images' => ['assets/garden-steel-gazebo-02.webp', 'assets/garden-steel-gazebo-03.webp'],
            'specs' => [
                ['Material', 'Corrosion-Resistant Steel'],
                ['Dimensions', '120" x 96" x 108"'],
                ['Roof Material', 'Polycarbonate + Steel'],
                ['Warranty', '10 Years']
            ],
            'features' => [
                ['UV-protected polycarbonate roof', 'fa-sun'],
                ['Integrated gutter drainage system', 'fa-water'],
                ['Decorative steel lattice panels', 'fa-border-all']
            ]
        ]);

        // ---- 22. Poolside Recliner Chair ----
        $insertProduct([
            'category_id' => 6,
            'name' => 'Poolside Recliner Chair',
            'slug' => 'poolside-recliner-chair',
            'short_description' => 'Rust-free multi-position luxury outdoor poolside lounger.',
            'description' => 'Crafted for resorts, hotels, and luxury private pools. The Poolside Recliner Chair features a lightweight yet incredibly strong, rust-free steel column post frame, and premium outdoor weather-resistant mesh fabric.',
            'price' => 175.00,
            'sku' => 'KSM-PRC-701',
            'unit' => 'Unit',
            'stock' => 16,
            'featured_image' => 'assets/poolside-recliner-chair-01.webp',
            'featured' => 0,
            'sort_order' => 22,
            'images' => ['assets/poolside-recliner-chair-01.webp', 'assets/poolside-recliner-chair-02.webp', 'assets/poolside-recliner-chair-03.webp'],
            'specs' => [
                ['Material', 'Lightweight Structural Steel'],
                ['Fabric', 'Breathable UV-Resistant Mesh'],
                ['Positions', '5-stage backrest adjustments'],
                ['Finish', 'Anti-Oxidant Powder Coat']
            ],
            'features' => [
                ['5 adjustable lounging positions', 'fa-gears'],
                ['Waterproof quick-dry mesh cloth', 'fa-umbrella'],
                ['Completely stackable space-saving layout', 'fa-boxes']
            ]
        ]);

        echo "Seeded: ProductSeeder\n";
    }
}
