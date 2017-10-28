<?php
  function select(){
    $query = mysql_query("SELECT a.*, b.*, SUM(e.retur) AS total_retur, SUM(a.retur_total_price) AS tot_price, d.* FROM retur a
                          JOIN transactions b ON b.transaction_id = a.transaction_id
                          JOIN retur_details c ON c.retur_id = a.retur_id
                          JOIN transaction_details e ON e.transaction_detail_id = c.transaction_detail_id
                          LEFT JOIN members d ON d.member_id = b.member_id
                          GROUP BY a.transaction_id
                          ");
    return $query;
  }

  function select_retur($id){
    $query = mysql_query("SELECT a.*, b.*, c.*, d.*,e.*, g.unit_name, f.item_name FROM retur a
                          JOIN transactions b ON b.transaction_id = a.transaction_id
                          JOIN retur_details c ON c.retur_id = a.retur_id
                          JOIN transaction_details e ON e.transaction_detail_id = c.transaction_detail_id
                          JOIN items f ON f.item_id = e.item_id
                          JOIN units g on g.unit_id = f.unit_id
                          LEFT JOIN members d ON d.member_id = b.member_id
                          WHERE a.transaction_id = '".$id."'
                          ");
    return $query;
  }
  function select_item_purchase($id){
    $query = mysql_query("SELECT a.*, b.*, b.purchase_price as harga_item, b.purchase_total as harga_item_total,
                          b.unit_id as unit_id_beli, c.*, e.unit_name AS unit_name_beli FROM purchases a
                          LEFT JOIN purchases_details b ON b.purchase_id  = a.purchases_id
                          LEFT JOIN suppliers c ON c.supplier_id = a.supplier_id
                          LEFT JOIN items d ON d.item_id = b.item_id
                          LEFT JOIN units e ON e.unit_id = d.unit_id
                          WHERE a.purchases_id = '$id'");
    return $query;
  }
  // function select_member
 ?>
