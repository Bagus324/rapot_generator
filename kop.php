<?php
session_start();
require 'fungsi.php';
if (!isset($_SESSION['login_status'])) {
    header("Location: login.php");
}
$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];

if (isset($_POST['submit'])) {
        $output = kop_surat($_POST);

        if ($output > 0) {
            echo "<script> alert('KOP Surat berhasil dirubah')</script>";
        } else {
            echo "<script> alert('KOP Surat gagal dirubah')</script>";
        }
}
$id_kop = 1;
$kop = querydb("SELECT * FROM kop WHERE id_kop = $id_kop")[0];
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

                <div class="marker" style="float:left;padding-left:50px;">
                    <div class="logo" style="float:left;" ><img src="img/<?= $kop['gambar']; ?>" class="gambar_kop" width="150px"> </div>
                    <div class="kop" style="float:left;padding-left:50px;text-align:center;padding-top:50px;"> <b style="text-transform: uppercase;"><?= $kop['kop']; ?></b></div>

                </div>
</br>
</br>
</br>
                <div class="container-fluid">

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <textarea type="text" class="form-control form-control-user" id="kop" name="kop"></textarea>
                    </div>
                    <div class="form-group">
                    <input type="file" accept="image/*" name="gambar" id="gambar">
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