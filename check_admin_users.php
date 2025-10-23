<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=sylius_dev', 'root', '');
    $stmt = $pdo->query('SELECT email, username FROM sylius_admin_user');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($users)) {
        echo "No admin users found in database.\n";
    } else {
        echo "Found admin users:\n";
        foreach ($users as $user) {
            echo "Email: " . $user['email'] . "\n";
            echo "Username: " . $user['username'] . "\n";
            echo "---\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>



