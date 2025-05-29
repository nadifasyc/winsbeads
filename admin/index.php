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
    <title>Dashboard | Wins Beads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8e1f4 0%, #c9a6c6 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 960px;
        }

        .card-summary {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            padding: 35px;
            color: #5b2d4d;
            cursor: pointer;
        }

        .card-summary:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2);
        }

        .card-summary .icon {
            font-size: 4.5rem;
            color: #9c5b86;
            margin-bottom: 20px;
            transition: color 0.4s ease;
        }

        .card-summary:hover .icon {
            color: #b56ca1;
        }

        .card-summary h3 {
            font-weight: 700;
            font-size: 1.9rem;
            margin-bottom: 12px;
            letter-spacing: 0.05em;
        }

        .card-summary p.number {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 20px;
            color: #7a3e66;
        }

        .link-detail {
            font-weight: 600;
            color: #9c5b86;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            transition: color 0.4s ease, border-color 0.4s ease;
        }

        .link-detail:hover {
            color: #b56ca1;
            border-color: #b56ca1;
            text-decoration: none;
        }

        @media (max-width: 575.98px) {
            .card-summary {
                padding: 25px 15px;
            }
            .card-summary .icon {
                font-size: 3.5rem;
            }
            .card-summary h3 {
                font-size: 1.5rem;
            }
            .card-summary p.number {
                font-size: 2.4rem;
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
