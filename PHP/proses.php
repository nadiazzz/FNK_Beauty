<?php

include 'koneksi.php';

$nama_produk = $_POST['nama_produk']; // tulisan birunya untuk menarik data input(form) ke database ($nama_produk)
$brand       = $_POST['brand'];
$kategori    = $_POST['kategori'];
$stok        = $_POST['stok'];
$harga       = $_POST['harga'];

mysqli_query( //Menjalankan perintah SQL pada database MySQL
    $koneksi, //Agar database tahu perintah itu dikirim ke koneksi yang mana
    "INSERT INTO produk
    (nama_produk, brand, kategori, stok, harga)
    
    VALUES

    ('$nama_produk',
     '$brand',
     '$kategori',
     '$stok',
     '$harga')"
);

header("Location: ../index.php");//Mengembalikan pengguna ke halaman index setelah data disimpan ke database

?>