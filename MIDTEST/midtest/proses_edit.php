<?php
include("koneksi.php");

$id     = (int)$_POST['id'];
$nama   = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
$produk = mysqli_real_escape_string($koneksi, $_POST['produk']);
$jumlah = (int)$_POST['jumlah'];
$tgl    = $_POST['tanggal_pesan'];

$query = "UPDATE `pesanan` SET 
          nama_pelanggan = '$nama',
          produk = '$produk',
          jumlah = '$jumlah',
          tanggal_pesan = '$tgl'
          WHERE id_pesanan = '$id'";

if (mysqli_query($koneksi, $query)) {
    header("Location: index.php?status=updated");
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>