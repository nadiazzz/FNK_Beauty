<?php
include 'koneksi.php';

if (isset($_POST['update'])) {

    $id     = $_POST['id'];
    $nama   = $_POST['nama_produk'];
    $brand  = $_POST['brand'];
    $kat    = $_POST['kategori'];
    $stok   = $_POST['stok'];
    $harga  = $_POST['harga'];

    $query = "UPDATE produk SET 
              nama_produk = '$nama', 
              brand       = '$brand', 
              kategori    = '$kat', 
              stok        = '$stok', 
              harga       = '$harga' 
              WHERE id    = '$id'";

    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        header("Location: ../index.php");
    } else {
        echo "Gagal mengupdate data ke database: " . mysqli_error($koneksi);
    }
}
?>