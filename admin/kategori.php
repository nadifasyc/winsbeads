<?php
require "session.php";
require "../koneksi.php";

if (isset($_POST['simpan_kategori'])) {
    $kategori = htmlspecialchars($_POST['kategori']);
    $queryExist = mysqli_query($con, "SELECT nama FROM kategori WHERE nama='$kategori'");
    if (mysqli_num_rows($queryExist) > 0) {
        $alert = '<div class="alert alert-warning mt-3">Kategori sudah ada.</div>';
    } else {
        $querySimpan = mysqli_query($con, "INSERT INTO kategori(nama) VALUES ('$kategori')");
        $alert = $querySimpan
            ? '<div class="alert alert-success mt-3">Kategori berhasil ditambahkan.</div>'
            : '<div class="alert alert-danger mt-3">Gagal menambahkan kategori.</div>';
    }
}

if (isset($_POST['edit_kategori'])) {
    $id = $_POST['id'];
    $nama = htmlspecialchars($_POST['nama']);
    $queryUpdate = mysqli_query($con, "UPDATE kategori SET nama='$nama' WHERE id='$id'");
    $alert = $queryUpdate
        ? '<div class="alert alert-success mt-3">Kategori berhasil diupdate.</div>'
        : '<div class="alert alert-danger mt-3">Gagal mengupdate kategori.</div>';
}

if (isset($_POST['hapus_kategori'])) {
    $id = $_POST['id'];
    $queryDelete = mysqli_query($con, "DELETE FROM kategori WHERE id='$id'");
    $alert = $queryDelete
        ? '<div class="alert alert-success mt-3">Kategori berhasil dihapus.</div>'
        : '<div class="alert alert-danger mt-3">Gagal menghapus kategori.</div>';
}

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kategori | Winsbeads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <style>

        body { 
            background-color: #f9f9f9; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        }

        .btn.custom-btn { 
            background-color: rgba(128, 93, 116, 0.75); 
            color: #fff; transition: background-color 0.3s; 
        }

        .btn.custom-btn:hover { 
            background-color: #a97474; 
        }

        .card { 
            border: none; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
            margin-bottom: 30px; 
            background: rgba(255,255,255,0.7);
        }

        thead.table-light { 
            background: rgba(158,94,137,0.4); 
            color: #fff; 
        }

        table tr:hover { 
            background: rgba(199,139,179,0.2); 
        }

        footer { 
            background-color: rgba(158,94,137,0.65); 
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
                        <h4 class="mb-3"><i class="fas fa-plus-circle me-2"></i>Tambah Kategori</h4>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Nama Kategori</label>
                                <input type="text" id="kategori" name="kategori" class="form-control" required>
                            </div>
                            <button class="btn custom-btn" type="submit" name="simpan_kategori">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </form>
                        <?php if (isset($alert)) echo $alert; ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3"><i class="fas fa-list me-2"></i>List Kategori</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:5%;">No.</th>
                                        <th>Nama</th>
                                        <th style="width:20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($jumlahKategori == 0) { ?>
                                        <tr><td colspan="3">Tidak ada data kategori</td></tr>
                                    <?php } else {
                                        $number = 1;
                                        while ($data = mysqli_fetch_array($queryKategori)) { ?>
                                            <tr>
                                                <td><?= $number++; ?></td>
                                                <td><?= $data['nama']; ?></td>
                                                <td>

                                                    <button class="btn btn-table" data-bs-toggle="modal" data-bs-target="#editModal<?= $data['id']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <form action="" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                                        <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                                        <button type="submit" name="hapus_kategori" class="btn btn-table">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- MODAL EDIT KATEGORI -->
                                            <div class="modal fade" id="editModal<?= $data['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $data['id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="" method="post">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel<?= $data['id']; ?>">Edit Kategori</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Nama Kategori</label>
                                                                    <input type="text" class="form-control" name="nama" value="<?= $data['nama']; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" name="edit_kategori" class="btn btn-primary">Simpan Perubahan</button>
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
