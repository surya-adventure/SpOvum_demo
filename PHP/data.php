<?php
$mysqli = new mysqli("localhost", "root", "", "spovum_demo");

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => $mysqli->connect_error]);
    exit;
}

header('Content-Type: application/json');

$mode = $_GET['mode'] ?? 'sno';

// Mode-based queries
if ($mode === 'sno_colA') {
    $result = $mysqli->query("SELECT Sno, colA FROM dm_values");
} elseif ($mode === 'sno_colB') {
    $result = $mysqli->query("SELECT Sno, colB FROM dm_values");
} elseif ($mode === 'avg_colA') {
    $result = $mysqli->query("SELECT date, AVG(colA) AS avg_colA FROM dm_values GROUP BY date");
} elseif ($mode === 'avg_colB') {
    $result = $mysqli->query("SELECT date, AVG(colB) AS avg_colB FROM dm_values GROUP BY date");
} else {
    echo json_encode(["error" => "Invalid mode"]);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$mysqli->close();
?>
