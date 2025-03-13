<?php
session_start();

// Inisialisasi session cart jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart']; // Ambil data cart dari session
$total = 0; // Inisialisasi total harga
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Apotek Online</title>
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
            <br>
            <div class="cart-icon">
                <span id="cart-count"><?php echo is_array($cart) ? count($cart) : 0; ?></span>
                🛒
            </div>
        </div>
    </header>

    <main>
        <section class="cart">
            <div class="container">
                <h2>Keranjang Belanja</h2>
                <?php if (empty($cart)): ?>
                    <p>Keranjang belanja Anda kosong.</p>
                <?php else: ?>
                    <table style="margin-left: auto; margin-right: auto">
                        <thead>
                            <tr style="background-color: #4facfe; color: white">
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $id => $item): ?>
                                <?php
                                include '../includes/db.php'; // Pastikan file db.php di-include
                                $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
                                $stmt->execute([$id]);
                                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                                $total += $product['price'] * $item['quantity'];
                                ?>
                                <tr style="border-bottom: 1px 0 0 gray;">
                                    <td><?php echo $product['name']; ?></td>
                                    <td>Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></td>
                                    <td style="text-align: center;"><?php echo $item['quantity']; ?></td>
                                    <td>Rp <?php echo number_format($product['price'] * $item['quantity'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p class="total">Total: Rp <?php echo number_format($total, 0, ',', '.'); ?></p>
                    <a href="checkout.php" class="btn-checkout">Checkout</a>
                <?php endif; ?>
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