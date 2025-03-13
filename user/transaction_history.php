<?php
include '../includes/db.php';
$query = "SELECT id, product_name, total, status, tracking_number, date FROM transactions ORDER BY date DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Riwayat Transaksi</h2>

        <div class="card p-4 shadow-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Nomor Resi</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
    <?php if ($result): ?>
        <?php $no = 1; ?>
        <?php foreach ($result as $row): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                <td>1</td> <!-- Jumlah sementara diisi 1 karena nggak ada kolom quantity -->
                <td>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td> <!-- Pakai kolom total -->
                <td><?php echo ucfirst($row['status']); ?></td>
                <td><?php echo $row['tracking_number'] ?: '-'; ?></td>
                <td><?php echo date('d M Y', strtotime($row['date'])); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" class="text-center">Belum ada transaksi.</td>
        </tr>
    <?php endif; ?>
</tbody>

            </table>
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-primary" onclick="history.back()">Kembali</button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
