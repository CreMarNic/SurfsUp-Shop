<?php
require_once 'vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

// Bootstrap Symfony
$kernel = new \App\Kernel('dev', true);
$kernel->boot();
$container = $kernel->getContainer();

// Get the admin user factory and repository
$adminUserFactory = $container->get('sylius.factory.admin_user');
$adminUserRepository = $container->get('sylius.repository.admin_user');
$userManager = $container->get('sylius.manager.admin_user');

// Create new admin user
$adminUser = $adminUserFactory->createNew();
$adminUser->setEmail('admin@example.com');
$adminUser->setUsername('admin');
$adminUser->setPlainPassword('admin123');
$adminUser->setFirstName('Admin');
$adminUser->setLastName('User');
$adminUser->setLocaleCode('en_US');
$adminUser->setEnabled(true);

// Save the user
$userManager->persist($adminUser);
$userManager->flush();

echo "✅ Admin user created successfully!\n";
echo "📧 Email: admin@example.com\n";
echo "🔑 Password: admin123\n";
echo "🌐 Login at: http://localhost:8000/admin/login\n";
?>



