<?php
require "session.php";
require "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = htmlspecialchars($_POST['nama']);

    $queryUpdate = mysqli_query($con, "UPDATE kategori SET nama='$nama' WHERE id='$id'");
    if ($queryUpdate) {
        header("Location: kategori.php?success=1");
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($con);
    }
}
?>