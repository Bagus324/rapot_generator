<?php

session_start();
require 'fungsi.php';

$id = $_GET['id'];
$output = proses_alumni($id);

if ($output > 0) {
    echo "<script> alert('Data alumni berhasil ditambah')</script>";
    header("Location: alumni.php");
} else {
    echo "<script> alert('Data alumni gagal ditambah')</script>";
    header("Location: list_unrapot.php");
}


?>