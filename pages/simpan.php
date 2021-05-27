<?php

include "koneksi.php";

// menyimpan data kedalam variabel
$name                   = $_POST['name'];
$status                 = 0;
$ipaddress              = ip2long($_POST['ipaddress']);
$group                  = $_POST['group'];
$lastping               = $_POST['lastping'];

/*
if($id_devices=="")
{
  // echo "id_devices kosong belum diisi, ";
  echo "<script>alert('ID Devices Belum diisi');history.go(-1);</script>";
}
 
if($ipaddress=="")
{
  echo "<script>alert('ipaddressBelum diisi');history.go(-1);</script>";
}
 
 
 // cek input id_devices apakah sudah ada id_devices yang digunakan 
   $pilih="select * from devices where id_devices='$id_devices'";
   $cek=mysqli_query($koneksi, $pilih);
 
   $jumlah_data = mysqli_num_rows($cek);
   if ($jumlah_data >= 1 ) 
   {
 
  echo "<script>alert('id_devices yang sama sudah digunakan');history.go(-1);</script>";
    }

   else */
// query untuk insert data device
   $query="INSERT INTO devices(`name`, `ipaddress`, `status`, `lastping`, `group_id`) VALUES ('$name' , $ipaddress, $status, $lastping, $group)";
mysqli_query($koneksi, $query);
 
// echo " Input Data yang anda masukkan sukses berhasil";
header("location:?act=query");
 
// echo "<script>alert('Data yang anda Input sukses');window.location='index.php?act=query'</script>";

?>