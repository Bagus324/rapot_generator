<?php
$conn = mysqli_connect("localhost", "root", "", "rapot");

function querydb($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function querydb_update_rapot($query)
{
    global $conn;
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
function getGrade($score)
{
    switch ($score) {
        case ($score >= 95 && $score <= 100):
            return "ممتاز";
        case ($score >= 85 && $score < 94):
            return "جيّد جيدا";
        case ($score >= 75 && $score < 84):
            return "جيّد";
        case ($score >= 65 && $score < 74):
            return "مقبول";
        case ($score < 65):
            return "ضعيف";
        default:
            return "Invalid score";
    }
}
function getCheck($score)
{
    switch (true) {
        case ($score == "a"):
            return '
            <td style="text-align: center;font-size: 18px;">√</td>
            <td></td>
            <td></td>
            <td></td>';
        case ($score == "b"):
            return '
            <td></td>
            <td style="text-align: center;font-size: 18px;">√</td>
            <td></td>
            <td></td>';
        case ($score == "c"):
            return '
            <td></td>
            <td></td>
            <td style="text-align: center;font-size: 18px;">√</td>
            <td></td>';
        case ($score == "d"):
            return '
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center;font-size: 18px;">√</td>';
        default:
            return '
            <td></td>
            <td></td>
            <td></td>
            <td></td>';
    }
}
function tambah($data)
{
    global $conn;
    $judul = $data['judul'];
    $teks = $data['editor'];
    $id_tag = $data['id_tag'];
    $id_author = $data['id_author'];

    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO artikel (judul, isi, gambar, id_tag, id_author)
                VALUES ('$judul', '$teks', '$gambar' , $id_tag, $id_author)";
    mysqli_query($conn, $query);
    log_artikel($data, 1);
    return mysqli_affected_rows($conn);
}

function proses_alumni($data)
{
    global $conn;
    $id_siswa = $data;
    $query = "UPDATE siswa SET is_alumni = 1 WHERE id_siswa = $id_siswa";
    mysqli_query($conn, $query);
    $rapot = "SELECT * FROM siswa WHERE id_siswa = $id_siswa";
    $result = mysqli_query($conn, $rapot);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    if ($rows) {
        $query = "UPDATE rapot SET is_listed = 0 WHERE id_siswa = $id_siswa";
        mysqli_query($conn, $query);
    } else {
    }

    $alumni = "SELECT s.id_siswa, s.id_kelas, a.id_angkatan, ta.id_ta FROM siswa s CROSS JOIN angkatan a CROSS JOIN tahun_ajaran ta WHERE s.id_siswa=$id_siswa AND a.id_angkatan=(SELECT MAX(id_angkatan) AS id_angkatan FROM angkatan) AND ta.id_ta=(SELECT MAX(id_ta) AS id_ta FROM tahun_ajaran)";
    $result_alumni = mysqli_query($conn, $alumni);
    $rows_alumni = [];
    while ($row = mysqli_fetch_assoc($result_alumni)) {
        $rows_alumni[] = $row;
    }
    var_dump($rows_alumni);
    
    $query_add_alumni = "INSERT INTO alumni (id_siswa, id_angkatan, id_ta, id_kelas) VALUES (".$rows_alumni[0]['id_siswa'].", ".$rows_alumni[0]['id_angkatan'].", ".$rows_alumni[0]['id_ta'].", ".$rows_alumni[0]['id_kelas'].")";
    mysqli_query($conn, $query_add_alumni);

    return mysqli_affected_rows($conn);

}

function tambah_rapot($data, $idta)
{
    global $conn;
    $id_siswa = $data;
    $id_ta = $idta;
    $dt = date('d-F-Y');
    // bikin row rapot
    $query = 'INSERT INTO rapot (id_siswa, tanggal, id_ta) 
                        VALUES ('.$id_siswa.', "'.$dt.'", '.$id_ta.')';
    mysqli_query($conn, $query);


    //bikin isi relation
    //mapel
    //select mapel
    $query_select_mapel = "SELECT id_mapel FROM kelas_mapel WHERE id_kelas = (SELECT id_kelas FROM siswa WHERE id_siswa = $id_siswa)";
    $data = mysqli_query($conn, $query_select_mapel);
    $rows = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $rows[] = $row;
    }
    $new_data = array_map(function ($element) {
        return $element['id_mapel'];
    }, $rows);
    //select rapot id
    $query_id_rapot = "SELECT id_rapot from rapot WHERE id_siswa = $id_siswa AND id_ta = $id_ta";
    $data_id_rapot = mysqli_query($conn, $query_id_rapot);
    $rows_id_rapot = [];
    while ($row = mysqli_fetch_assoc($data_id_rapot)) {
        $rows_id_rapot[] = $row;
    }
    $new_data_id_rapot = array_map(function ($element) {
        return $element['id_rapot'];
    }, $rows_id_rapot);
    $new_data_id_rapot_single = $new_data_id_rapot[0];
    //insert mapel relation
    foreach ($new_data as $row) {
        $query = "INSERT INTO nilai_mapel (id_rapot, id_mapel) 
        VALUES ($new_data_id_rapot_single, $row)";
        mysqli_query($conn, $query);
    }
    //pd
    //select pd
    $query_select_pd = "SELECT id_pd FROM kelas_pd WHERE id_kelas = (SELECT id_kelas FROM siswa WHERE id_siswa = $id_siswa)";
    $data = mysqli_query($conn, $query_select_pd);
    $rows_pd = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $rows_pd[] = $row;
    }
    $new_data_pd = array_map(function ($element) {
        return $element['id_pd'];
    }, $rows_pd);
    //insert mapel relation
    foreach ($new_data_pd as $row) {
        $query = "INSERT INTO nilai_pd (id_rapot, id_pd) 
        VALUES ($new_data_id_rapot_single, $row)";
        mysqli_query($conn, $query);
    }
    //ex
    //select ex
    $query_select_ex = "SELECT id_ex FROM kelas_ex WHERE id_kelas = (SELECT id_kelas FROM siswa WHERE id_siswa = $id_siswa)";
    $data = mysqli_query($conn, $query_select_ex);
    $rows_ex = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $rows_ex[] = $row;
    }
    $new_data_ex = array_map(function ($element) {
        return $element['id_ex'];
    }, $rows_ex);
    //insert ex relation
    foreach ($new_data_ex as $row) {
        $query_select_pp = "SELECT id_param FROM ex_pp WHERE id_ex = $row";
        $data_temp = mysqli_query($conn, $query_select_pp);
        $rows_temp = [];
        while ($row_temp = mysqli_fetch_assoc($data_temp)) {
            $rows_temp[] = $row_temp;
        }
        $new_data_pp = array_map(function ($element) {
            return $element['id_param'];
        }, $rows_temp);
        foreach ($new_data_pp as $row_pp) {
            $query = "INSERT INTO nilai_ex (id_rapot, id_ex, id_pp) 
            VALUES ($new_data_id_rapot_single, $row, $row_pp)";
            mysqli_query($conn, $query);
        }
    }

    return mysqli_affected_rows($conn);
}

