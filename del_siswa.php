<?php
session_start();
require 'fungsi.php';
if (!isset($_SESSION['login_status'])) {
    header("Location: login.php");
}
$id = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$id = $_GET['id'];

$data_siswa = querydb("SELECT * FROM siswa WHERE id_siswa = $id");

if (isset($_POST['submit'])) {

    $output = del_siswa($_POST);
    if ($output > 0) {
        echo "
        <script> 
        alert('Data Siswa berhasil dihapus');
        window.location = 'siswa.php';
        </script>
        ";
        // header("Location: siswa.php");
    } else {
        echo "<script> alert('Terdapat kesalahan, Data Siswa gagal dihapus')</script>";
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
                        <?php foreach ($data_siswa as $row ):?>
                        <label class="col-sm-2 col-form-label">ID Siswa</label>
                        <input class="form-control" type="text" value="<?= $row['id_siswa']; ?>" name="id_siswa" readonly>
                        <label class="col-sm-2 col-form-label">Nama Siswa</label>
                        <input class="form-control" type="text" value="<?= $row['nama']; ?>" name="nama" readonly>
                        <label class="col-sm-2 col-form-label">NIS Siswa</label>
                        <input class="form-control" type="text" value="<?= $row['nis']; ?>" name="nis" readonly>
                        <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <input class="form-control" type="text" value="<?= $row['jk']; ?>" name="jk" readonly>
                        <?php endforeach ?>
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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