<?php
function select(){
  $query = mysql_query("SELECT a.*, b.*, sum(e.retur) as total_retur, e.*, d.*, SUM(a.retur_total_price) AS tot_price FROM retur_pembelian a
                        JOIN purchases b ON b.purchases_id = a.purchase_id
                        JOIN retur_pembelian_details c ON c.retur_id = a.retur_id
                        JOIN purchases_details e ON e.purchase_detail_id = c.purchase_detail_id
                        LEFT JOIN suppliers d ON d.supplier_id = b.supplier_id
                        GROUP BY a.purchase_id");
  return $query;
}

function select_retur($id){
  $query = mysql_query("SELECT a.*, b.*, c.*, d.*,f.*, g.*,e.* FROM retur_pembelian a
                        JOIN purchases b ON b.purchases_id = a.purchase_id
                        JOIN retur_pembelian_details c ON c.retur_id = a.retur_id
                        JOIN purchases_details e ON e.purchase_detail_id = c.purchase_detail_id
                        LEFT JOIN suppliers d ON d.supplier_id = b.supplier_id
                        JOIN items f ON f.item_id = e.item_id
                        JOIN units g on g.unit_id = f.unit_id
                        WHERE a.purchase_id = '".$id."'");
  return $query;
}
 ?>
