
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalLong">
  PETUNJUK
</button> -->

<!-- Modal -->
<!-- <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Petunjuk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 style="color:black;font-weight:bold;">PASTIKAN SEMUA DATA SUDAH BENAR SEBELUM MEMBUAT RAPOT SISWA</h3>
        <hr style="height:2px;border:none;color:#333;background-color:#333;">
        <h5>1. Data Siswa</h5>
        <p>Berisi Master Data Siswa-Siswa</p>
        <p>Untuk menambahkan data siswa, klik tombol "Tambah Data Siswa" pada halaman Data Siswa. lalu isi data yang dibutuhkan</p>
        <p>Untuk mengedit data siswa, klik tombol "Buka" pada data siswa yang ingin diubah</p>
        <p>Untuk menghapus data siswa, klik tombol "Hapus" pada data siswa yang ingin dihapus</p>
        <hr style="height:2px;border:none;color:#333;background-color:#333;">
        <h5>2. Data Rapot</h5>
        <p>Berisi Data Rapot Siswa</p>
        <p>Untuk menambahkan data rapot, klik tombol "Tambah Data Rapot" pada halaman Data Rapot. lalu isi data yang dibutuhkan</p>
        <p>Untuk mengedit data rapot, klik tombol "Buka" pada data rapot yang ingin diubah</p>
        <p>Untuk mencetak data rapot, klik tombol "Cetak" pada data rapot yang ingin dicetak</p>
        <hr style="height:2px;border:none;color:#333;background-color:#333;">
        <h5>3. Data Guru</h5>
        <p>Berisi Master Data Guru</
        <p>Untuk menambahkan data guru, klik tombol "Tambah Data Guru" pada halaman Data Guru. lalu isi data yang dibutuhkan</p>
        <p>Untuk mengedit data guru, klik tombol "Buka" pada data guru yang ingin diubah, ketika membuka data guru, hanya akan ditampilkan daftar kelas dari guru itu sendiri dan daftar kelas yang belum memiliki guru, maka jika ingin mengganti kelas lain yang sudah memiliki guru, guru dari kelas tersebut harus dihilangkan</p>
        <p>Contoh : Guru A bertanggung jawab atas kelas A, Guru B bertanggung atas kelas B, Guru A ingin diganti ke kelas B, maka Guru B harus dirubah terlebih dahulu ke kelas lain, menjadi kelas C atau kelas X (kelas kosong)</p>
        <p>Untuk menghapus data guru, klik tombol "Hapus" pada data guru yang ingin dihapus</p>
        <hr style="height:2px;border:none;color:#333;background-color:#333;">
      </div>
    </div>
  </div>
</div> -->
    <!-- Sidebar Toggle (Topbar) -->

    <!-- Topbar Search -->

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">



        <!-- Nav Item - Messages -->

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= ucwords($nama) ?></span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <?php if ($_SESSION['role'] == 'su') : ?>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="logout.php">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
                
            <?php else : ?>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="ganti_pw.php">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Ganti Password
                    </a>
                    <a class="dropdown-item" href="logout.php">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            <?php endif; ?>
        </li>

    </ul>

</nav>