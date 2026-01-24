<?php
    #1. Meng-koneksikan PHP ke MySQL
    include("../koneksi.php");

    #2. Mengambil Value dari Form Tambah
    $nama = $_POST['nama'];
    $nisn = $_POST['nisn'];
    $tp_lahir = $_POST['tp_lahir'];
    $tg_lahir = $_POST['tg_lahir'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $jk = $_POST['jk'];
    $jur = $_POST['jur'];
    $nama_foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];

    #3. Query Insert (proses tambah data)
    $query = "INSERT INTO biodata (nama,nisn,tp_lahir,tg_lahir,alamat,email,jk,jur,foto) 
    VALUES ('$nama','$nisn','$tp_lahir','$tg_lahir','$alamat','$email','$jk','$jur','$nama_foto')";

    move_uploaded_file($tmp_foto,"../fotosiswa/$nama_foto");

    $tambah = mysqli_query($koneksi,$query);

    #4. Jika Berhasil triggernya apa? (optional)
    if($tambah){
        header("location:index.php");
    }else{
        echo "Data Gagal ditambah";
    }
?>