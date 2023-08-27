<?php
$conn = mysqli_connect("localhost", "root", "", "rapot");

function querydb($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data) {
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

function tambah_rapot($data){
    global $conn;
    $id_siswa = $data['id_siswa'];
    $bindo = $data['bindo'];
    $sej_islam = $data['sej_islam'];
    $btq = $data['btq'];
    $dt = $data['dt'];
    $query = "INSERT INTO rapot (id_siswa, bindo, sej_islam, btq, tanggal) 
                        VALUES ($id_siswa, '$bindo', '$sej_islam', '$btq', '$dt')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function tambah_siswa($data){
    global $conn;
    $nama = $data['nama'];
    $jk = $data['jk'];
    $nis = $data['nis'];
    $query = "INSERT INTO siswa (nama, nis, jk) VALUES ('$nama', '$nis', '$jk')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function del_siswa($data){
    global $conn;
    $id = $data['id_siswa'];
    $query = "DELETE FROM siswa WHERE id_siswa = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function del_rapot($data){
    global $conn;
    $id = $data['id_rapot'];
    $query = "DELETE FROM rapot WHERE id_rapot = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function edit_siswa($data){
    global $conn;
    $id = $data['id_siswa'];
    $nama = $data['nama'];
    $jk = $data['jk'];
    $nis = $data['nis'];
    // var_dump($data);
    $query = "UPDATE siswa SET nama = '$nama', nis = '$nis', jk = '$jk' WHERE id_siswa = $id;";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function edit_rapot($data){
    global $conn;
    $id_rapot = $data['id_rapot'];
    $id_siswa = $data['id_siswa'];
    $bindo = $data['bindo'];
    $sej_islam = $data['sej_islam'];
    $btq = $data['btq'];
    // var_dump($data);
    $query = "UPDATE rapot SET id_siswa = $id_siswa, bindo = '$bindo', sej_islam = '$sej_islam', btq = '$btq' WHERE id_rapot = $id_rapot;";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function del_artikel($data){
    global $conn;
    $id = $data['id_artikel'];

    $query = "UPDATE artikel SET stat_artikel = 0 WHERE id_artikel = $id";

    mysqli_query($conn, $query);
    log_artikel($data, 2);

    return mysqli_affected_rows($conn);
}
function kop_surat($data){
    global $conn;
    $id = 1;
    $dir_gambar = upload();
    $kop = $data["kop"];
    $query = "UPDATE kop SET kop = '$kop', gambar = '$dir_gambar' WHERE id_kop = $id";
    // var_dump($query);

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
    function log_artikel($data, $type){
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

function upload(){

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


?>