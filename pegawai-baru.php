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
	<h1>Tambah Data Pegawai</h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

  <?php
  //tambah

    if($_POST['tambah-pegawai']){

      $date	  = date('Y-m-d H:i:s');
      $username   = $_POST['username'];
      $password   = md5($_POST['password']);
      $name	  = $_POST['name'];
      $address	  = $_POST['address'];
      $phone	  = $_POST['phone'];
      $email	  = $_POST['email'];
      $level	  = $_POST['level'];
      $active	  = $_POST['active'];

      if($username && $password && name){
	$insert = mysql_query("INSERT INTO pegawai VALUES(NULL, '$date', '$username', '$password', '$name', '$address', '$phone', '$email', '$level', '$active')");

	if($insert){
	  echo '<script language="javascript">alert("Pegawai berhasil ditambahkan."); document.location="'.$_SERVER['PHP_SELF'].'";</script>';

	}else{
	  echo 'ERROR: Gagal menambahkan pegawai.';
	}

      }else{
	echo 'ERROR: Masukkan username, password dan nama pegawai.';
      }
    }

?>

    <form method="post" action="" class="form">
    <div class="box-container post-content">
	<div class="box-">

		<ul>
		    <li>
			<input type="text" name="name" class="big" placeholder="Nama Lengkap dan Gelar">
		    </li>
		    <li>
			<textarea name="address" id="address" rows="10" cols="40" placeholder="Alamat Lengkap"></textarea>
		    </li>
		</ul>

	</div>
	<div class="box">
	    <h3>
		Detail Pegawai
	    </h3>
	    <div class="box-content form label">
	    <ul>
		<li>
		    <label for="username">Username</label>
		    <div class="form-content">
			<input type="text" name="username" id="title">
		    </div>
		</li>
		<li>
		    <label for="password">Password</label>
		    <div class="form-content">
			<input type="password" name="password" id="tag-line">
		    </div>
		</li>
		<li>
		    <label for="phone">Nomer Telepon</label>
		    <div class="form-content">
			<input type="text" name="phone" id="title">
		    </div>
		</li>
		<li>
		    <label for="email">Email</label>
		    <div class="form-content">
			<input type="text" name="email" id="title">
		    </div>
		</li>
		<li>
		    <label for="level">Level</label>
		    <div class="form-content">
			<select name="level" id="level">
			    <option value="Admin">Admin</option>
			    <option value="Dokter">Dokter</option>
			    <option value="Apoteker">Apoteker</option>
			    <option value="Perawat">Perawat</option>
			    <option value="Resepsionis">Resepsionis</option>
			</select>
		    </div>
		</li>
	    </ul>
	    </div>
	</div>
    </div>

    <div class="box-container post-rightbar">
	<div class="box">
	    <h3>
		Status
	    </h3>

	    <div class="box-content">

		<div style="padding-left:10px;padding-top:0px;">
			<input type="radio" name="active" value="Aktif" <?php echo ($dataGet['pegawai_active'] == 'Aktif') ? 'checked' : ''; ?> />Aktif <input type="radio" name="active" value="Tidak Aktif" <?php echo ($dataGet['pegawai_active'] == 'Tidak Aktif') ? 'checked' : ''; ?> />Tidak Aktif
		</div>

		<div class="publish-content">
		    <button type="submit" name="tambah-pegawai" value="tambah-pegawai" onclick="this.value=\'tambah-pegawai\'">Tambah</button>
		</div>
	    </div>
	</div>
    </div>
    </form>
</div>

<?php include('inc/footer.php'); ?>