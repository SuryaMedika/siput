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
            Data Kunjungan 
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
        <table class="footable">
            <thead>
                <tr>
                    <th>Nama Pasien</th>
                    <th data-hide="phone,tablet">Anamnesa</th>
                    <th data-hide="phone">Diagnosa</th>
                    <th data-hide="">Terapi</th>
                    <th data-hide="phone,tablet">Tanggal</th>
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
            $query = "SELECT * FROM kunjungan";

            if(isset($_GET['s']) !== "") {
                $query .= " WHERE kunjungan_anamnese LIKE '%$keyword%'";
            }
            $query .= " ORDER BY kunjungan_id DESC LIMIT $offset, $dataPerPage";
            $sql = mysql_query($query);

            if(mysql_num_rows($sql) == 0){
                echo '<tr><td>Blank...!</td></tr>';
            }else{
                while($data = mysql_fetch_assoc($sql)){ 

                $id = $data['kunjungan_pasien_id'];
                $get = mysql_query("SELECT * FROM pasien WHERE pasien_id='$id'");
                $dataGet = mysql_fetch_assoc($get);

                $icd10_id = $data['kunjungan_diagnose'];
                $get_diagnose = mysql_query("SELECT * FROM kode_icd10 WHERE kode='$icd10_id'");
                $dataGet_Diagnose = mysql_fetch_assoc($get_diagnose);

            ?>

                <tr>
                    <td>
                        <?php echo $dataGet['pasien_name']; ?>
                    </td>
                    <td>
                        <?php echo $data['kunjungan_anamnese']; ?>
                    </td>
                    <td>
                        <?php echo $data['kunjungan_diagnose']; ?> - <?php echo $dataGet_Diagnose['indonesia']; ?>
                    </td>
                    <td>
                        <?php echo $data['kunjungan_treatment']; ?>
                    </td>
                    <td>
                        <span class="date"><?php echo date('j M Y', strtotime($data['kunjungan_date'])); ?></span>
                    </td>
                </tr>

            <?php } ?>

            </tbody>
        </table>

        <?php 

        $query = "SELECT COUNT(kunjungan_id) AS jumData FROM kunjungan";

        if(isset($_GET['s']) !== "") {
            $query .= " WHERE kunjungan_anamnese LIKE '%$keyword%'";
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

</div>

<?php include('inc/footer.php'); ?>