<?php $page = basename($_SERVER['SCRIPT_NAME']); ?>

<!--sidebar-->
<div class="sidebar">

    <ul>
        <li <?php if ($page == 'index.php' || $page == 'pengumuman.php') { ?>class="active"<?php } ?>>
            <a href="#">
                <span class="fa fa-tachometer"></span>
                <span class="title">
                    Dasbor
                </span>
            </a>
            <ul class="sub-menu">
                <li <?php if ($page == 'index.php') { ?>class="active"<?php } ?>>
                    <a href="index.php">
                        Beranda
                    </a>
                </li>
                <li <?php if ($page == 'pengumuman.php') { ?>class="active"<?php } ?>>
                    <a href="pengumuman.php">
                        Pengumuman
                    </a>
                </li>
            </ul>
        </li>
        <li class="line">
            <span></span>
        </li>
        <li <?php if ($page == 'loket.php') { ?>class="active"<?php } ?>>
            <a href="loket.php">
                <span class="fa fa-wpforms"></span>
                <span class="title">
                    Loket 
                </span>
            </a>
        </li>
        <li <?php if ($page == 'poli-umum.php') { ?>class="active"<?php } ?>>
            <a href="poli-umum.php">
                <span class="fa fa-stethoscope"></span>
                <span class="title">
                    <?php $hitung_poliumum = mysql_fetch_array(mysql_query("SELECT COUNT(pasien_id) AS jumData FROM pasien WHERE pasien_stage = 'Poli Umum'")); ?>     
                    Poli Umum <span class="pending-count"><?php echo $hitung_poliumum['jumData']; ?></span>
                </span>
            </a>
        </li>
        <li <?php if ($page == 'poli-gigi.php') { ?>class="active"<?php } ?>>
            <a href="poli-gigi.php">
                <span class="fa fa-twitch"></span>
                <span class="title">
                    <?php $hitung_poligigi = mysql_fetch_array(mysql_query("SELECT COUNT(pasien_id) AS jumData FROM pasien WHERE pasien_stage = 'Poli Gigi'")); ?>     
                    Poli Gigi <span class="pending-count"><?php echo $hitung_poligigi['jumData']; ?></span>
                </span>
            </a>
        </li>
        <li <?php if ($page == 'poli-kia.php') { ?>class="active"<?php } ?>>
            <a href="poli-kia.php">
                <span class="fa fa-odnoklassniki"></span>
                <span class="title">
                    <?php $hitung_polikia = mysql_fetch_array(mysql_query("SELECT COUNT(pasien_id) AS jumData FROM pasien WHERE pasien_stage = 'Poli KIA'")); ?>     
                    Poli KIA <span class="pending-count"><?php echo $hitung_polikia['jumData']; ?></span>
                </span>
            </a>
        </li>
        <li <?php if ($page == 'apotek.php') { ?>class="active"<?php } ?>>
            <a href="apotek.php">
                <span class="fa fa-foursquare"></span>
                <span class="title">
                    <?php $hitung_apotek = mysql_fetch_array(mysql_query("SELECT COUNT(pasien_id) AS jumData FROM pasien WHERE pasien_stage = 'Apotek'")); ?>     
                    Apotek <span class="pending-count"><?php echo $hitung_apotek['jumData']; ?></span> 
                </span>
            </a>
        </li>
        <li class="line">
            <span></span>
        </li>
        <?php if($_SESSION['pegawai_level'] == 'Admin' || $_SESSION['pegawai_level'] == 'Dokter' || $_SESSION['pegawai_level'] == 'Resepsionis'){ ?>
        <li <?php if ($page == 'pasien.php' || $page == 'pasien-baru.php' || $page == 'kunjungan.php') { ?>class="active"<?php } ?>>
            <a href="#">
                <span class="fa fa-users"></span>
                <span class="title">
                    Pasien
                </span>
            </a>
            <ul class="sub-menu">
                <li <?php if ($page == 'pasien.php') { ?>class="active"<?php } ?>>
                    <a href="pasien.php">
                        Semua Pasien
                    </a>
                </li>
                <li <?php if ($page == 'pasien-baru.php') { ?>class="active"<?php } ?>>
                    <a href="pasien-baru.php">
                        Tambah Pasien
                    </a>
                </li>
                <li <?php if ($page == 'kunjungan.php') { ?>class="active"<?php } ?>>
                    <a href="kunjungan.php">
                        Kunjungan
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <?php if($_SESSION['pegawai_level'] == 'Admin' || $_SESSION['pegawai_level'] == 'Dokter' || $_SESSION['pegawai_level'] == 'Apoteker'){ ?>
        <li <?php if ($page == 'obat.php' || $page == 'obat-baru.php') { ?>class="active"<?php } ?>>
            <a href="#">
                <span class="fa fa-medkit"></span>
                <span class="title">
                    Obat
                </span>
            </a>
            <ul class="sub-menu">
                <li <?php if ($page == 'obat.php') { ?>class="active"<?php } ?>>
                    <a href="obat.php">
                        Semua Obat
                    </a>
                </li>
                <li <?php if ($page == 'obat-baru.php') { ?>class="active"<?php } ?>>
                    <a href="obat-baru.php">
                        Tambah Obat
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <li <?php if ($page == 'pegawai.php' || $page == 'pegawai-baru.php' || $page == 'profil.php') { ?>class="active"<?php } ?>>
            <a href="#">
                <span class="fa fa-user-md"></span>
                <span class="title">
                    Pegawai
                </span>
            </a>
            <ul class="sub-menu">
                <?php if($_SESSION['pegawai_level'] == 'Admin'){ ?>
                <li <?php if ($page == 'pegawai.php') { ?>class="active"<?php } ?>>
                    <a href="pegawai.php">
                        Semua Pegawai
                    </a>
                </li>
                <li <?php if ($page == 'pegawai-baru.php') { ?>class="active"<?php } ?>>
                    <a href="pegawai-baru.php">
                        Tambah Pegawai
                    </a>
                </li>
                <?php } ?>
                <li <?php if ($page == 'profil.php') { ?>class="active"<?php } ?>>
                    <a href="profil.php">
                        Profil Kamu
                    </a>
                </li>
            </ul>
        </li>
        <?php if($_SESSION['pegawai_level'] == 'Admin'){ ?>
        <li <?php if ($page == 'laporan.php') { ?>class="active"<?php } ?>>
            <a href="laporan.php">
                <span class="fa fa-wrench"></span>
                <span class="title">
                    Laporan
                </span>
            </a>
        </li>
        <li <?php if ($page == 'pengaturan.php' || $page == 'master-data.php') { ?>class="active"<?php } ?>>
            <a href="#">
                <span class="fa fa-cog"></span>
                <span class="title">
                    Pengaturan
                </span>
            </a>
            <ul class="sub-menu">
                <li <?php if ($page == 'pengaturan.php') { ?>class="active"<?php } ?>>
                    <a href="pengaturan.php">
                        Umum
                    </a>
                </li>
                <li <?php if ($page == 'master-data.php') { ?>class="active"<?php } ?>>
                    <a href="master-data.php">
                        Master Data
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>
    </ul>

</div>
