<?php
function select_tingkat(){
  $query = mysql_query("SELECT * FROM tingkat ORDER BY tingkat_id");
  return $query;
}


function select_satuan(){
  $query = mysql_query("SELECT * FROM units ORDER BY unit_name ASC");
  return $query;
}

function read_id($id){
	$query = mysql_query("select *
			from units
			where unit_id = '$id'");
	$result = mysql_fetch_object($query);
	return $result;
}
function read_tingkat_id($id){
  $query = mysql_query("select *
			from tingkat
			where tingkat_id = '$id'");
	$result = mysql_fetch_object($query);
	return $result;
}

function delete_satuan($id){
  mysql_query("delete from units where unit_id = '$id'");
}

function delete_tingkat($id){
  mysql_query("delete from tingkat where tingkat_id = '$id'");
}

function update_satuan($id,$data){
  mysql_query("update units set ".$data." where unit_id = '$id'");
}

function update_tingkat($id,$data){
  mysql_query("update tingkat set ".$data." where tingkat_id = '$id'");
}

function select_satuan_baru($satuan_baru){
  $query = mysql_query("SELECT unit_name FROM units WHERE unit_name ='$satuan_baru'");
  return $query;
}

function select_tingkat_baru($satuan_baru){
  $query = mysql_query("SELECT tingkat_name FROM tingkat WHERE tingkat_name ='$satuan_baru'");
  return $query;
}
 ?>
