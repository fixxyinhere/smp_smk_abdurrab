<?php
// File: public/test_insert.php
// Test direct insert to check database permissions

try {
    $pdo = new PDO("mysql:host=localhost;dbname=smp_smk_abdurrab", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h2>Test Insert Request</h2>";

    // Test insert request
    $sql = "INSERT INTO requests (request_number, user_id, request_date, purpose, status) 
            VALUES ('TEST001', 3, '2024-01-01', 'Test permintaan manual', 'pending')";

    $stmt = $pdo->prepare($sql);

    if ($stmt->execute()) {
        $requestId = $pdo->lastInsertId();
        echo "✅ Request inserted successfully. ID: $requestId<br>";

        // Test insert request item
        $sql2 = "INSERT INTO request_items (request_id, item_id, quantity, notes) 
                 VALUES ($requestId, 1, 2, 'Test item')";

        $stmt2 = $pdo->prepare($sql2);

        if ($stmt2->execute()) {
            echo "✅ Request item inserted successfully<br>";

            // Clean up test data
            $pdo->exec("DELETE FROM request_items WHERE request_id = $requestId");
            $pdo->exec("DELETE FROM requests WHERE id = $requestId");
            echo "✅ Test data cleaned up<br>";
        } else {
            echo "❌ Failed to insert request item<br>";
        }
    } else {
        echo "❌ Failed to insert request<br>";
    }
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

echo "<br><a href='/requests'>Back to Requests</a>";
