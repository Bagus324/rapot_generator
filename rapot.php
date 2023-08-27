<?php
session_start();
require 'fungsi.php';
if (!isset($_SESSION['login_status'])) {
    header("Location: login.php");
}
$id = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$data_rapot = querydb("SELECT r.id_rapot, r.id_siswa, s.nama, r.tanggal FROM rapot AS r JOIN siswa AS s ON r.id_siswa = s.id_siswa");

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
                            
                    
                    

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Rapot Siswa</th>
                                            <th>Tanggal Rapot dibuat</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data_rapot as $row) : ?>
                                        <tr>
                                            <td><?= $row['nama'] ?></td>
                                            <td><?= $row['tanggal'] ?></td>
                                            <td>
                                                <a class="btn btn-primary"href="edit_rapot.php?id=<?= $row['id_rapot']; ?>&siswa=<?= $row['id_siswa']; ?>">Open&ensp;<i class="fa fa-window-maximize" aria-hidden="true"></i></a>
                                                <a class="btn btn-danger" href="del_rapot.php?id=<?= $row['id_rapot']; ?>&siswa=<?= $row['id_siswa']; ?>">Delete&ensp;<i class="fa fa-trash" aria-hidden="true"></i></a>
                                                <a class="btn btn-primary"href="print.php?id=<?= $row['id_rapot']; ?>&siswa=<?= $row['id_siswa']; ?>" target="_blank">Preview&ensp;<i class="fa fa-window-maximize" aria-hidden="true"></i></a>
                                            </td>
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

</html>