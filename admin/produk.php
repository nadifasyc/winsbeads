<?php
require "session.php";
require "../koneksi.php";

// Input produk
if (isset($_POST['simpan_produk'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $harga = htmlspecialchars($_POST['harga']);
    $detail = htmlspecialchars($_POST['detail']);
    $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

    $foto = $_FILES['foto']['name'];
    if ($foto != '') {
        $target_dir = "../image/";
        $target_file = $target_dir . basename($foto);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $image_size = $_FILES["foto"]["size"];

        if ($image_size < 500000 && in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
            mysqli_query($con, "INSERT INTO produk (nama, kategori_id, harga, foto, detail, ketersediaan_stok) 
                VALUES ('$nama', '$kategori', '$harga', '$foto', '$detail', '$ketersediaan_stok')");
        }
    } else {
        mysqli_query($con, "INSERT INTO produk (nama, kategori_id, harga, detail, ketersediaan_stok) 
            VALUES ('$nama', '$kategori', '$harga', '$detail', '$ketersediaan_stok')");
    }
}

// Update produk
if (isset($_POST['update_produk'])) {
    $id = $_POST['id'];
    $nama = htmlspecialchars($_POST['nama']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $harga = htmlspecialchars($_POST['harga']);
    $detail = htmlspecialchars($_POST['detail']);
    $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

    $foto = $_FILES['foto']['name'];
    if ($foto != '') {
        $target_dir = "../image/";
        $target_file = $target_dir . basename($foto);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $image_size = $_FILES["foto"]["size"];

        if ($image_size < 500000 && in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
            mysqli_query($con, "UPDATE produk SET 
                nama='$nama', kategori_id='$kategori', harga='$harga', foto='$foto', detail='$detail', ketersediaan_stok='$ketersediaan_stok' 
                WHERE id='$id'");
        }
    } else {
        mysqli_query($con, "UPDATE produk SET 
            nama='$nama', kategori_id='$kategori', harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok' 
            WHERE id='$id'");
    }
}

// Delete produk
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM produk WHERE id='$id'");
    header("Location: produk.php");
    exit;
}

$queryProduk = mysqli_query($con, "SELECT * FROM produk");
$jumlahProduk = mysqli_num_rows($queryProduk);
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Produk | Winsbeads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .btn.custom-btn {
            background-color: rgba(128, 93, 116, 0.75);
            color: #fff;
            transition: background-color 0.3s;
        }

        .btn.custom-btn:hover {
            background-color: #a97474;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            background: rgba(255, 255, 255, 0.7);
        }

        thead.table-light {
            background: rgba(158, 94, 137, 0.4);
            color: #fff;
        }

        table tr:hover {
            background: rgba(199, 139, 179, 0.2);
        }

        footer {
            background-color: rgba(158, 94, 137, 0.65);
            color: #fff;
            padding: 15px 0;
            text-align: center;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<?php require "navbar.php" ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3"><i class="fas fa-plus-circle me-2"></i>Tambah Produk</h4>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Produk</label>
                            <input type="text" id="nama" name="nama" class="form-control" required>
                        </div>
                        <div>
                            <label for="kategori" class="form-label">Kategori</label>
                            <select name="kategori" id="kategori" class="form-select" required>
                                <option value="">Pilih Satu</option>
                                <?php while($data=mysqli_fetch_array($queryKategori)){ ?>
                                    <option value="<?php echo $data['id']; ?>"><?php echo $data['nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="form-label">Detail</label>
                            <textarea name="detail" id="detail" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div>
                            <label for="ketersediaan_stok" class="form-label">Ketersediaan Stok</label>
                            <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-select">
                                <option value="tersedia">Tersedia</option>
                                <option value="habis">Habis</option>
                            </select>
                        </div>
                        <button class="btn custom-btn mt-3" type="submit" name="simpan_produk">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3"><i class="fas fa-list me-2"></i>List Produk</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:5%;">No.</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th style="width:20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($jumlahProduk == 0) {
                                    echo '<tr><td colspan="6">Tidak ada data produk</td></tr>';
                                } else {
                                    $number = 1;
                                    $queryProduk = mysqli_query($con, "SELECT * FROM produk");
                                    while ($data = mysqli_fetch_array($queryProduk)) {
                                ?>
                                        <tr>
                                            <td><?= $number++; ?></td>
                                            <td><?= $data['nama']; ?></td>
                                            <td><?= $data['kategori_id']; ?></td>
                                            <td><?= $data['harga']; ?></td>
                                            <td><?= $data['ketersediaan_stok']; ?></td>
                                            <td>
                                                <button class="btn btn-table" data-bs-toggle="modal" data-bs-target="#editModal<?= $data['id']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="produk.php?delete=<?= $data['id']; ?>" class="btn btn-table" onclick="return confirm('Yakin ingin hapus produk ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit Produk -->
                                        <div class="modal fade" id="editModal<?= $data['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post" enctype="multipart/form-data">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Produk</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                                            <div class="mb-3">
                                                                <label>Nama Produk</label>
                                                                <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Kategori</label>
                                                                <select name="kategori" class="form-control" required>
                                                                    <?php
                                                                    $queryKategoriModal = mysqli_query($con, "SELECT * FROM kategori");
                                                                    while ($kategori = mysqli_fetch_array($queryKategoriModal)) { ?>
                                                                        <option value="<?= $kategori['id']; ?>" <?= $kategori['id'] == $data['kategori_id'] ? 'selected' : ''; ?>>
                                                                            <?= $kategori['nama']; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Harga</label>
                                                                <input type="number" name="harga" class="form-control" value="<?= $data['harga']; ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Foto (opsional)</label>
                                                                <input type="file" name="foto" class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Detail</label>
                                                                <textarea name="detail" class="form-control"><?= $data['detail']; ?></textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Stok</label>
                                                                <select name="ketersediaan_stok" class="form-control">
                                                                    <option value="tersedia" <?= $data['ketersediaan_stok'] == 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                                                                    <option value="habis" <?= $data['ketersediaan_stok'] == 'habis' ? 'selected' : ''; ?>>Habis</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" name="update_produk" class="btn btn-primary">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
