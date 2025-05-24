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
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>
<body>
    <?php require "navbar.php"?>
        <div class="container mt-5">

        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Kategori</h3>

            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" id="kategori" name="kategori" placeholder="Input nama kategori" class="form-control">
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpan_kategori">Simpan</button>
                </div>
            </form>

            <?php
            if(isset($_POST['simpan_kategori'])){
                $kategori = htmlspecialchars($_POST['kategori']);

                $queryExist = mysqli_query($con, "SELECT nama FROM kategori WHERE nama='$kategori'");
                $jumlahKategoriBaru = mysqli_num_rows($queryExist);

                if($jumlahKategoriBaru > 0){
                    ?>
                    <div class="alert alert-secondary mt-3" role="alert">
                        Kategori sudah ada.
                    </div>
                    <?php
                }
                else{
                    $querySimpan = mysqli_query($con, "INSERT INTO kategori(nama) VALUES ('$kategori')");
                    if ($querySimpan){
                        ?>
                        <div class="alert alert-success mt-3" role="alert">
                            Kategori berhasil diinput.
                        </div>
                        <meta http-equiv="refresh" content="2; url=kategori.php"/>
                        <?php
                    }
                    else{
                        echo mysqli_error($con);
                    }
                }
            }
            ?>
        </div>

    <div class="mt-3">
        <h2>List Kategori</h2>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            if($jumlahKategori==0){
                    ?>
                                <tr>
                                    <td>Tidak ada data kategori</td>
                                </tr>
                    <?php
                            }
                            else{
                                $number = 1;
                                while($data=mysqli_fetch_array($queryKategori)){
                    ?>
                                <tr>
                                    <td><?php echo $number;?></td>
                                    <td><?php echo $data['nama'];?></td>
                                </tr>
                    <?php
                            $number++;
                            }
                        }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>