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
            Master Data
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <div class="box-container container-50">
        <div class="box" id="div-1">
            <h3>
                Data Pekerjaan
            </h3>
            <div class="box-content table">
            <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pekerjaan</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $query_pekerjaan = "SELECT * FROM pekerjaan ORDER BY pekerjaan_id ASC LIMIT 5";
            $sql_pekerjaan = mysql_query($query_pekerjaan);
            if(mysql_num_rows($sql_pekerjaan) == 0){
                echo '<tr><td>Blank...!</td></tr>';
            }else{
                while($data = mysql_fetch_assoc($sql_pekerjaan)){ 
            ?>
                <tr>
                    <td>
                        <span class="date"><?php echo $data['pekerjaan_id']; ?></span>
                    </td>
                    <td>
                        <?php echo $data['pekerjaan_nama']; ?>
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


    <div class="box-container container-50">
        <div class="box" id="div-1">
            <h3>
                Data Agama
            </h3>
            <div class="box-content table">
            <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Agama</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $query_agama = "SELECT * FROM agama ORDER BY agama_id ASC LIMIT 5";
            $sql_agama = mysql_query($query_agama);
            if(mysql_num_rows($sql_agama) == 0){
                echo '<tr><td>Blank...!</td></tr>';
            }else{
                while($data = mysql_fetch_assoc($sql_agama)){ 
            ?>
                <tr>
                    <td>
                        <span class="date"><?php echo $data['agama_id']; ?></span>
                    </td>
                    <td>
                        <?php echo $data['agama_nama']; ?>
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

</div>

<?php include('inc/footer.php'); ?>