function tambah_siswa($data)
{
    global $conn;
    $nama = $data['nama'];
    $jk = $data['jk'];
    $nis = $data['nis'];
    $id_kelas = $data['id_kelas'];
    $bacaan = $data['bacaan'];
    $progres = $data['progres'];
    $query = 'INSERT INTO siswa (nama, nis, jk, bacaan, index_bacaan, id_kelas) VALUES ("'.$nama.'", "'.$nis.'", "'.$jk.'", "'.$bacaan.'", '.$progres.', '.$id_kelas.')';
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function tambah_guru($data)
{
    global $conn;
    $nama = $data['nama'];
    $id_kelas = $data['id_kelas'];
    $query = 'INSERT INTO guru (nama_guru, id_kelas) VALUES ("'.$nama.'", "'.$id_kelas.'")';
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function tambah_angkatan($data)
{
    global $conn;
    $angkatan = $data['angkatan'];
    $query = "INSERT INTO angkatan (angkatan) VALUES ($angkatan)";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function tambah_mapel($data)
{
    global $conn;
    $nama = $data['nama'];
    $query = 'INSERT INTO mapel (nama_mapel) VALUES ("'.$nama.'")';
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function tambah_pd($data)
{
    global $conn;
    $nama = $data['nama_pd'];
    $query = 'INSERT INTO pengembangan_diri (nama_pd) VALUES ("'.$nama.'")';
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function ganti_ta($data)
{
    global $conn;
    $data_temp = $data;
    $name = str_replace('_', ' ', $data_temp);
    $query = 'INSERT INTO tahun_ajaran (nama_ta) VALUES ("'.$name.'")';
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function tambah_ex($data)
{
    global $conn;
    $nama = $data['nama_ex'];
    $query = 'INSERT INTO ekstrakurikuler (nama_ex) VALUES ("'.$nama.'")';
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function tambah_param($data)
{
    global $conn;
    $nama = $data['nama_param'];
    $query = 'INSERT INTO param_penilaian (nama_param) VALUES ("'.$nama.'")';
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function tambah_kelas($data)
{
    global $conn;
    $nama = $data['nama_kelas'];
    $query = 'INSERT INTO kelas (nama_kelas) VALUES ("'.$nama.'")';
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function tambah_acc($data)
{
    global $conn;
    $nama = $data['nama_akun'];
    $username = $data['username'];
    $password = $data['pw'];
    $query = 'INSERT INTO user (username, nama, password, role) VALUES ("'.$username.'", "'.$nama.'", "'.$password.'", "user")';
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function del_siswa($data)
{
    global $conn;
    $id = $data['id_siswa'];
    $query = "DELETE FROM siswa WHERE id_siswa = $id";
    $query_rapot = "DELETE FROM rapot WHERE id_siswa = $id";
    mysqli_query($conn, $query_rapot);
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function del_param($data)
{
    global $conn;
    $id = $data['id_param'];
    $query = "DELETE FROM param_penilaian WHERE id_param = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function del_guru($data)
{
    global $conn;
    $id = $data['id_guru'];
    $query = "DELETE FROM guru WHERE id_guru = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function del_mapel($data)
{
    global $conn;
    $id = $data['id_mapel'];
    $query = "DELETE FROM mapel WHERE id_mapel = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function del_pd($data)
{
    global $conn;
    $id = $data['id_pd'];
    $query = "DELETE FROM pengembangan_diri WHERE id_pd = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function del_kelas($data)
{
    global $conn;
    $id = $data['id_kelas'];
    $query = "DELETE FROM kelas WHERE id_kelas = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function del_ex($data)
{
    global $conn;
    $id = $data['id_ex'];
    $query = "DELETE FROM ekstrakurikuler WHERE id_ex = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function del_rapot($data)
{
    global $conn;
    $id = $data['id_rapot'];
    $query = "DELETE FROM rapot WHERE id_rapot = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function edit_siswa($data)
{
    global $conn;
    $id = $data['id_siswa'];
    $nama = $data['nama'];
    $jk = $data['jk'];
    $nis = $data['nis'];
    $id_kelas = $data['id_kelas'];
    $bacaan = $data['bacaan'];
    $progres = $data['progres'];
    // var_dump($data);
    $query = 'UPDATE siswa SET nama = "'.$nama.'", nis = "'.$nis.'", jk = "'.$jk.'", bacaan = "'.$bacaan.'", index_bacaan = '.$progres.', id_kelas = '.$id_kelas.' WHERE id_siswa = '.$id.';';

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
function edit_kelas($data)
{
    global $conn;
    $id = $data['id_kelas'];
    $nama = $data['nama_kelas'];
    $data_mapel = $data['mapel'];
    $data_ekskul = $data['ex'];
    $data_pd = $data['pd'];
    // var_dump($data);


    // DELETE KELAS_MAPEL
    $query_del_mapel = "DELETE FROM kelas_mapel WHERE id_kelas = $id;";

    mysqli_query($conn, $query_del_mapel);

    // INSERT KELAS_MAPEL
    foreach ($data_mapel as $row) {
        $query_insert_mapel = "INSERT INTO kelas_mapel (id_kelas, id_mapel) VALUES ($id, $row);";

        mysqli_query($conn, $query_insert_mapel);
    }
    // DELETE KELAS_EX
    $query_del_mapel = "DELETE FROM kelas_ex WHERE id_kelas = $id;";

    mysqli_query($conn, $query_del_mapel);

    // INSERT KELAS_EX
    foreach ($data_ekskul as $row) {
        $query_insert_mapel = "INSERT INTO kelas_ex (id_kelas, id_ex) VALUES ($id, $row);";

        mysqli_query($conn, $query_insert_mapel);
    }
    // DELETE KELAS_PD
    $query_del_mapel = "DELETE FROM kelas_pd WHERE id_kelas = $id;";

    mysqli_query($conn, $query_del_mapel);

    // INSERT KELAS_PD
    foreach ($data_pd as $row) {
        $query_insert_mapel = "INSERT INTO kelas_pd (id_kelas, id_pd) VALUES ($id, $row);";

        mysqli_query($conn, $query_insert_mapel);
    }

    $query = 'UPDATE kelas SET nama_kelas = "' . strtolower($nama) . '" WHERE id_kelas = '.$id.';';

    mysqli_query($conn, $query);
    $query = 'UPDATE kelas SET nama_kelas = "'.$nama.'" WHERE id_kelas = '.$id.';';

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function edit_param($data)
{
    global $conn;
    $id = $data['id_ex'];
    $nama = $data['nama_ex'];
    $data_mapel = $data['param'];
    // var_dump($data);
    $query = 'UPDATE ekstrakurikuler SET nama_ex = "'.$nama.'" WHERE id_ex = '.$id.';';

    mysqli_query($conn, $query);

    // DELETE ex_pp
    $query_del_mapel = "DELETE FROM ex_pp WHERE id_ex = $id;";

    mysqli_query($conn, $query_del_mapel);

    // INSERT ex_pp
    foreach ($data_mapel as $row) {
        $query_insert_mapel = "INSERT INTO ex_pp (id_ex, id_param) VALUES ($id, $row);";

        mysqli_query($conn, $query_insert_mapel);
    }

    return mysqli_affected_rows($conn);
}

function edit_param_data($data)
{
    global $conn;
    $id = $data['id_param'];
    $nama = $data['nama_param'];
    // var_dump($data);
    $query = 'UPDATE param_penilaian SET nama_param = "' . $nama . '" WHERE id_param = ' . $id;

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function edit_guru($data)
{
    global $conn;
    $id = $data['id_guru'];
    $nama = $data['nama_guru'];
    $kelas = $data['id_kelas'];
    // var_dump($data);
    $query = 'UPDATE guru SET nama_guru = "'.$nama.'", id_kelas = '.$kelas.' WHERE id_guru = '.$id.';';

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
function edit_mapel($data)
{
    global $conn;
    $id = $data['id_mapel'];
    $nama = $data['nama_mapel'];
    // var_dump($data);
    $query = 'UPDATE mapel SET nama_mapel = "' . $nama . '" WHERE id_mapel = ' . $id;

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ganti_pw($data)
{
    global $conn;
    $id = $data['id'];
    $pw = $data['pw'];
    // var_dump($data);
    $query = 'UPDATE user SET password = "' . $pw . '" WHERE id_user = ' . $id;

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
function edit_pd($data)
{
    global $conn;
    $id = $data['id_pd'];
    $nama = $data['nama_pd'];
    // var_dump($data);
    $query = 'UPDATE pengembangan_diri SET nama_pd = "' . $nama . '" WHERE id_pd = ' . $id;

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function edit_rapot($data)
{
    global $conn;
    $data_mapel_tulis = $data['mapel_tulis']; //
    $data_mapel_praktik = $data['mapel_praktek']; //
    $data_indeks_ex = $data['indeks_pp'];
    $data_indeks_pd = $data['indeks_pd'];
    $data_ket = $data['ket'];
    $id_rapot = $data['id_rapot'];
    $nilai_bacaan_tulis = $data['bacaan_tulis'];
    $nilai_bacaan_praktek = $data['bacaan_praktek'];


    // NILAI_BACAAN_TULIS
    $query = "UPDATE siswa SET nilai_bacaan = '".$nilai_bacaan_tulis."|".$nilai_bacaan_praktek."' WHERE id_siswa = (SELECT id_siswa FROM rapot WHERE id_rapot = ".$id_rapot.") ;";
    mysqli_query($conn, $query);
    // NILAI_MAPEL_TULIS
    foreach ($data_mapel_tulis as $key => $value) {
        $query = "UPDATE nilai_mapel SET tulis = '$value' WHERE id_rapot = $id_rapot AND id_mapel = $key ;";

        mysqli_query($conn, $query);
    }
    // NILAI_MAPEL_PRAKTEK
    foreach ($data_mapel_praktik as $key => $value) {
        $query = "UPDATE nilai_mapel SET praktek = '$value' WHERE id_rapot = $id_rapot AND id_mapel = $key ;";

        mysqli_query($conn, $query);
    }
    // NILAI_INDEKS_PD
    foreach ($data_indeks_pd as $key => $value) {
        $query = "UPDATE nilai_pd SET indeks = '$value' WHERE id_rapot = $id_rapot AND id_pd = $key ;";

        mysqli_query($conn, $query);
    }
    // NILAI_INDEKS_EX
    foreach ($data_indeks_ex as $key => $value) {
        foreach ($value as $key_pp => $value_pp) {
            $query = "UPDATE nilai_ex SET indeks = '$value_pp' WHERE id_rapot = $id_rapot AND id_ex = $key AND id_pp = $key_pp ;";

            mysqli_query($conn, $query);
        }
    }
    // KETERANGAN
    foreach ($data_ket as $key => $value) {
        $query = 'UPDATE rapot SET '.$key.' = "'.$value.'" WHERE id_rapot = '.$id_rapot.' ;';

        mysqli_query($conn, $query);
    }
    // var_dump($data);
    date_default_timezone_set("Asia/Jakarta");
    $dt = date('d-F-Y H:i:s');

    $query = "UPDATE rapot SET tanggal = '$dt' WHERE id_rapot = $id_rapot ;";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function del_artikel($data)
{
    global $conn;
    $id = $data['id_artikel'];

    $query = "UPDATE artikel SET stat_artikel = 0 WHERE id_artikel = $id";

    mysqli_query($conn, $query);
    log_artikel($data, 2);

    return mysqli_affected_rows($conn);
}
function kop_surat($data)
{
    global $conn;
    $id = 1;
    $dir_gambar = upload();
    $kop = $data["kop"];
    $query = "UPDATE kop SET kop = '$kop', gambar = '$dir_gambar' WHERE id_kop = $id";
    // var_dump($query);

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
function log_artikel($data, $type)
{
    global $conn;
    $judul = $data['judul'];
    $id_tag = $data['id_tag'];
    $id_author = $data['id_author'];
    if ($type === 1) {
        $alasan = "";
    } else if ($type === 2) {
        $alasan = $data['alasan'];
    }
    if ($type === 1) {
        $jenis = "Menerbitkan";
    } else if ($type === 2) {
        $jenis = "Menghapus";
    }
    if ($type === 1) {
        $query = "INSERT INTO log_artikel (judul, id_tag, id_author, alasan, jenis)
        VALUES ('$judul', $id_tag ,$id_author , '$alasan', '$jenis')";
        mysqli_query($conn, $query);
    } else if ($type === 2) {
        $tanggal = $data['tanggal'];
        $query = "INSERT INTO log_artikel (judul, id_tag, tanggal_artikel, id_author, alasan, jenis)
        VALUES ('$judul', $id_tag, '$tanggal' ,$id_author , '$alasan', '$jenis')";
        mysqli_query($conn, $query);
    }
}

function upload()
{

    $namaFile = $_FILES['gambar']['name'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // upload atau ga
    if ($error === 4) {
        echo "<script> alert('upload dulu coy')</script>";
        return false;
    }

    // extention

    $extFileValid = ['jpg', 'jpeg', 'webp', 'png'];
    $extFile = explode('.', $namaFile);
    $extFile = strtolower(end($extFile));
    if (!in_array($extFile, $extFileValid)) {
        echo "<script> alert('upload gagal coy')</script>";
        return false;
    }

    $namaFileBaru = "logo.";
    $namaFileBaru .= $extFile;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}
