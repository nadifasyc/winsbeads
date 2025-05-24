<?php
require "session.php";
require "../koneksi.php";

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <style>
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
    .btn-table {
        background-color: rgba(158, 94, 137, 0.6);
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 6px 10px;
        transition: background-color 0.3s ease;
    }
    .btn-table:hover {
        background-color: rgba(199, 139, 179, 0.8);
        color: #fff;
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
    <?php require "navbar.php" ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Form Tambah Kategori -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3"><i class="fas fa-plus-circle me-2"></i>Tambah Kategori</h4>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Nama Kategori</label>
                                <input type="text" id="kategori" name="kategori" placeholder="Input nama kategori" class="form-control" required>
                            </div>
                            <button class="btn custom-btn" type="submit" name="simpan_kategori">
                                <i class="fas fa-save me-1"></i>Simpan
                            </button>
                        </form>

                        <?php
                        if (isset($_POST['simpan_kategori'])) {
                            $kategori = htmlspecialchars($_POST['kategori']);

                            $queryExist = mysqli_query($con, "SELECT nama FROM kategori WHERE nama='$kategori'");
                            $jumlahKategoriBaru = mysqli_num_rows($queryExist);

                            if ($jumlahKategoriBaru > 0) {
                                echo '<div class="alert alert-warning mt-3">Kategori sudah ada.</div>';
                            } else {
                                $querySimpan = mysqli_query($con, "INSERT INTO kategori(nama) VALUES ('$kategori')");
                                if ($querySimpan) {
                                    echo '<div class="alert alert-success mt-3">Kategori berhasil diinput.</div>';
                                    echo '<meta http-equiv="refresh" content="2; url=kategori.php"/>';
                                } else {
                                    echo '<div class="alert alert-danger mt-3">Error: ' . mysqli_error($con) . '</div>';
                                }
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Tabel List Kategori -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3"><i class="fas fa-list me-2"></i>List Kategori</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">No.</th>
                                        <th>Nama</th>
                                        <th style="width: 20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($jumlahKategori == 0) { ?>
                                        <tr>
                                            <td colspan="3">Tidak ada data kategori</td>
                                        </tr>
                                    <?php } else {
                                        $number = 1;
                                        while ($data = mysqli_fetch_array($queryKategori)) { ?>
                                            <tr>
                                                <td><?php echo $number; ?></td>
                                                <td><?php echo $data['nama']; ?></td>
                                                <td>
                                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $data['id']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <form action="kategori-delete.php" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                                        <button type="submit" class="btn">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editModal<?php echo $data['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $data['id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="kategori-edit.php" method="post">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel<?php echo $data['id']; ?>">Edit Kategori</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                                                <div class="mb-3">
                                                                    <label for="namaKategori<?php echo $data['id']; ?>" class="form-label">Nama Kategori</label>
                                                                    <input type="text" class="form-control" id="namaKategori<?php echo $data['id']; ?>" name="nama" value="<?php echo $data['nama']; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php $number++;
                                        }
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

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
