<?php 
    #1. koneksi database
    include_once("../koneksi.php");

    #2. ID hapus
    $idhapus = $_GET['id'];

    #2.1
    $qry = "SELECT * FROM biodata WHERE id='$idhapus'";
    $hapus_foto = mysqli_query($koneksi,$qry);
    $data = mysqli_fetch_array($hapus_foto);
    $nama_foto = $data['foto'];
    $lokasi_foto = "../fotosiswa/$nama_foto";

    if(file_exists($lokasi_foto)){
        unlink($lokasi_foto);
    }

    #3. menulis query
    $qry = "DELETE FROM biodata WHERE id='$idhapus'";

    #4. menjalan query
    $hapus = mysqli_query($koneksi,$qry);
    
    #5. mengalihkan halaman
    header("location:index.php");
?>