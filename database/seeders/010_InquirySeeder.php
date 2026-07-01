<?php

class InquirySeeder {
    public function run($pdo) {
        $inquiries = [
            [
                'Suresh Kumar',
                'suresh.kumar@email.com',
                '+91 98765 12345',
                'Greenfield Developers',
                'Bulk Order Inquiry - Steel Cupboards',
                'We are developing a 200-unit residential complex and need steel cupboards for all units. Could you please share your bulk pricing for the Sliding Almirah and Household Wardrobe models? Looking for delivery within 45 days.',
            ],
            [
                'Maria Gonzalez',
                'maria.g@importexport.com',
                '+1 305 555 7890',
                'Gonzalez Imports LLC',
                'International Shipping - Product Pricing',
                'I am interested in importing your Platform Bed (7201) and Dining Set DS-301 for our retail stores in Miami. Please provide FOB pricing, minimum order quantities, and estimated shipping timeline to the Port of Miami.',
            ],
            [
                'Ankit Shah',
                'ankit.shah@email.com',
                '+91 99887 66554',
                '',
                'Customization Request - Security Gate',
                'I need a customized main entrance security gate for my farmhouse. The opening width is 96 inches and height 84 inches. Can you manufacture this in a custom wrought-iron design? Please share a quote and design options.',
            ],
        ];

        $stmt = $pdo->prepare("INSERT INTO inquiries (name, email, phone, company, subject, message) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($inquiries as $inq) {
            $stmt->execute($inq);
        }
        echo "Seeded: InquirySeeder\n";
    }
}
