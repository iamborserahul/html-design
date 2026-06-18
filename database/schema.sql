-- ============================================================
-- DATABASE SCHEMA — Manthan Clinic
-- ============================================================

CREATE DATABASE IF NOT EXISTS manthan_clinic
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE manthan_clinic;

-- Contact form submissions
CREATE TABLE IF NOT EXISTS contact_messages (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100)    NOT NULL,
    email       VARCHAR(255)    NOT NULL,
    phone       VARCHAR(20)     DEFAULT NULL,
    subject     VARCHAR(255)    DEFAULT NULL,
    message     TEXT            NOT NULL,
    is_read     TINYINT(1)      NOT NULL DEFAULT 0,
    created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_read (is_read),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Appointments
CREATE TABLE IF NOT EXISTS appointments (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    patient_name    VARCHAR(100)    NOT NULL,
    patient_email   VARCHAR(255)    NOT NULL,
    patient_phone   VARCHAR(20)     NOT NULL,
    appointment_date DATE           NOT NULL,
    appointment_time TIME           DEFAULT NULL,
    service         VARCHAR(255)    DEFAULT NULL,
    message         TEXT            DEFAULT NULL,
    status          ENUM('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
    created_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_date (appointment_date),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Testimonials (admin managed)
CREATE TABLE IF NOT EXISTS testimonials (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(100)   NOT NULL,
    patient_role VARCHAR(100)   DEFAULT NULL,
    photo_url   VARCHAR(500)    DEFAULT NULL,
    rating      TINYINT UNSIGNED NOT NULL DEFAULT 5,
    review      TEXT            NOT NULL,
    is_active   TINYINT(1)      NOT NULL DEFAULT 1,
    created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample testimonial data
INSERT INTO testimonials (patient_name, patient_role, photo_url, rating, review) VALUES
('Priya Patel', 'Regular Patient', 'https://randomuser.me/api/portraits/women/44.jpg', 5, 'Dr. Sharma is incredibly thorough and compassionate. He takes the time to explain everything clearly. I have been coming here for years and highly recommend him.'),
('Ravi Kumar', 'Diabetes Patient', 'https://randomuser.me/api/portraits/men/32.jpg', 5, 'After struggling with diabetes management for years, Dr. Sharma helped me get my blood sugar under control with a personalized treatment plan. Truly life-changing.'),
('Anita Singh', 'Parent', 'https://randomuser.me/api/portraits/women/68.jpg', 5, 'The best pediatric care in the city. My children love visiting Dr. Sharma. The staff is friendly and the clinic is always clean and welcoming.'),
('Vikram Mehta', 'Hypertension Patient', 'https://randomuser.me/api/portraits/men/46.jpg', 5, 'Professional, knowledgeable, and always available when needed. The online appointment system makes it very convenient to book visits.'),
('Sneha Desai', 'Preventive Care', 'https://randomuser.me/api/portraits/women/26.jpg', 4, 'Great experience with my annual checkup. The comprehensive health screening was thorough and the results were explained to me in detail.'),
('Amit Verma', 'General Patient', 'https://randomuser.me/api/portraits/men/75.jpg', 5, 'I appreciate the modern approach to healthcare at Manthan Clinic. Digital prescriptions, online reports, and minimal waiting time. Highly recommended.');
