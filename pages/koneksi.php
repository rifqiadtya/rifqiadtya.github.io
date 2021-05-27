<?php 

$host = 'localhost';
$user = 'budiluhur';
$password = 'nU6tKz_NWH5';

$koneksi = mysqli_connect($host, $user, $password) or die("tidak bisa koneksi ke database");
mysqli_select_db($koneksi, "device_monitoring") or die("Tidak ada Database yang dipilih!");

?>

