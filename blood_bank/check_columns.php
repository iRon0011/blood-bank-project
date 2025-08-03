<?php
$conn = new mysqli("localhost", "root", "", "blood_bank");
$result = $conn->query("SHOW COLUMNS FROM redemption_log");

while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . "<br>";
}
