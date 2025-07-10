<?php
// File: public/debug_request_items.php
// Check request items data

try {
    $pdo = new PDO("mysql:host=localhost;dbname=smp_smk_abdurrab", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h2>Debug Request Items</h2>";

    // Get latest request
    $stmt = $pdo->query("SELECT * FROM requests ORDER BY id DESC LIMIT 5");
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Latest Requests:</h3>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Request Number</th><th>User ID</th><th>Status</th><th>Created</th></tr>";

    foreach ($requests as $request) {
        echo "<tr>";
        echo "<td>{$request['id']}</td>";
        echo "<td>{$request['request_number']}</td>";
        echo "<td>{$request['user_id']}</td>";
        echo "<td>{$request['status']}</td>";
        echo "<td>{$request['created_at']}</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Check request items for each request
    echo "<h3>Request Items for Each Request:</h3>";
    foreach ($requests as $request) {
        echo "<h4>Request {$request['request_number']} (ID: {$request['id']}):</h4>";

        $stmt2 = $pdo->prepare("SELECT ri.*, i.name as item_name 
                               FROM request_items ri 
                               LEFT JOIN items i ON i.id = ri.item_id 
                               WHERE ri.request_id = ?");
        $stmt2->execute([$request['id']]);
        $items = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if (empty($items)) {
            echo "<p style='color: red;'>❌ No items found for this request!</p>";
        } else {
            echo "<table border='1' style='border-collapse: collapse; margin-bottom: 10px;'>";
            echo "<tr style='background: #f0f0f0;'><th>Item ID</th><th>Item Name</th><th>Quantity</th><th>Notes</th></tr>";
            foreach ($items as $item) {
                echo "<tr>";
                echo "<td>{$item['item_id']}</td>";
                echo "<td>{$item['item_name']}</td>";
                echo "<td>{$item['quantity']}</td>";
                echo "<td>{$item['notes']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

    // Test manual insert to request_items
    echo "<h3>Test Manual Insert to request_items:</h3>";
    $latestRequestId = $requests[0]['id'];

    try {
        $sql = "INSERT INTO request_items (request_id, item_id, quantity, notes) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$latestRequestId, 1, 1, 'Manual test item']);

        if ($result) {
            echo "✅ Manual insert to request_items successful<br>";

            // Delete test data
            $pdo->exec("DELETE FROM request_items WHERE request_id = $latestRequestId AND notes = 'Manual test item'");
            echo "✅ Test data cleaned up<br>";
        } else {
            echo "❌ Manual insert failed<br>";
        }
    } catch (Exception $e) {
        echo "❌ Manual insert error: " . $e->getMessage() . "<br>";
    }
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

echo "<br><a href='/requests'>Back to Requests</a>";
