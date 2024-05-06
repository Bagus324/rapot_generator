<?php
require 'fungsi.php';
session_start();
$id = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$data = querydb("SELECT * FROM rapot WHERE id_siswa = 21");
if ($data) {
    echo 'ada';
} else {
    echo 'tidak ada';
}
var_dump($data);
// var_dump($data_rapot_2[0]);
// foreach ($data as $row) {
//     echo '<pre>' . var_export($row['COLUMN_NAME'], true) . '</pre>';
//     echo '<pre>' . var_export($row['ORDINAL_POSITION'], true) . '</pre>';
//     echo '----------------------------------------------------------------';
// };

?>