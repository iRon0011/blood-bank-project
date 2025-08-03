<?php
include 'db.php';

if (isset($_GET['gov'])) {
    $gov = $_GET['gov'];
    $stmt = $conn->prepare("SELECT name, address FROM donation_locations WHERE governorate = ?");
    $stmt->bind_param("s", $gov);
    $stmt->execute();
    $result = $stmt->get_result();

    $places = [];
    while ($row = $result->fetch_assoc()) {
        $places[] = $row;
    }

    echo json_encode($places, JSON_UNESCAPED_UNICODE);
}
?>

