<?php
require "../init.php";

// Proses ubah status jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ubah_status'])) {
    $id = intval($_POST['pesanan_id']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    mysqli_query($con, "UPDATE pesanan SET status='$status' WHERE id=$id");
    header("Location: admin-pesanan.php");
    exit;
}

// Ambil semua data pesanan
$query = mysqli_query($con, "
    SELECT 
        pesanan.id AS pesanan_id,
        pesanan.nama,
        pesanan.telepon,
        pesanan.alamat,
        pesanan.status,
        pesanan.tanggal,
        produk.nama AS nama_produk,
        produk.harga,
        produk.foto,
        pesanan_detail.jumlah
    FROM pesanan
    JOIN pesanan_detail ON pesanan.id = pesanan_detail.pesanan_id
    JOIN produk ON pesanan_detail.produk_id = produk.id
    ORDER BY pesanan.tanggal DESC
");

$pesanan = [];
while ($row = mysqli_fetch_assoc($query)) {
    $id = $row['pesanan_id'];
    if (!isset($pesanan[$id])) {
        $pesanan[$id] = [
            'info' => [
                'nama' => $row['nama'],
                'telepon' => $row['telepon'],
                'alamat' => $row['alamat'],
                'status' => $row['status'],
                'tanggal' => $row['tanggal'],
            ],
            'produk' => [],
            'subtotal' => 0
        ];
    }

    $pesanan[$id]['produk'][] = [
        'nama_produk' => $row['nama_produk'],
        'harga' => $row['harga'],
        'jumlah' => $row['jumlah'],
        'foto' => $row['foto'],
    ];

    $pesanan[$id]['subtotal'] += $row['harga'] * $row['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan | Winsbeads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: rgba(255,255,255,0.9);
            margin-bottom: 30px;
        }

        .card-header {
            background-color: rgba(128, 93, 116, 0.85);
        }

        .table-header {
            background-color: rgba(158,94,137,0.8);
            color: #fff;
        }

        .produk-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }

        table tr:hover {
            background: rgba(199,139,179,0.15);
        }

        .btn.custom-btn {
            background-color: rgba(128, 93, 116, 0.75);
            color: #fff;
        }

        .btn.custom-btn:hover {
            background-color: #a97474;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(199,139,179,0.2);
        }

        .table-nested {
            background-color: #f8f9fa;
            font-size: 14px;
        }

        .foto-produk {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 5px;
        }

        .table td, .table th {
            vertical-align: middle !important;
        }
    </style>
</head>
<body>
<?php require "navbar.php"; ?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4"><i class="fas fa-shopping-cart me-2"></i>Daftar Pesanan</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama Pemesan</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Produk</th>
                            <th>Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pesanan)): ?>
                            <tr><td colspan="8">Belum ada pesanan.</td></tr>
                        <?php else: ?>
                            <?php foreach ($pesanan as $id => $data): ?>
                                <tr>
                                    <td><strong>#<?= $id ?></strong></td>
                                    <td><?= htmlspecialchars($data['info']['nama']) ?></td>
                                    <td><?= htmlspecialchars($data['info']['telepon']) ?></td>
                                    <td><?= htmlspecialchars($data['info']['alamat']) ?></td>
                                    <td><?= $data['info']['tanggal'] ?></td>
                                    <td><span class="badge bg-secondary"><?= ucfirst($data['info']['status']) ?></span></td>
                                    <td>
                                        <table class="table table-nested table-sm mb-0">
                                            <?php foreach ($data['produk'] as $produk): ?>
                                                <tr>
                                                    <td class="text-start">
                                                        <img src="../image/<?= $produk['foto'] ?>" class="foto-produk" alt="">
                                                        <?= $produk['nama_produk'] ?> (x<?= $produk['jumlah'] ?>)
                                                    </td>
                                                    <td>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td class="text-end fw-bold">Subtotal:</td>
                                                <td class="fw-bold text-danger">Rp <?= number_format($data['subtotal'], 0, ',', '.') ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <form method="post" class="d-flex flex-column gap-2 align-items-center">
                                            <input type="hidden" name="pesanan_id" value="<?= $id ?>">
                                            <select name="status" class="form-select form-select-sm w-auto">
                                                <option <?= $data['info']['status'] == 'baru' ? 'selected' : '' ?> value="baru">Baru</option>
                                                <option <?= $data['info']['status'] == 'diproses' ? 'selected' : '' ?> value="diproses">Diproses</option>
                                                <option <?= $data['info']['status'] == 'dikirim' ? 'selected' : '' ?> value="dikirim">Dikirim</option>
                                                <option <?= $data['info']['status'] == 'dibatalkan' ? 'selected' : '' ?> value="dibatalkan">Dibatalkan</option>
                                                <option <?= $data['info']['status'] == 'selesai' ? 'selected' : '' ?> value="selesai">Selesai</option>
                                            </select>
                                            <button name="ubah_status" class="btn btn-sm custom-btn">Ubah</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="text-center mt-5" style="background: rgba(158,94,137,0.65); color:white; padding:10px; border-radius:12px;">
        &copy; 2025 Wins Beads - All Rights Reserved
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>