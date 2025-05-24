<?php
    require "session.php";
    require "../koneksi.php";

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);

    $queryProduk = mysqli_query($con, "SELECT * FROM produk");
    $jumlahProduk = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Wins Beads</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../fontawesome/css/all.min.css" />

    <style>
        /* Background gradient lembut */
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f0e6e6 0%, #c9a6a6 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Container untuk home */
        .container {
            max-width: 960px;
        }

        /* Glass card style */
        .card-summary {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 30px;
            color: #4a2c2c;
            cursor: pointer;
        }
        .card-summary:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
            color: #733636;
        }

        /* Icon style */
        .card-summary .icon {
            font-size: 5rem;
            color: #7e4c4c;
            margin-bottom: 20px;
            transition: color 0.3s ease;
        }
        .card-summary:hover .icon {
            color: #a55e5e;
        }

        /* Judul dan angka */
        .card-summary h3 {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 10px;
            letter-spacing: 0.04em;
        }
        .card-summary p.number {
            font-size: 3.2rem;
            font-weight: 900;
            margin-bottom: 20px;
            color: #5d3b3b;
        }

        /* Link detail */
        .link-detail {
            font-weight: 600;
            color: #7e4c4c;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            transition: color 0.3s ease, border-color 0.3s ease;
        }
        .link-detail:hover {
            color: #a55e5e;
            border-color: #a55e5e;
            text-decoration: none;
        }

        /* Responsive adjustments */
        @media (max-width: 575.98px) {
            .card-summary {
                padding: 25px 15px;
            }
            .card-summary .icon {
                font-size: 4rem;
            }
            .card-summary h3 {
                font-size: 1.7rem;
            }
            .card-summary p.number {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <?php require "navbar.php" ?>

    <div class="container mt-5 text-center">
        <div class="row justify-content-center g-4">
            <div class="col-lg-5 col-md-6 col-sm-8 mx-auto">
                <div class="card-summary">
                    <div class="icon">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <h3>Kategori</h3>
                    <p class="number"><?php echo $jumlahKategori; ?></p>
                    <a href="kategori.php" class="link-detail">Lihat Detail &rarr;</a>
                </div>
            </div>

            <div class="col-lg-5 col-md-6 col-sm-8 mx-auto">
                <div class="card-summary">
                    <div class="icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <h3>Produk</h3>
                    <p class="number"><?php echo $jumlahProduk; ?></p>
                    <a href="produk.php" class="link-detail">Lihat Detail &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>