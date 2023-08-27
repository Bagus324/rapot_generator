<?php 
require_once __DIR__ . '/vendor/autoload.php';

require 'fungsi.php';
$id_kop = 1;
$kop = querydb("SELECT * FROM kop WHERE id_kop = $id_kop")[0];

$id_rapot = $_GET['id'];
$id_siswa = $_GET['siswa'];

$data_rapot = querydb("SELECT r.id_rapot, r.id_siswa, s.nama, r.tanggal, r.bindo, r.sej_islam, r.btq FROM rapot AS r JOIN siswa AS s ON r.id_siswa = s.id_siswa WHERE r.id_siswa = $id_siswa");
$data_siswa = querydb("SELECT * FROM siswa WHERE id_siswa = $id_siswa");
$data_rapot_final = $data_rapot[0];
$tanggal = date('d-F-Y');
$tanggal_final = str_replace("-"," ",$tanggal);
$nama_file = "Rapot_".$data_siswa[0]['nama'].".pdf";
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
         .logo{
         /* padding : 1%; */
         /* color: white; */
         /* background-color: 009900; */
         width: 15%;
         /* border: solid black; */
         }
         .kop{
         /* padding : 1%; */
         /* color: white; */
         /* background-color: 009900; */
         width: 70%;
         /* border: solid black; */
         }

</style>
<meta charset="UTF-8" />
<title>'.$nama_file.'</title>
</head>
<body>
<div class="container" style="display: flex;flex-direction: column;">
<div class="container_kop">';

// KOP SURAT
$html .= '<div class="logo" style="float:left;" ><img src="img/'.$kop['gambar'].'" class="gambar_kop" width="150px"> </div>
<div class="kop" style="float:left;padding-left:50px;text-align:center;padding-top:12px;"> <b style="text-transform: uppercase;">'.$kop['kop'].'</b></div>
<hr style="height:7px;border:none;color:#000000;"/>';


$html .='</div>
<div class="container_siswa">
    <div style="width:50%;height:12%;float:left;">
        <p><b> Nama Siswa : '.$data_siswa[0]['nama'].'</b></p>
        <p><b> NIS : '.$data_siswa[0]['nis'].'</b></p>
        <p><b> Jenis Kelamin : '.$data_siswa[0]['jk'].'</b></p>
    </div>
    <div style="width:48%;height:12%;">
        <p><b> Agama : Islam </b></p>
    </div>
</div>
<br/>
<p><b>1. Nilai Akademik Siswa</p>
<div class="">
<table border="1" cellpadding="10" cellspacing="0" style="width:100%">
    <tr style="background-color: #ddd;">
        <th rowspan="2">No</th>
        <th rowspan="2">Mata Pelajaran</th>
        <th colspan="3">Nilai</th>
    </tr>
    <tr style="background-color: #ddd;">
        <th >KKM</th>
        <th >Nilai Akhir</td>
        <th >Keterangan</td>
    </tr>';
    
    foreach($data_rapot as $row){
        $html .= '
        <tr>
            <td> 1. </td>
            <td> Bahasa Indonesia </td>
            <td> 75 </td>
            <td> '.$row['bindo'].'</td>';
            if ($row['bindo'] >= 75) {
                $html .= '<td> Tuntas </td>';
            } else{
                $html .= '<td> Tidak Tuntas </td>';
            }
        $html .='</tr>';
// pembatas nilai
        $html .= '
        <tr>
            <td> 2. </td>
            <td> Sejarah Islam </td>
            <td> 75 </td>
            <td> '.$row['sej_islam'].'</td>';
            if ($row['sej_islam'] >= 75) {
                $html .= '<td> Tuntas </td>';
            } else{
                $html .= '<td> Tidak Tuntas </td>';
            }
        $html .='</tr>';
// pembatas nilai
        $html .= "
        <tr>
            <td> 3. </td>
            <td> Baca-Tulis Al-Qur'an </td>
            <td> 75 </td>
            <td> ".$row["sej_islam"]."</td>";
            if ($row['sej_islam'] >= 75) {
                $html .= '<td> Tuntas </td>';
            } else{
                $html .= '<td> Tidak Tuntas </td>';
            }
        $html .='</tr>';
    }

$html .= '
</table>
</div>
<h1>Autoloader</h1>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>


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
    Tangerang,'.$tanggal_final.'
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
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output($nama_file, 'I');


?>