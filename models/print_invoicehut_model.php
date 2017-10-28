<?php
function get_hutang($id){
  mysql_query("SELECT a.*, b.*, c.*, d.* FROM hutang a
                      JOIN purchases b ON b.id_2 = a.purchase_id
                      JOIN items c ON c.item_id = b.item_id
                      JOIN  suppliers d ON d.supplier_id = b.supplier_id WHERE a.id_hutang = '".$id."' AND b.lunas = 1");
  return $query;
}
 ?>
