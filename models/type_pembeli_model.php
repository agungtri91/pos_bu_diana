<?php

function select(){
  $query=mysql_query("SELECT * FROM type_pembeli");
  return $query;
}
function read_id($id){
  $query = mysql_query("SELECT * FROM type_pembeli
                        where type_id_pembeli = '$id'");
  $result = mysql_fetch_object($query);
  return $result;
}

function create_type_pembeli($data){
  mysql_query("insert into type_pembeli values(".$data.")");
}

function update_type_pembeli($data,$id){
  mysql_query("update type_pembeli set ".$data." where type_id_pembeli = ".$id);
}
 ?>
