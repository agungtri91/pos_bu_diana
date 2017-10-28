<?php
function select(){
  $query = mysql_query("SELECT * FROM kategori");
  return $query;
}


function read_id($id){
  $query = mysql_query("SELECT * from kategori WHERE kategori_id = '$id'");
  $result = mysql_fetch_object($query);
  return $result;
}

function create_kategori($data){
  mysql_query("insert into kategori values(".$data.")");
  }

function delete($id){
    $query = mysql_query("SELECT * from sub_kategori WHERE kategori_utama_id = '$id'");
    while ($row = mysql_fetch_array($query)) {
      mysql_query("delete from sub_kategori where kategori_utama_id = '$id'");
    }
    mysql_query("delete from kategori where kategori_id = '$id'");
}

function update_kategori($data, $id){
  mysql_query("update kategori set ".$data." where kategori_id = '$id'");
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

function select_sub_kategori($id){
  $query = mysql_query("SELECT * from sub_kategori WHERE kategori_utama_id = '$id'");
  return $query;
}

function read_id_kategori($id){
  $query = mysql_query("SELECT * from sub_kategori WHERE kategori_utama_id = '$id'");
  $result = mysql_fetch_object($query);
  return $result;
}

function read_id_sub_kategori($id){
  $query = mysql_query("SELECT * from sub_kategori WHERE sub_kategori_id = '$id'");
  $result = mysql_fetch_object($query);
  return $result;
}

function delete_sub_kategori($id){
    mysql_query("delete from sub_kategori where sub_kategori_id = '$id'");
}

function update_sub_kategori($data, $id){
  mysql_query("update sub_kategori set ".$data." where sub_kategori_id = '$id'");
}
?>
