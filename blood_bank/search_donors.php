<?php
session_start();
include 'db.php';
include 'navbar.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$donors = [];

if (isset($_POST['search'])) {
    $blood_type = $_POST['blood_type'];
    $city = $_POST['city'];

    $query = "SELECT full_name, blood_type, city, phone 
              FROM users 
              WHERE role = 'donor' 
              AND blood_type = '$blood_type' 
              AND city LIKE '%$city%'";

    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $donors[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>🔍 Search for Donors</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        form { text-align: center; margin-bottom: 20px; }
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        th { background-color: #eee; }
    </style>
</head>
<body>

<h2 style="text-align: center; color: #b30000;">Search for Blood Donors</h2>

<form method="POST">
    <label>Blood Type: 
        <select name="blood_type" required>
            <option value="">Select</option>
            <option>A+</option><option>A-</option>
            <option>B+</option><option>B-</option>
            <option>AB+</option><option>AB-</option>
            <option>O+</option><option>O-</option>
        </select>
    </label>
    <label style="margin-left: 10px;">
        City: <input type="text" name="city" placeholder="Enter city" />
    </label>
    <button type="submit" name="search">Search</button>
</form>

<?php if (!empty($donors)): ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Blood Type</th>
            <th>City</th>
            <th>Phone</th>
        </tr>
        <?php foreach ($donors as $donor): ?>
            <tr>
                <td><?= $donor['full_name'] ?></td>
                <td><?= $donor['blood_type'] ?></td>
                <td><?= $donor['city'] ?></td>
                <td><?= $donor['phone'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <p style="text-align: center;">No donors found for the selected criteria.</p>
<?php endif; ?>

</body>
</html>
