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
<?php if($_SESSION['pegawai_level'] !== 'Admin'){
      echo 'Akses terbatas';
  } else { 
?>

    <div class="box-">
        <h1>
            Settings
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <div class="box-">
        <form action="" class="form label">
            <ul>
                <li>
                    <label for="title">Site Title</label>
                    <div class="form-content">
                        <input type="text" id="title">
                    </div>
                </li>
                <li>
                    <label for="tag-line">Tag Line</label>
                    <div class="form-content">
                        <input type="text" id="tag-line">
                        <p>
                            In a few words, explain what this site is about.
                        </p>
                    </div>
                </li>
                <li>
                    <label for="description">Description</label>
                    <div class="form-content">
                        <textarea name="description" id="description" cols="30" rows="5"></textarea>
                        <p>
                            In a few words, explain what this site is about.
                        </p>
                    </div>
                </li>
                <li class="submit">
                    <button type="submit">Save Changes</button>
                </li>
            </ul>
        </form>
    </div>
<?php } ?>
</div>

<?php include('inc/footer.php'); ?>
