<?php
// File: public/view_logs.php
// View latest log entries

$logDir = '../writable/logs/';
$logFiles = glob($logDir . 'log-*.php');

if (empty($logFiles)) {
    echo "No log files found in $logDir";
    exit;
}

// Get the latest log file
$latestLog = end($logFiles);
echo "<h2>Latest Log: " . basename($latestLog) . "</h2>";

// Read last 50 lines
$lines = file($latestLog);
$totalLines = count($lines);
$startLine = max(0, $totalLines - 100); // Last 100 lines

echo "<pre style='background: #f0f0f0; padding: 10px; max-height: 500px; overflow-y: scroll;'>";
for ($i = $startLine; $i < $totalLines; $i++) {
    echo htmlspecialchars($lines[$i]);
}
echo "</pre>";

echo "<br><a href='/requests/create'>Test Form Again</a> | ";
echo "<a href='/requests'>View Requests</a>";
