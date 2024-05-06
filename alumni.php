<?php
session_start();
require 'fungsi.php';
if (!isset($_SESSION['login_status'])) {
    header("Location: login.php");
}
$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$data_alumni = querydb("SELECT s.id_siswa, s.nama, s.nis, k.nama_kelas, a.angkatan, ta.nama_ta FROM alumni al JOIN siswa s ON al.id_siswa = s.id_siswa JOIN angkatan a ON al.id_angkatan = a.id_angkatan JOIN tahun_ajaran ta ON al.id_ta = ta.id_ta JOIN kelas k ON al.id_kelas = k.id_kelas");


?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php
include 'parts/head.php';
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
                            
                    
                    

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                    <span style="text-align: right;"><a class="btn btn-primary" href="list_unalumni.php" style="width:165px;">Tambah Data Alumni&nbsp;<i class="fa fa-plus-square" aria-hidden="true"></i></a> <a class="btn btn-primary" href="edit_angkatan.php" style="width:165px;height:62px;padding-top:18px;">Edit Angkatan&nbsp;<i class="fa fa-link" aria-hidden="true"></i></a></span>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama Ekstrakurikuler</th>
                                            <th>Angkatan Ke</th>
                                            <th>Pada Semester</th>
                                            <th>NIS</th>
                                            <th>Kelas Terakhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data_alumni as $row) : ?>
                                        <tr>
                                            <td><?= $row['nama'] ?></td>
                                            <td><?= $row['angkatan'] ?></td>
                                            <td><?= $row['nama_ta'] ?></td>
                                            <td><?= $row['nis'] ?></td>
                                            <td><?= $row['nama_kelas'] ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/datatables-alumni.js"></script>

</html>