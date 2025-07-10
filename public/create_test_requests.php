<?php
// File: public/create_test_request.php
// Create proper test request with correct user_id

try {
    $pdo = new PDO("mysql:host=localhost;dbname=smp_smk_abdurrab", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h2>Create Test Request</h2>";

    // First, let's see what users exist
    $stmt = $pdo->query("SELECT id, username, full_name, role FROM users WHERE role = 'user' AND status = 'active'");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($users)) {
        echo "❌ No active users found! Let's check all users:<br>";
        $stmt = $pdo->query("SELECT id, username, full_name, role, status FROM users");
        $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($allUsers as $user) {
            echo "User ID: {$user['id']}, Username: {$user['username']}, Role: {$user['role']}, Status: {$user['status']}<br>";
        }

        // Use any user for testing
        $testUserId = 3; // assuming user with ID 3 exists
        echo "<br>Using User ID 3 for test...<br>";
    } else {
        $testUserId = $users[0]['id'];
        echo "Found active user: {$users[0]['username']} (ID: $testUserId)<br>";
    }

    // Check available items
    $stmt = $pdo->query("SELECT id, name, quantity FROM items WHERE quantity > 0 LIMIT 1");
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        echo "❌ No available items found!<br>";
        return;
    }

    echo "Found available item: {$item['name']} (ID: {$item['id']})<br>";

    // Create test request
    $requestNumber = 'REQ' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);

    $sql = "INSERT INTO requests (request_number, user_id, request_date, purpose, status, created_at) 
            VALUES (?, ?, ?, ?, 'pending', NOW())";

    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $requestNumber,
        $testUserId,
        date('Y-m-d'),
        'Test permintaan untuk debugging sistem'
    ]);

    if ($result) {
        $requestId = $pdo->lastInsertId();
        echo "✅ Request created successfully. ID: $requestId, Number: $requestNumber<br>";

        // Add request item
        $sql2 = "INSERT INTO request_items (request_id, item_id, quantity, notes, created_at) 
                 VALUES (?, ?, ?, ?, NOW())";

        $stmt2 = $pdo->prepare($sql2);
        $result2 = $stmt2->execute([
            $requestId,
            $item['id'],
            1,
            'Test item untuk debugging'
        ]);

        if ($result2) {
            echo "✅ Request item added successfully<br>";
        } else {
            echo "❌ Failed to add request item<br>";
        }

        echo "<br><strong>Test request created with:</strong><br>";
        echo "- Request Number: $requestNumber<br>";
        echo "- User ID: $testUserId<br>";
        echo "- Item: {$item['name']}<br>";
        echo "- Quantity: 1<br>";
    } else {
        echo "❌ Failed to create request<br>";
    }
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

echo "<br><br>";
echo "<a href='/debug_requests.php'>Check Database</a> | ";
echo "<a href='/requests'>View Requests List</a> | ";
echo "<a href='/dashboard'>Dashboard</a>";
