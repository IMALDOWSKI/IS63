<?php
if(isset($_POST['tbl']));
    
    $nama = $_POST['nama'];
    $nilai = $_POST['nilai'];

    if($nilai >= 70){
        echo "Selamat $nama, Kamu Lulus";
    }elseif($nilai >= 40){
        echo "Maaf $nama, Kamu Remedial";
    }elseif($nilai >= 0){
        echo "Maaf $nama, Kamu Tidak Lulus";
    }else{
        echo "Maaf $nama, Langsung DO";
    }
    if($nilai >= 85){
        echo ", Nilai A";
    }elseif($nilai >= 70){
        echo ", Nilai B";
    }elseif($nilai >= 60){
        echo ", Nilai C";   
    }elseif($nilai >= 50){ 
        echo ", Nilai D"; 
    }else{
        echo ", Nilai E";
    }
?>
<hr>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai</title>
</head>
<body>
    <H1>Form Nilai</H1>
    <form action="latihan.php" method="POST">
        <table> 
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><input type="text" name="nama"></td>
            </tr>
            <tr>
                <td>Nilai 1</td>
                <td>:</td>
                <td><input type="number" name="nilai"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input type="submit" name="tbl" value="Hitung"></td>
            </tr>

        </table>
</body>
</html>