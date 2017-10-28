<?php
function get_jenis_denda($id){
  $query = mysql_query("SELECT periode_name as result FROM periode where periode_id = '$id'");
  $row = mysql_fetch_array($query);
  $result = $row['result'];
  return $result;
}
 ?>
