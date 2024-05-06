<?php
session_start();
require 'fungsi.php';
if (!isset($_SESSION['login_status'])) {
    header("Location: login.php");
}
$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$id = $_GET['id_kelas'];
$data_kelas = querydb("SELECT * FROM kelas WHERE id_kelas = $id");
$data_mapel = querydb("SELECT * FROM mapel");
$data_ekskul = querydb("SELECT * FROM ekstrakurikuler");
$data_pd = querydb("SELECT * FROM pengembangan_diri");

$cek_data = querydb("SELECT id_mapel FROM kelas_mapel WHERE id_kelas = $id");
$new_data_mapel = array_map(function ($element) {
    return $element['id_mapel'];
}, $cek_data);

$cek_data = querydb("SELECT id_ex FROM kelas_ex WHERE id_kelas = $id");
$new_data_ex = array_map(function ($element) {
    return $element['id_ex'];
}, $cek_data);

$cek_data = querydb("SELECT id_pd FROM kelas_pd WHERE id_kelas = $id");
$new_data_pd = array_map(function ($element) {
    return $element['id_pd'];
}, $cek_data);

// print_r($new_data);
// var_dump($cek_data_mapel);

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    $_POST['id_kelas'] = $id;
    $output = edit_kelas($_POST);
    if ($output > 0) {
        echo "
        <script> 
        alert('Data Kelas berhasil diubah');
        window.location = 'kelas.php';
        </script>
        ";
        // header("Location: siswa.php");
    } else {
        echo "<script> alert('Terdapat kesalahan, Data Kelas gagal diubah')</script>";
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
        input[type="checkbox"] {
            width: 22px;
            height: 22px;
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


                    <form action="" method="post">
                        <?php foreach ($data_kelas as $row) : ?>
                            <label class="col-sm-3 col-form-label">
                                <h2>Nama Firqoh</h2>
                            </label>
                            <input class="form-control col-sm-3" type="text" value="<?= $row['nama_kelas']; ?>" name="nama_kelas">

                        <?php endforeach ?>
                        <br />
                        <h2> Mata Pelajaran untuk Kelas <?= $data_kelas[0]['nama_kelas'] ?> </h2>

                        <?php for ($i = 0; $i < count($data_mapel); $i++) : ?>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox<?= $data_mapel[$i]['nama_mapel'] ?>" value="<?= $data_mapel[$i]['id_mapel'] ?>" name="mapel[]" <?php if (in_array($data_mapel[$i]['id_mapel'], $new_data_mapel)) : ?> checked <?php endif ?>>
                                <label class="form-check-label" for="inlineCheckbox<?= $data_mapel[$i]['nama_mapel'] ?>" style="padding-top: 10px;">
                                    <h4><?= $data_mapel[$i]['nama_mapel'] ?>&nbsp;&nbsp;&nbsp;</h4>
                                </label>
                            </div>
                        <?php endfor ?>
                        <br />
                        <h2> Kegiatan Ekstrakurikuler untuk Kelas <?= $data_kelas[0]['nama_kelas'] ?> </h2>

                        <?php for ($i = 0; $i < count($data_ekskul); $i++) : ?>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox<?= $data_ekskul[$i]['nama_ex'] ?>" value="<?= $data_ekskul[$i]['id_ex'] ?>" name="ex[]" <?php if (in_array($data_ekskul[$i]['id_ex'], $new_data_ex)) : ?> checked <?php endif ?>>
                                <label class="form-check-label" for="inlineCheckbox<?= $data_ekskul[$i]['nama_ex'] ?>" style="padding-top: 10px;">
                                    <h4><?= $data_ekskul[$i]['nama_ex'] ?>&nbsp;&nbsp;&nbsp;</h4>
                                </label>
                            </div>
                        <?php endfor ?>
                        <br />
                        <h2> Pengembangan Diri untuk Kelas <?= $data_kelas[0]['nama_kelas'] ?> </h2>

                        <?php for ($i = 0; $i < count($data_pd); $i++) : ?>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox<?= $data_pd[$i]['nama_pd'] ?>" value="<?= $data_pd[$i]['id_pd'] ?>" name="pd[]" <?php if (in_array($data_pd[$i]['id_pd'], $new_data_pd)) : ?> checked <?php endif ?>>
                                <label class="form-check-label" for="inlineCheckbox<?= $data_pd[$i]['nama_pd'] ?>" style="padding-top: 10px;">
                                    <h4><?= $data_pd[$i]['nama_pd'] ?>&nbsp;&nbsp;&nbsp;</h4>
                                </label>
                            </div>
                        <?php endfor ?>
                        <br />
                        <button class="btn btn-primary btn-user mt-3" type="submit" name="submit">
                            Submit
                        </button>
                    </form>

                    <!-- DataTales Example -->


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