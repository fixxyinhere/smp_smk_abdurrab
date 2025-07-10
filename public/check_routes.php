<?php
// File: public/check_routes.php
// Check what routes are currently active

// This is a simple route tester
echo "<h2>Route Testing</h2>";

echo "<h3>Test Routes:</h3>";
echo "<ul>";
echo "<li><a href='/requests'>GET /requests</a></li>";
echo "<li><a href='/requests/create'>GET /requests/create</a></li>";
echo "<li><a href='/requests/store' onclick='alert(\"This should be POST only\"); return false;'>GET /requests/store (should fail)</a></li>";
echo "</ul>";

echo "<h3>Form Test:</h3>";
echo "<form method='post' action='/requests/store'>";
echo "<input type='hidden' name='request_date' value='" . date('Y-m-d') . "'>";
echo "<input type='hidden' name='purpose' value='Test route submission'>";
echo "<input type='hidden' name='items[]' value='1'>";
echo "<input type='hidden' name='quantities[]' value='1'>";
echo "<input type='hidden' name='notes[]' value='Test'>";
echo "<button type='submit'>Test POST to /requests/store</button>";
echo "</form>";

echo "<hr>";
echo "<h3>Debug Info:</h3>";
echo "Current URL: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "<br>";
echo "Server: " . $_SERVER['SERVER_NAME'] . "<br>";

if ($_POST) {
    echo "<h3>POST Data Received:</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}
