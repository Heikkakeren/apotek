<?php
include 'includes/db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM products";
if (!empty($search)) {
    $query .= " WHERE name LIKE :search OR description LIKE :search";
}
$stmt = $conn->prepare($query);
if (!empty($search)) {
    $stmt->bindValue(':search', "%$search%");
}
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Apotek Online</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Apotek Onliness</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="cart/index.php">Keranjang</a></li>
                    <li><a href="user/transaction_history.php">Riwayat Transaksi</a></li>
                    <li><a href="user/login.php">Login</a></li>
                </ul>
            </nav>
            <div class="cart-icon">
                <span id="cart-count">0</span>
                🛒
            </div>
        </div>
    </header>

    <main>
        <!-- Form Pencarian -->
        <section class="search">
            <div class="container">
                <form method="GET" action="index.php" class="search-form">
                    <input type="text" name="search" placeholder="Cari produk..." value="<?php echo $search; ?>">
                    <button type="submit">Cari</button>
                </form>
            </div>
        </section>

        <!-- Daftar Produk -->
        <section class="products">
            <div class="container">
                <h2>Produk Terpopuler</h2>
                <div class="product-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                            <h3><?php echo $product['name']; ?></h3>
                            <p><?php echo substr($product['description'], 0, 50); ?>...</p>
                            <p class="price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                            <button class="btn-add-to-cart" data-id="<?php echo $product['id']; ?>">+ Keranjang</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Apotek Online. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
    
</body>
</html>