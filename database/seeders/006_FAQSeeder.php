<?php

class FAQSeeder {
    public function run($pdo) {
        $faqs = [
            [
                'What is the typical delivery time for orders?',
                'Standard delivery takes 7-14 business days depending on your location and order size. Custom orders may require 2-3 weeks. We provide real-time tracking for all shipments.',
                'Ordering & Delivery',
                1
            ],
            [
                'Do you offer customization options for products?',
                'Yes, we offer extensive customization including dimensions, color finishes, drawer configurations, and hardware choices. Contact our sales team with your requirements and we will provide a quotation within 48 hours.',
                'Customization',
                2
            ],
            [
                'What is the quality guarantee on your products?',
                'All Khodiyar Steel products come with a minimum 5-year structural warranty. Our powder-coated finishes are tested for 500+ hours of salt spray resistance. We use automotive-grade paint for superior durability.',
                'Quality & Warranty',
                3
            ],
            [
                'How does the warranty work?',
                'Our warranty covers manufacturing defects, structural integrity issues, and premature finish failure. Simply contact us with your order number and issue details. We will arrange inspection and resolution within 7 days.',
                'Quality & Warranty',
                4
            ],
            [
                'Do you ship internationally?',
                'Yes, we export to USA, UK, Canada, Australia, Middle East, and Africa. International shipping costs vary by destination and order volume. We handle all export documentation and customs clearance.',
                'International Shipping',
                5
            ],
            [
                'What are the payment terms?',
                'Domestic orders: 50% advance, 50% before dispatch. International orders: 30% advance, 70% against shipping documents. We accept bank transfers, UPI, and Letter of Credit for bulk orders.',
                'Payment',
                6
            ],
            [
                'Is there a minimum order quantity?',
                'For retail customers, there is no minimum order quantity. For wholesale and bulk orders, we offer tiered pricing with MOQs starting at 10 units per product. Contact our B2B team for a customized quote.',
                'Ordering & Delivery',
                7
            ],
            [
                'What after-sales support do you provide?',
                'We provide lifetime technical support for all products. Our service team is available Monday-Saturday, 9 AM to 6 PM. We also offer paid installation services and spare parts for all products.',
                'After-Sales Support',
                8
            ],
            [
                'Can I get a sample before placing a bulk order?',
                'Yes, sample orders are welcome. The sample cost is deducted from your first bulk order. Samples are dispatched within 3-5 business days. Shipping charges apply.',
                'Ordering & Delivery',
                9
            ],
            [
                'How do I clean and maintain steel furniture?',
                'Wipe with a soft damp cloth and mild detergent. Avoid abrasive cleaners or scouring pads. For powder-coated surfaces, periodic waxing helps maintain the gloss. Our finishes are designed for low-maintenance care.',
                'Quality & Warranty',
                10
            ],
        ];

        $stmt = $pdo->prepare("INSERT INTO faqs (question, answer, category, sort_order, status) VALUES (?, ?, ?, ?, 1)");
        foreach ($faqs as $faq) {
            $stmt->execute($faq);
        }
        echo "Seeded: FAQSeeder\n";
    }
}
