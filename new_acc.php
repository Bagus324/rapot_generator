<?php
session_start();
require 'fungsi.php';
if (!isset($_SESSION['login_status'])) {
    header("Location: login.php");
}
$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$validifier = querydb("SELECT * FROM user WHERE role = 'su'")[0];
if (isset($_POST['submit'])) {
    // var_dump($_POST);
    if ($_POST['pw_admin'] == $validifier['password']) {
        $output = tambah_acc($_POST);

        if ($output > 0) {
            echo "<script> alert('Berhasil menambah akun baru')
            window.location = 'siswa.php';
            </script>";
        } else {
            echo "<script> alert('Gagal menambah akun baru')</script>";
        }
    } else {
        echo "<script> alert('Password Admin Salah')</script>";
    }
}
$data_kelas = querydb("SELECT * FROM kelas");
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php
include 'parts/head.php';
include 'parts/bs.php';
?>

<style>
    .marker{
         /* padding : 1%; */
         /* color: white; */
         /* background-color: 009900; */
         width: 100%;
         /* border: solid black; */
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

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <p style="font-size: 20px; font-weight:bold;">Nama Akun</p>
                        <input type="text" class="form-control form-control-user" id="nama" name="nama_akun" style="width: 500px;" required></input>
                    </div>
                    <div class="form-group">
                        <p style="font-size: 20px; font-weight:bold;">Username</p>
                        <input type="text" class="form-control form-control-user" id="nama" name="username" style="width: 500px;" required></input>
                    </div>
                    <div class="form-group">
                        <p style="font-size: 20px; font-weight:bold;">Password</p>
                        <input type="text" class="form-control form-control-user" id="nama" name="pw" style="width: 500px;" required></input>
                    </div>
                    <div class="form-group">
                        <p style="font-size: 20px; font-weight:bold;">Password Admin</p>
                        <input type="password" class="form-control form-control-user" id="nama" name="pw_admin" style="width: 500px;" required></input>
                    </div>
                    <div class="form-group">
                        
                        <input class="btn btn-primary btn-user mt-3" type="submit" name="submit">
                    </div>

                </form>
                
                    


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