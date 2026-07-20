<?php

class HeroSlideSeeder {
    public function run($pdo) {
        $slides = [
            [
                'Timeless Elegance. Unmatched Strength',
                'PREMIUM WOOD & METAL BED COLLECTION',
                'Engineered with premium materials and superior craftsmanship, these beds combine modern elegance with rock-solid strength to enhance every bedroom.',
                'bed-slider.png',
                'Explore Collection',
                '#contact',
                1
            ],
            [
                'Designed for Beautiful Living',
                'MODERN BATHROOM VANITIES',
                'Exquisitely crafted vanities that bring elegance, durability, and modern sophistication to your bathroom.',
                'bathroom-slider.png',
                'View Bathroom Range',
                '#contact',
                2
            ],
            [
                'Wardrobes Designed for Every Style',
                'MODERN WARDROBES',
                'From sleek sliding doors to spacious hinged wardrobes, our collection combines premium aesthetics, smart organization, and durable construction to complement any bedroom style.',
                'fwardrobe-slider.png',
                'Shop Wardrobes',
                '#contact',
                3
            ],
            [
                'Where Style Meets Smart Storage',
                'MODERN DINING TABLES',
                'Expertly crafted wardrobes featuring elegant designs, intelligent organization, and lasting durability to elevate every bedroom.',
                'dining-slider.png',
                'Explore Dining Sets',
                '#contact',
                4
            ],
            [
                'Where Comfort Meets Architectural Elegance',
                'MODERN GAZEBOS',
                'Enhance your outdoor lifestyle with beautifully designed gazebos that offer style, shelter, and enduring performance.',
                'gazebo-slider.png',
                'Outdoor Collection',
                '#contact',
                5
            ],
        ];

        $stmt = $pdo->prepare("INSERT INTO hero_slides (title, subtitle, description, image, btn_text, btn_link, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
        foreach ($slides as $slide) {
            $stmt->execute($slide);
        }
        echo "Seeded: HeroSlideSeeder\n";
    }
}
