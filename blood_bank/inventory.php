<?php
include('db_connection.php');

// استعلام لجمع بيانات المخزون
$sql = "SELECT blood_type, COUNT(*) AS units_available, SUM(quantity) AS total_ml 
        FROM donations 
        WHERE status = 'Available' 
        GROUP BY blood_type";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Inventory</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f0f2f5; }
        h1 { text-align: center; color: #b30000; margin-bottom: 30px; }
        table { width: 70%; margin: auto; border-collapse: collapse; background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        th, td { padding: 14px; text-align: center; border: 1px solid #ccc; }
        th { background-color: #b30000; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .export-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }
        .export-btn:hover { background-color: #45a049; }
    </style>
</head>
<body>

    <h1>Blood Inventory</h1>

    <a href="export_inventory_excel.php" class="export-btn">Export to Excel</a>

    <table>
        <thead>
            <tr>
                <th>Blood Type</th>
                <th>Units Available</th>
                <th>Total Quantity (ml)</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['blood_type']) ?></td>
                    <td><?= $row['units_available'] ?></td>
                    <td><?= $row['total_ml'] ?> ml</td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
