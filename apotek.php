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
$get = mysql_query("SELECT * FROM pasien WHERE pasien_stage = 'Apotek' AND pasien_id='$id'");
$dataGet = mysql_fetch_assoc($get);
$get_kunjungan = mysql_query("SELECT * FROM kunjungan WHERE kunjungan_pasien_id='$id'");
$dataGet_kunjungan = mysql_fetch_assoc($get_kunjungan);
?>

<!--content-->
<div class="content">

<?php 
  if(!$_GET['aksi']){
?>

    <div class="box-">
        <h1>
            Apotek 
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
                    <th>Status</th>
                    <th class="hide">Tanggal</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $query = "SELECT * FROM pasien WHERE pasien_stage = 'Apotek' ORDER BY pasien_update ASC";
            $sql = mysql_query($query);
            if(mysql_num_rows($sql) == 0){
                echo '<tr><td>Blank...!</td></tr>';
            }else{
                while($data = mysql_fetch_assoc($sql)){ 
            ?>
                <tr>
                    <td>
                        <a href="apotek.php?aksi=view&id=<?php echo $data['pasien_id']; ?>" class="title">
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
                        <?php echo $data['pasien_stage']; ?>
                    </td>
                    <td class="hide">
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
  //view
  if($_GET['aksi'] == "view"){

    $today="R".date("Ym");
    $resep_number = mysql_query("select max(resep_number) from resep");
    $get_number = mysql_fetch_array($resep_number);
    $lastNumber = substr($get_number[0], 8, 4);
    $nextNumber = $lastNumber + 1;
    $nextResepNumber = $today.sprintf('%04s', $nextNumber);

    if($_POST['simpan-pasien']){

      $date              = date('Y-m-d H:i:s');
      $update     = date('Y-m-d H:i:s');
      $stage      = 'Arsip';

      $pegawai           = $_SESSION['pegawai_login'];
      $number            = $nextResepNumber;
      $pasien_number     = $dataGet['pasien_number'];
      $kunjungan_number  = $dataGet_kunjungan['kunjungan_number'];
 
      $update = mysql_query("UPDATE pasien SET pasien_update='$update', pasien_stage='$stage' WHERE pasien_id='$id'");

      foreach($_POST["jumlahs"] as $key => $jumlah_field) {
          $nama_obat_field = $_POST["nama_obats"][$key];
          $aturan_pakai_field = $_POST["aturan_pakais"][$key];
          $get_obat = mysql_query("SELECT * FROM obat WHERE obat_name = '$nama_obat_field'");
          $dataGet_obat = mysql_fetch_assoc($get_obat);
          $obat_stock_update = $dataGet_obat['obat_stock_update'];
          $jumlah_obat = $obat_stock_update - $jumlah_field;
          $query_obat = mysql_query("UPDATE obat SET obat_stock_update='$jumlah_obat' WHERE obat_name='$nama_obat_field'");
          if (!empty($nama_obat_field) && !empty($jumlah_field)) {
              $insert_resep = mysql_query("INSERT INTO resep VALUES(NULL, '$pegawai', '$date', '$number', '$pasien_number', '$kunjungan_number', '$nama_obat_field', '$jumlah_field', '$aturan_pakai_field')");
          }
      }

      if($update){
        echo '<script language="javascript">alert("Pasien berhasil disimpan."); document.location="'.$_SERVER['PHP_SELF'].'";</script>';

      }else{
        echo 'ERROR: Gagal menyimpan pasien.';
      }
    }
  ?>
    <div class="box-">
        <h1>
            Apotek &raquo; <?php echo "<strong>".$dataGet['pasien_number']."</strong>"; ?>
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
                Detail Resep
            </h3>
            <div class="box-content form">
            <?php 
            $query_kunjungan = "SELECT * FROM kunjungan WHERE kunjungan_pasien_id = '$id' ORDER BY kunjungan_date DESC LIMIT 1";
            $sql_kunjungan = mysql_query($query_kunjungan);
            if(mysql_num_rows($sql_kunjungan) == 0){
                echo '<tr><td>Blank...!</td></tr>';
            }else{
                while($data = mysql_fetch_assoc($sql_kunjungan)){ 
            ?>
                <ul>
                    <li>
                    <div class="form-content" style="padding-top:10px;">
                        <textarea name="" id="" cols="30" rows="10" style="pointer-events:none;color:#000;width:100%;"><?php echo $data['kunjungan_resep']; ?></textarea>
                    </div>
                    </li>
                    <li>
                    <?php
                    $query_nama_obat = mysql_query("SELECT obat_name FROM obat");
                    if(mysql_num_rows($query_nama_obat)) {
                        $select_nama_obats = '<select name="nama_obats[]" id="obat">';
                        $select_nama_obats .='<option value="">Pilih Obat</option>';
                        while($nama_obat = mysql_fetch_array($query_nama_obat)) { 
                            $select_nama_obats .='<option value="'.$nama_obat['obat_name'].'">'.$nama_obat['obat_name'].'</option>';
                        }
                    }
                    $select_nama_obats .='</select>';
                    ?>
                    <?php
                    $select_jumlahs = '<select name="jumlahs[]">';
                    $i=0;
                    while($i <= 10 ) { 
                        $select_jumlahs .='<option value="'.$i.'">'.$i.'</option>';
                        $i++;
                    }
                    $select_jumlahs .='</select>';
                    ?>
                    <div class="form-content" style="padding-top:10px;">
                        <table id="obat-fieldset-one" >
                        <tbody>
                            <tr class="empty-row screen-reader-text">
                                <td style="padding:5px 5px 5px 0;"><?php echo $select_nama_obats; ?></td>
                                <td style="padding:5px;"><?php echo $select_jumlahs; ?></td>
                                <td style="padding:5px;"><input style="width:100%;" type="text" name="aturan_pakais[]"></td>
                                <td style="padding:5px;"><span class="remove-row fa fa-minus-square"></span></td>
                            </tr>
                        </tbody>       
                        </table>
                        <div style="padding-top:10px;"><button id="add-row"><span class="fa fa-plus"></span> Obat</button></div>
                    </div>
                    </li>
                </ul>
                <?php 
                } 
            }
            ?>
            </div>
        </div>
    </div>

    <div class="box-container post-rightbar">
        <div class="box">
            <h3>
                Kontrol
            </h3>

            <div class="box-content">

                <a href="#" class="btn right">Cetak Resep</a>
                <a href="#" class="btn">Cetak Nota</a>

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