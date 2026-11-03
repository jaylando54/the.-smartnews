CREATE DATABASE IF NOT EXISTS rwanda_today CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE rwanda_today;

CREATE TABLE users (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 role ENUM('user','admin') NOT NULL DEFAULT 'user',
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE articles (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 title VARCHAR(220) NOT NULL,
 summary TEXT,
 body LONGTEXT NOT NULL,
 category VARCHAR(80) NOT NULL,
 is_premium TINYINT(1) NOT NULL DEFAULT 0,
 status ENUM('draft','published') NOT NULL DEFAULT 'draft',
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 INDEX(status,created_at)
) ENGINE=InnoDB;

CREATE TABLE payment_requests (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 plan ENUM('monthly','yearly') NOT NULL,
 amount_rwf INT UNSIGNED NOT NULL,
 provider ENUM('MTN','Airtel') NOT NULL,
 phone VARCHAR(24) NOT NULL,
 transaction_reference VARCHAR(100) NOT NULL,
 status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
 reviewed_by BIGINT UNSIGNED NULL,
 reviewed_at DATETIME NULL,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(id),
 FOREIGN KEY(reviewed_by) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE subscriptions (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 plan ENUM('monthly','yearly') NOT NULL,
 starts_at DATETIME NOT NULL,
 ends_at DATETIME NOT NULL,
 status ENUM('active','cancelled','expired') NOT NULL DEFAULT 'active',
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(id),
 INDEX(user_id,status,ends_at)
) ENGINE=InnoDB;

-- After registering your own account, promote it to administrator:
-- UPDATE users SET role='admin' WHERE email='YOUR_EMAIL_ADDRESS';
