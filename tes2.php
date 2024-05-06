<?php 
require 'fungsi.php';
session_start();
$id = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$data = querydb("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'rapot'");
$data_rapot = querydb("SELECT * FROM rapot WHERE id_rapot = 1")[0];
$relation_data = querydb("SELECT * FROM kelas_mapel_rel WHERE id_kelas = 1");
$relation_mapel = explode("|", $relation_data[0]['mapel']);
$relation_hadroh = explode("|", $relation_data[0]['hadroh']);
$relation_ekskul = explode("|", $relation_data[0]['ekskul']);
$hadroh = "";
$mapel = "";
$ekskul = "";
foreach ($data as $row) {
    if(in_array($row['ORDINAL_POSITION'], $relation_mapel)){
        if($mapel == ""){
            $mapel = $row['COLUMN_NAME'];
        }else{
            $mapel = $mapel.", ".$row['COLUMN_NAME'];
        }
    }else if(in_array($row['ORDINAL_POSITION'], $relation_hadroh)){
        if($hadroh == ""){
            $hadroh = $row['COLUMN_NAME'];
        }else{
            $hadroh = $hadroh.", ".$row['COLUMN_NAME'];
        }
    }else if(in_array($row['ORDINAL_POSITION'], $relation_ekskul)){
        if($ekskul == ""){
            $ekskul = $row['COLUMN_NAME'];
        }else{
            $ekskul = $ekskul.", ".$row['COLUMN_NAME'];
        }
    }
};

// echo '<pre>' . var_export($hadroh, true) . '</pre>';
// echo '<pre>' . var_export($mapel, true) . '</pre>';
// echo '<pre>' . var_export($ekskul, true) . '</pre>';
// echo '<pre>' . var_export($data, true) . '</pre>';
foreach ($relation_mapel as $key => $value) {
    echo '<pre>' . var_export($data_rapot[$data[$value-1]['COLUMN_NAME']], true) . '</pre>';
    echo '<pre>' . var_export($value-1, true) . '</pre>';
}
$data_siswa = querydb("SELECT s.nama, s.nis, k.nama_kelas FROM siswa s JOIN kelas k ON s.id_kelas = k.id_kelas");
echo '<pre>' . var_export($data_siswa, true) . '</pre>';

?>