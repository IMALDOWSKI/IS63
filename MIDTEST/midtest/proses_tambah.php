<?php
include("koneksi.php");

$nama   = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
$produk = mysqli_real_escape_string($koneksi, $_POST['produk']);
$jumlah = (int)$_POST['jumlah'];
$tgl    = $_POST['tanggal_pesan'];

$query = "INSERT INTO `pesanan` (nama_pelanggan, produk, jumlah, tanggal_pesan) 
          VALUES ('$nama', '$produk', '$jumlah', '$tgl')";

if (mysqli_query($koneksi, $query)) {
    header("Location: index.php?status=success");
} else {
    header("Location: form_tambah.php?status=error");
}
?>