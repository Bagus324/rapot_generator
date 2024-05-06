<?php
require_once __DIR__ . '/vendor/autoload.php';

require 'fungsi.php';

$id_rapot = $_GET['id'];
$id_siswa = $_GET['siswa'];
$data_siswa_guru = querydb("SELECT s.nama, s.nis, s.bacaan, s.index_bacaan, s.nilai_bacaan, k.nama_kelas, g.nama_guru FROM siswa s JOIN kelas k ON k.id_kelas = s.id_kelas JOIN guru g ON g.id_kelas = k.id_kelas WHERE id_siswa = $id_siswa")[0];
$nilai_mapel = querydb("SELECT  nm.tulis, nm.praktek, m.nama_mapel FROM nilai_mapel nm JOIN mapel m ON m.id_mapel = nm.id_mapel WHERE id_rapot = $id_rapot");
$counter_nilai = 0;
$temp_average = 0;
$sum_average = 0;
$i_mapel = 1;
$i_bawah = 1;
$nilai_hadroh = querydb("SELECT  nh.indeks, h.nama_hadroh FROM nilai_hadroh nh JOIN hadroh h ON h.id_hadroh = nh.id_hadroh WHERE id_rapot = $id_rapot");
$nilai_pd = querydb("SELECT  npd.indeks, pd.nama_pd FROM nilai_pd npd JOIN pengembangan_diri pd ON pd.id_pd = npd.id_pd WHERE id_rapot = $id_rapot");
$data_rapot = querydb("SELECT * FROM rapot WHERE id_rapot = $id_rapot")[0];
$ex = querydb("SELECT kex.id_ex, ex.nama_ex FROM kelas_ex kex JOIN ekstrakurikuler ex ON kex.id_ex = ex.id_ex WHERE id_kelas = (SELECT id_kelas FROM siswa WHERE id_siswa = " . $id_siswa . ")");
$data_ta = querydb("SELECT * FROM tahun_ajaran WHERE id_ta = ".$data_rapot['id_ta'])[0];
$nilai_bacaan = (explode("|",$data_siswa_guru['nilai_bacaan']));
$nilai_bacaan[2] = ($nilai_bacaan[0] == "-" || $nilai_bacaan[1] == "-") ? (int)(((int)$nilai_bacaan[0] + (int)$nilai_bacaan[1])) : (int)(((int)$nilai_bacaan[0] + (int)$nilai_bacaan[1]) / 2);
if (isset($data_siswa_guru['bacaan']) || isset($data_siswa_guru['index_bacaan'])){
    $progres_bacaan = $data_siswa_guru['bacaan']=='alquran'?"Al-Qur'an Juz ".$data_siswa_guru['index_bacaan']:"Iqra' Jilid ".$data_siswa_guru['index_bacaan'];
}else{
    $progres_bacaan = "Belum Ada Progres Bacaan";
}
$nama_file = "Rapot_" . $data_siswa_guru['nama'] . ".pdf";
$mpdf = new \Mpdf\Mpdf(['format' => [216, 356], 'autoArabic' => true]);
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;
$mpdf->baseScript = 1;
$mpdf->autoArabic = true;
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
            body {
                background-image: url("img/logo-tpq-80si-25op.png");
                background-repeat: no-repeat;
                background-position: center 50%;
                background-size: 10% 10%;
            }
</style>
<meta charset="UTF-8" />

<title>' . $nama_file . '</title>

</head>
<body>';


$html .= '
<div class="container_siswa" style="display:flex;">
    <h2 style="text-align: center;">HASIL PENILAIAN KEMAMPUAN SANTRI</h2>
    <div style="width:50%;height:5%;float:left;display:flex;">
        <p style="font-size: 18px;"><b> Nama Santri : ' . $data_siswa_guru['nama'] . '</b></p>
        <p style="font-size: 18px;"><b> No. Induk &nbsp;&nbsp;&nbsp;&nbsp;: ' . $data_siswa_guru['nis'] . '</b></p>
    </div>
    <div style="width:48%;height:5%;display:flex;">
        <p style="font-size: 18px;"><b> Firqoh &nbsp;&nbsp;&nbsp; : ' . $data_siswa_guru['nama_kelas'] . '</b></p>
        <p style="font-size: 18px;"><b> Semester  : '.$data_ta['nama_ta'].' </b></p>
    </div>
