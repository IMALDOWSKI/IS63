<?php
    #1. Meng-koneksikan PHP ke MySQL
    include("../koneksi.php");

    #2. Mengambil Value dari Form Tambah
    $nama = $_POST['nama'];
    $nidn = $_POST['nidn'];
    $rumpun = $_POST['rumpun'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $nama_foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];

    #3. Query Insert (proses tambah data)
    $query = "INSERT INTO dosen (nama,nidn,rumpun,email,no_hp,foto) 
    VALUES ('$nama','$nidn','$rumpun','$email','$no_hp','$nama_foto')";

    move_uploaded_file($tmp_foto,"../fotodosen/$nama_foto");

    $tambah = mysqli_query($koneksi,$query);

    #4. Jika Berhasil triggernya apa? (optional)
    if($tambah){
        header("location:index.php");
    }else{
        echo "Data Gagal ditambah";
    }
?>