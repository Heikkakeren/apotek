<?php
session_start();

// Redirect ke halaman beranda jika tidak ada session cart
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}

// Kosongkan keranjang setelah transaksi berhasil
$_SESSION['cart'] = [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Berhasil - Apotek Online</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Apotek Online</h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Beranda</a></li>
                    <li><a href="index.php">Keranjang</a></li>
                    <li><a href="../user/login.php">Login</a></li>
                </ul>
            </nav>
            <div class="cart-icon">
                <span id="cart-count">0</span>
                🛒
            </div>
        </div>
    </header>

    <main>
        <section class="success">
            <div class="container">
                <h2>Transaksi Berhasil!</h2>
                <p>Terima kasih telah berbelanja di Apotek Online. Pesanan Anda sedang diproses.</p>
                <a href="../index.php" class="btn-home">Kembali ke Beranda</a>
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