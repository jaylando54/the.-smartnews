<?php
declare(strict_types=1);
session_start();

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'rwanda_today');
define('DB_USER', 'root');
define('DB_PASS', ''); // Set your local MySQL password.

define('SITE_NAME', 'Rwanda Today');
define('MONTHLY_PRICE_RWF', 2000);
define('YEARLY_PRICE_RWF', 20000); // Suggested placeholder: confirm before launch.
define('CURRENCY', 'RWF');

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
    return $pdo;
}
