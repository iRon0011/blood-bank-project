<?php
session_start();
include 'db.php';
include 'navbar.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id      = $_SESSION['user_id'];
    $blood_type   = $_POST['blood_type'];
    $units_needed = $_POST['units_needed'];
    $hospital     = $_POST['hospital_name'];
    $location     = $_POST['location'];
    $needed_date  = $_POST['needed_date'];

    $sql = "INSERT INTO requests (user_id, blood_type, units_needed, hospital_name, location, needed_date)
            VALUES ('$user_id', '$blood_type', '$units_needed', '$hospital', '$location', '$needed_date')";

    if ($conn->query($sql) === TRUE) {
        $message = "✅ Blood request submitted successfully!";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Blood</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        form { width: 300px; margin: auto; }
        input, select, button { margin-top: 10px; width: 100%; padding: 8px; }
    </style>
</head>
<body>

<h2>🆘 Request Blood</h2>
<form method="POST">
    <label>Blood Type:</label>
    <select name="blood_type" required>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
    </select>

    <label>Units Needed:</label>
    <input type="number" name="units_needed" min="1" required>

    <label>Hospital Name:</label>
    <input type="text" name="hospital_name" required>

    <label>Location:</label>
    <input type="text" name="location" required>

    <label>Needed Date:</label>
    <input type="date" name="needed_date" required>

    <button type="submit">Send Request</button>
</form>

<p style="color:green;"><?php echo $message; ?></p>

</body>
</html>
