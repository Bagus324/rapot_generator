<?php
session_start();
require 'fungsi.php';
if (!isset($_SESSION['login_status'])) {
    header("Location: login.php");
}
$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$id = $_GET['id_guru'];
$data_kelas = querydb("SELECT * FROM kelas");
$data_guru = querydb("SELECT *, k.nama_kelas FROM guru g JOIN kelas k ON g.id_kelas = k.id_kelas WHERE g.id_guru = $id");
$cek_data = querydb("SELECT id_kelas FROM guru");
$new_data_kelas = array_map(function ($element) {
    return $element['id_kelas'];
}, $cek_data);

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    $_POST['id_guru'] = $id;
    $output = edit_guru($_POST);
    if ($output > 0) {
        echo "
        <script> 
        alert('Data Guru berhasil diubah');
        window.location = 'guru.php';
        </script>
        ";
        // header("Location: siswa.php");
    } else {
        echo "<script> alert('Terdapat kesalahan, Data Guru gagal diubah')</script>";
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
                        <?php foreach ($data_guru as $row) : ?>
                            <p style="font-size: 20px;font-weight:bold;">Nama Guru</p>

                            <input class="form-control col-sm-3" type="text" value="<?= $row['nama_guru']; ?>" name="nama_guru"><br/>

                        <?php endforeach ?>
                        <p style="font-size: 20px; font-weight: bold;">Firqoh Siswa</p>

                        <select id="id_kelas" name="id_kelas" class="form-control col-sm-3">

                            <?php foreach ($data_kelas as $row) {
                                if ($row['id_kelas'] == $data_guru[0]["id_kelas"]) {
                                    echo "<option value=" . $row['id_kelas'] . " selected>" . $row['nama_kelas'] . "</option>";
                                }elseif (!in_array($row['id_kelas'], $new_data_kelas)) {
                                    echo "<option value=" . $row['id_kelas'] . ">" . $row['nama_kelas'] . "</option>";
                                }
                            } ?>
                        </select>
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