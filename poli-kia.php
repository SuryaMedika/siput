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
$get = mysql_query("SELECT * FROM pasien WHERE pasien_stage = 'Poli KIA' AND pasien_id='$id'");
$dataGet = mysql_fetch_assoc($get);
?>
<!--content-->
<div class="content">

<?php 
  if(!$_GET['aksi']){
?>

    <div class="box-">
        <h1>
            Poli KIA 
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <div class="table">
        <table>
            <thead>
                <tr>
                    <th>Nama Pasien</th>
                    <th class="hide">Alamat</th>
                    <th class="hide">Telepon</th>
                    <th>Jam</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $query = "SELECT * FROM pasien WHERE pasien_stage = 'Poli KIA' ORDER BY pasien_update ASC";
            $sql = mysql_query($query);
            if(mysql_num_rows($sql) == 0){
                echo '<tr><td>Blank...!</td></tr>';
            }else{
                while($data = mysql_fetch_assoc($sql)){ 
            ?>
                <tr>
                    <td>
                        <a href="poli-kia.php?aksi=view&id=<?php echo $data['pasien_id']; ?>" class="title">
                            <?php echo $data['pasien_name']; ?>
                        </a>
                    </td>
                    <td class="hide">
                        <?php echo $data['pasien_address']; ?>
                    </td>
                    <td class="hide">
                        <?php echo $data['pasien_phone']; ?>
                    </td>
                    <td>
                        <span class="date"><?php echo date('G:i:s', strtotime($data['pasien_update'])); ?> WITA</span>
                    </td>
                </tr>
                <?php 
                } 
            }
            ?>
            </tbody>
        </table>
    </div>

  <?php } ?>

  <?php
  //edit
  if($_GET['aksi'] == "view"){

    //get next kunjungan number
    $today="T".date("Ym");
    $kunjungan_number = mysql_query("select max(kunjungan_number) from kunjungan");
    $get_number = mysql_fetch_array($kunjungan_number);
    $lastNumber = substr($get_number[0], 8, 4);
    $nextNumber = $lastNumber + 1;
    $nextVisNumber = $today.sprintf('%04s', $nextNumber);

    if($_POST['simpan-pasien']){

      $update     = date('Y-m-d H:i:s');
      $name       = $_POST['name'];
      $sex        = $_POST['sex'];
      $birthdate  = $_POST['birthdate'];
      $address    = $_POST['address'];
      $phone      = $_POST['phone'];
      $occupation = $_POST['occupation'];
      $religion   = $_POST['religion'];
      $stage      = $_POST['stage'];

      //insert kunjungan 
      $pasien_id  = $_GET['id'];
      $pegawai    = $_SESSION['pegawai_login'];
      $date       = date('Y-m-d H:i:s');
      $update     = date('Y-m-d H:i:s');
      $number     = $nextVisNumber;
      $anamnese   = $_POST['anamnese'];
      $diagnose   = $_POST['diagnose'];
      $treatment  = $_POST['treatment'];
      $resep      = $_POST['resep'];

      if($_POST['stage'] == 'Apotek' && $anamnese && $diagnose && $treatment){

        $update = mysql_query("UPDATE pasien SET pasien_update='$update', pasien_name='$name', pasien_sex='$sex', pasien_birthdate='$birthdate', pasien_address='$address', pasien_phone='$phone', pasien_occupation='$occupation', pasien_religion='$religion', pasien_stage='$stage' WHERE pasien_id='$id'");

        $insert = mysql_query("INSERT INTO kunjungan VALUES(NULL, '$pasien_id', '$pegawai', '$date', '$update', '$number', '$anamnese', '$diagnose', '$treatment', '$resep')");

        if($update && $insert){
          echo '<script language="javascript">alert("Kunjungan berhasil ditambahkan."); document.location="'.$_SERVER['PHP_SELF'].'";</script>';

        }else{
          echo 'ERROR: Gagal menambahkan kunjungan.';
        }

      }else{
        //echo 'ERROR: Pilih langkah selanjutnya. Dan jangan lupa isi Anamnesa, Diagnosa Dan Tindakan pasien.';
        $message_error = "Error 3";
      }

    }

?>

    <div class="box-">
        <h1>
            Poli KIA <?php echo "&raquo; <strong>".$dataGet['pasien_number']."</strong>"; ?>
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>
    <?php echo $message_error; ?>

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
                        <select name="occupation" id="occupation" style="pointer-events:none;color:#000;">
                            <option value="PNS">PNS</option>
                            <option value="Swasta">Swasta</option>
                            <option value="Petani">Petani</option>
                            <option value="Lain-Lain">Lain-Lain</option>
                        </select>
                    </div>
                </li>
                <li>
                    <label for="religion">Agama</label>
                    <div class="form-content">
                        <select name="religion" id="religion">
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                            <option value="Konghucu">Konghucu</option>
                            <option value="Lain-Lain">Lain-Lain</option>
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
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th class="hide">Anamnesa</th>
                    <th class="hide">Diagnosa</th>
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
            ?>
                <tr>
                    <td>
                        <span class="date"><?php echo date('j M Y', strtotime($data['kunjungan_date'])); ?></span>
                    </td>
                    <td class="hide">
                        <?php echo $data['kunjungan_anamnese']; ?>
                    </td>
                    <td class="hide">
                        <?php echo $data['kunjungan_diagnose']; ?>
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
                Insert Kunjungan 
            </h3>

            <div class="box-content">
                <ul>
                    <li>
                        <div style="font-size:18px;font-weight:bold;">No : <?php echo $nextVisNumber; ?></div>
                    </li>
                    <li>
                        <textarea name="anamnese" id="" cols="30" rows="5" placeholder="Anamnesa"></textarea>
                    </li>
                    <li>
                        <select name="diagnose" class="diagnosa" style="width:100%"></select>
                    </li>
                    <li>
                        <textarea name="treatment" id="" cols="30" rows="5" placeholder="Terapi"></textarea>
                    </li>
                    <li>
                        <textarea name="resep" id="" cols="30" rows="5" placeholder="Resep"></textarea>
                    </li>
                </ul>
            </div>
        </div>

        <div class="box">
            <h3>
                Kontrol 
            </h3>

            <div class="box-content">

                <div style="padding-left:10px;padding-top:0px;">
                <strong>Selanjutnya ke</strong><br/>
                    <input type="radio" name="stage" value="Poli Umum" <?php echo ($dataGet['pasien_stage'] == 'Poli Umum') ? 'checked' : ''; ?> />Poli Umum <br/>
                    <input type="radio" name="stage" value="Poli Gigi" <?php echo ($dataGet['pasien_stage'] == 'Poli Gigi') ? 'checked' : ''; ?> />Poli Gigi <br/>
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

</div>

<?php include('inc/footer.php'); ?>