<?php
session_start();
include '../includes/db.php';

// Pastikan user sudah login
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];

// Ambil data riwayat pesanan dari database
$stmt = $conn->prepare("SELECT o.id, o.order_date, o.total_price, o.status, o.tracking_number FROM orders o WHERE o.user_id = ? ORDER BY o.order_date DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Riwayat Pesanan</h1>
    </header>

    <div class="order-history-container">
        <table class="order-history-table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal Pembelian</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Nomor Resi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($orders) > 0): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['id']); ?></td>
                            <td><?= htmlspecialchars($order['order_date']); ?></td>
                            <td>Rp <?= number_format($order['total_price'], 0, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($order['status']); ?></td>
                            <td><?= htmlspecialchars($order['tracking_number'] ?: 'Belum tersedia'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada riwayat pesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
