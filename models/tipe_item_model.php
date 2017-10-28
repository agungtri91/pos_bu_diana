<?php
function select(){
  $query = mysql_query("SELECT * FROM items_types");
  return $query;
}
function read_id($id){
  $query = mysql_query("select a.*, b.* from items_types a
                        left join type_diskon_pembeli b on b.type_item = a.item_type_id
                        where item_type_id = '$id'");
  $result = mysql_fetch_object($query);
  return $result;
}

function create_type_item($data){
  mysql_query("insert into items_types values(".$data.")");
  }

function delete($id){
	mysql_query("delete from items_types where item_type_id = '$id'");
  $query=mysql_query("SELECT * FROM type_diskon_pembeli WHERE type_item = '$id'");
  while ($row = mysql_fetch_array($query)) {
    mysql_query("delete from type_diskon_pembeli where type_item = '$id'");
  }
}

function update_type_item($data, $id){
  mysql_query("update items_types set ".$data." where item_type_id = '$id'");
}

function get_type_pembeli(){
  $query = mysql_query("SELECT * FROM type_pembeli");
  return $query;
}

function get_type_item(){
  $query=mysql_query("SELECT max(item_type_id) as result  from items_types");
  $row=mysql_fetch_array($query);
  return $row['result'];
}

function create_type_pembeli_diskon($data){
  mysql_query("insert into type_diskon_pembeli values(".$data.")");
}

function update_diskon_pembeli($data_diskon,$id,$type_id_pembeli){
  $query=mysql_query("SELECT count(*) as result from type_diskon_pembeli where type_id_pembeli = $type_id_pembeli and type_item = $id");
  $row=mysql_fetch_array($query);
  if($row['result'] > 0){
      mysql_query("UPDATE type_diskon_pembeli SET $data_diskon WHERE type_item = $id AND type_id_pembeli = $type_id_pembeli");
  }else {
      mysql_query("insert into type_diskon_pembeli values('',$type_id_pembeli,$id,$data_diskon)");
  }
}

function read_diskon($id,$r_type_pembeli){
  $query=mysql_query("SELECT * from type_diskon_pembeli WHERE type_id_pembeli = $r_type_pembeli AND type_item = $id");
  $result = mysql_fetch_object($query);
  return $result;
}

?>
