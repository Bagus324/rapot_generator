<?php
session_start();
require 'fungsi.php';
if (!isset($_SESSION['login_status'])) {
    header("Location: login.php");
}
$id = $_SESSION['id_user'];
$nama = $_SESSION['nama'];

$data_siswa = querydb("SELECT * FROM siswa ORDER BY nama ASC");

if (isset($_POST['submit'])) {
    $_POST["dt"] = date('d-F-Y');
    // var_dump($_POST);
        $output = tambah_rapot($_POST);

        if ($output > 0) {
            echo "<script> alert('Data rapot berhasil ditambah')</script>";
        } else {
            echo "<script> alert('Data rapot gagal ditambah')</script>";
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
                        <p style="font-size: 20px; font-weight:bold;">Pilih Siswa</p>
                        <select id="id_siswa" name="id_siswa">
                            <?php foreach ($data_siswa as $row) : ?>
                                    <option value="<?= $row['id_siswa']; ?>"><?= ucfirst($row['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <p style="font-size: 20px;font-weight:bold;">Nilai Bahasa Indonesia</p>
                        <input type="text" class="form-control form-control-user" id="nis" name="bindo" style="width: 500px;" required></input>
                    </div>
                    <div class="form-group">
                        <p style="font-size: 20px;font-weight:bold;">Nilai Sejarah Islam</p>
                        <input type="text" class="form-control form-control-user" id="nis" name="sej_islam" style="width: 500px;" required></input>
                    </div>
                    <div class="form-group">
                        <p style="font-size: 20px;font-weight:bold;">Nilai Baca-Tulis Al-Qur'an</p>
                        <input type="text" class="form-control form-control-user" id="nis" name="btq" style="width: 500px;" required></input>
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