<?php
require 'fungsi.php';

$nama_ta = str_replace("###", " ", $_GET['nama_ta']);
$name = str_replace(' ', '_', $_GET['nama_ta']);
 $output = ganti_ta($name);
 if ($output > 0) {
     echo "<script> alert('Tahun Ajaran berhasil diganti')
     window.location = 'siswa.php';
     </script>";
 } else {
     echo "<script> alert('Tahun Ajaran gagal diganti')</script>";
 }
?>