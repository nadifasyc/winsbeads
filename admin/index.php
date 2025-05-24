<?php
    require "session.php";
    require "../koneksi.php";

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);

    $queryProduk = mysqli_query($con, "SELECT * FROM produk");
    $jumlahProduk = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>
<style>
    .summary-kategori {
        background-color: #987070;
        border-radius: 10px;
    }
    .summary-produk {
        background-color: #705C53;
        border-radius: 10px;
    }
        .link-detail {
      color: #FFFFFF;
    }
    .link-detail:hover {
      color: #F1E5D1;
    }

</style>
<body>
    <?php require "navbar.php"?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="summary-kategori p-4">
                    <div class="row">
                        <div class="col-6">
                        <i class="fas fa-align-justify fa-5x text-black-50"></i>
                    </div>
            
                        <div class="col-6 text-white">
                            <h3 class="fs-2">Kategori</h3>
                            <p class="fs-4"><?php echo $jumlahKategori; ?></p>
                            <a href="kategori.php" class="link-detail">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>

            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="summary-produk p-4">
                    <div class="row">
                        <div class="col-6">
                        <i class="fas fa-box fa-5x text-black-50"></i>
                    </div>
            
                        <div class="col-6 text-white">
                            <h3 class="fs-2">Produk</h3>
                            <p class="fs-4"><?php echo $jumlahProduk; ?></p>
                            <a href="produk.php" class="link-detail">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>