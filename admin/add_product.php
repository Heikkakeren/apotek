<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;


include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "../images/" . basename($image);

    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $image]);

    $success = "Produk berhasil ditambahkan!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Apotek Online</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Apotek Online - Admin</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="add_product.php">Tambah Produk</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="admin-form">
            <div class="container">
                <h2>Tambah Produk</h2>
                <?php if (isset($success)): ?>
                    <p style="color: green;"><?php echo $success; ?></p>
                <?php endif; ?>
                <form method="POST" enctype="multipart/form-data">
                    <label for="name">Nama Produk:</label>
                    <input type="text" name="name" required>
                    <label for="description">Deskripsi:</label>
                    <textarea name="description" required></textarea>
                    <label for="price">Harga:</label>
                    <input type="number" name="price" required>
                    <label for="image">Gambar:</label>
                    <input type="file" name="image" required>
                    <button type="submit">Tambah Produk</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Apotek Online. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>