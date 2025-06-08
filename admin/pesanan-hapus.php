<?php
require "../init.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    mysqli_query($con, "DELETE FROM pesanan WHERE id=$id");

    header("Location: pesanan.php");
    exit;
}
?>