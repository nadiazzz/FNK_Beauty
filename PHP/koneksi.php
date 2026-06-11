<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "beauty_inventory";

$koneksi = mysqli_connect($host, $user, $pass, $db); // untuk menghubungkan ke database untuk melakukan CRUD 

if (!$koneksi) {
    die("koneksi gagal : " . mysqli_connect_error()); //Menghentikan program dan menampilkan pesan, dan menampilkan penyebab kesalahan koneksi/error
}

?>