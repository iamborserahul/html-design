<?php

class HeroSlideSeeder {
    public function run($pdo) {
        $slides = [
            [
                'Timeless Elegance. Unmatched Strength',
                'Premium Metal Beds & Bunks',
                'Discover our collection of handcrafted steel beds that blend timeless design with industrial strength. Built to last a lifetime.',
                'assets/slider/bed-slider.png',
                'Explore Collection',
                '/products/metal-beds-bunks',
                1
            ],
            [
                'Designed for Beautiful Living',
                'Bathroom Vanities & Storage',
                'Transform your bathroom into a sanctuary of style with our premium steel vanities and storage solutions.',
                'assets/slider/bathroom-slider.png',
                'View Bathroom Range',
                '/products/dining-bathroom',
                2
            ],
            [
                'Wardrobes Designed for Every Style',
                'Steel Cupboards & Wardrobes',
                'From sleek modern to classic elegance — find the perfect wardrobe that complements your space and style.',
                'assets/slider/wardrobe-slider.png',
                'Shop Wardrobes',
                '/products/steel-cupboards',
                3
            ],
            [
                'Where Style Meets Smart Storage',
                'Dining Sets & Kitchen Storage',
                'Elevate your dining experience with steel furniture that combines smart storage with contemporary style.',
                'assets/slider/dining-slider.png',
                'Explore Dining Sets',
                '/products/dining-bathroom',
                4
            ],
            [
                'Where Comfort Meets Architectural Elegance',
                'Outdoor Gazebos & Furniture',
                'Create your perfect outdoor retreat with our elegant steel gazebos and garden furniture collections.',
                'assets/slider/gazebo-slider.png',
                'Outdoor Collection',
                '/products/outdoor-furniture',
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
