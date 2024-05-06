<?php
require_once __DIR__ . '/vendor/autoload.php';

require 'fungsi.php';

$id_rapot = $_GET['id'];
$id_siswa = $_GET['siswa'];
$data_siswa = querydb("SELECT s.id_kelas, s.nama, s.nis, k.nama_kelas FROM siswa s JOIN kelas k ON s.id_kelas = k.id_kelas WHERE s.id_siswa =".$id_siswa);

$data_column = querydb("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'rapot'");
$data_rapot = querydb("SELECT * FROM rapot WHERE id_rapot = ".$data_siswa[0]['id_kelas'])[0];
$relation_data = querydb("SELECT * FROM kelas_mapel_rel WHERE id_kelas = 1");
$relation_mapel = explode("|", $relation_data[0]['mapel']);
$relation_hadroh = explode("|", $relation_data[0]['hadroh']);
$relation_pribadi = explode("|", $relation_data[0]['pribadi']);
$i_mapel = 1;
$i_pribadi = 2;
$final_avg = 0;
$nama_file = "Rapot_.pdf";
$mpdf = new \Mpdf\Mpdf();

$html = '<!DOCTYPE HTML>
<html lang="en">
<head>
<style>
    .marker{
         /* padding : 1%; */
         /* color: white; */
         /* background-color: 009900; */
         width: 100%;
         height: 12%;
         border: solid black;
         }
         .container_siswa{
            /* padding : 1%; */
            /* color: white; */
            /* background-color: 009900; */
            width: 100%;
            height: 12%;

            }
         .container_kop{
            /* padding : 1%; */
            /* color: white; */
            /* background-color: 009900; */
            width: 100%;
            height: 12%;

            }
         .container{
            /* padding : 1%; */
            /* color: white; */
            /* background-color: 009900; */
            width: 100%;
            height: 100%;
            }

</style>
<meta charset="UTF-8" />

<title>' . $nama_file . '</title>

</head>
<body>';


$html .= '
<div class="container_siswa" style="display:flex;">
    <h2 style="text-align: center;">HASIL PENILAIAN KEMAMPUAN SANTRI</h2>
    <div style="width:50%;height:10%;float:left;display:flex;">
        <p><b> Nama Santri : '.ucwords($data_siswa[0]['nama']).'</b></p>
        <p><b> No. Induk &nbsp;&nbsp;&nbsp;&nbsp;: '.$data_siswa[0]['nis'].'</b></p>
    </div>
    <div style="width:48%;height:10%;display:flex;">
    <p><b> Firqoh &nbsp;&nbsp;&nbsp; : '.ucwords($data_siswa[0]['nama_kelas']).'</b></p>
    <p><b> Semester  : Ganjil/2023 </b></p>
    </div>
</div>';
$html .= '
<div class="" style="display:flex;">
<table border="1" cellpadding="2" cellspacing="0" style="width:100%">
    <tr>
        <th rowspan="2">No.</th>
        <th rowspan="2">Materi Pelajaran</th>
        <th colspan="2">Nilai</th>
        <th rowspan="2">Nilai Rata-Rata</th>
        <th rowspan="2">Keterangan</th>
    </tr>
    <tr>
        <th>Lisan</th>
        <th>Tulis</th>
    </tr>';
    foreach ($relation_mapel as $key => $value) {
        // echo '<pre>' . var_export($data_rapot[$data[$value-1]['COLUMN_NAME']], true) . '</pre>';
        // echo '<pre>' . var_export($value-1, true) . '</pre>';
        $temp = explode('|',$data_rapot[$data_column[$value-1]['COLUMN_NAME']]);
        $temp_average = ($temp[0] == "-"||$temp[1] == "-") ? (int)(((int)$temp[0]+(int)$temp[1])) : (int)(((int)$temp[0]+(int)$temp[1])/2);
        $html .= '
        <tr>
            <td style="width: 10%;text-align:center;"><b> '.$i_mapel.' </b></td>
            <td style="width: 30%"> '.$data_column[$value-1]['COLUMN_NAME'].' </td>
            <td style="width: 10%"> '.$temp[0].' </td> <!-- Nilai Lisan -->
            <td style="width: 10%"> '.$temp[1].' </td> <!-- Nilai Tulis -->
            <td> '.$temp_average.' </td> <!-- Nilai Rata-Rata -->
            <td> </td>
        </tr>';
        $final_avg+=$temp_average;
        $i_mapel+=1;
    }