</div>';
$html .= '
<div class="" style="display:flex;">
<table border="1" cellpadding="2" cellspacing="0" style="width:100%">
    <tr>
        <th rowspan="2" style="font-size: 18px;">No.</th>
        <th rowspan="2" style="font-size: 18px;">Materi Pelajaran</th>
        <th colspan="2" style="font-size: 18px;">Nilai</th>
        <th rowspan="2" style="font-size: 18px;">Nilai Rata-Rata</th>
        <th rowspan="2" style="font-size: 18px;">Keterangan</th>
    </tr>
    <tr >
        <th style="font-size: 18px;">Lisan</th>
        <th style="font-size: 18px;">Tulis</th>
    </tr>
    <tr>
            <td style="font-size: 18px;width: 10%;text-align:center;"><b> ' . $i_mapel . ' </b></td>
            <td style="font-size: 18px;width: 30%"><b> ' . $progres_bacaan . ' </b></td>
            <td style="font-size: 18px;text-align:center;width: 10%"> ' . $nilai_bacaan[1] . ' </td> <!-- Nilai Lisan -->
            <td style="font-size: 18px;text-align:center;width: 10%"> ' . $nilai_bacaan[0] . ' </td> <!-- Nilai Tulis -->
            <td style="font-size: 18px;text-align:center;"> ' . $nilai_bacaan[2] . ' </td> <!-- Nilai Rata-Rata -->
            <td> </td>
        </tr>';
        $sum_average += $nilai_bacaan[2];

foreach ($nilai_mapel as $row) {
    $temp_average = ($row['tulis'] == "-" || $row['praktek'] == "-") ? (int)(((int)$row['tulis'] + (int)$row['praktek'])) : (int)(((int)$row['tulis'] + (int)$row['praktek']) / 2);
    $html .= '
        <tr>
            <td style="font-size: 18px;width: 10%;text-align:center;"><b> ' . $i_mapel+1 . ' </b></td>
            <td style="font-size: 18px;width: 30%;"><b> ' . $row['nama_mapel'] . ' </b></td>
            <td style="font-size: 18px;text-align:center;width: 10%;"> ' . $row['praktek'] . ' </td> <!-- Nilai Lisan -->
            <td style="font-size: 18px;text-align:center;width: 10%"> ' . $row['tulis'] . ' </td> <!-- Nilai Tulis -->
            <td style="font-size: 18px;text-align:center;"> ' . $temp_average . ' </td> <!-- Nilai Rata-Rata -->
            <td> </td>
        </tr>';
    $sum_average += $temp_average;
    $i_mapel += 1;
}

$html .= '
<tr>
    <td colspan="2" style="font-size: 18px;text-align:center;font-weight:bold;padding-left:30px;"><b>Pencapaian Akhir</b></td>
    <td></td>
    <td></td>
    <td style="text-align:center;font-size: 18px;"><b>' . number_format($sum_average / $i_mapel, 2, ',', '') . '</b></td>
    <td style="text-align:center;font-size: 18px;"><b><span lang="ar">' . getGrade(number_format($sum_average / $i_mapel, 0, ',', '')) . '</span></b></td>
</tr>
';

$html .= '
</table>
</div>';
$html .= '<h2 style="text-align: center;">Kegiatan Ekstrakurikuler dan Pengembangan Diri</h2>
<div class="" style="display:flex;">
<table border="1" cellpadding="2" cellspacing="0" style="width:100%">
    <tr>
        <th rowspan="2" style="font-size: 18px;"><b>No.</b></th>
        <th rowspan="2" style="font-size: 18px;"><b>Kegiatan</b></th>
        <th colspan="4" style="font-size: 18px;"><b>Nilai</b></th>
    </tr>
    <tr>
        <th style="font-size: 18px;"><b>A</b></th>
        <th style="font-size: 18px;"><b>B</b></th>
        <th style="font-size: 18px;"><b>C</b></th>
        <th style="font-size: 18px;"><b>D</b></th>
    </tr>';


