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
            Tampilan Kosong
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <div class="box-">
    </div>

</div>

<?php include('inc/footer.php'); ?>
