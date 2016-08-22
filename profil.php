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

    <div class="box-">
        <h1>
            Profil
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <div class="box-">
<?php 
    $username = $_SESSION['pegawai_login'];
    $get = mysql_query("SELECT * FROM pegawai WHERE pegawai_username='$username'");
    $dataGet = mysql_fetch_assoc($get);

    if($_POST['simpan-pegawai']){

      $password   = md5($_POST['password']);
      $name       = $_POST['name'];
      $address    = $_POST['address'];
      $phone      = $_POST['phone'];
      $email      = $_POST['email'];

      $sql = "UPDATE pegawai SET pegawai_name='$name', pegawai_address='$address', pegawai_phone='$phone', pegawai_email='$email'";
      if(!empty($_POST['password'])) {
      $sql .= ", pegawai_password='$password'";
      }
      $sql .= " WHERE pegawai_username='$username'";

      $update = mysql_query($sql);

      if($update){
        echo '<script language="javascript">alert("Pegawai berhasil disimpan."); document.location="'.$_SERVER['PHP_SELF'].'";</script>';

      }else{
        echo 'ERROR: Gagal menyimpan pegawai.';
      }
    }

?>

        <form method="post" action="" class="form label">
            <ul>
                <li>
                    <label for="username">Nama Pengguna</label>
                    <div class="form-content">
                        <input type="text" name="username" id="username" value="<?php echo $dataGet['pegawai_username']; ?>" disabled>
                    </div>
                </li>
                <li>
                    <label for="name">Nama Lengkap dan Gelar</label>
                    <div class="form-content">
                        <input type="text" name="name" id="title" value="<?php echo $dataGet['pegawai_name']; ?>">
                    </div>
                </li>
                <li>
                    <label for="nip">NIP/NRPTT/NRP</label>
                    <div class="form-content">
                        <input type="text" id="tag-line">
                        <p>
                            In a few words, explain what this site is about.
                        </p>
                    </div>
                </li>
                <li>
                    <label for="address">Alamat Lengkap</label>
                    <div class="form-content">
                        <textarea name="address" id="address" cols="30" rows="5"><?php echo $dataGet['pegawai_address']; ?></textarea>
                        <p>
                            In a few words, explain what this site is about.
                        </p>
                    </div>
                </li>
                <li>
                    <label for="phone">No Handphone</label>
                    <div class="form-content">
                        <input type="text" name="phone" id="phone" value="<?php echo $dataGet['pegawai_phone']; ?>">
                    </div>
                </li>
                <li>
                    <label for="email">Alamat Email</label>
                    <div class="form-content">
                        <input type="text" name="email" id="email" value="<?php echo $dataGet['pegawai_email']; ?>">
                    </div>
                </li>
                <li>
                    <label for="password">Password</label>
                    <div class="form-content">
                        <input type="text" name="password" id="password">
                        <p>
                            Biarkan kosong jika tidak ingin mengganti password.
                        </p>
                    </div>
                </li>
                <li class="submit">
                    <button type="submit" name="simpan-pegawai" value="simpan-pegawai" onclick="this.value=\'simpan-pegawai\'">Simpan</button>
                </li>
            </ul>
        </form>
    </div>

</div>

<?php include('inc/footer.php'); ?>
