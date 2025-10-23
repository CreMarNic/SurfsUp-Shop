<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

// Load environment variables
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

// Create a simple script to add surf products
$surfProducts = [
    [
        'name' => 'Classic Longboard 9-6',
        'code' => 'LONGBOARD_001',
        'slug' => 'classic-longboard-96',
        'category' => 'Boards > Longboards',
        'price' => 599.99,
        'description' => 'Perfect for beginners and longboard enthusiasts'
    ],
    [
        'name' => 'Performance Shortboard 6-0',
        'code' => 'SHORTBOARD_001', 
        'slug' => 'performance-shortboard-60',
        'category' => 'Boards > Shortboards',
        'price' => 449.99,
        'description' => 'High-performance shortboard for advanced surfers'
    ],
    [
        'name' => 'Beginner Windboard 120L',
        'code' => 'WINDBOARD_001',
        'slug' => 'beginner-windboard-120l', 
        'category' => 'Boards > Windboards',
        'price' => 799.99,
        'description' => 'Stable windboard perfect for learning windsurfing'
    ],
    [
        'name' => 'Classic Board Shorts',
        'code' => 'MENS_SHORTS_001',
        'slug' => 'classic-board-shorts',
        'category' => 'Men\'s > Shorts',
        'price' => 49.99,
        'description' => 'Comfortable board shorts for surfing and beach'
    ],
    [
        'name' => 'Classic Surf T-Shirt',
        'code' => 'MENS_SHIRT_001',
        'slug' => 'classic-surf-t-shirt',
        'category' => 'Men\'s > Shirts',
        'price' => 29.99,
        'description' => 'Classic surf t-shirt in 100% cotton'
    ],
    [
        'name' => 'Classic Bikini Set',
        'code' => 'WOMENS_BIKINI_001',
        'slug' => 'classic-bikini-set',
        'category' => 'Women\'s > Bathing Suits',
        'price' => 39.99,
        'description' => 'Stylish bikini set for beach and surf'
    ],
    [
        'name' => 'Surf Tank Top',
        'code' => 'WOMENS_SHIRT_001',
        'slug' => 'surf-tank-top',
        'category' => 'Women\'s > Shirts',
        'price' => 24.99,
        'description' => 'Comfortable tank top for surfing and beach'
    ],
    [
        'name' => 'Classic Baseball Cap',
        'code' => 'CAP_001',
        'slug' => 'classic-baseball-cap',
        'category' => 'Accessories > Caps',
        'price' => 19.99,
        'description' => 'Classic baseball cap with SurfsUp logo'
    ],
    [
        'name' => '3mm Wetsuit',
        'code' => 'WETSUIT_001',
        'slug' => '3mm-wetsuit',
        'category' => 'Accessories > Wetsuits',
        'price' => 199.99,
        'description' => '3mm neoprene wetsuit for warm water surfing'
    ]
];

echo "Surf Products to be added:\n";
foreach ($surfProducts as $product) {
    echo "- {$product['name']} ({$product['code']}) - \${$product['price']}\n";
    echo "  Category: {$product['category']}\n";
    echo "  Description: {$product['description']}\n\n";
}

echo "Total products: " . count($surfProducts) . "\n";
echo "These products match your menu categories:\n";
echo "- Boards (Longboards, Shortboards, Windboards)\n";
echo "- Men's (Shorts, Shirts)\n"; 
echo "- Women's (Bathing Suits, Shirts)\n";
echo "- Accessories (Caps, Wetsuits)\n";


