<?php

class TestimonialSeeder {
    public function run($pdo) {
        $testimonials = [
            [
                'Rajesh Mehta',
                'Managing Director',
                'Mehta Interiors',
                'We have been sourcing steel furniture from Khodiyar Steel for over five years. Their product quality, timely delivery, and attention to detail are unmatched in the industry. Highly recommended for commercial projects.',
                5,
                1
            ],
            [
                'Priya Sharma',
                'Homeowner',
                '',
                'I purchased the Platform Bed (7201) and Sliding Almirah for my new home. The craftsmanship is outstanding and the powder-coated finish looks as good as new even after two years. Very happy with my purchase!',
                5,
                2
            ],
            [
                'Amit Patel',
                'Operations Head',
                'Sunrise Hotels & Resorts',
                'Khodiyar Steel supplied bunk beds and wardrobes for our resort chain. The build quality is excellent and their team was very accommodating with custom sizing requirements. A reliable partner for bulk orders.',
                5,
                3
            ],
            [
                'Sneha Desai',
                'Architect',
                'Desai Design Studio',
                'I recommend Khodiyar Steel to all my clients. Their steel furniture offers the perfect balance of aesthetics and durability. The Dining Set DS-301 is one of my favorite pieces for modern homes.',
                5,
                4
            ],
            [
                'Vikram Singh',
                'Project Manager',
                'Gujarat Infrastructure Ltd',
                'We ordered outdoor gazebos and security gates for a residential complex. Khodiyar delivered ahead of schedule and the installation was seamless. The 15-year warranty on the gates speaks volumes about their confidence in product quality.',
                5,
                5
            ],
        ];

        $stmt = $pdo->prepare("INSERT INTO testimonials (name, designation, company, content, rating, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, 1)");
        foreach ($testimonials as $t) {
            $stmt->execute($t);
        }
        echo "Seeded: TestimonialSeeder\n";
    }
}
