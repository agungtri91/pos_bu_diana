<?php
function select(){
  $query = mysql_query("SELECT a.*, b.* FROM stock_retur_penjualan a
                        LEFT JOIN items b on b.item_id = a.item_id
                      ");
  return $query;
}

  function select_item_retur_detail($id){
    $query = mysql_query("SELECT a.*, b.transaction_code, c.member_name, d.unit_name FROM stock_retur_details_penjualan a
                          LEFT JOIN transactions b on b.transaction_id = a.transaction_id
                          LEFT JOIN members c on c.member_id = a.member_id
                          LEFT JOIN units d on d.unit_id = a.unit_id
                          WHERE a.item_id = '$id'");
    return $query;
  }

 ?>
