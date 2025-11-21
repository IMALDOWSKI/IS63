<?php
    #1. Meng-koneksikan PHP ke MySQL
    include("../koneksi.php");

    #2. Mengambil Value dari Form Tambah
    $id_pesanan = $_POST['id_pesanan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $produk = $_POST['produk'];
    $jumlah = $_POST['jumlah'];
    $tanggal_pesan = $_POST['tanggal_pesan'];


    #3. Query Insert (proses tambah data)
    $query = "UPDATE order SET id_pesanan='$id_pesanan', nama_pelanggan='$nama_pelanggan', produk='$produk', 
    jumlah='$jumlah', tanggal_pesan='$tanggal_pesan' 
    WHERE id='$id'";

    $tambah = mysqli_query($koneksi,$query);

    #4. Jika Berhasil triggernya apa? (optional)
    if($tambah){
        header("location:index.php");
    }else{
        echo "Data Gagal ditambah";
    }
?>