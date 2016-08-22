
<!--navbar-->
<div class="navbar">
    <ul dropdown>
        <li>
            <a href="#" class="collapse-menu">
                <span class="fa fa-bars"></span>
            </a>
        </li>
        <li>
            <a href="index.php">
                <span class="fa fa-home"></span>
                <span class="title">
                    SIPUT
                </span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="fa fa-wpforms"></span>
                <span class="title">Menu</span>
            </a>
            <ul>
                <li>
                    <a href="loket.php">
                        Loket 
                    </a>
                </li>
                <li>
                    <a href="poli-umum.php">
                        Poli Umum
                    </a>
                </li>
                <li>
                    <a href="poli-gigi.php">
                        Poli Gigi
                    </a>
                </li>
                <li>
                    <a href="poli-kia.php">
                        Poli KIA
                    </a>
                </li>
                <li>
                    <a href="apotek.php">
                        Apotek
                    </a>
                </li>
            </ul>
        </li>
        <?php if($_SESSION['pegawai_level'] == 'Admin' || $_SESSION['pegawai_level'] == 'Dokter' || $_SESSION['pegawai_level'] == 'Apoteker'){ ?>
        <li>
            <a href="#">
                <span class="fa fa-plus"></span>
                <span class="title">Tambah</span>
            </a>
            <ul>
               <?php if($_SESSION['pegawai_level'] == 'Admin' || $_SESSION['pegawai_level'] == 'Dokter'){ ?>
                <li>
                    <a href="pasien-baru.php">
                        Pasien Baru
                    </a>
                </li>
                <?php } ?>
                <li>
                    <a href="obat-baru.php">
                        Obat Baru
                    </a>
                </li>
                <?php if($_SESSION['pegawai_level'] == 'Admin'){ ?>
                <li>
                    <a href="pegawai-baru.php">
                        Pegawai Baru
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
    </ul>
    <ul dropdown style="float:right;">
        <li>
            <a href="#">
                <span class="title">
                    <?php echo 'Selamat Datang, '.$_SESSION['pegawai_login'].''; ?>
                </span>
                <span class="fa fa-user"></span>
            </a>
            <ul style="right:0;left:auto;">
                <li>
                    <a href="profil.php">
                        Profile 
                    </a>
                </li>
                <li>
                    <a href="login.php?aksi=logout">
                        Keluar
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>