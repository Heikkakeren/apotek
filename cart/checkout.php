<?php
session_start(); // Pastikan session_start() dipanggil di awal

// Inisialisasi session cart jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Redirect ke halaman keranjang jika keranjang kosong
if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $payment_method = $_POST['payment_method']; // Ambil metode pembayaran dari form

    foreach ($_SESSION['cart'] as $id => $item) {
        // Ambil harga produk dari database
        $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Hitung total harga
        $total_price = $product['price'] * $item['quantity'];

        // Status awal dan nomor resi kosong
        $status = 'Diproses';
        $tracking_number = NULL;

        // Simpan pesanan ke tabel orders (dengan payment_method, status, tracking_number)
        $stmt = $conn->prepare("INSERT INTO orders (product_id, quantity, total_price, customer_name, customer_email, payment_method, status, tracking_number, purchase_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$id, $item['quantity'], $total_price, $customer_name, $customer_email, $payment_method, $status, $tracking_number]);
    }

    // Kosongkan keranjang
    $_SESSION['cart'] = [];
    header('Location: success.php');

    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Apotek Online</title>
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
                </ul>
            </nav>
            <div class="cart-icon">
                <span id="cart-count"><?php echo count($_SESSION['cart'] ?? []); ?></span>
                🛒
            </div>
        </div>
    </header>

    <main>
        <section class="checkout">
            <div class="container">
                <h2>Checkout</h2>
                <form method="POST">
                    <label for="customer_name">Nama:</label>
                    <input type="text" name="customer_name" required>

                    <label for="customer_email">Email:</label>
                    <input type="email" name="customer_email" required>

                    <label for="payment_method">Metode Pembayaran:</label>
                    <select name="payment_method" required>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Kartu Kredit">Kartu Kredit</option>
                        <option value="COD">COD (Bayar di Tempat)</option>
                    </select>

                    <button type="submit">Bayar Sekarang</button>
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