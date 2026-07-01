<?php

class TeamMemberSeeder {
    public function run($pdo) {
        $members = [
            [
                'Mr. Vimalbhai Sakariya',
                'Founder & Managing Director',
                'With over 30 years of experience in the steel fabrication industry, Mr. Vimalbhai Sakariya founded Khodiyar Steel in 1998 with a vision to deliver world-class steel furniture. His leadership and commitment to quality have made the company a trusted name in the industry.',
                'assets/ceo.png',
                'vimal@khodiyarsteel.com',
                '+91 90999 99266',
                1
            ],
            [
                'Mr. Manthan Sakariya',
                'Chief Executive Officer',
                'Mr. Manthan Sakariya brings modern management expertise and a passion for innovation. He has spearheaded the company\'s digital transformation and expansion into international markets, driving year-on-year growth of 25%.',
                'assets/manthan-sakariya-ceo.png',
                'manthan@khodiyarsteel.com',
                '+91 98765 43210',
                2
            ],
            [
                'Mr. Nayan Patel',
                'Chief Operating Officer',
                'Mr. Nayan Patel oversees day-to-day operations, production, and supply chain management. With a background in industrial engineering, he ensures that every product meets Khodiyar Steel\'s exacting standards of quality and craftsmanship.',
                'assets/nayan-patel-coo.png',
                'nayan@khodiyarsteel.com',
                '+91 98765 43211',
                3
            ],
        ];

        $stmt = $pdo->prepare("INSERT INTO team_members (name, designation, bio, image, email, phone, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
        foreach ($members as $m) {
            $stmt->execute($m);
        }
        echo "Seeded: TeamMemberSeeder\n";
    }
}
