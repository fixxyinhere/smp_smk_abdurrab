<?php
// File: public/test_requests.php
// Simple debug file to test requests functionality

echo "<h1>Debug Requests</h1>";

// Test database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=smp_smk_abdurrab", "root", "");
    echo "✅ Database connection OK<br>";

    // Check if tables exist
    $tables = ['users', 'items', 'requests', 'request_items'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "✅ Table '$table' exists<br>";
        } else {
            echo "❌ Table '$table' missing<br>";
        }
    }

    // Check items data
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM items WHERE quantity > 0 AND condition_status = 'baik'");
    $result = $stmt->fetch();
    echo "✅ Available items: " . $result['count'] . "<br>";

    // Check users
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE status = 'active'");
    $result = $stmt->fetch();
    echo "✅ Active users: " . $result['count'] . "<br>";
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

// Test file exists
$files = [
    '../app/Controllers/Requests.php',
    '../app/Views/requests/create.php',
    '../app/Models/RequestModel.php',
    '../app/Models/ItemModel.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✅ File exists: $file<br>";
    } else {
        echo "❌ File missing: $file<br>";
    }
}

echo "<br><a href='/requests/create'>Test Requests Create</a>";
echo "<br><a href='/items'>Test Items List</a>";
echo "<br><a href='/dashboard'>Back to Dashboard</a>";
