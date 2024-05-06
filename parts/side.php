<?php

$data_ta = querydb("SELECT * FROM tahun_ajaran ORDER BY id_ta DESC LIMIT 0, 1")[0];
$data_angkatan = querydb("SELECT * FROM angkatan ORDER BY id_angkatan DESC LIMIT 0, 1")[0];
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="siswa.php">
        <div class="sidebar-brand-text mx-3">TPQ AL - MASYHURIYAH</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <!-- Nav Item - Tables -->

    <li class="nav-item active">
        <a class="nav-link" href="siswa.php">
            <i class="fas fa-fw fa-user"></i>
            <span>Data Siswa</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="rapot.php">
            <i class="fas fa-fw fa-address-book"></i>
            <span>Data Rapot</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="guru.php">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>Data Guru</span></a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="mapel.php">
            <i class="fas fa-fw fa-book"></i>
            <span>Data Mata Pelajaran</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="pd.php">
            <i class="fas fa-fw fa-lightbulb"></i>
            <span>Data Pengembangan Diri</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="kelas.php">
            <i class="fas fa-fw fa-home"></i>
            <span>Data Kelas</span></a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="ekskul.php">
            <i class="fas fa-fw fa-star"></i>
            <span>Data Ekstrakurikuler</span></a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="alumni.php">
            <i class="fa fa-database"></i>
            <span>Data Alumni</span></a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="new_acc.php">
            <i class="fas fa-fw fa-lock"></i>
            <span>Buat Akun Baru</span></a>
    </li>

    <!-- <li class="nav-item active">
        <a class="nav-link" href="log.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Log</span></a>
    </li> -->



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" style="margin-bottom:10px;">
    <div class="sidebar-brand" style="padding-top:15px;"><?= $data_ta['nama_ta'];?></div>
    <div class="sidebar-brand" style="padding-top:0px;">Angkatan Ke - <?= $data_angkatan['angkatan'];?></div>
    <hr class="sidebar-divider d-none d-md-block" style="margin-top:-30px;">
    <li class="nav-item active">
        <a class="nav-link" href="tahun_ajaran.php">
            <span><h4><b>Ganti Tahun Ajaran/Semester</b></h4></span></a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->

</ul>
