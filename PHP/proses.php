<?php

include 'koneksi.php';

$nama_produk = $_POST['nama_produk'];
$brand       = $_POST['brand'];
$kategori    = $_POST['kategori'];
$stok        = $_POST['stok'];
$harga       = $_POST['harga'];

mysqli_query(
    $koneksi, 
    "INSERT INTO produk
    (nama_produk, brand, kategori, stok, harga)
    
    VALUES

    ('$nama_produk',
     '$brand',
     '$kategori',
     '$stok',
     '$harga')"
);

header("Location: ../index.php");

?>