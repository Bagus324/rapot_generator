<?php
session_start();
require 'fungsi.php';
if (!isset($_SESSION['login_status'])) {
    header("Location: masuk.php");
}
$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$data_rapot = querydb("SELECT * FROM rapot WHERE id_rapot = " . $_GET['id_rapot']);
$data_rapot_2 = querydb("SELECT sakit, izin, tanpa_ket, catatan FROM rapot WHERE id_rapot = " . $_GET['id_rapot']);
$data_siswa = querydb("SELECT s.id_siswa, s.nama, s.bacaan, s.index_bacaan, s.nilai_bacaan, k.nama_kelas FROM siswa s JOIN kelas k ON s.id_kelas = k.id_kelas WHERE s.id_siswa = " . $data_rapot[0]['id_siswa'])[0];
$nilai_mapel = querydb("SELECT nm.*, m.nama_mapel FROM nilai_mapel nm JOIN mapel m ON m.id_mapel = nm.id_mapel WHERE id_rapot = " . $_GET['id_rapot']);
$nilai_pd = querydb("SELECT npd.*, pd.nama_pd FROM nilai_pd npd JOIN pengembangan_diri pd ON pd.id_pd = npd.id_pd WHERE id_rapot = " . $_GET['id_rapot']);
$data_ex = querydb("SELECT kex.id_ex, ex.nama_ex FROM kelas_ex kex JOIN ekstrakurikuler ex ON kex.id_ex = ex.id_ex WHERE id_kelas = (SELECT id_kelas FROM siswa WHERE id_siswa = " . $data_rapot[0]['id_siswa'] . ")");
$nilai_bacaan = (explode("|",$data_siswa['nilai_bacaan']));
$progres_bacaan = $data_siswa['bacaan']=='alquran'?"Al-Qur'an Juz ".$data_siswa['index_bacaan']:"Iqra' Jilid ".$data_siswa['index_bacaan'];

