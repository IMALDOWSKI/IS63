<?php
$host     = 'localhost';
$user     = 'root';
$password = '';
$database = 'db_perpus_nim';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die('<div style="font-family:sans-serif;padding:20px;color:red;">
        <h3>❌ Koneksi Database Gagal</h3>
        <p>' . mysqli_connect_error() . '</p>
    </div>');
}

mysqli_set_charset($conn, 'utf8mb4');
?>
