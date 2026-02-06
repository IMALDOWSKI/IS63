<?php 
    #1. koneksi database
    include_once("../koneksi.php");

    #2. ID hapus
    $idhapus = $_GET['id'];

    #3. menulis query
    $qry = "DELETE FROM jurusan WHERE id='$idhapus'";

    #4. menjalan query
    $hapus = mysqli_query($koneksi,$qry);
    
    #5. mengalihkan halaman
    header("location:index.php");
?>