<?php

session_start();
require 'fungsi.php';

$id = $_GET['id'];
$id_ta = $_SESSION['id_ta']['id_ta'];
$output = tambah_rapot($id, $id_ta);

if ($output > 0) {
    header("Location: rapot.php");
} else {
    echo "<script> alert('Data rapot gagal ditambah')</script>";
    header("Location: list_unrapot.php");
}


?>