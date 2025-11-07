<?php 
    #1. Meng-koneksikan PHP ke MySql
    include("koneksi1.php");

    #2. Mengambil value dari form tambah
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];


    #3. Query inserr (Proses tambah data)
    $query = "INSERT INTO pekerja (nama,email,no_hp)
    VALUES ('$nama','$email','$no_hp')";

   $tambah = mysqli_query($koneksi, $query);
   
   #4. Jika Berhasil 
    if($tambah){
         header("Location: index1.php");
    } else {
         echo "data gagal ditambahkan";
    }
?>