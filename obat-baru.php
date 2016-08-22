<?php include('inc/header.php'); ?>
<?php 
    if(!$_SESSION['pegawai_login']){
      header("Location: login.php");
    }
?>
<?php include('inc/navbar.php'); ?>
<?php include('inc/sidebar.php'); ?>

<!--content-->
<div class="content">

  <?php
  //tambah

    if($_POST['tambah-obat']){

      $date       = date('Y-m-d H:i:s');
      $pegawai    = $_SESSION['pegawai_login'];
      $name       = $_POST['name'];
      $stock      = $_POST['stock'];
      $satuan     = $_POST['satuan'];
      $jenis      = $_POST['jenis'];

      if($name && stock){
        $insert = mysql_query("INSERT INTO obat VALUES(NULL, '$pegawai', '$date', '$date', '$name', '$stock', '$stock', '$satuan', '$jenis')");

        if($insert){
          echo '<script language="javascript">alert("Obat berhasil ditambahkan."); document.location="'.$_SERVER['PHP_SELF'].'";</script>';

        }else{
          echo 'ERROR: Gagal menambahkan obat.';
        }

      }else{
        echo 'ERROR: Masukkan nama dan jumlah obat.';
      }
    }
  ?>

    <div class="box-">
        <h1>Tambah Data Obat</h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <form method="post" action="" class="form">
    <div class="box-container post-content">
        <div class="box-">

                <ul>
                    <li>
                        <input type="text" name="name" class="big" placeholder="Nama Obat">
                    </li>
                </ul>

        </div>
        <div class="box">
            <h3>
                Detail Obat
            </h3>
            <div class="box-content form label">
            <ul>
                <li>
                    <label for="stock">Jumlah</label>
                    <div class="form-content">
                        <input type="text" name="stock" id="stock">
                    </div>
                </li>
                <li>
                    <label for="satuan">Satuan</label>
                    <div class="form-content">
                        <input type="text" name="satuan" id="satuan">
                    </div>
                </li>
            </ul>
            </div>
        </div>
    </div>

    <div class="box-container post-rightbar">
        <div class="box">
            <h3>
                Jenis Obat
            </h3>

            <div class="box-content">

                <div style="padding-left:10px;padding-top:0px;">
                        <input type="radio" name="jenis" value="Generik" />Generik <input type="radio" name="jenis" value="Bebas" />Bebas
                </div>

                <div class="publish-content">
                    <button type="submit" name="tambah-obat" value="tambah-obat" onclick="this.value=\'tambah-obat\'">Tambah</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<?php include('inc/footer.php'); ?>