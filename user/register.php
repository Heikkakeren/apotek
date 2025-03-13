<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $password]);

    $_SESSION['user'] = ['name' => $name, 'email' => $email];
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pembeli - Apotek Online</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="overlay">
        <div class="login-container">
            <h1>Daftar Pembeli</h1>
            <form method="POST">
                <input type="text" name="name" placeholder="Nama" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Daftar</button>
            </form>
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>
    
</body>
</html>