<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    // STRUKTUR LOGIKA
    // if, else if, else
    // switch

    //OPERATOR PERBANDINGAN <, >, <=, >=, ==, !=
    // OPERATOR LOGIKA &&, ||, !

    //$username = "admin";
    //$password = "admin123";

    //if($username == "admin" && $password == "admin123"){
    //    echo "Selamat Datang $username";
    //}elseif($username == "admin" && $password != "admin123"){
    //    echo "Password Salah";
    //}elseif($username != "admin" && $password == "admin123"){
    //    echo "Username Salah";
    //}else{
    //    echo "Username dan Password Salah";
    //}
    




//    $nama = "BUDIONO";
//    $nilai = 19;

//    if($nilai >= 70){
//        echo "Selamat $nama, anda Lulus";
//    }elseif($nilai >= 40){
//        echo "Hallo $nama, Silahkan Ikut Remedial";
//    }elseif($nilai >= 20){
//        echo "Hallo $nama, Anda Tidak Lulus";
//    }else{
//        echo "Kepada $nama, Anda Langsung DO";
//    }




//    $nilai = 12;
//    if($nilai > 75){
//        echo "Lulus";
//        if($nilai > 90){
//           echo ", Nilai A";
//        }
//    } else {
//        echo "Tidak Lulus";
//        if($nilai > 30){
//            echo ", Silahkan Ikut Remedial";
//        }
//        if($nilai < 15){
//            echo ", Langsung DO";
//        }
//    }
    
    ##### SWITCH #####
    
    switch($hari){
        case 1:
            echo "Hari Minggu";
            break;

        case 2:
            echo "Hari Senin";
            break;

        case 3:
            echo "Hari Selasa";
            break;

        case 4:
            echo "Hari Rabu";
            break;

        case 5:
            echo "Hari Kamis";
            break;

        case 6:
            echo "Hari Jumat";
            break;

        case 7:
            echo "Hari Sabtu";
            break;

        default:
            echo "Hari Tidak Diketahui";
    }    

    
    ?>

</body>
</html>