<?php
require_once 'vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

// Create a simple admin user
$pdo = new PDO('mysql:host=127.0.0.1;dbname=sylius_dev', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create a simple password hash
$password = password_hash('admin123', PASSWORD_DEFAULT);

// Insert new admin user
$stmt = $pdo->prepare("INSERT INTO sylius_admin_user (id, email, username, password, first_name, last_name, locale_code, created_at, updated_at, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)");
$stmt->execute([3, 'admin@waveshop.com', 'admin', $password, 'Admin', 'User', 'en_US', 1]);

echo "Admin user created successfully!\n";
echo "Email: admin@waveshop.com\n";
echo "Password: admin123\n";
?>

