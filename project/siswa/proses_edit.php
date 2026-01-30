<?php
    #1. Meng-koneksikan PHP ke MySQL
    include("../koneksi.php");

    #2. Mengambil Value dari Form Tambah
    $id = $_POST['id'];
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

    if($nama_foto != ""){
        $qry = "SELECT * FROM biodata WHERE id='$id'";
        $hapus_foto = mysqli_query($koneksi,$qry);
        $data = mysqli_fetch_array($hapus_foto);
        $nama_foto_hapus = $data['foto'];
        $lokasi_foto = "../fotosiswa/$nama_foto_hapus";
        if(file_exists($lokasi_foto)){
            unlink($lokasi_foto);
        }

        #3. Query Insert (proses edit data)
        $query = "UPDATE biodata SET nama='$nama', nisn='$nisn', tp_lahir='$tp_lahir', 
        tg_lahir='$tg_lahir', alamat='$alamat', email='$email', jk='$jk',  jurusans_id='$jur', foto='$nama_foto' 
        WHERE id='$id'";

        #hapus foto
        // $lokasi_foto = "../fotosiswa/$nama_foto";
        // if(file_exists($lokasi_foto)){
        //     unlink($lokasi_foto);
        // }

        #tambahkan foto
        move_uploaded_file($tmp_foto,"../fotosiswa/$nama_foto");
    }else{
        #3. Query Insert (proses edit data)
        $query = "UPDATE biodata SET nama='$nama', nisn='$nisn', tp_lahir='$tp_lahir', 
        tg_lahir='$tg_lahir', alamat='$alamat', email='$email', jk='$jk',  jurusans_id='$jur' 
        WHERE id='$id'";
    }

    
    $tambah = mysqli_query($koneksi,$query);

    #4. Jika Berhasil triggernya apa? (optional)
    if($tambah){
        header("location:index.php");
    }else{
        echo "Data Gagal ditambah";
    }
?>