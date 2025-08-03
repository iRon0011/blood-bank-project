<?php
session_start();
include 'db.php';

$results = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blood_type = $_POST['blood_type'];
    $location = $_POST['location'];


    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $query = "SELECT * FROM donations 
              JOIN users ON donations.user_id = users.id 
              WHERE donations.blood_type = ? AND users.location = ? AND donations.status = 'available'";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $blood_type, $location);
    $stmt->execute();
    $results = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Donations</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        form { margin-bottom: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
<h2>🔎 Search for Available Blood Donations</h2>

<form method="post">
    <label>Blood Type:</label>
    <select name="blood_type">
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
    </select>

    <label>Location:</label>
    <input type="text" name="location" required>

    <input type="submit" value="Search">
</form>

<?php if (!empty($results)): ?>
    <table>
        <tr>
            <th>Donor Name</th>
            <th>Blood Type</th>
            <th>Location</th>
            <th>Contact</th>
        </tr>
        <?php while ($row = $results->fetch_assoc()): ?>
        <tr>
            <td><?= $row['name'] ?></td>
            <td><?= $row['blood_type'] ?></td>
            <td><?= $row['location'] ?></td>
            <td><?= $row['email'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>
</body>
</html>



