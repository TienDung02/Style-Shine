<?php
$host = 'xxxxx.mysql.database.azure.com';
$db = 'app_database';
$user = 'admin105@xxxxx';
$pass = 'your_password';
$ssl_ca = __DIR__ . '/ca-cert.pem';

$dsn = "mysql:host=$host;dbname=$db;port=3306;charset=utf8mb4";

$options = [
    PDO::MYSQL_ATTR_SSL_CA => $ssl_ca,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Kết nối thành công với SSL!";
} catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
}
