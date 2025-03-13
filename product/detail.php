<?php
include '../includes/db.php';
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Ambil ulasan produk
$reviewsStmt = $conn->prepare("SELECT r.*, u.name AS user_name FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id = ?");
$reviewsStmt->execute([$id]);
$reviews = $reviewsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - Apotek Online</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Apotek Online</h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Beranda</a></li>
                    <li><a href="#">Produk</a></li>
                    <li><a href="../cart/index.php">Keranjang</a></li>
                </ul>
            </nav>
            <div class="cart-icon">
                <span id="cart-count">0</span>
                🛒
            </div>
        </div>
    </header>

    <main>
        <section class="product-detail">
            <div class="container">
                <div class="product-image">
                    <img src="../images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                </div>
                <div class="product-info">
                    <h2><?php echo $product['name']; ?></h2>
                    <p class="price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                    <p><?php echo $product['description']; ?></p>
                    <button class="btn-add-to-cart" data-id="<?php echo $product['id']; ?>">+ Keranjang</button>
                </div>
            </div>
        </section>

        <section class="product-reviews">
            <h3>Ulasan Produk</h3>
            <?php if ($reviews): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review">
                        <strong><?php echo htmlspecialchars($review['user_name']); ?>:</strong>
                        <p>Rating: <?php echo $review['rating']; ?> / 5</p>
                        <p><?php echo htmlspecialchars($review['review']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Belum ada ulasan.</p>
            <?php endif; ?>

            <h4>Tambahkan Ulasan Anda</h4>
            <form action="add_review.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                <label for="rating">Rating (1-5):</label>
                <select name="rating" required>
                    <option value="">Pilih Rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <label for="review">Ulasan:</label>
                <textarea name="review" required></textarea>
                <button type="submit">Kirim Ulasan</button>
            </form>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Apotek Online. All rights reserved.</p>
        </div>
    </footer>

    <script src="../script.js"></script>
</body>
</html>