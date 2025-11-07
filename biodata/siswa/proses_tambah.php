<?php 
    #1. Meng-koneksikan PHP ke MySql
    include("koneksi.php");

    #2. Mengambil value dari form tambah
    $nama = $_POST['nama'];
    $nisn = $_POST['nisn'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $jurusan = $_POST['jurusan'];

    #3. Query inserr (Proses tambah data)
    $query = "INSERT INTO biodata (nama,nisn,tempat_lahir,tgl_lahir,alamat,email,jenis_kelamin,jurusan)
    VALUES ('$nama', '$nisn', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$email', '$jenis_kelamin', '$jurusan')";

   $tambah = mysqli_query($koneksi, $query);
   
   #4. Jika Berhasil 
    if($tambah){
         header("Location: index.php");
    } else {
         echo "data gagal ditambahkan";
    }
?>