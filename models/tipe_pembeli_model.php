<?php

function select($s_cabang){
  $query=mysql_query("SELECT * FROM type_pembeli where branch_id = '$s_cabang' order by type_pembeli_name asc");
  return $query;
}
function read_id($id,$branch_id){
  $query = mysql_query("SELECT * FROM type_pembeli
                        where type_id_pembeli = '$id' and branch_id = '$branch_id'");
  $result = mysql_fetch_object($query);
  return $result;
}

function create_type_pembeli($data){
  mysql_query("insert into type_pembeli values(".$data.")");
  return mysql_insert_id();
}

function update_tipe_pembeli($data,$id,$branch_id){
  mysql_query("update type_pembeli set ".$data." where type_id_pembeli = '$id' and branch_id='$branch_id'");
}

function delete($id,$branch_id){
  $query = mysql_query("SELECT * FROM tipe_pembeli_diskon WHERE tipe_pembeli = '$id'");
  while ($row = mysql_fetch_array($query)) {
    mysql_query("delete from tipe_pembeli_diskon where tipe_pembeli = '$id'");
  }
	mysql_query("delete from type_pembeli where type_id_pembeli = '$id' and branch_id='$branch_id'");
}
function select_baru($data_baru){
  $query = mysql_query("SELECT type_pembeli_name as result FROM type_pembeli WHERE type_pembeli_name ='$data_baru'");
  return $query;
}
function select_diskon($id){
  $query = mysql_query("SELECT a.*, b.kategori_name FROM tipe_pembeli_diskon a
                        LEFT JOIN kategori b on b.kategori_id = a.kategori_item
                        WHERE tipe_pembeli = '$id'");
  return $query;
}

function read_tipe_item_diskon($tipe_pembeli_diskon_id){
  $query = mysql_query("SELECT * FROM tipe_pembeli_diskon
                        WHERE tipe_pembeli_diskon_id = '$tipe_pembeli_diskon_id'");
  $result = mysql_fetch_object($query);
  return $result;
}

function select_tipe_item(){
  $query = mysql_query("SELECT * FROM kategori");
  return $query;
}
function update_diskon($data,$kategori,$id){
    mysql_query("update tipe_pembeli_diskon set ".$data." where tipe_pembeli_diskon_id = '$id'
                 and kategori_item='$kategori'");
}

function select_diskon_brlk(){
  $query = mysql_query("SELECT * FROM tipe_diskon");
  return $query;
}
 ?>
