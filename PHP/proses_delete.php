<?php
include 'koneksi.php';

$id = $_GET['id'];

$query = "DELETE FROM produk WHERE id = '$id'";

$eksekusi = mysqli_query($koneksi, $query);

if ($eksekusi) {
    header("Location: ../index.php");
} else {
    echo "Gagal menghapus data dari database: " . mysqli_error($koneksi);
}
?>