// print_r($nilai_mapel);
if (isset($_POST['submit'])) {
    $_POST['id_rapot'] = $_GET['id_rapot'];
    $output = edit_rapot($_POST);

    if ($output > 0) {
        echo "
        <script> 
        alert('Data rapot berhasil diubah');
        window.location = 'rapot.php';
        </script>
        ";
    } else {
        echo "<script> alert('Data rapot gagal diubah')</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'parts/head.php';
    include 'parts/bs.php';
    ?>

    <style>
        .marker {
            /* padding : 1%; */
            /* color: white; */
            /* background-color: 009900; */
            width: 100%;
            /* border: solid black; */
        }

        .logo {
            /* padding : 1%; */
            /* color: white; */
            /* background-color: 009900; */
            width: 15%;
            /* border: solid black; */
        }

        .kop {
            /* padding : 1%; */
            /* color: white; */
            /* background-color: 009900; */
            width: 70%;
            /* border: solid black; */
        }

        input[type=radio] {
            width: 25px;
            height: 25px;
        }
    </style>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        include 'parts/side.php'
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include 'parts/top.php'
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <!-- Page Heading -->

                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <h1 class="h3 mb-1 text-gray-800">Nama Siswa : <?= ucwords($data_siswa['nama']) ?></h1>
                        </div>
                        <div class="col">
                            <h1 class="h3 mb-1 text-gray-800">Firqoh : <?= ucwords($data_siswa['nama_kelas']) ?></h1>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col">
                            <h1 class="h1 mb-1 text-gray-800"><b>Mata Pelajaran</b></h1>
                        </div>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <?php 
                        if (!isset($data_siswa['bacaan'])||!isset($data_siswa['index_bacaan'])) {
                            echo ('
                            <h3 class="h3 mb-1 text-gray-800"><b>Belum ada Progres Bacaan</b></h3>
                            <hr style="height:2px;border:none;color:#333;background-color:#333;">
                            ');
                        } else {
                            echo('
                            <div class="row">
                            <div class="col">
                                <br />
                                <h1 class="h3 mb-1 text-gray-800"><b>'.$progres_bacaan.'</b></h1>
                                <h3 class="h3 mb-1 text-gray-800"><b>Nilai Tulis</b></h3>
                                <input class="form-control" type="text" value="'.$nilai_bacaan[0].'" name="bacaan_tulis" style="width: 500px;display:flex;">
                            </div>
                            <div class="col">
                                <h1 class="h3 mb-1 text-gray-800" style="margin-top:60px;"><b>Nilai Lisan</b></h1>
                                <input class="form-control form-control-user" type="text" value="'.$nilai_bacaan[1].'" name="bacaan_praktek" style="width: 500px;display:flex;">
                            </div>
                        </div>
                        <hr style="height:2px;border:none;color:#333;background-color:#333;">
                            ');
                        }
                        ?>

                        <?php foreach ($nilai_mapel as $row) : ?>
                            <div class="row">
                                <div class="col">
                                    <br />
                                    <h1 class="h3 mb-1 text-gray-800"><b><?= $row['nama_mapel']; ?></b></h1>
                                    <h3 class="h3 mb-1 text-gray-800"><b>Nilai Tulis</b></h3>
                                    <input class="form-control" type="text" value="<?= $row['tulis']; ?>" name="mapel_tulis[<?= $row['id_mapel']; ?>]" style="width: 500px;display:flex;">
                                </div>
                                <div class="col">
                                    <h1 class="h3 mb-1 text-gray-800" style="margin-top:60px;"><b>Nilai Lisan</b></h1>
                                    <input class="form-control form-control-user" type="text" value="<?= $row['praktek']; ?>" name="mapel_praktek[<?= $row['id_mapel']; ?>]" style="width: 500px;display:flex;">
                                </div>
                            </div>
                            <hr style="height:2px;border:none;color:#333;background-color:#333;">
                        <?php endforeach ?>
                        <h1 class="h1 mb-1 text-gray-800"><b>Ekstrakurikuler</b></h1>
                        <?php foreach ($data_ex as $row) : ?>
                            <h1 class="h1 mb-1 text-gray-800"><b><?= $row['nama_ex'] ?></b></h1>
                            <?php
                            $query_select_pp = "SELECT nex.id_pp, pp.nama_param, nex.indeks FROM nilai_ex nex JOIN param_penilaian pp ON nex.id_pp = pp.id_param WHERE id_ex = " . $row['id_ex'] . " AND id_rapot = " . $_GET['id_rapot'] . ";";
                            $data_temp = mysqli_query($conn, $query_select_pp);
                            $rows_temp = [];
                            while ($row_temp = mysqli_fetch_assoc($data_temp)) {
                                $rows_temp[] = $row_temp;
                            }
                            ?>
                            <?php foreach ($rows_temp as $row_pp) : ?>
                                <div class="row_pp" style="margin-left:1px;">
                                    <h1 class="h3 mb-1 text-gray-800"><b><?= $row_pp['nama_param'] ?></b></h1>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="indeks_pp[<?= $row['id_ex'] ?>][<?= $row_pp['id_pp'] ?>]" id="ex<?= $row_pp['id_pp'] ?>A" value="a" <?php if ($row_pp['indeks'] === "a") : ?> checked <?php endif ?> required>
                                        <label class="form-check-label text-gray-800" style="font-weight: bold; font-size: 25px; " for="ex<?= $row_pp['id_pp'] ?>A">
                                            A
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="indeks_pp[<?= $row['id_ex'] ?>][<?= $row_pp['id_pp'] ?>]" id="ex<?= $row_pp['id_pp'] ?>B" value="b" <?php if ($row_pp['indeks'] === "b") : ?> checked <?php endif ?> required>
                                        <label class="form-check-label text-gray-800" style="font-weight: bold; font-size: 25px; " for="ex<?= $row_pp['id_pp'] ?>B">
                                            B
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="indeks_pp[<?= $row['id_ex'] ?>][<?= $row_pp['id_pp'] ?>]" id="ex<?= $row_pp['id_pp'] ?>C" value="c" <?php if ($row_pp['indeks'] === "c") : ?> checked <?php endif ?> required>
                                        <label class="form-check-label text-gray-800" style="font-weight: bold; font-size: 25px; " for="ex<?= $row_pp['id_pp'] ?>C">
                                            C
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="indeks_pp[<?= $row['id_ex'] ?>][<?= $row_pp['id_pp'] ?>]" id="ex<?= $row_pp['id_pp'] ?>D" value="d" <?php if ($row_pp['indeks'] === "d") : ?> checked <?php endif ?> required>
                                        <label class="form-check-label text-gray-800" style="font-weight: bold; font-size: 25px; " for="ex<?= $row_pp['id_pp'] ?>D">
                                            D
                                        </label>
                                    </div>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            <hr style="height:2px;border:none;color:#333;background-color:#333;">

                            <h1 class="h1 mb-1 text-gray-800"><b>Pengembangan Diri</b></h1>
                            <?php for ($i = 0; $i < count($nilai_pd); $i++) : ?>
                                <div class="row" style="margin-left:-11px;">
                                    <div class="col">
                                        <h1 class="h3 mb-1 text-gray-800"><b><?= $nilai_pd[$i]['nama_pd'] ?></b></h1>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="indeks_pd[<?= $nilai_pd[$i]['id_pd'] ?>]" id="flexRadioDefault<?= $nilai_pd[$i]['nama_pd'] ?>A" value="a" <?php if ($nilai_pd[$i]['indeks'] === "a") : ?> checked <?php endif ?> required>
                                            <label class="form-check-label text-gray-800" style="font-weight: bold; font-size: 25px; " for="flexRadioDefault<?= $nilai_pd[$i]['nama_pd'] ?>A">
                                                A
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="indeks_pd[<?= $nilai_pd[$i]['id_pd'] ?>]" id="flexRadioDefault<?= $nilai_pd[$i]['nama_pd'] ?>B" value="b" <?php if ($nilai_pd[$i]['indeks'] === "b") : ?> checked <?php endif ?> required>
                                            <label class="form-check-label text-gray-800" style="font-weight: bold; font-size: 25px; " for="flexRadioDefault<?= $nilai_pd[$i]['nama_pd'] ?>B">
                                                B
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="indeks_pd[<?= $nilai_pd[$i]['id_pd'] ?>]" id="flexRadioDefault<?= $nilai_pd[$i]['nama_pd'] ?>C" value="c" <?php if ($nilai_pd[$i]['indeks'] === "c") : ?> checked <?php endif ?> required>
                                            <label class="form-check-label text-gray-800" style="font-weight: bold; font-size: 25px; " for="flexRadioDefault<?= $nilai_pd[$i]['nama_pd'] ?>C">
                                                C
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="indeks_pd[<?= $nilai_pd[$i]['id_pd'] ?>]" id="flexRadioDefault<?= $nilai_pd[$i]['nama_pd'] ?>D" value="d" <?php if ($nilai_pd[$i]['indeks'] === "d") : ?> checked <?php endif ?> required>
                                            <label class="form-check-label text-gray-800" style="font-weight: bold; font-size: 25px; " for="flexRadioDefault<?= $nilai_pd[$i]['nama_pd'] ?>D">
                                                D
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            <?php endfor ?>
                            <hr style="height:2px;border:none;color:#333;background-color:#333;">


                            <div class="row">
                                <div class="col">
                                    <h1 class="h2 mb-1 text-gray-800"><b>Keterangan / Kehadiran</b></h1>
                                    <?php foreach ($data_rapot_2[0] as $key => $value) : ?>
                                        <h3 class="h3 mb-1 text-gray-800"><b><?= ucwords($key); ?></b></h3>
                                        <input class="form-control" type="text" value="<?= $value; ?>" name="ket[<?= $key; ?>]" style="width: 500px;display:flex;">
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <input class="btn btn-primary btn-user mt-3" type="submit" name="submit">

                    </form>
                </div>






            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">

                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>