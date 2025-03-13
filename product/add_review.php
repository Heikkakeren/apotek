<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user']['id']; // Ambil user id dari session
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Validasi input
    if ($rating < 1 || $rating > 5) {
        echo "Rating harus antara 1 dan 5";
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO reviews (product_id, user_id, rating, review) VALUES (?, ?, ?, ?)");
        $stmt->execute([$product_id, $user_id, $rating, $review]);

        // Redirect kembali ke halaman detail produk
        header("Location: detail.php?id=$product_id");
        exit;
    } catch (PDOException $e) {
        echo "Gagal menambahkan ulasan: " . $e->getMessage();
    }
}
?>
