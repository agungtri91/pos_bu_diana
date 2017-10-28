<?php
function select_transaction($where){
  						$query = mysql_query("SELECT b.*, c.user_name, e.member_name, g.user_name as user_hapus, f.branch_name
  														from hapus_transactions b
  														left JOIN users c on c.user_id = b.user_id
                              left JOIN users g on g.user_id = b.user_id_hapus
  														left JOIN branches d on d.branch_id = b.branch_id
  														LEFT JOIN members e on e.member_id = b.member_id
  														LEFT JOIN branches f on f.branch_id = b.branch_id
  														$where
  														order by b.transaction_id
  											");
  	return $query;
}


function select_detail_transaction($id,$branch_id){
	$query = mysql_query("SELECT a.*, b.*, c.* FROM hapus_transactions a
												LEFT JOIN hapus_transaction_details b on b.transaction_id = a.transaction_id
												LEFT JOIN items c on c.item_id = b.item_id
												WHERE a.transaction_code = '$id' AND a.branch_id = '$branch_id'");
  return $query;
}

function get_transaction_total($id,$branch_id){
	$query = mysql_query("SELECT a.total_all FROM hapus_transactions a
												WHERE a.transaction_code = '$id' AND a.branch_id = '$branch_id'");
	$row = mysql_fetch_array($query);
	$result = $row['total_all'];
	return $result;
}


function select_purchase($where){
						$query = mysql_query("SELECT b.*, c.user_name, d.purchase_total, e.supplier_name, g.user_name as user_hapus,f.branch_name
                                  FROM hapus_purchase b
                                  JOIN users c ON c.user_id = b.user_id
                                  LEFT JOIN hapus_purchase_details d ON d.purchase_id = b.purchases_id
                                  LEFT JOIN branches f ON f.branch_id = b.branch_id
                                  LEFT JOIN suppliers e ON e.supplier_id = b.supplier_id
                                  left JOIN users g on g.user_id = b.user_id_hapus
																	$where
																	GROUP BY b.purchases_id order by b.purchases_id
											");
	return $query;
}

function select_detail_purchases($id,$branch_id){
	$query = mysql_query("SELECT a.*, b.*, c.* FROM hapus_purchase a
												LEFT JOIN hapus_purchase_details b on b.purchase_id = a.purchases_id
												LEFT JOIN items c on c.item_id = b.item_id
												WHERE a.purchases_code = '$id' AND a.branch_id = '$branch_id'");
  return $query;
}

function get_purchase_total($id,$branch_id){
	$query = mysql_query("SELECT a.purchase_total FROM hapus_purchase a
												WHERE a.purchases_code = '$id' AND a.branch_id = '$branch_id'");
	$row = mysql_fetch_array($query);
	$result = $row['purchase_total'];
	return $result;
}
 ?>
