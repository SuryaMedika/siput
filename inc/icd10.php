<?php

include('config.php');
 
$q = $_POST['q'];
 
$sql = mysql_query("select kode as id, indonesia as text from kode_icd10 where kode like '%".$q."%' or indonesia like '%".$q."%'");
$num = mysql_num_rows($sql);
if($num > 0){
	while($data = mysql_fetch_assoc($sql)){
		$tmp[] = $data;
	}
} else $tmp = array();
 
echo json_encode($tmp);

?>
