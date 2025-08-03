<?php
include('db_connection.php');

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=blood_inventory.xls");

echo "Blood Type\tUnits Available\tTotal Quantity (ml)\n";

$sql = "SELECT blood_type, COUNT(*) AS units_available, SUM(quantity) AS total_ml 
        FROM donations 
        WHERE status = 'Available' 
        GROUP BY blood_type";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "{$row['blood_type']}\t{$row['units_available']}\t{$row['total_ml']}\n";
}
?>
