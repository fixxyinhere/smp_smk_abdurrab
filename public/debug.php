<?php
// File: public/debug.php
echo "<h1>PHP Debug Info</h1>";
echo "<h2>PHP Version: " . phpversion() . "</h2>";
echo "<h2>Extensions:</h2>";

$required = ['mysqli', 'intl', 'json', 'mbstring'];
foreach ($required as $ext) {
    echo $ext . ": " . (extension_loaded($ext) ? "✅ Loaded" : "❌ Missing") . "<br>";
}

echo "<h2>Database Connection Test:</h2>";
try {
    $pdo = new PDO("mysql:host=localhost", "root", "");
    echo "✅ MySQL connection successful<br>";

    // Test database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE 'smp_smk_abdurrab'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Database 'smp_smk_abdurrab' exists<br>";
    } else {
        echo "❌ Database 'smp_smk_abdurrab' not found<br>";
        echo "Creating database...<br>";
        $pdo->exec("CREATE DATABASE smp_smk_abdurrab");
        echo "✅ Database created<br>";
    }
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

echo "<h2>File Permissions:</h2>";
echo "writable/ folder: " . (is_writable('../writable/') ? "✅ Writable" : "❌ Not writable") . "<br>";
echo "app/ folder: " . (is_readable('../app/') ? "✅ Readable" : "❌ Not readable") . "<br>";

echo "<h2>Environment:</h2>";
echo "Current directory: " . getcwd() . "<br>";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";

phpinfo();
