<?php include('inc/header.php'); ?>
<?php 
    if(!$_SESSION['pegawai_login']){
      header("Location: login.php");
    }
?>
<?php include('inc/navbar.php'); ?>
<?php include('inc/sidebar.php'); ?>

  <?php
  //tambah

    $today="P".date("Ym");
    $pasien_number = mysql_query("select max(pasien_number) from pasien");
    $get_number = mysql_fetch_array($pasien_number);
    $lastNumber = substr($get_number[0], 8, 4);
    $nextNumber = $lastNumber + 1;
    $nextRegNumber = $today.sprintf('%04s', $nextNumber);

    if($_POST['tambah-pasien']){

      $pegawai    = $_SESSION['pegawai_login'];
      $date       = date('Y-m-d H:i:s');
      $number     = $nextRegNumber;
      $name       = $_POST['name'];
      $sex        = $_POST['sex'];
      $birthdate  = $_POST['birthdate'];
      $address    = $_POST['address'];
      $rt         = $_POST['rt'];
      $rw         = $_POST['rw'];
      $desa       = $_POST['desa'];
      $phone      = $_POST['phone'];
      $occupation = $_POST['occupation'];
      $religion   = $_POST['religion'];
      $stage      = $_POST['stage'];

      if($name && $address){
        $insert = mysql_query("INSERT INTO pasien VALUES(NULL, '$pegawai', '$date', '$date', '$number', '$name', '$sex', '$birthdate', '$address', '$rt', '$rw', '$desa', '$phone', '$occupation', '$religion', '$stage')");

        if($insert){
          echo '<script language="javascript">alert("Pasien berhasil ditambahkan."); document.location="'.$_SERVER['PHP_SELF'].'";</script>';

        }else{
          echo 'ERROR: Gagal menambahkan pasien.';
        }

      }else{
        echo 'ERROR: Masukkan nama dan alamat pasien.';
      }
    }

?>

<!--content-->
<div class="content">

    <div class="box-">
        <h1>Pasien Baru &raquo; <strong><?php echo $nextRegNumber; ?></strong></h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <form method="post" action="" class="form">
    <div class="box-container post-content">
        <div class="box-">

                <ul>
                    <li>
                        <input type="text" name="name" class="big" placeholder="Nama Lengkap dan Gelar">
                    </li>
                    <li>
                        <textarea name="address" id="address" rows="5" cols="40" placeholder="Alamat Lengkap"></textarea>
                    </li>
                    <li>
                        <input type="text" name="rt" class="big" style="display:inline;width:40%;"  placeholder="RT"> / <input type="text" name="rw" class="big" style="display:inline;width:40%;"  placeholder="RW">
                    </li>
                    <li>
                    <?php
                    $query_nama_desa = mysql_query("SELECT desa_nama FROM desa");
                    if(mysql_num_rows($query_nama_desa)) {
                        $select_nama_desa = '<select name="desa" class="big">';
                        $select_nama_desa .='<option value="">Pilih Desa/Kelurahan</option>';
                        while($nama_desa = mysql_fetch_array($query_nama_desa)) { 
                            $select_nama_desa .='<option value="'.$nama_desa['desa_nama'].'">'.$nama_desa['desa_nama'].'</option>';
                        }
                        $select_nama_desa .='</select>';
                    }
                    ?>
                    <?php echo $select_nama_desa; ?>
                    </li>
                </ul>

        </div>
        <div class="box">
            <h3>
                Detail Pasien
            </h3>
            <div class="box-content form label">
            <ul>
                <li>
                    <label for="sex">Jenis Kelamin</label>
                    <div class="form-content" style="padding-top:10px;">
                        <input type="radio" name="sex" value="Laki-Laki" />Laki-Laki <input type="radio" name="sex" value="Perempuan" />Perempuan
                    </div>
                </li>
                <li>
                    <label for="birthdate">Tanggal Lahir</label>
                    <div class="form-content">
                        <input type="text" name="birthdate" id="birthdate">
                    </div>
                </li>
                <li>
                    <label for="phone">Nomer Telepon</label>
                    <div class="form-content">
                        <input type="text" name="phone" id="title">
                    </div>
                </li>
                <li>
                    <label for="occupation">Pekerjaan</label>
                    <?php
                    $query_nama_pekerjaan = mysql_query("SELECT pekerjaan_nama FROM pekerjaan");
                    if(mysql_num_rows($query_nama_pekerjaan)) {
                        $select_nama_pekerjaans = '<select name="occupation">';
                        $select_nama_pekerjaans .='<option value="">Pilih Pekerjaan</option>';
                        while($nama_pekerjaan = mysql_fetch_array($query_nama_pekerjaan)) { 
                            $select_nama_pekerjaans .='<option value="'.$nama_pekerjaan['pekerjaan_nama'].'">'.$nama_pekerjaan['pekerjaan_nama'].'</option>';
                        }
                    }
                    $select_nama_pekerjaans .='</select>';
                    ?>
                    <div class="form-content">
                    <?php echo $select_nama_pekerjaans; ?>
                    </div>
                </li>
                <li>
                    <label for="religion">Agama</label>
                    <?php
                    $query_nama_agama = mysql_query("SELECT agama_nama FROM agama");
                    if(mysql_num_rows($query_nama_agama)) {
                        $select_nama_agamas = '<select name="religion">';
                        $select_nama_agamas .='<option value="">Pilih Agama</option>';
                        while($nama_agama = mysql_fetch_array($query_nama_agama)) { 
                            $select_nama_agamas .='<option value="'.$nama_agama['agama_nama'].'">'.$nama_agama['agama_nama'].'</option>';
                        }
                    }
                    $select_nama_agamas .='</select>';
                    ?>
                    <div class="form-content">
                    <?php echo $select_nama_agamas; ?>
                    </div>
                </li>
            </ul>
            </div>
        </div>
    </div>

    <div class="box-container post-rightbar">
        <div class="box">
            <h3>
                Pilih Layanan
            </h3>

            <div class="box-content">

                <div style="padding-left:10px;padding-top:0px;">
                    <input type="radio" name="stage" value="Poli Umum" />Poli Umum<br/>
                    <input type="radio" name="stage" value="Poli Gigi" />Poli Gigi<br/>
                    <input type="radio" name="stage" value="Poli KIA" />Poli KIA<br/>
                    <input type="radio" name="stage" value="Apotek" />Apotek<br/>
                    <input type="radio" name="stage" value="Arsip" />Arsip<br/>
                </div>

                <div class="publish-content">
                    <button type="submit" name="tambah-pasien" value="tambah-pasien" onclick="this.value=\'tambah-pasien\'">Tambah</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<?php include('inc/footer.php'); ?>