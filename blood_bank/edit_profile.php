<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $blood_type = $_POST['blood_type'];

    $conn->query("UPDATE users SET name='$name', email='$email', phone='$phone', blood_type='$blood_type' WHERE id=$user_id");
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 30px;
            background: #f7f7f7;
            border-radius: 8px;
        }
        label { display: block; margin: 10px 0 5px; }
        input, select {
            width: 100%; padding: 10px; margin-bottom: 15px;
            border: 1px solid #ccc; border-radius: 5px;
        }
        .btn {
            background-color: #d32f2f;
            color: white; padding: 10px 20px;
            border: none; border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit Your Profile</h2>
    <form method="post">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

        <label>Blood Type:</label>
        <select name="blood_type" required>
            <?php
            $types = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
            foreach ($types as $type) {
                $selected = $user['blood_type'] === $type ? 'selected' : '';
                echo "<option value='$type' $selected>$type</option>";
            }
            ?>
        </select>

        <button type="submit" class="btn">Update</button>
    </form>
</div>

</body>
</html>
