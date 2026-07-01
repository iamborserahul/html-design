<?php

class UserSeeder {
    public function run($pdo) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            'Admin',
            'admin@khodiyarsteel.com',
            password_hash('password@123', PASSWORD_BCRYPT),
            'admin',
            1
        ]);
        echo "Seeded: UserSeeder\n";
    }
}
