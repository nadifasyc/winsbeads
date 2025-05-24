<?php
require "session.php";
require "../koneksi.php";

if (isset($_POST['id']) && isset($_POST['nama'])) {
    $id = htmlspecialchars($_POST['id']);
    $nama = htmlspecialchars($_POST['nama']);

    // Cek apakah nama produk baru sudah ada (selain yang sedang diedit)
    $queryCheck = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama' AND id!='$id'");
    $jumlahCheck = mysqli_num_rows($queryCheck);

    if ($jumlahCheck > 0) {
        echo '<script>alert("Nama produk sudah ada!"); window.location.href="produk.php";</script>';
    } else {
        $queryUpdate = mysqli_query($con, "UPDATE produk SET nama='$nama' WHERE id='$id'");
        if ($queryUpdate) {
            echo '<script>alert("Produk berhasil diperbarui!"); window.location.href="produk.php";</script>';
        } else {
            echo '<script>alert("Gagal memperbarui produk: ' . mysqli_error($con) . '"); window.location.href="produk.php";</script>';
        }
    }
} else {
    echo '<script>window.location.href="produk.php";</script>';
}
