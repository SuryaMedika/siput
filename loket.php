<?php include('inc/header.php'); ?>
<?php 
    if(!$_SESSION['pegawai_login']){
      header("Location: login.php");
    }
?>
<?php include('inc/navbar.php'); ?>
<?php include('inc/sidebar.php'); ?>

<?php
$id = abs((int)$_GET['id']);
$get = mysql_query("SELECT * FROM pasien WHERE pasien_id='$id'");
$dataGet = mysql_fetch_assoc($get);
?>
<!--content-->
<div class="content">

<?php 
if(!$_GET['aksi']){
?>

    <div class="box-">
        <h1>
            Data Pasien 
            <a href="loket.php?aksi=tambah">Tambah Baru</a>
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <div class="search" style="width:250px;float:right;margin-bottom:10px;">
        <form action="" method="get">
            <input type="text" style="width:160px;display:inline;" name="s" value="" />
            <button type="submit" style="display:inline;">Cari</button>
        </form>
    </div>

    <div class="table">
        <table>
            <thead>
                <tr>
                    <th>Nama Pasien</th>
                    <th class="hide">Alamat</th>
                    <th class="hide">Telepon</th>
                    <th>Stage</th>
                    <th class="hide">Tanggal</th>
                </tr>
            </thead>
            <tbody>

            <?php 
            $dataPerPage = 5;
     
            if(isset($_GET['page'])){
                $noPage = $_GET['page'];
            }else{
                $noPage = 1;
            }
            $offset = ($noPage - 1) * $dataPerPage;
            $keyword = $_GET['s'];
            $query = "SELECT * FROM pasien";

            if(isset($_GET['s']) !== "") {
                $query .= " WHERE pasien_name LIKE '%$keyword%'";
            }
            $query .= " ORDER BY pasien_id DESC LIMIT $offset, $dataPerPage";
            $sql = mysql_query($query);

            if(mysql_num_rows($sql) == 0){
                echo '<tr><td>Blank...!</td></tr>';
            }else{
                while($data = mysql_fetch_assoc($sql)){ 
            ?>
                <tr>
                    <td>
                        <a href="#" class="title">
                            <?php echo $data['pasien_name']; ?>
                        </a>
                        <div class="magic-links">
                            <a href="loket.php?aksi=edit&id=<?php echo $data['pasien_id']; ?>">Edit</a> | <a href="#" class="trash">Trash</a> | <a href="loket.php?aksi=view&id=<?php echo $data['pasien_id']; ?>">View</a>
                        </div>
                    </td>
                    <td class="hide">
                        <?php echo $data['pasien_address']; ?>
                    </td>
                    <td class="hide">
                        <?php echo $data['pasien_phone']; ?>
                    </td>
                    <td>
                        <?php echo $data['pasien_stage']; ?>
                    </td>
                    <td class="hide">
                        <span class="date"><?php echo date('j M Y', strtotime($data['pasien_date'])); ?></span>
                    </td>
                </tr>

            <?php } ?>

            </tbody>
        </table>

        <?php 

        $query = "SELECT COUNT(pasien_id) AS jumData FROM pasien";

        if(isset($_GET['s']) !== "") {
            $query .= " WHERE pasien_name LIKE '%$keyword%'";
        }

        $hasil = mysql_query($query);
        $row = mysql_fetch_array($hasil);        
        $jumData = $row['jumData'];        
        $jumPage = ceil($jumData/$dataPerPage);        

        echo '<div class="pagination"><ul>';
        if ($noPage > 1) echo  "<li><a href='".$_SERVER['PHP_SELF']."?s=".$keyword."&page=".($noPage-1)."'>&laquo;</a></li>";        

        for($page = 1; $page <= $jumPage; $page++){
            if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)){   
                if (($showPage == 1) && ($page != 2))  echo "..."; 
                if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "...";
                if ($page == $noPage) echo " <li class='active'><a href='#'>".$page."</a></li> ";
            else echo " <li><a href='".$_SERVER['PHP_SELF']."?s=".$keyword."&page=".$page."'>".$page."</a></li> ";
            $showPage = $page;          
            }
        }
        if ($noPage < $jumPage) echo "<li><a href='".$_SERVER['PHP_SELF']."?s=".$keyword."&page=".($noPage+1)."'>&raquo;</a></li>";
        echo '</ul></div>';
    }

    ?>

  </div>
  <?php } ?>

  <?php
  //tambah
  if($_GET['aksi'] == "tambah"){ 

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
      $phone      = $_POST['phone'];
      $occupation = $_POST['occupation'];
      $religion   = $_POST['religion'];
      $stage      = $_POST['stage'];

      if($name && $address){
        $insert = mysql_query("INSERT INTO pasien VALUES(NULL, '$pegawai', '$date', '$date', '$number', '$name', '$sex', '$birthdate', '$address', '$phone', '$occupation', '$religion', '$stage')");

        if($insert){
          echo '<script language="javascript">alert("Pasien berhasil ditambahkan."); document.location="'.$_SERVER['PHP_SELF'].'";</script>';

        }else{
          $message_error = "<div class='message error box-'>ERROR: Gagal menambahkan pasien.</div>";
        }

      }else{
        $message_error = "<div class='message error box-'>ERROR: Masukkan nama dan alamat pasien.</div>";
      }
    }

