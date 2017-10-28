<?php

function select_detail($date1, $date2,$where){

	$query = mysql_query("SELECT a.item_id , d.item_price, a.item_name, b.jumlah, jumlah_dasar, jumlah_omset, c.branch_name
								FROM items a
								JOIN item_harga d on d.item_id = a.item_id
								JOIN (
									SELECT 	sum( transaction_detail_qty ) AS jumlah,
											sum( transaction_detail_qty * transaction_detail_original_price ) AS jumlah_dasar,
											sum( transaction_detail_qty * transaction_detail_price ) AS jumlah_omset,
											item_id, branch_id
									FROM transaction_details a
									JOIN transactions b on b.transaction_id = a.transaction_id
									WHERE  b.transaction_date >= '$date1'
									AND b.transaction_date <= '$date2'
									GROUP BY item_id
								) AS b ON b.item_id = a.item_id
								LEFT JOIN branches c on c.branch_id = b.branch_id
								order by b.jumlah desc
						");

	return $query;
}

function select_transaction($date1, $date2,$where){
						$query = mysql_query("SELECT b.*, c.user_name, e.member_name, f.branch_name
														from transactions b
														JOIN users c on c.user_id = b.user_id
														left JOIN branches d on d.branch_id = b.branch_id
														LEFT JOIN members e on e.member_id = b.member_id
														LEFT JOIN branches f on f.branch_id = b.branch_id
														WHERE  b.transaction_date >= '$date1'
														AND b.transaction_date <= '$date2'
														$where
														order by transaction_id
											");

	return $query;
}

function select_purchase($date1, $date2, $where){
						$query = mysql_query("SELECT b.*, c.user_name, d.purchase_total, e.supplier_name, f.branch_name
																	FROM purchases b
																	JOIN users c ON c.user_id = b.user_id
																	JOIN purchases_details d ON d.purchase_id = b.purchases_id
																	left JOIN branches f on f.branch_id = b.branch_id
																	left JOIN suppliers e on e.supplier_id = b.supplier_id
																	WHERE  b.purchases_date >= '$date1'
																	AND b.purchases_date <= '$date2'
																	$where
																	GROUP BY b.purchases_id order by b.purchases_id
											");
	return $query;
}

function select_retur_penjualan($date1, $date2,$s_cabang){
						$query = mysql_query("SELECT a.*, d.user_name from retur a
																	LEFT JOIN retur_details b on b.retur_id = a.retur_id
																	LEFT JOIN users d on d.user_id = a.user_id
																	WHERE  a.retur_date >= '$date1'
																	AND a.retur_date <= '$date2'
																	order by transaction_id
											");

	return $query;
}

function select_retur_pembelian($date1, $date2,$s_cabang){
	$query = mysql_query("SELECT b.*, c.user_name
									from retur_pembelian b
									JOIN users c on c.user_id = b.user_id
									WHERE  b.retur_date >= '$date1'
									AND b.retur_date <= '$date2'
									order by purchase_id
						");
	return $query;
}

function read_id($id){
	$query = mysql_query("SELECT a.*, b.unit_name, c.transaction_type_name
							FROM  transactions a
							left JOIN units b on a.unit_id = b.unit_id
							left JOIN transaction_types c on c.transaction_type_id = a.transaction_type_id
 							WHERE  a.transaction_id = '$id'");
	$result = mysql_fetch_object($query);
	return $result;
}

function get_jumlah_penjualan($date1, $date2, $s_cabang){
	$query = mysql_query("SELECT count(transaction_id) as jumlah
							from transactions
							WHERE  transaction_date >= '$date1'
							AND transaction_date <= '$date2'
							and branch_id = '".$s_cabang."'
							 ");
	$result = mysql_fetch_object($query);
	return $result->jumlah;
}

function get_total_penjualan($date1, $date2, $s_cabang){
	$query = mysql_query("SELECT sum(transaction_grand_total) as jumlah
							from transactions
							WHERE  transaction_date >= '$date1'
							AND transaction_date <= '$date2'
							and branch_id = '".$s_cabang."'
							 ");
	$result = mysql_fetch_array($query);
	$result = ($result['jumlah']) ? $result['jumlah'] : "0";
	return $result;
}

function get_jumlah_pembelian($date1, $date2, $s_cabang){
	$query = mysql_query("SELECT count(purchases_id) as jumlah
							from purchases
							WHERE  purchases_date >= '$date1'
							AND purchases_date <= '$date2'
							and branch_id = '".$s_cabang."'
							 ");
	$result = mysql_fetch_object($query);
	return $result->jumlah;
}

function get_total_pembelian($date1, $date2, $s_cabang){
	$query = mysql_query("SELECT sum(purchase_total) as jumlah
							from purchases
							WHERE purchases_date >= '$date1'
							AND purchases_date <= '$date2'
							and branch_id = '".$s_cabang."'
							 ");
	$result = mysql_fetch_array($query);
	$result = ($result['jumlah']) ? $result['jumlah'] : "0";
	return $result;
}

function get_menu_terlaris($date1, $date2, $s_cabang){
	$query = mysql_query("SELECT a.item_id, c.item_price, a.item_id, a.item_name, jumlah
												FROM items a
												JOIN item_harga c ON c.item_id = a.item_id
												JOIN (
													SELECT sum( transaction_detail_qty ) AS jumlah, item_id
													FROM transaction_details a
													JOIN transactions b on b.transaction_id = a.transaction_id
													WHERE  b.transaction_date >= '$date1 00:00:00'
													AND b.transaction_date <= '$date2 23:59:59'
													GROUP BY item_id
												) AS b ON b.item_id = a.item_id
												order by jumlah desc, item_id asc
												limit 1");
	$result = mysql_fetch_array($query);
	$result = ($result['item_name']) ? $result['item_name'] : "-";
	return $result;
}

function select_partner($date1, $date2){
	$query = mysql_query("SELECT a.partner_id, a.partner_name, jumlah_qty, jumlah_margin, jumlah_original, jumlah_omset
								FROM partners a
								JOIN (

									SELECT sum(transaction_detail_qty) as jumlah_qty,
											sum(transaction_detail_qty * transaction_detail_margin_price ) AS jumlah_margin,
											sum(transaction_detail_qty * transaction_detail_original_price ) AS jumlah_original,
											sum(transaction_detail_qty * transaction_detail_price ) AS jumlah_omset,
											partner_id
									FROM transaction_details a
									JOIN transactions b on b.transaction_id = a.transaction_id
									JOIN menus c on c.menu_id = a.menu_id
									WHERE  b.transaction_date >= '$date1 00:00:00'
									AND b.transaction_date <= '$date2 23:59:59'
									AND partner_id <> 1
									GROUP BY partner_id
								) AS b ON b.partner_id = a.partner_id


								");

	return $query;
}


function get_total_dasar($date1, $date2, $partner_id){
	$query = mysql_query("SELECT a.menu_id, a.menu_price, a.menu_name, jumlah
								FROM menus a
								JOIN (

									SELECT sum( transaction_detail_qty ) AS jumlah, menu_id
									FROM transaction_details a
									JOIN transactions b on b.transaction_id = a.transaction_id
									WHERE  b.transaction_date >= '$date1 00:00:00'
									AND b.transaction_date <= '$date2 23:59:59'
									GROUP BY menu_id
								) AS b ON b.menu_id = a.menu_id
								order by jumlah desc, menu_id asc
								limit 1

							 ");
	$result = mysql_fetch_array($query);
	$result = ($result['menu_name']) ? $result['menu_name'] : "-";
	return $result;
}

function get_cabang_name1($id){
	$query = mysql_query("select branch_name from branches where branch_id = '".$id."'");
	$result = mysql_fetch_array($query);
	$result = ($result['branch_name']) ? $result['branch_name'] : "-";
	return $result;
}

function select_detail_trans($id,$branch_id){
	$query = mysql_query("SELECT a.*, b.* FROM transactions a
												LEFT JOIN transaction_details b on b.transaction_id = a.transaction_id
												WHERE a.transaction_code = '$id' AND a.branch_id = '$branch_id'");
  return $query;
}
function select_detail_purchases($id,$branch_id){
	$query = mysql_query("SELECT a.*, b.*, c.*, a.purchase_total as p_tot, b.purchase_total as p_total, d.unit_name
		 										FROM purchases a
												LEFT JOIN purchases_details b on b.purchase_id = a.purchases_id
												LEFT JOIN items c on c.item_id = b.item_id
												LEFT JOIN units d on IF(b.unit_id != 0,d.unit_id = b.unit_id,d.unit_id = c.unit_id)
												WHERE a.purchases_code = '$id' AND a.branch_id = '$branch_id'");
  return $query;
}

function get_purchase_total($id,$branch_id){
	$query = mysql_query("SELECT a.purchase_total FROM purchases a
												LEFT JOIN purchases_details b on b.purchase_id = a.purchases_id
												WHERE a.purchases_code = '$id' AND a.branch_id = '$branch_id'");
	$row = mysql_fetch_array($query);
	$result = $row['purchase_total'];
	return $result;
}

function select_delete_purchase($id,$branch_id){
	$query = mysql_query("SELECT a.* FROM purchases a
												WHERE a.purchases_code = '$id' AND a.branch_id = '$branch_id'");
	return $query;
}

function select_delete_purchase_details($id,$branch_id){
		$query = mysql_query("SELECT b.* FROM purchases a
													LEFT JOIN purchases_details b on b.purchase_id = a.purchases_id
													WHERE a.purchases_code = '$id' AND a.branch_id = '$branch_id'");
		return $query;
}


function delete_purchase($id, $branch_id){
	$query=mysql_query("SELECT a.* FROM purchases a
											LEFT JOIN purchases_details b on b.purchase_id = a.purchases_id
											WHERE a.purchases_code = '$id' AND a.branch_id = '$branch_id' ");
	while ($row = mysql_fetch_array($query)) {
		mysql_query("delete from purchases_details where purchase_id = '".$row['purchases_id']."'");
	}
	mysql_query("delete from journals where data_id = '$id' and branch_id = '$branch_id'");
	mysql_query("delete from purchases where purchases_code = '$id' and branch_id = '$branch_id'");
}

function select_detail_transaction($id,$branch_id){
	$query = mysql_query("SELECT a.*, b.*, c.*, d.unit_name FROM transactions a
												LEFT JOIN transaction_details b on b.transaction_id = a.transaction_id
												LEFT JOIN items c on c.item_id = b.item_id
												LEFT JOIN units d on if(b.transaction_detail_unit != 0 ,d.unit_id = b.transaction_detail_unit, d.unit_id = c.unit_id )
												WHERE a.transaction_code = '$id' AND a.branch_id = '$branch_id'");
  return $query;
}

function get_transaction_total($id,$branch_id){
	$query = mysql_query("SELECT a.total_all FROM transactions a
												WHERE a.transaction_code = '$id' AND a.branch_id = '$branch_id'");
	$row = mysql_fetch_array($query);
	$result = $row['total_all'];
	return $result;
}

function select_delete_transaction($id,$branch_id){
		$query = mysql_query("SELECT a.* FROM transactions a
													LEFT JOIN transaction_details b on b.transaction_id = a.transaction_id
													WHERE a.transaction_code = '$id' AND a.branch_id = '$branch_id'");
		return $query;
}
function select_delete_transaction_details($id,$branch_id){
	$query = mysql_query("SELECT a.*,b.* FROM transactions a
												LEFT JOIN transaction_details b on b.transaction_id = a.transaction_id
												WHERE a.transaction_code = '$id' AND a.branch_id = '$branch_id'");
	return $query;
}

function delete_transaction($id, $branch_id){
	$query=mysql_query("SELECT a.* FROM transactions a
											LEFT JOIN transaction_details b on b.transaction_id = a.transaction_id
											WHERE a.transaction_code = '$id' AND a.branch_id = '$branch_id' ");
	while ($row = mysql_fetch_array($query)) {
		mysql_query("delete from transaction_details where transaction_id = '".$row['transaction_id']."'");
	}
	mysql_query("delete from journals where data_id = '$id' and branch_id = '$branch_id'");
	mysql_query("delete from transactions where transaction_code = '$id' and branch_id = '$branch_id'");
}

function update_stock($id ,$qty, $branch_id){
	mysql_query("update item_stocks set item_stock_qty = item_stock_qty - '$qty' WHERE item_id = '$id' and branch_id = '$branch_id'");
}


  function select_item_purchase($id){
    $query = mysql_query("SELECT a.*, b.*, b.purchase_price as harga_item, b.purchase_total as harga_item_total, b.unit_id as unit_id_beli, c.*, e.unit_name AS unit_name_beli FROM purchases a
                          LEFT JOIN purchases_details b ON b.purchase_id  = a.purchases_id
                          LEFT JOIN suppliers c ON c.supplier_id = a.supplier_id
                          LEFT JOIN items d ON d.item_id = b.item_id
                          LEFT JOIN units e ON e.unit_id = d.unit_id
                          WHERE a.purchases_id = '$id'");
    return $query;
  }

	function select_item_penjualan($id){
		$query = mysql_query("SELECT a.*, b.*, b.transaction_detail_price AS harga_item, b.transaction_detail_total AS harga_item_total,
													b.transaction_detail_unit AS unit_id_jual, c.*, e.unit_name AS unit_name_jual, f.unit_name as unit_name_jual FROM transactions a
													LEFT JOIN transaction_details b ON b.transaction_id  = a.transaction_id
													LEFT JOIN members c ON c.member_id = a.member_id
													LEFT JOIN items d ON d.item_id = b.item_id
													LEFT JOIN units e ON e.unit_id = b.transaction_detail_unit
													LEFT JOIN units f ON f.unit_id = d.unit_id
													WHERE a.transaction_id = '$id'");
		return $query;
	}
	function select_grafik_transaction($tanggal, $branch_id){
		$query = mysql_query("SELECT a.*, b.total_penjualan, b.total_pembelian  FROM bulan a
													LEFT JOIN (
															SELECT MONTH(a.transaction_date) as bulan_b, SUM(a.total_all) AS total_penjualan,
															SUM(b.purchase_total) AS total_pembelian FROM transactions a
															LEFT JOIN purchases b ON MONTH(b.purchases_date) = MONTH(a.transaction_date)
															WHERE a.branch_id = '$branch_id' AND b.branch_id = '$branch_id'
																															 AND YEAR(a.transaction_date) = YEAR('$tanggal')
																															 AND YEAR(b.purchases_date) = YEAR('$tanggal')
														) as b on bulan_b = a.bulan_id
													group by a.bulan_id
													");
		return $query;
	}
?>
