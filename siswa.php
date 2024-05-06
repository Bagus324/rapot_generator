<?php
session_start();
require 'fungsi.php';
if (!isset($_SESSION['login_status'])) {
    header("Location: masuk.php");
}
$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$id_ta = querydb("SELECT MAX(id_ta) as id_ta FROM tahun_ajaran")[0];
$_SESSION['id_ta'] = $id_ta;
$data_siswa = querydb("SELECT s.id_siswa, s.nama, s.nis, s.bacaan, s.index_bacaan, g.nama_guru, k.nama_kelas FROM siswa s JOIN guru g ON s.id_kelas = g.id_kelas JOIN kelas k ON s.id_kelas = k.id_kelas WHERE s.is_alumni = 0");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Siswa</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">


    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">





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
                    <span style="text-align: right;"><a class="btn btn-primary" href="tambah_siswa.php" style="width:165px;">Tambah Siswa&ensp;<i class="fa fa-user-plus" aria-hidden="true"></i></a></span>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Wali Kelas</th>
                                            <th>NIS</th>
                                            <th>Progres Bacaan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data_siswa as $row) : ?>
                                            <tr>
                                                <td><?= $row['nama'] ?></td>
                                                <td><?= $row['nama_kelas'] ?></td>
                                                <td><?= $row['nama_guru'] ?></td>
                                                <td><?= $row['nis'] ?></td>
                                                <?php if ($row['bacaan']=='iqra') {
                                                    echo("<td>Iqra Jilid ".$row['index_bacaan']."</td>");
                                                } elseif ($row['bacaan']=='alquran') {
                                                    echo("<td>Al-Qur'an Juz ".$row['index_bacaan']."</td>");
                                                } else {
                                                    echo("<td>Belum Ada Progres</td>");
                                                } ?>
                                                <td>
                                                    <a class="btn btn-primary" href="edit_siswa.php?id=<?= $row['id_siswa']; ?>">Buka&ensp;<i class="fa fa-window-maximize" aria-hidden="true"></i></a>
                                                    <a class="btn btn-danger" href="del_siswa.php?id=<?= $row['id_siswa']; ?>">Hapus&ensp;<i class="fa fa-trash" aria-hidden="true"></i></a>
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
<script src="js/demo/datatables-siswa.js"></script>

</html>