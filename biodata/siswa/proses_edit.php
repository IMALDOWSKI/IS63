<?php
    #1. Meng-koneksikan PHP ke MySQL
    include("../koneksi.php");

    #2. Mengambil Value dari Form Tambah
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nisn = $_POST['nisn'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $jurusan = $_POST['jurusan'];
    $nama_foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];



    #3. Query Insert (proses tambah data)
    $query = "UPDATE biodata SET nama='$nama', nisn='$nisn', tempat_lahir='$tempat_lahir', 
    tgl_lahir='$tgl_lahir', alamat='$alamat', email='$email', jenis_kelamin='$jenis_kelamin',  jurusan='$jurusan', foto='$nama_foto'
    WHERE id='$id'";

    $tambah = mysqli_query($koneksi,$query);

    #4. Jika Berhasil triggernya apa? (optional)
    if($tambah){
        header("location:index.php");
    }else{
        echo "Data Gagal ditambah";
    }

    move_uploaded_file($tmp_foto, "../gambar/".$nama_foto);
?>