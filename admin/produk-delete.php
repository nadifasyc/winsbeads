<?php
require "session.php";
require "../koneksi.php";

if (isset($_POST['id'])) {
    $id = htmlspecialchars($_POST['id']);

    $queryDelete = mysqli_query($con, "DELETE FROM produk WHERE id='$id'");

    if ($queryDelete) {
        echo '<script>alert("Produk berhasil dihapus!"); window.location.href="produk.php";</script>';
    } else {
        echo '<script>alert("Gagal menghapus produk: ' . mysqli_error($con) . '"); window.location.href="produk.php";</script>';
    }
} else {
    echo '<script>window.location.href="produk.php";</script>';
}
