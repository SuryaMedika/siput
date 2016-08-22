<?php include('inc/header.php'); ?>
<?php 
    if(!$_SESSION['pegawai_login']){
      header("Location: login.php");
    }
?>
<?php include('inc/navbar.php'); ?>
<?php include('inc/sidebar.php'); ?>

<!-- Content -->
<div class="content">

    <div class="box-">
	<h1>
	    Dashboard
	</h1>
    </div>

    <!-- Container box Selamat Datang -->
    <div class="box-container">
	<div class="box" id="div-0">
	    <div class="box-content">
		<h1>SIPUT Panel</h1>
		<p style="font-size:16px;color:#444;">Sistem Informasi Puskesmas Terpadu.</p>  
		<div class="clear" style="height: 20px;"></div> 	 

		<div class="box-container container-33"><div class="container-stat">
	<?php
	$date  = date('Y-m-d H:i:s');
	$now   = date('Y-m-d', strtotime($date));
	$query = "SELECT COUNT(pasien_id) AS jumPasien FROM pasien WHERE pasien_update LIKE '%$now%'";
	$hasil = mysql_query($query);
	$row = mysql_fetch_array($hasil);	 
	$jumData = $row['jumPasien'];  
	?>	
		    <h2 style="font-size:18px;">Pendaftaran Hari Ini</h2>
		    <h2 style="font-size:30px; padding: 10px;"><?php echo $jumData; ?></h2>
		    <h2 style="font-size:18px;">Pasien</h2>

		<div class="clear" style="height: 10px;"></div> 
		</div></div>

		<div class="box-container container-33"><div class="container-stat">
	<?php
	$query_khi = "SELECT COUNT(kunjungan_id) AS jumKunjungan FROM kunjungan WHERE kunjungan_date LIKE '%$now%'";
	$hasil_khi = mysql_query($query_khi);
	$row_khi = mysql_fetch_array($hasil_khi);	 
	$jumData_KHI = $row_khi['jumKunjungan'];  
	?>	
		    <h2 style="font-size:18px;">Dilayani Hari Ini</h2>
		    <h2 style="font-size:30px; padding: 10px;"><?php echo $jumData_KHI; ?></h2>
		    <h2 style="font-size:18px;">Pasien</h2>

		<div class="clear" style="height: 10px;"></div> 
		</div></div>

		<div class="box-container container-33"><div class="container-stat">
		    <h2 style="font-size:18px;">Pendapatan Hari Ini</h2>
		    <h2 style="font-size:30px; padding: 10px;">850.000</h2>
		    <h2 style="font-size:18px;">Rupiah</h2>

		<div class="clear" style="height: 10px;"></div> 
		</div></div>

		<div class="clear" style="height: 10px;"></div> 
	    </div>
	</div>
    </div>
    <!-- End Container box Selamat Datang -->

    <!-- Container box 10 Diagnosa Terbanyak Bulan Ini -->
    <div class="box-container container-50">
	<div class="box" id="div-2">
	    <h3>
		Diagnosa Bulan Ini
	    </h3>
	    <div class="box-content">

	    </div>
	</div>
    </div>
    <!-- End Container box 10 Diagnosa Terbanyak Bulan Ini -->

    <!-- Container box Jumlah Pasien Bulan Ini -->
    <div class="box-container container-50">
	<div class="box" id="div-2">
	    <h3>
		Pasien Bulan Ini
	    </h3>
	    <div class="box-content">

	    </div>
	</div>
    </div>
    <!-- End Container box Jumlah Pasien Bulan Ini -->

    <!-- Container box Catatan Aktifitas -->
    <div class="box-container container-50">
	<div class="box" id="div-1">
	    <h3>
		Catatan Aktifitas
	    </h3>
	    <div class="box-content table">
	    <table class="footable">
	    <thead>
		<tr>
		    <th>Tanggal</th>
		    <th data-hide="phone">Diagnosa</th>
		    <th>Tindakan</th>
		</tr>
	    </thead>
	    <tbody>
	    <?php 
	    $query_kunjungan = "SELECT * FROM kunjungan ORDER BY kunjungan_date DESC LIMIT 6";
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
		    <td>
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
    <!-- End Container box Catatan Aktifitas -->

    <!-- Container box Pendaftaran Cepat -->
    <div class="box-container container-50">
	<div class="box" id="div-2">
	    <h3>
		Pendaftaran Cepat
	    </h3>
	    <div class="box-content">
		<form action="" class="form">
		    <ul>
			<li>
			    <input type="text" id="input" placeholder="Nama Lengkap Pasien">
			</li>
			<li>
			    <textarea name="" id="" cols="30" rows="5" placeholder="Alamat Lengkap"></textarea>
			</li>
			<li>
			    <button type="submit">Submit</button>
			</li>
		    </ul>
		</form>
	    </div>
	</div>
    </div>
    <!-- End Container box Pendaftaran Cepat -->

</div>
<!-- End Content -->

<?php include('inc/footer.php'); ?>