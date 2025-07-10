<?php
// File: public/debug_requests.php
// Debug file to check what's actually in the database

try {
    $pdo = new PDO("mysql:host=localhost;dbname=smp_smk_abdurrab", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h2>Debug Requests Data</h2>";

    // Check all requests in database
    echo "<h3>All Requests in Database:</h3>";
    $stmt = $pdo->query("SELECT * FROM requests ORDER BY created_at DESC");
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($requests)) {
        echo "<p style='color: red;'>❌ No requests found in database!</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'>";
        echo "<th>ID</th><th>Request Number</th><th>User ID</th><th>Date</th><th>Purpose</th><th>Status</th><th>Created At</th>";
        echo "</tr>";

        foreach ($requests as $request) {
            echo "<tr>";
            echo "<td>{$request['id']}</td>";
            echo "<td>{$request['request_number']}</td>";
            echo "<td>{$request['user_id']}</td>";
            echo "<td>{$request['request_date']}</td>";
            echo "<td>" . substr($request['purpose'], 0, 30) . "...</td>";
            echo "<td>{$request['status']}</td>";
            echo "<td>{$request['created_at']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    // Check users table
    echo "<h3>Users in Database:</h3>";
    $stmt = $pdo->query("SELECT id, username, full_name, role FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Username</th><th>Full Name</th><th>Role</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>{$user['id']}</td>";
        echo "<td>{$user['username']}</td>";
        echo "<td>{$user['full_name']}</td>";
        echo "<td>{$user['role']}</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Test the JOIN query that RequestModel uses
    echo "<h3>Test JOIN Query (RequestModel::getAllRequests):</h3>";
    $sql = "SELECT requests.*, users.full_name as user_name, approver.full_name as approver_name 
            FROM requests 
            LEFT JOIN users ON users.id = requests.user_id 
            LEFT JOIN users as approver ON approver.id = requests.approved_by 
            ORDER BY requests.created_at DESC";

    $stmt = $pdo->query($sql);
    $joinResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($joinResults)) {
        echo "<p style='color: red;'>❌ JOIN query returned no results!</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'>";
        echo "<th>ID</th><th>Request Number</th><th>User Name</th><th>Date</th><th>Status</th><th>Approver</th>";
        echo "</tr>";

        foreach ($joinResults as $result) {
            echo "<tr>";
            echo "<td>{$result['id']}</td>";
            echo "<td>{$result['request_number']}</td>";
            echo "<td>{$result['user_name']}</td>";
            echo "<td>{$result['request_date']}</td>";
            echo "<td>{$result['status']}</td>";
            echo "<td>" . ($result['approver_name'] ?: '-') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

echo "<br><br>";
echo "<a href='/requests'>Back to Requests</a> | ";
echo "<a href='/dashboard'>Dashboard</a>";
