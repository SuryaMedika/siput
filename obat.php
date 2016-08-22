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
$get = mysql_query("SELECT * FROM obat WHERE obat_id='$id'");
$dataGet = mysql_fetch_assoc($get);
?>

<!--content-->
<div class="content">

<?php 
  if(!$_GET['aksi']){
?>

    <div class="box-">
        <h1>
            Data Obat
            <a href="obat-baru.php">Tambah Obat</a>
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
                    <th>Nama Obat</th>
                    <th class="hide">Stok Awal</th>
                    <th>Stok Kini</th>
                    <th>Satuan</th>
                    <th class="hide">Jenis</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $dataPerPage = 10;       
            if(isset($_GET['page'])){
                $noPage = $_GET['page'];
            }else{
                $noPage = 1;
            }
            $offset = ($noPage - 1) * $dataPerPage;
            $keyword = $_GET['s'];
            $query = "SELECT * FROM obat";
            if(isset($_GET['s']) !== "") {
                $query .= " WHERE obat_name LIKE '%$keyword%'";
            }
            $query .= " ORDER BY obat_id DESC LIMIT $offset, $dataPerPage";
            $sql = mysql_query($query);
            if(mysql_num_rows($sql) == 0){
                echo '<tr><td>Blank...!</td></tr>';
            }else{
                while($data = mysql_fetch_assoc($sql)){ 
            ?>
                <tr>
                    <td>
                        <a href="obat.php?aksi=edit&id=<?php echo $data['obat_id']; ?>" class="title">
                            <?php echo $data['obat_name']; ?>
                        </a>
                    </td>
                    <td class="hide">
                        <?php echo $data['obat_stock']; ?>
                    </td>
                    <td>
                        <?php echo $data['obat_stock_update']; ?>
                    </td>
                    <td>
                        <?php echo $data['obat_satuan']; ?>
                    </td>
                    <td class="hide">
                        <?php echo $data['obat_jenis']; ?>
                    </td>
                    <td>
                        <span class="date"><?php echo date('j M Y', strtotime($data['obat_update'])); ?></span>
                    </td>
                </tr>

            <?php 
            } 
            ?>
            </tbody>
        </table>
        <?php 
        $query = "SELECT COUNT(obat_id) AS jumData FROM obat";
        if(isset($_GET['s']) !== "") {
            $query .= " WHERE obat_name LIKE '%$keyword%'";
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

    if($_POST['simpan-obat']){

      $update       = date('Y-m-d H:i:s');
      $name         = $_POST['name'];
      $stock        = $_POST['stock'];
      $stock_update = $_POST['stock_update'];
      $satuan       = $_POST['satuan'];
      $jenis        = $_POST['jenis'];

      $sql = "UPDATE obat SET obat_update='$update', obat_name='$name', obat_stock='$stock', obat_stock_update='$stock_update', obat_satuan='$satuan', obat_jenis='$jenis'";

      $sql .= " WHERE obat_id='$id'";

      $update = mysql_query($sql);

      if($update){
        echo '<script language="javascript">alert("Obat berhasil disimpan."); document.location="'.$_SERVER['PHP_SELF'].'";</script>';

      }else{
        echo 'ERROR: Gagal menyimpan obat.';
      }
    }

?>

    <div class="box-">
        <h1>
            Edit Obat 
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <form method="post" action="" class="form">
    <div class="box-container post-content">
        <div class="box-">

                <ul>
                    <li>
                        <input type="text" name="name" class="big" value="<?php echo $dataGet['obat_name']; ?>">
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
                        <input type="text" name="stock" id="title" value="<?php echo $dataGet['obat_stock']; ?>">
                    </div>
                </li>
                <li>
                    <label for="stock">Stock Update</label>
                    <div class="form-content">
                        <input type="text" name="stock_update" id="title" value="<?php echo $dataGet['obat_stock_update']; ?>">
                    </div>
                </li>
                <li>
                    <label for="satuan">Satuan</label>
                    <div class="form-content">
                        <input type="text" name="satuan" id="satuan" value="<?php echo $dataGet['obat_satuan']; ?>">
                    </div>
                </li>
            </ul>
            </div>
        </div>
    </div>

    <div class="box-container post-rightbar">
        <div class="box">
            <h3>
                Publish
            </h3>

            <div class="box-content">

                <div style="padding-left:10px;padding-top:0px;">
                <strong>Status</strong><br/>
                        <input type="radio" name="jenis" value="Generik" <?php echo ($dataGet['obat_jenis'] == 'Generik') ? 'checked' : ''; ?> />Generik <input type="radio" name="jenis" value="Bebas" <?php echo ($dataGet['obat_jenis'] == 'Bebas') ? 'checked' : ''; ?> />Bebas
                </div>

                <div class="publish-content">
                    <button type="submit" name="simpan-obat" value="simpan-obat" onclick="this.value=\'simpan-obat\'">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    </form>
<?php } ?>

</div>

<?php include('inc/footer.php'); ?>