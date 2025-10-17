<?php 

if(isset($_POST['tbl'])){
    
    $username = $_POST['un']; 
    $password = $_POST['pw'];

    if($username == "admin" && $password == "admin123"){
        header(header: "location:index.php");
        die();
    }elseif($username == "admin" && $password != "admin123"){
        echo "Password Salah";
    }elseif($username != "admin" && $password == "admin123"){
        echo "Username Salah";
    }else{
        echo "Username dan Password Salah";
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
    <h1><p>Form Login Sederhana</p></h1>
    <form action="form-logika.php" method="POST">
        <table>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><input type="text" name="un"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td>:</td>
                <td><input type="password" name="pw"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input type="submit" name="tbl" value="Login"></td>
            </tr>

        </table>
    
</body>
</html>