?>

    <div class="box-">
        <h1>
            Pasien Baru &raquo; <?php echo "<strong>".$nextRegNumber."</strong>"; ?>
        </h1>
    </div>

    <?php echo $message_error; ?>
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
                        <input type="text" name="" class="big" style="display:inline;width:30%;"  placeholder="RT"> / <input type="text" name="" class="big" style="display:inline;width:30%;"  placeholder="RW">
                    </li>
                    <li>
                        <input type="text" name="" class="big" placeholder="Kelurahan/Desa">
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
                            $select_nama_pekerjaans .='<option' . $selected . ' value="'.$nama_pekerjaan['pekerjaan_nama'].'">'.$nama_pekerjaan['pekerjaan_nama'].'</option>';
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
                            $select_nama_agamas .='<option' . $selected . ' value="'.$nama_agama['agama_nama'].'">'.$nama_agama['agama_nama'].'</option>';
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

  <?php } ?>

  <?php
  //edit
  if($_GET['aksi'] == "edit"){

    if($_POST['simpan-pasien']){

      $update     = date('Y-m-d H:i:s');
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

      $update = mysql_query("UPDATE pasien SET pasien_update='$update', pasien_name='$name', pasien_sex='$sex', pasien_birthdate='$birthdate', pasien_address='$address', pasien_rt='$rt', pasien_rw='$rw', pasien_desa='$desa', pasien_phone='$phone', pasien_occupation='$occupation', pasien_religion='$religion', pasien_stage='$stage' WHERE pasien_id='$id'");

      if($update){
        echo '<script language="javascript">alert("Pasien berhasil disimpan."); document.location="'.$_SERVER['PHP_SELF'].'";</script>';

      }else{
        echo 'ERROR: Gagal menyimpan pasien.';
      }
    }

    ?>

    <div class="box-">
        <h1>
            Edit Pasien &raquo; <strong><?php echo $dataGet['pasien_number']; ?></strong>
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <form method="post" action="" class="form">
    <div class="box-container post-content">
        <div class="box-">

                <ul>
                    <li>
                        <input type="text" name="name" class="big" value="<?php echo $dataGet['pasien_name']; ?>">
                    </li>
                    <li>
                        <textarea name="address" id="address" rows="5" cols="40"><?php echo $dataGet['pasien_address']; ?></textarea>
                    </li>
                    <li>
                        <input type="text" name="rt" class="big" value="<?php echo $dataGet['pasien_rt']; ?>" style="display:inline;width:40%;"  placeholder="RT"> / <input type="text" name="rw" class="big" value="<?php echo $dataGet['pasien_rw']; ?>" style="display:inline;width:40%;"  placeholder="RW">
                    </li>
                    <li>
                    <?php
                    $query_nama_desa = mysql_query("SELECT desa_nama FROM desa");
                    if(mysql_num_rows($query_nama_desa)) {
                        $select_nama_desa = '<select name="desa" class="big">';
                        $select_nama_desa .='<option value="">Pilih Desa/Kelurahan</option>';
                        while($nama_desa = mysql_fetch_array($query_nama_desa)) { 
                            $selected = "";
                            if($dataGet['pasien_desa'] == $nama_desa['desa_nama']){
                                $selected = ' selected="selected"';
                            }
                            $select_nama_desa .='<option' . $selected . '  value="'.$nama_desa['desa_nama'].'">'.$nama_desa['desa_nama'].'</option>';
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
                        <input type="radio" name="sex" value="Laki-Laki" <?php echo ($dataGet['pasien_sex'] == 'Laki-Laki') ? 'checked' : ''; ?> />Laki-Laki <input type="radio" name="sex" value="Perempuan" <?php echo ($dataGet['pasien_sex'] == 'Perempuan') ? 'checked' : ''; ?> />Perempuan
                    </div>
                </li>
                <li>
                    <label for="birthdate">Tanggal Lahir</label>
                    <div class="form-content">
                        <input type="text" name="birthdate" id="birthdate" value="<?php echo $dataGet['pasien_birthdate']; ?>" >
                    </div>
                </li>
                <li>
                    <label for="phone">Nomer Telepon</label>
                    <div class="form-content">
                        <input type="text" name="phone" id="phone" value="<?php echo $dataGet['pasien_phone']; ?>" >
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
                            $selected = "";
                            if($dataGet['pasien_occupation'] == $nama_pekerjaan['pekerjaan_nama']){
                                $selected = ' selected="selected"';
                            }
                            $select_nama_pekerjaans .='<option' . $selected . ' value="'.$nama_pekerjaan['pekerjaan_nama'].'">'.$nama_pekerjaan['pekerjaan_nama'].'</option>';
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
                            $selected = "";
                            if($dataGet['pasien_religion'] == $nama_agama['agama_nama']){
                                $selected = ' selected="selected"';
                            }
                            $select_nama_agamas .='<option' . $selected . ' value="'.$nama_agama['agama_nama'].'">'.$nama_agama['agama_nama'].'</option>';
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
                    <input type="radio" name="stage" value="Poli Umum" <?php echo ($dataGet['pasien_stage'] == 'Poli Umum') ? 'checked' : ''; ?> />Poli Umum <br/>
                    <input type="radio" name="stage" value="Poli Gigi" <?php echo ($dataGet['pasien_stage'] == 'Poli Gigi') ? 'checked' : ''; ?> />Poli Gigi <br/>
                    <input type="radio" name="stage" value="Poli KIA" <?php echo ($dataGet['pasien_stage'] == 'Poli KIA') ? 'checked' : ''; ?> />Poli KIA <br/>
                    <input type="radio" name="stage" value="Apotek" <?php echo ($dataGet['pasien_stage'] == 'Apotek') ? 'checked' : ''; ?> />Apotek <br/>
                    <input type="radio" name="stage" value="Arsip" <?php echo ($dataGet['pasien_stage'] == 'Arsip') ? 'checked' : ''; ?> />Arsip <br/>
                </div>

                <div class="publish-content">
                    <button type="submit" name="simpan-pasien" value="simpan-pasien" onclick="this.value=\'simpan-pasien\'">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    </form>
<?php } ?>

  <?php
  //edit
  if($_GET['aksi'] == "view"){

    if($_POST['simpan-pasien']){

      $update     = date('Y-m-d H:i:s');
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

      $update = mysql_query("UPDATE pasien SET pasien_update='$update', pasien_name='$name', pasien_sex='$sex', pasien_birthdate='$birthdate', pasien_address='$address', pasien_rt='$rt', pasien_rw='$rw', pasien_desa='$desa', pasien_phone='$phone', pasien_occupation='$occupation', pasien_religion='$religion', pasien_stage='$stage' WHERE pasien_id='$id'");

      if($update){
        echo '<script language="javascript">alert("Pasien berhasil disimpan."); document.location="'.$_SERVER['PHP_SELF'].'";</script>';

      }else{
        echo 'ERROR: Gagal menyimpan pasien.';
      }
    }

    ?>

    <div class="box-">
        <h1>
            Edit Pasien &raquo; <strong><?php echo $dataGet['pasien_number']; ?></strong>
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <form method="post" action="" class="form">
    <div class="box-container post-content">
        <div class="box-">

                <ul>
                    <li>
                        <input type="text" name="name" class="big" style="pointer-events:none;color:#000;" value="<?php echo $dataGet['pasien_name']; ?>">
                    </li>
                    <li>
                        <textarea name="address" id="address" rows="5" cols="40" style="pointer-events:none;color:#000;"><?php echo $dataGet['pasien_address']; ?></textarea>
                    </li>
                    <li>
                        <input type="text" name="rt" class="big" value="<?php echo $dataGet['pasien_rt']; ?>" style="pointer-events:none;color:#000;display:inline;width:40%;"  placeholder="RT"> / <input type="text" name="rw" class="big" value="<?php echo $dataGet['pasien_rw']; ?>" style="pointer-events:none;color:#000;display:inline;width:40%;"  placeholder="RW">
                    </li>
                    <li>
                    <?php
                    $query_nama_desa = mysql_query("SELECT desa_nama FROM desa");
                    if(mysql_num_rows($query_nama_desa)) {
                        $select_nama_desa = '<select name="desa" class="big" style="pointer-events:none;color:#000;">';
                        $select_nama_desa .='<option value="">Pilih Desa/Kelurahan</option>';
                        while($nama_desa = mysql_fetch_array($query_nama_desa)) { 
                            $selected = "";
                            if($dataGet['pasien_desa'] == $nama_desa['desa_nama']){
                                $selected = ' selected="selected"';
                            }
                            $select_nama_desa .='<option' . $selected . '  value="'.$nama_desa['desa_nama'].'">'.$nama_desa['desa_nama'].'</option>';
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
                        <input type="radio" style="pointer-events:none;color:#000;" name="sex" value="Laki-Laki" <?php echo ($dataGet['pasien_sex'] == 'Laki-Laki') ? 'checked' : ''; ?> />Laki-Laki <input type="radio" style="pointer-events:none;color:#000;" name="sex" value="Perempuan" <?php echo ($dataGet['pasien_sex'] == 'Perempuan') ? 'checked' : ''; ?> />Perempuan
                    </div>
                </li>
                <li>
                    <label for="birthdate">Tanggal Lahir</label>
                    <div class="form-content">
                        <input type="text" style="pointer-events:none;color:#000;" name="birthdate" id="birthdate" value="<?php echo $dataGet['pasien_birthdate']; ?>" >
                    </div>
                </li>
                <li>
                    <label for="phone">Nomer Telepon</label>
                    <div class="form-content">
                        <input type="text" style="pointer-events:none;color:#000;" name="phone" id="phone" value="<?php echo $dataGet['pasien_phone']; ?>" >
                    </div>
                </li>
                <li>
                    <label for="occupation">Pekerjaan</label>
                    <div class="form-content">
                        <select style="pointer-events:none;color:#000;" name="occupation" id="occupation">
                            <option value="PNS" <?php if ($dataGet['pasien_occupation'] == 'PNS') echo 'selected="selected"'; ?>>PNS</option>
                            <option value="Swasta" <?php if ($dataGet['pasien_occupation'] == 'Swasta') echo 'selected="selected"'; ?>>Swasta</option>
                            <option value="Petani" <?php if ($dataGet['pasien_occupation'] == 'Petani') echo 'selected="selected"'; ?>>Petani</option>
                            <option value="Lain-Lain" <?php if ($dataGet['pasien_occupation'] == 'Lain-Lain') echo 'selected="selected"'; ?>>Lain-Lain</option>
                        </select>
                    </div>
                </li>
                <li>
                    <label for="religion">Agama</label>
                    <div class="form-content">
                        <select style="pointer-events:none;color:#000;" name="religion" id="religion">
                            <option value="Islam" <?php if ($dataGet['pasien_religion'] == 'Islam') echo 'selected="selected"'; ?>>Islam</option>
                            <option value="Kristen" <?php if ($dataGet['pasien_religion'] == 'Kristen') echo 'selected="selected"'; ?>>Kristen</option>
                            <option value="Hindu" <?php if ($dataGet['pasien_religion'] == 'Hindu') echo 'selected="selected"'; ?>>Hindu</option>
                            <option value="Budha" <?php if ($dataGet['pasien_religion'] == 'Budha') echo 'selected="selected"'; ?>>Budha</option>
                            <option value="Konghucu" <?php if ($dataGet['pasien_religion'] == 'Konghucu') echo 'selected="selected"'; ?>>Konghucu</option>
                            <option value="Lain-Lain" <?php if ($dataGet['pasien_religion'] == 'Lain-Lain') echo 'selected="selected"'; ?>>Lain-Lain</option>
                        </select>
                    </div>
                </li>
            </ul>
            </div>
        </div>

        <div class="box">
            <h3>
                Kunjungan Pasien
            </h3>
            <div class="box-content table">
            <table class="footable">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th data-hide="phone">Anamnesa</th>
                    <th data-hide="phone">Diagnosa</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $query_kunjungan = "SELECT * FROM kunjungan WHERE kunjungan_pasien_id = '$id' ORDER BY kunjungan_date ASC";
            $sql_kunjungan = mysql_query($query_kunjungan);
            if(mysql_num_rows($sql_kunjungan) == 0){
                echo '<tr><td>Blank...!</td></tr>';
            }else{
                while($data = mysql_fetch_assoc($sql_kunjungan)){ 

                $icd10_id = $data['kunjungan_diagnose'];
                $get_diagnose = mysql_query("SELECT * FROM icd10 WHERE id='$icd10_id'");
                $dataGet_Diagnose = mysql_fetch_assoc($get_diagnose);

            ?>
                <tr>
                    <td>
                        <span class="date"><?php echo date('j M Y', strtotime($data['kunjungan_date'])); ?></span>
                    </td>
                    <td>
                        <?php echo $data['kunjungan_anamnese']; ?>
                    </td>
                    <td>
                        <?php echo $data['kunjungan_diagnose']; ?> - <?php echo $dataGet_Diagnose['descriptions']; ?>
                    </td>
                    <td>
                        <?php echo $data['kunjungan_treatment']; ?>
                    </td>
                </tr>
                <?php   
                } 
            }
            ?>
            </tbody>
            </table>
            </div>
        </div>
    </div>

    <div class="box-container post-rightbar">
        <div class="box">
            <h3>
                Mencetak
            </h3>

            <div class="box-content">

                <a href="#" class="btn right">Rekam Medik</a>
                <a href="#" class="btn">Kartu Berobat</a>

                <div class="publish-content">
                    <button type="submit" name="simpan-pasien" value="simpan-pasien" onclick="this.value=\'simpan-pasien\'">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    </form>
<?php } ?>

</div>

<?php include('inc/footer.php'); ?>