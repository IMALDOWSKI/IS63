<?php
if(isset($_POST['tbl'])){
        //jika ada aktivitas dari tombol
        $hari = $_POST['hari'];
        switch($hari){
        case 1:
            echo "Hari Senin";
            break;
        
        case 2:
            echo "Hari Selasa";
            break;
        
        case 3:
            echo "Hari Rabu";
            break;
        
        case 4:
            echo "Hari Kamis";
            break;

        case 5:
            echo "Hari Jumat";
            break;

        case 6:
            echo "Hari Sabtu";
            break;

        case 7:
            echo "Hari Minggu";  
            break;
        
        default:
            echo "Tidak Ada Hari";
            break;

    }
    echo "<hr>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="form-switch2.php" method="post">
        <label for="">Tuliskan Angka Hari</label>:
            <input type="number" name="hari">

            <br>
            <button type="submit" name="tbl">Cek Hari</button>
    </form>
</body>
</html>