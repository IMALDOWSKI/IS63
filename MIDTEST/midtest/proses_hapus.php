<?php
include("koneksi.php");

$id = (int)$_GET['id'];

$query = "DELETE FROM `pesanan` WHERE id_pesanan = '$id'";

if (mysqli_query($koneksi, $query)) {
    header("Location: index.php?status=deleted");
} else {
    header("Location: index.php?status=error");
}
?>