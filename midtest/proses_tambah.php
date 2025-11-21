<?php 
    #1. Meng-koneksikan PHP ke MySql
    include("../koneksi.php");

    #2. Mengambil value dari form tambah
    $id_pesanan = $_POST['id_pesanan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $produk = $_POST['produk'];
    $jumlah = $_POST['jumlah'];
    $tanggal_pesan = $_POST['tanggal_pesan'];


    #3. Query inserr (Proses tambah data)
    $query = "INSERT INTO order (id_pesanan,nama_pelanggan,produk,jumlah,tanggal_pesan)
    VALUES ('$id_pesanan', '$nama_pelanggan', '$produk', '$jumlah', '$tanggal_pesan')";

   $tambah = mysqli_query($koneksi, $query);
   
   #4. Jika Berhasil 
    if($tambah){
         header("Location: index.php");
    } else {
         echo "data gagal ditambahkan";
    }
?>