<?php
require "session.php";
require "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $queryDelete = mysqli_query($con, "DELETE FROM kategori WHERE id='$id'");
    if ($queryDelete) {
        header("Location: kategori.php?delete_success=1");
    } else {
        echo "Gagal menghapus data: " . mysqli_error($con);
    }
}
?>