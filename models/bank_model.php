<?php
function select(){
  $query = mysql_query("select * from banks");
  return $query;
}

function read_id($id){
  $query = mysql_query("select * from banks where bank_id = '$id'");
  $result = mysql_fetch_object($query);
	return $result;
}
function create_data($data){
  mysql_query("insert into banks values(".$data.")");
}

function delete($id){
  mysql_query("delete from banks where bank_id = '$id'");
}

function update($data, $id){
  mysql_query("update banks set ".$data." where bank_id = '$id'");
}

 ?>
