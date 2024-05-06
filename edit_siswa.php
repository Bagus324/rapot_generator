<?php
session_start();
require 'fungsi.php';
if (!isset($_SESSION['login_status'])) {
    header("Location: login.php");
}
$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$id = $_GET['id'];

$data_siswa = querydb("SELECT * FROM siswa WHERE id_siswa = $id");
$data_kelas = querydb("SELECT * FROM kelas ORDER BY nama_kelas ASC");




if (isset($_POST['submit'])) {
    // var_dump($_POST);
    $_POST['id_siswa'] = $id;
    $output = edit_siswa($_POST);
    if ($output > 0) {
        echo "
        <script> 
        alert('Data Siswa berhasil diubah');
        window.location = 'siswa.php';
        </script>
        ";
        // header("Location: siswa.php");
    } else {
        echo "<script> alert('Terdapat kesalahan, Data Siswa gagal diganti')</script>";
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
        input[type=radio] {
            width: 20px;
            height: 20px;
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
                        <?php foreach ($data_siswa as $row) : ?>
                            <p style="font-size: 20px; font-weight: bold;">Nama Siswa</p>

                            <input class="form-control col-sm-3" type="text" value="<?= $row['nama']; ?>" name="nama"><br />
                            <p style="font-size: 20px; font-weight: bold;">NIS Siswa</p>

                            <input class="form-control col-sm-3" type="text" value="<?= $row['nis']; ?>" name="nis">
                            <br />
                            <p style="font-size: 20px; font-weight: bold;">Jenis Kelamin</p>

                            <?php
                            if ($row['jk'] == "Perempuan") :
                            ?>
                                <input type="radio" name="jk" id="lk" value="Laki - Laki"><b style="font-weight: bold; font-size: 20px; "> Laki - Laki &nbsp;&nbsp;&nbsp;&nbsp;</b>
                                <input type="radio" name="jk" id="pr" value="Perempuan" checked><b style="font-weight: bold; font-size: 20px; "> Perempuan</b></br>

                            <?php else : ?>
                                <input type="radio" name="jk" id="lk" value="Laki - Laki" checked><b style="font-weight: bold; font-size: 20px; "> Laki - Laki &nbsp;&nbsp;&nbsp;&nbsp;</b>
                                <input type="radio" name="jk" id="pr" value="Perempuan"><b style="font-weight: bold; font-size: 20px; "> Perempuan</b></br>
                            <?php endif ?>

                        <?php endforeach ?>
                        <br />
                        <div class="form-group">
                            <p style="font-size: 20px; font-weight: bold;">Firqoh Siswa</p>
                            <select class="form-control col-sm-3" id="id_kelas" name="id_kelas">
                                <?php foreach ($data_kelas as $row) {

                                    echo ($row['id_kelas'] == $data_siswa[0]["id_kelas"]) ? "<option value=" . $row['id_kelas'] . " selected>" . $row['nama_kelas'] . "</option>" : "<option value=" . $row['id_kelas'] . ">" . $row['nama_kelas'] . "</option>";
                                } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <p style="font-size: 20px; font-weight: bold;">Bacaan Siswa</p>
                            <select class="form-control col-sm-3" id="id_kelas" name="bacaan" required>
                                <?php 
                                echo ($data_siswa[0]['bacaan']=='alquran') ? "<option value='iqra'>Iqra</option><option value='alquran' selected>Al-Qur'an</option>" : "<option value='iqra' selected>Iqra</option><option value='alquran'>Al-Qur'an</option>";
                                ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <p style="font-size: 20px; font-weight:bold;">Progress Bacaan Siswa</p>
                            <?php 
                            if (isset($data_siswa[0]['index_bacaan'])){
                                echo("<input type='number' id='progres' name='progres' min='1' class='form-control col-sm-3' value='".$data_siswa[0]['index_bacaan']."' required>");
                            }else{
                                echo("<input type='number' id='progres' name='progres' min='1' class='form-control col-sm-3' value='1' required>");
                            }
                            ?>
                        </div>



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