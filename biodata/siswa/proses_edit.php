<?php
    #1. Meng-koneksikan PHP ke MySQL
    include("../koneksi.php");

    #2. Mengambil Value dari Form Tambah
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nisn = $_POST['nisn'];
    $tp_lahir = $_POST['tp_lahir'];
    $tg_lahir = $_POST['tg_lahir'];
    $tgl_daftar = $_POST['tgl_daftar']; // TAMBAHAN: ambil tanggal daftar dari input
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $jk = $_POST['jk'];
    $jur = $_POST['jur'];
    $nama_foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];

    // TAMBAHAN: Hitung Gelombang berdasarkan BULAN dari tanggal daftar yang dipilih user
    $bulan = date('n', strtotime($tgl_daftar)); // Ambil bulan dari input (1-12)
    
    if ($bulan >= 1 && $bulan <= 3) {
        $gelombang = 1; // Januari - Maret
    } elseif ($bulan >= 4 && $bulan <= 6) {
        $gelombang = 2; // April - Juni
    } elseif ($bulan >= 7 && $bulan <= 9) {
        $gelombang = 3; // Juli - September
    } else {
        $gelombang = 4; // Oktober - Desember
    }

    if($nama_foto != ""){
        $qry = "SELECT * FROM biodata WHERE id='$id'";
        $hapus_foto = mysqli_query($koneksi,$qry);
        $data = mysqli_fetch_array($hapus_foto);
        $nama_foto_hapus = $data['foto'];
        $lokasi_foto = "../fotosiswa/$nama_foto_hapus";
        if(file_exists($lokasi_foto)){
            unlink($lokasi_foto);
        }

        #3. Query Insert (proses edit data) - UPDATED dengan tgl_daftar dan gelombang
        $query = "UPDATE biodata SET nama='$nama', nisn='$nisn', tp_lahir='$tp_lahir', 
        tg_lahir='$tg_lahir', tgl_daftar='$tgl_daftar', gelombang='$gelombang', alamat='$alamat', email='$email', jk='$jk',  jurusans_id='$jur', foto='$nama_foto' 
        WHERE id='$id'";

        #tambahkan foto
        move_uploaded_file($tmp_foto,"../fotosiswa/$nama_foto");
    }else{
        #3. Query Insert (proses edit data) - UPDATED dengan tgl_daftar dan gelombang
        $query = "UPDATE biodata SET nama='$nama', nisn='$nisn', tp_lahir='$tp_lahir', 
        tg_lahir='$tg_lahir', tgl_daftar='$tgl_daftar', gelombang='$gelombang', alamat='$alamat', email='$email', jk='$jk',  jurusans_id='$jur' 
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