$html.='
<tr>
    <td colspan="2"></td>
    <td></td>
    <td></td>
    <td>'.$final_avg/$i_mapel.'</td>
    <td>'.getGrade($final_avg/$i_mapel).'</td>
</tr>
';

$html .= '
</table>
</div>';
$html .= '<h2 style="text-align: center;">Kegiatan Ekstrakurikuler dan Pengembangan Diri</h2>
<div class="" style="display:flex;">
<table border="1" cellpadding="2" cellspacing="0" style="width:100%">
    <tr>
        <th rowspan="2">No.</th>
        <th rowspan="2">Kegiatan</th>
        <th colspan="4">Nilai</th>
    </tr>
    <tr>
        <th>A</th>
        <th>B</th>
        <th>C</th>
        <th>D</th>
    </tr>';
$html .= '
        <tr>
            <td>  </td>
            <td> Ekstrakurikuler </td>
            <td>  </td> <!-- Nilai A -->
            <td>  </td> <!-- Nilai B -->
            <td>  </td> <!-- Nilai C -->
            <td>  </td> <!-- Nilai D -->
        </tr>
        <tr>
        <td> 1 </td>
        <td> Hadroh </td>
        <td>  </td> <!-- Nilai A -->
        <td>  </td> <!-- Nilai B -->
        <td>  </td> <!-- Nilai C -->
        <td>  </td> <!-- Nilai D -->
    </tr>';
        foreach ($relation_hadroh as $key => $value) {
            // echo '<pre>' . var_export($data_rapot[$data[$value-1]['COLUMN_NAME']], true) . '</pre>';
            // echo '<pre>' . var_export($value-1, true) . '</pre>';
        $html.='
        <tr>
            <td>  </td>
            <td> '.ucwords(str_replace("hadroh", " ",str_replace("_", " ", $data_column[$value-1]['COLUMN_NAME']))).' </td>';
            $html.=getCheck($data_rapot[$data_column[$value-1]['COLUMN_NAME']]);
            
        }

        $html .= '</tr>
        <tr>
            <td>  </td>
            <td> Pengembangan Diri </td>
            <td>  </td> <!-- Nilai A -->
            <td>  </td> <!-- Nilai B -->
            <td>  </td> <!-- Nilai C -->
            <td>  </td> <!-- Nilai D -->
        </tr>';
        foreach ($relation_pribadi as $key => $value) {
            // echo '<pre>' . var_export($data_rapot[$data[$value-1]['COLUMN_NAME']], true) . '</pre>';
            // echo '<pre>' . var_export($value-1, true) . '</pre>';
        $html.='
        <tr>
            <td> '.$i_pribadi.' </td>
            <td> '.ucwords(str_replace("_", " ", $data_column[$value-1]['COLUMN_NAME'])).' </td>';
            $html.=getCheck($data_rapot[$data_column[$value-1]['COLUMN_NAME']]);
            $i_pribadi+=1;
        }
$html .= '</tr>
</table>
</div>';
$html .= '
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<div class="container_siswa" style="display:flex;">
    <div style="width:30%;height:10%;float:left;display:flex;padding-right:10px;">
    <p><b> Absensi : </b></p>
        <table border="1" cellpadding="7" cellspacing="0" style="width:100%">
            <tr style="background-color: #ddd;">
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
            <tr>
                <th>Sakit</th>
                <th>10</th>
            </tr>
            <tr>
                <th>Izin</th>
                <th>30</th>
            </tr>
            <tr>
                <th>Tanpa Keterangan</th>
                <th>5</th>
            </tr>
        </table>
    </div>
    <div style="width:68%;height:10%;display:flex;">
    <p><b> Catatan : </b></p>
    <div style="width:99%; border:1px solid black; height:155px;">
    </div>
    </div>
</div>';


$html .='
<div class="container_kaki" style="width:100%;height:25%;margin-top: auto;">
    <div class="isi_kaki_kiri" style="width:30%;height:25%;float: left;padding-top:20px;">
    Mengetahui,
    <br/>INI SIAPA
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <b>(INI SIAPA)</b>
    </div>
    <div class="isi_kaki_kanan" style="width:30%;height:25%;float: right;padding-top:20px;">
    Tangerang,' . date("Y-m-d") . '
    <br/>INI SIAPA
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <b>(INI SIAPA)</b>
    </div>
</div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output($nama_file, 'I');
