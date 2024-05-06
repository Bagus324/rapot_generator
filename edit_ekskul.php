<?php
session_start();
require 'fungsi.php';
if (!isset($_SESSION['login_status'])) {
    header("Location: login.php");
}
$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$id = $_GET['ex'];
$data_ex = querydb("SELECT * FROM ekstrakurikuler WHERE id_ex = $id");
$data_param = querydb("SELECT * FROM param_penilaian");
$cek_data = querydb("SELECT id_param FROM ex_pp WHERE id_ex = $id");
$new_data_param = array_map(function ($element) {
    return $element['id_param'];
}, $cek_data);


// print_r($new_data);
// var_dump($cek_data_mapel);

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    $_POST['id_ex'] = $id;
    $output = edit_param($_POST);
    if ($output > 0) {
        echo "
        <script> 
        alert('Data Ekstrakurikuler berhasil diubah');
        window.location = 'ekskul.php';
        </script>
        ";
        // header("Location: siswa.php");
    } else {
        echo "<script> alert('Terdapat kesalahan, Data Ekstrakurikuler gagal diubah')</script>";
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
                        <?php foreach ($data_ex as $row) : ?>
                            <p style="font-size: 35px;font-weight:bold;">Nama Ekstrakurikuler</p>

                            <input class="form-control col-sm-3" type="text" value="<?= $row['nama_ex']; ?>" name="nama_ex">

                        <?php endforeach ?>
                        <br />
                        <h2><b> Parameter Nilai untuk Ekstrakurikuler <?= $data_ex[0]['nama_ex'] ?></b> </h2>

                        <?php for ($i = 0; $i < count($data_param); $i++) : ?>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox<?= $data_param[$i]['nama_param'] ?>" value="<?= $data_param[$i]['id_param'] ?>" name="param[]" <?php if (in_array($data_param[$i]['id_param'], $new_data_param)) : ?> checked <?php endif ?>>
                                <label class="form-check-label" for="inlineCheckbox<?= $data_param[$i]['nama_param'] ?>" style="padding-top: 10px;">
                                    <h4><?= $data_param[$i]['nama_param'] ?>&nbsp;&nbsp;&nbsp;</h4>
                                </label>
                            </div>
                        <?php endfor ?>
                        <br/>
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