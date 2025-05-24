<?php
require "session.php";
require "../koneksi.php";

$queryProduk = mysqli_query($con, "SELECT * FROM produk");
$jumlahProduk = mysqli_num_rows($queryProduk);

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

$alert = '';
if (isset($_POST['simpan_produk'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $harga = htmlspecialchars($_POST['harga']);
    $detail = htmlspecialchars($_POST['detail']);
    $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

    $target_dir = "../image/";
    $nama_file = basename($_FILES["foto"]["name"]);
    $imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    $image_size = $_FILES["foto"]["size"];
    $tmp_file = $_FILES["foto"]["tmp_name"];

    if ($nama == '' || $kategori == '' || $harga == '') {
        $alert = '<div class="alert alert-secondary mt-3">Nama, Kategori, dan Harga wajib diisi.</div>';
    } else {
        if ($nama_file != '') {
            if ($image_size > 500000) {
                $alert = '<div class="alert alert-warning mt-3">File tidak boleh lebih dari 500 KB.</div>';
            } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $alert = '<div class="alert alert-warning mt-3">File wajib bertipe JPG, JPEG, PNG, atau GIF.</div>';
            } else {
                $nama_file_baru = uniqid() . '.' . $imageFileType;
                $target_file = $target_dir . $nama_file_baru;

                if (move_uploaded_file($tmp_file, $target_file)) {
                    $querySimpan = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$nama_file_baru', '$detail', '$ketersediaan_stok')");

                    if ($querySimpan) {
                        $alert = '<div class="alert alert-success mt-3">Produk berhasil disimpan.</div>';
                        echo '<meta http-equiv="refresh" content="1; url=produk.php">';
                    } else {
                        $alert = '<div class="alert alert-danger mt-3">Gagal menyimpan ke database.</div>';
                    }
                } else {
                    $alert = '<div class="alert alert-danger mt-3">Gagal upload file.</div>';
                }
            }
        } else {
            $querySimpan = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$detail', '$ketersediaan_stok')");

            if ($querySimpan) {
                $alert = '<div class="alert alert-success mt-3">Produk berhasil disimpan (tanpa gambar).</div>';
                echo '<meta http-equiv="refresh" content="1; url=produk.php">';
            } else {
                $alert = '<div class="alert alert-danger mt-3">Gagal menyimpan ke database.</div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <style>
    body {
        background-color: #f9f9f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .btn.custom-btn {
        background-color: rgba(128, 93, 116, 0.75);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: #FFFFFF;
        transition: background-color 0.3s ease;
    }
    .btn.custom-btn:hover {
        background-color: #a97474;
        color: #FFFFFF;
    }
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
    }
    table {
        border-radius: 12px;
        overflow: hidden;
    }
    thead.table-light {
        background: rgba(158, 94, 137, 0.4);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: #fff;
    }
    table td, table th {
        vertical-align: middle;
    }
    table tr:hover {
        background: rgba(199, 139, 179, 0.2);
        transition: background 0.3s ease;
    }
    footer {
        background-color: rgba(158, 94, 137, 0.65);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: #fff;
        padding: 15px 0;
        text-align: center;
        margin-top: 40px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Form Tambah Produk -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3"><i class="fas fa-plus-circle me-2"></i>Tambah Produk</h4>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select name="kategori" id="kategori" class="form-control" required>
                                    <option value="">Pilih Satu</option>
                                    <?php while ($data = mysqli_fetch_array($queryKategori)) { ?>
                                        <option value="<?php echo $data['id']; ?>"><?php echo $data['nama']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" name="harga" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" name="foto" id="foto" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="detail" class="form-label">Detail</label>
                                <textarea name="detail" id="detail" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="ketersediaan_stok" class="form-label">Ketersediaan Stok</label>
                                <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                                    <option value="tersedia">Tersedia</option>
                                    <option value="habis">Habis</option>
                                </select>
                            </div>
                            <button type="submit" name="simpan_produk" class="btn custom-btn">
                                <i class="fas fa-save me-1"></i>Simpan
                            </button>
                        </form>

                        <?php echo $alert; ?>
                    </div>
                </div>

                <!-- Tabel List Produk -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3"><i class="fas fa-list me-2"></i>List Produk</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">No.</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Ketersediaan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($jumlahProduk == 0) {
                                        echo '<tr><td colspan="5">Tidak ada data produk</td></tr>';
                                    } else {
                                        $number = 1;
                                        while ($data = mysqli_fetch_array($queryProduk)) {
                                            $queryNamaKategori = mysqli_query($con, "SELECT nama FROM kategori WHERE id=" . $data['kategori_id']);
                                            $kategoriData = mysqli_fetch_array($queryNamaKategori);
                                            echo '<tr>';
                                            echo '<td>' . $number . '</td>';
                                            echo '<td>' . $data['nama'] . '</td>';
                                            echo '<td>' . $kategoriData['nama'] . '</td>';
                                            echo '<td>Rp ' . number_format($data['harga'], 0, ',', '.') . '</td>';
                                            echo '<td>' . ucfirst($data['ketersediaan_stok']) . '</td>';
                                            echo '</tr>';
                                            $number++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <footer>
                    &copy; 2025 Wins Beads - All Rights Reserved
                </footer>

            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