foreach ($ex as $row) {
    $html .= '
        <tr>
            <td>  </td>
            <td style="text-align:center;font-weight:bold;font-size: 18px;"> Ekstrakurikuler </td>
            <td>  </td> <!-- Nilai A -->
            <td>  </td> <!-- Nilai B -->
            <td>  </td> <!-- Nilai C -->
            <td>  </td> <!-- Nilai D -->
        </tr>
        <tr>
        <td style="text-align:center;font-weight:bold;font-size: 18px;">'.$i_bawah.' </td>
        <td style="font-weight:bold;font-size: 18px;"> '.$row['nama_ex'].' </td>
        <td>  </td> <!-- Nilai A -->
        <td>  </td> <!-- Nilai B -->
        <td>  </td> <!-- Nilai C -->
        <td>  </td> <!-- Nilai D -->
    </tr>';
    $query_select_pp = "SELECT nex.id_pp, pp.nama_param, nex.indeks FROM nilai_ex nex JOIN param_penilaian pp ON nex.id_pp = pp.id_param WHERE id_ex = " . $row['id_ex'] . " AND id_rapot = " . $id_rapot . ";";
    $data_temp = mysqli_query($conn, $query_select_pp);
    $rows_temp = [];
    while ($row_temp = mysqli_fetch_assoc($data_temp)) {
        $rows_temp[] = $row_temp;
    }
    foreach ($rows_temp as $row_pp) {
        $html .= '
    <tr>
        <td>  </td>
        <td style="font-size: 18px;"> <span style="font-weight:bold;font-size: 18px;">•</span> ' . ucwords($row_pp['nama_param']) . ' </td>';
    $html .= getCheck($row_pp['indeks']);
    }
    $i_bawah+=1;
    
}


$html .= '</tr>
        <tr>
            <td>  </td>
            <td style="text-align:center;font-weight:bold;font-size: 18px;"> Pengembangan Diri </td>
            <td>  </td> <!-- Nilai A -->
            <td>  </td> <!-- Nilai B -->
            <td>  </td> <!-- Nilai C -->
            <td>  </td> <!-- Nilai D -->
        </tr>';

foreach ($nilai_pd as $row) {

    $html .= '
            <tr>
                <td style="text-align:center;font-weight:bold;font-size: 18px;">' . $i_bawah . '</td>
                <td style="font-size: 18px;"> ' . ucwords($row['nama_pd']) . ' </td>';
    $html .= getCheck($row['indeks']);
    $i_bawah += 1;
}

$html .= '</tr>
</table>
</div>';
$html .= '
<div class="container_siswa" style="display:flex;;">
    <div style="width:30%;height:5%;float:left;display:flex;padding-right:10px;">
    <p style="font-size: 18px;"><b> Absensi Kehadiran : </b></p>
        <table border="1" cellpadding="7" cellspacing="0" style="width:100%;">
            <tr style="background-color: #ddd;">
                <th style="font-weight:bold;font-size: 18px;">Keterangan</th>
                <th style="font-weight:bold;font-size: 18px;">Jumlah</th>
            </tr>
            <tr>
                <th style="font-size: 18px;">Sakit</th>
                <th style="font-size: 18px;">' . $data_rapot['sakit'] . '</th>
            </tr>
            <tr>
                <th style="font-size: 18px;">Izin</th>
                <th style="font-size: 18px;">' . $data_rapot['izin'] . '</th>
            </tr>
            <tr>
                <th style="font-size: 18px;">Tanpa Keterangan</th>
                <th style="font-size: 18px;">' . $data_rapot['tanpa_ket'] . '</th>
            </tr>
        </table>
    </div>
    <div style="width:68%;height:10%;display:flex;">
    <p style="font-size: 18px;"><b> Catatan Guru : </b></p>
    <div style="width:95%; border:2px solid black; height:165px;padding:5px 5px 5px 5px;">
    <span style="font-size: 16px;">' . $data_rapot['catatan'] . '</span>
    </div>
    </div>
</div>';


$html .= '<br/>
<div class="container_kaki " style="width:100%;height:100%;">
    <div class="isi_kaki_kiri " style="width:30%;height:100%;float: left;">
    <span style="font-weight:bold;">Orangtua/Wali</span>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <b>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</b>
    </div>
    <div class="isi_kaki_kiri" style="width:30%;height:100%;float: left;">
    <span style="font-weight:bold;">Wali Kelas</span>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <b>(' . ucwords($data_siswa_guru['nama_guru']) . ')</b>
    </div>
    <div class="isi_kaki_kanan" style="width:30%;height:100%;float: right;">
    <span style="font-weight:bold;">Tangerang, ' . date("Y-m-d") . '</span>
    <br/><span style="font-weight:bold;">Kepala TPQ</span>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <b>(Nur Aisyah Mashuri, S.Pd)</b>
    </div>
</div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output($nama_file, 'I');
