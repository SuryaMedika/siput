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
$get = mysql_query("SELECT * FROM pegawai WHERE pegawai_id='$id'");
$dataGet = mysql_fetch_assoc($get);
?>

<!--content-->
<div class="content">

<?php 
  if(!$_GET['aksi']){
?>

    <div class="box-">
	<h1>
	    Data Pegawai
	    <a href="pegawai-baru.php">Tambah Pegawai</a>
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
		    <th>Nama Pegawai</th>
		    <th class="hide">Telepon</th>
		    <th class="hide">e-Mail</th>
		    <th>Level</th>
		    <th class="hide">Status</th>
		    <th>Tanggal</th>
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
	    $query = "SELECT * FROM pegawai";
	    if(isset($_GET['s']) !== "") {
		$query .= " WHERE pegawai_name LIKE '%$keyword%'";
	    }
	    $query .= " ORDER BY pegawai_id DESC LIMIT $offset, $dataPerPage";
	    $sql = mysql_query($query);
	    if(mysql_num_rows($sql) == 0){
		echo '<tr><td>Blank...!</td></tr>';
	    }else{
		while($data = mysql_fetch_assoc($sql)){ 
	    ?>
		<tr>
		    <td>
			<a href="#" class="title">
			    <?php echo $data['pegawai_name']; ?>
			</a>
			<div class="magic-links">
			    <a href="pegawai.php?aksi=edit&id=<?php echo $data['pegawai_id']; ?>">Edit</a> | <a href="#" class="trash">Trash</a> | <a href="#">View</a>
			</div>
		    </td>
		    <td class="hide">
			<?php echo $data['pegawai_phone']; ?>
		    </td>
		    <td class="hide">
			<?php echo $data['pegawai_email']; ?>
		    </td>
		    <td>
			<?php echo $data['pegawai_level']; ?>
		    </td>
		    <td class="hide">
			<?php echo $data['pegawai_active']; ?>
		    </td>
		    <td>
			<span class="date"><?php echo date('j M Y', strtotime($data['pegawai_date'])); ?></span>
		    </td>
		</tr>

	    <?php 
	    } 
	    ?>
	    </tbody>
	</table>
	<?php 
	$query = "SELECT COUNT(pegawai_id) AS jumData FROM pegawai";
	if(isset($_GET['s']) !== "") {
	    $query .= " WHERE pegawai_name LIKE '%$keyword%'";
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
    <?php 
    } 
    ?>

  <?php
  //edit
  if($_GET['aksi'] == "edit"){

    if($_POST['simpan-pegawai']){

      $update	  = date('Y-m-d H:i:s');
      $username   = $_POST['username'];
      $password   = md5($_POST['password']);
      $name	  = $_POST['name'];
      $address	  = $_POST['address'];
      $phone	  = $_POST['phone'];
      $email	  = $_POST['email'];
      $level	  = $_POST['level'];
      $active	  = $_POST['active'];

      $sql = "UPDATE pegawai SET pegawai_update='$update', pegawai_name='$name', pegawai_address='$address', pegawai_phone='$phone', pegawai_email='$email', pegawai_level='$level', pegawai_active='$active'";

      if(!empty($_POST['password'])) {
      $sql .= ", pegawai_password='$password'";
      }
      $sql .= " WHERE pegawai_id='$id'";

      $update = mysql_query($sql);

      if($update){
	echo '<script language="javascript">alert("Pegawai berhasil disimpan."); document.location="'.$_SERVER['PHP_SELF'].'";</script>';

      }else{
	echo 'ERROR: Gagal menyimpan pegawai.';
      }
    }

?>

    <div class="box-">
	<h1>
	    Edit Pegawai 
	</h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <form method="post" action="" class="form">
    <div class="box-container post-content">
	<div class="box-">

		<ul>
		    <li>
			<input type="text" name="name" class="big" value="<?php echo $dataGet['pegawai_name']; ?>">
		    </li>
		    <li>
			<textarea name="address" id="editor" rows="10" cols="40"><?php echo $dataGet['pegawai_address']; ?></textarea>
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
			<input type="text" name="username" id="title" value="<?php echo $dataGet['pegawai_username']; ?>" disabled>
		    </div>
		</li>
		<li>
		    <label for="password">Password</label>
		    <div class="form-content">
			<input type="password" name="password" id="password">
		    </div>
		</li>
		<li>
		    <label for="phone">Nomer Telepon</label>
		    <div class="form-content">
			<input type="text" name="phone" id="title" value="<?php echo $dataGet['pegawai_phone']; ?>">
		    </div>
		</li>
		<li>
		    <label for="email">Email</label>
		    <div class="form-content">
			<input type="text" name="email" id="title" value="<?php echo $dataGet['pegawai_email']; ?>">
		    </div>
		</li>
		<li>
		    <label for="level">Level</label>
		    <div class="form-content">
			<select name="level" id="level">
			    <option value="Admin" <?php if ($dataGet['pegawai_level'] == 'Admin') echo 'selected="selected"'; ?>>Admin</option>
			    <option value="Dokter" <?php if ($dataGet['pegawai_level'] == 'Dokter') echo 'selected="selected"'; ?>>Dokter</option>
			    <option value="Apoteker" <?php if ($dataGet['pegawai_level'] == 'Apoteker') echo 'selected="selected"'; ?>>Apoteker</option>
			    <option value="Perawat" <?php if ($dataGet['pegawai_level'] == 'Perawat') echo 'selected="selected"'; ?>>Perawat</option>
			    <option value="Resepsionis" <?php if ($dataGet['pegawai_level'] == 'Resepsionis') echo 'selected="selected"'; ?>>Resepsionis</option>
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
		    <button type="submit" name="simpan-pegawai" value="simpan-pegawai" onclick="this.value=\'simpan-pegawai\'">Simpan</button>
		</div>
	    </div>
	</div>
    </div>
    </form>
<?php } ?>

</div>

<?php include('inc/footer.php'); ?>