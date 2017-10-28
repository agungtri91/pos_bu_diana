<?php

function get_jumlah_penjualan($date, $s_cabang){
	$query = mysql_query("SELECT count(transaction_id) as jumlah
							from transactions
							WHERE  transaction_date >= '$date 00:00:00'
							AND transaction_date <= '$date 23:59:59'
							and branch_id = '$s_cabang'
							 ");
	$result = mysql_fetch_object($query);
	return $result->jumlah;
}

function get_jumlah_pembelian($date, $s_cabang){
	$query = mysql_query("SELECT count(purchases_id) as jumlah
							from purchases
							WHERE  purchases_date >= '$date 00:00:00'
							AND purchases_date <= '$date 23:59:59'
							and branch_id = '".$s_cabang."'
							 ");
	$result = mysql_fetch_object($query);
	return $result->jumlah;
}

function get_total_omset($date,$s_cabang){
	$query = mysql_query("SELECT sum(journal_debit) as jumlah
							from journals
							WHERE  journal_date >= '$date 00:00:00'
							AND journal_date <= '$date 23:59:59'
							and branch_id = '".$s_cabang."'
							 ");
	$result = mysql_fetch_array($query);
	$result = ($result['jumlah']) ? $result['jumlah'] : "0";
	return $result;
}

function get_total_pengeluaran($date,$s_cabang){
	$query = mysql_query("SELECT sum(journal_credit) as jumlah
							from journals
							WHERE  journal_date >= '$date 00:00:00'
							AND journal_date <= '$date 23:59:59'
							and branch_id = '".$s_cabang."'
							 ");
	$result = mysql_fetch_array($query);
	$result = ($result['jumlah']) ? $result['jumlah'] : "0";
	return $result;
}

function get_item_terlaris($date, $s_cabang){
	$query = mysql_query("SELECT a.item_id, c.item_price, a.item_name, jumlah
								FROM items a
								JOIN item_harga c on c.item_id = a.item_id
								JOIN (
									SELECT sum( transaction_detail_qty ) AS jumlah, item_id
									FROM transaction_details a
									JOIN transactions b on b.transaction_id = a.transaction_id
									WHERE  b.transaction_date >= '$date 00:00:00'
									AND b.transaction_date <= '$date 23:59:59'
									and b.branch_id = '$s_cabang'
									GROUP BY item_id
								) AS b ON b.item_id = a.item_id
								order by jumlah desc, item_id asc
								limit 1

							 ");
	$result = mysql_fetch_array($query);
	$result = ($result['item_name']) ? $result['item_name'] : "-";
	return $result;
}

function select_top_food($date1, $date2, $s_cabang){
	$where_date1 = "";
	if($date1){
		$where_date1 = " AND  b.transaction_date >= '$date1 00:00:00' ";
	}
	$where_date2 = "";
	if($date2){
		$where_date2 = " AND b.transaction_date <= '$date2 23:59:59' ";
	}
	$query = mysql_query("SELECT a.item_id, a.item_name, jumlah
												FROM items a
												JOIN item_stocks b ON b.item_id = a.item_id
												JOIN (
													SELECT SUM( transaction_detail_qty ) AS jumlah, item_id
													FROM transaction_details a
													JOIN transactions b ON b.transaction_id = a.transaction_id
													WHERE transaction_detail_id <> 0
													$where_date1
													$where_date2
													and b.branch_id = '$s_cabang'
													GROUP BY item_id
													)AS c ON c.item_id = a.item_id
													ORDER BY jumlah DESC, item_id ASC
							 ");
	return $query;
}

function select_history(){
	$where_branch = "";
		if($_SESSION['user_type_id']==1 || $_SESSION['user_type_id']==2){
			$where_branch = "";
		}else{
			$where_branch = " where b.branch_id = '".$_SESSION['branch_id']."' ";
		}

	$query = mysql_query("SELECT b.*, c.table_name, d.building_name , e.branch_name, f.user_name
												FROM transactions b
												LEFT JOIN TABLES c ON c.table_id = b.table_id
												LEFT JOIN buildings d ON d.building_id = c.building_id
												JOIN branches e ON e.branch_id = d.branch_id
												LEFT JOIN users f ON f.user_id = b.user_id
												ORDER BY transaction_id
						");
	return $query;
}

function select_transaction($where){
	$query = mysql_query("SELECT a.transaction_date, SUM(a.total_all) AS transaction_total,
												SUM(b.purchase_total) AS purchase_total
												FROM transactions a
												LEFT JOIN purchases b ON DATE(a.transaction_date) = DATE(b.purchases_date)
												WHERE a.transaction_date BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()
												OR b.purchases_date BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()
												GROUP BY DATE(a.transaction_date)
												");
	return $query;
}

function select_item_penjualan($id){
	$query = mysql_query("SELECT COUNT(a.transaction_detail_id) AS total_penjualan,
												DATE(b.transaction_date) as tanggal,
												COUNT(d.purchase_detail_id) AS total_pembelian, c.item_name
												FROM transaction_details a
												LEFT JOIN transactions b ON b.transaction_id = a.transaction_id
												LEFT JOIN items c ON c.item_id = a.item_id
												LEFT JOIN purchases_details d ON d.item_id = a.item_id
												LEFT JOIN purchases e ON e.purchases_id = d.purchase_id
												WHERE c.item_id = '$id' OR b.transaction_date BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()
												OR e.purchases_date BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()
												GROUP BY DATE(b.transaction_date)");
	return $query;
}

// rabu 8-1-2017
function select_kredit_telat($branch_id){
	$query = mysql_query("SELECT a.*, b.member_name FROM kredit a
												LEFT JOIN members b on b.member_id = a.member_id
												LEFT JOIN transactions c on c.transaction_id = a.transaction_id
												WHERE branch_id = '$branch_id'
												AND a.pembayaran_per_tanggal_2 < Date(now())
												");
	return $query;
}
?>
