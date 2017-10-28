<?php

function select($param){
	$where = "";
	$query = mysql_query("select * from items $where order by item_id");
	return $query;
}

function select_widget($user_id, $transaction_id){
	$query = mysql_query("SELECT *, SUM(jumlah) AS jml_real_tiap_item, SUM(jumlah_konversi) AS jml_tiap_item  FROM widget_tmp
												WHERE transaction_id = '$transaction_id' GROUP BY stock_id");
	return $query;
}

function select_tipe_pembeli($where){
	$query = mysql_query("SELECT * FROM type_pembeli $where");
	return $query;
}

function select_cat($param){
	$where = "";
	$query = mysql_query("select * from menu_types $where order by menu_type_id");
	return $query;
}

function get_stock_tmp($id,$item_id){
	$query = mysql_query("SELECT SUM(a.jumlah) AS result
												FROM widget_tmp a WHERE a.transaction_id = '".$id."' and stock_id = '".$item_id."'");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function select_history($transaction_id){
	$query = mysql_query("select b.*, c.menu_name
												FROM transaction_tmp_details b
												JOIN menus c ON c.menu_id = b.menu_id
												WHERE transaction_id = '".$transaction_id."'
												ORDER BY transaction_detail_id");
						return $query;
}

function select_menu($keyword){
	$query = mysql_query("select * from menus where menu_name like '%$keyword%' order by menu_id");
	$row = mysql_fetch_array($query);
	return $row['menu_id'];
}

function delete_history($id){
	mysql_query("delete from transaction_tmp_details  where transaction_detail_id = '$id'");
}

function check_transaction_id($transaction_id){
	$query = mysql_query("select count(*) as jumlah
							  from transactions_tmp
							  where transaction_id = '".$transaction_id."'
							  ");
	$row = mysql_fetch_array($query);
	$jumlah = $row['jumlah'];
	return $jumlah;
}

function check_member_id($id){
	$query = mysql_query("select count(*) as jumlah
							  from piutang2
							  where member_id = '".$id."'
							  ");
	$row = mysql_fetch_array($query);
	$jumlah = $row['jumlah'];
	return $jumlah;
}

function update_member_id($data, $member_id){
	mysql_query("update piutang2 set total_piutang = total_piutang + '$data' where member_id = '$member_id'");
}

function get_transaction_id_old($transaction_id){
	$query = mysql_query("select transaction_id
							  from transactions_tmp
							  where transaction_id = '".$transaction_id."'
							  ");
	$row = mysql_fetch_array($query);
	return $row['transaction_id'];
}

function get_note_desc($wt_id){
	$query = mysql_query("select wt_desc
							  from widget_tmp
							  where wt_id = '".$wt_id."'
							  ");
	$row = mysql_fetch_array($query);

	return $row['wt_desc'];

}

function get_note_active($note_id, $wt_id){
	$query = mysql_query("select count(wt_id) as result
							  from widget_tmp_details
							  where wt_id = '".$wt_id."' and note_id  = '$note_id'
							  ");
	$row = mysql_fetch_array($query);


	return ($row['result']) ? $row['result'] : 0;

}

function get_link_active($note_id, $wt_id){
	$query = mysql_query("select wtd_id as result
							  from widget_tmp_details
							  where wt_id = '".$wt_id."' and note_id  = '$note_id'
							  ");
	$row = mysql_fetch_array($query);


	return $row['result'];

}

function check_history($transaction_id, $menu_id){
	$query = mysql_query("select count(b.transaction_detail_id) as jumlah
							  from transaction_tmp_details where transaction_id = '".$transaction_id."'
							  ");
	$row = mysql_fetch_array($query);
	$jumlah = $row['jumlah'];
	return $jumlah;
}

function get_data_history($transaction_id, $menu_id){
	$query = mysql_query("select b.*
							  from transaction_tmp_details where transaction_id = '".$transaction_id."' and menu_id = '$transaction_id'
							  ");
	return $query;
}

function delete_reserved($transaction_id){
	mysql_query("delete from reserved where transaction_id = '$transaction_id'
							  ");
}

function get_widget($menu_id, $transaction_id){
	$query = mysql_query("select count(menu_id) as jumlah
							from widget_tmp
							where menu_id = '".$menu_id."'
							and transaction_id = '$transaction_id'
							  ");
	$row = mysql_fetch_array($query);

	$jumlah = ($row['jumlah']) ? $row['jumlah'] : 0;
	return $jumlah;
}

function get_jumlah($menu_id, $transaction_id){
	$query = mysql_query("select (jumlah) as jumlah
							from widget_tmp
							where menu_id = '".$menu_id."'
							and transaction_id = '$transaction_id'
							  ");
	$row = mysql_fetch_array($query);

	$jumlah = ($row['jumlah']) ? $row['jumlah'] : 0;
	return $jumlah;
}


function get_all_jumlah($transaction_id){
	$query = mysql_query("SELECT SUM(jumlah * b.item_price) AS total
												FROM widget_tmp a
												JOIN item_harga b ON b.item_id = a.stock_id
												WHERE transaction_id = '$transaction_id'
							  ");
	$row = mysql_fetch_array($query);

	$jumlah = ($row['total']) ? $row['total'] : 0;
	return $jumlah;
}

function get_all_item($transaction_id){
	$query = mysql_query("select count(*) as total
							from widget_tmp a
							where transaction_id = '$transaction_id'
							  ");
	$row = mysql_fetch_array($query);

	$jumlah = ($row['total']) ? $row['total'] : 0;
	return $jumlah;
}

// function get_item_name($item_id){
// 	$query = mysql_query("select item_name as result
// 												from items
// 												where item_id = '".$item_id."'
// 							  			");
// 	$row = mysql_fetch_array($query);
// 	return $row['result'];
// }

function get_item_price($item_id){
	$query = mysql_query("select item_price as result
							from item_harga
							where item_id = '".$item_id."'
							  ");
	$row = mysql_fetch_array($query);

	return $row['result'];

}

function get_menu_name_widget($wt_id){
	$query = mysql_query("select menu_name as result
							from widget_tmp a
							join menus b on b.menu_id = a.menu_id
							where wt_id = '".$wt_id."'
							  ");
	$row = mysql_fetch_array($query);

	return $row['result'];

}

function get_jumlah_widget($wt_id){
	$query = mysql_query("select jumlah as result
							from widget_tmp a
							where wt_id = '".$wt_id."'
							  ");
	$row = mysql_fetch_array($query);

	return $row['result'];

}

function get_data_total($transaction_id){
	 $query = mysql_query("select sum(transaction_detail_total) as total
							  from transactions_tmp a
							  join transaction_tmp_details b on b.transaction_id = a.transaction_id
							  where a.transaction_id = '".$transaction_id."'");
	$row = mysql_fetch_array($query);

	return $row['total'];
}

function get_total_discount($id){
	 $query = mysql_query("SELECT SUM(transaction_detail_nominal_discount) AS total_diskon_nominal,
												 SUM(transaction_detail_original_price * transaction_detail_qty * transaction_detail_persen_discount / 100)
												 AS total_diskon_persen FROM transactions a
												 JOIN transaction_details b ON b.transaction_id = a.transaction_id
												 WHERE a.transaction_id = '$id'");
	$row = mysql_fetch_array($query);
	$result = $row['total_diskon_nominal'] + $row['total_diskon_persen'];
	return $result;
}

function update_settlement($data, $member_id){
	mysql_query("update members set member_settlement = member_settlement + '$data' where member_id = '$member_id'");
}

function create_journal($data_id, $data_url, $journal_type_id, $i_payment_method, $journal_debit,
												$i_bank_id, $i_bank_account, $i_bank_id_to, $i_bank_account_to, $s_cabang){
	mysql_query("insert into journals values(
				'',
				'$journal_type_id',
				'".time()."',
				'$data_url',
				'$journal_debit',
				'0',
				'0',
				'0',
				'',
				'".date("Y-m-d")."',
				'$i_payment_method',
				'$i_bank_id',
				'$i_bank_account',
				'$i_bank_id_to',
				'$i_bank_account_to',
				'".$_SESSION['user_id']."',
				'$s_cabang'
	)");
}

function create_journal2($data_id, $data_url, $journal_type_id, $i_payment_method, $journal_debit,
												 $journal_piutang, $i_bank_id, $i_bank_account, $i_bank_id_to, $i_bank_account_to,$s_cabang){
	mysql_query("insert into journals values(
				'',
				'$journal_type_id',
				'".time()."',
				'$data_url',
				'$journal_debit',
				'0',
				'$journal_piutang',
				'0',
				'',
				'".date("Y-m-d")."',
				'$i_payment_method',
				'$i_bank_id',
				'$i_bank_account',
				'$i_bank_id_to',
				'$i_bank_account_to',
				'".$_SESSION['user_id']."',
				'$s_cabang'
	)");
}

function delete_tmp($transaction_id){
		$query =  mysql_query("select *
								from transactions_tmp a
								where a.transaction_id = '$transaction_id'
								");
		while($row = mysql_fetch_array($query)){
			mysql_query("delete from transaction_tmp_details where transaction_id = '".$row['transaction_id']."'");
		}
		mysql_query("delete from transactions_tmp where transaction_id = '$transaction_id'");
}

	function delete_widget_tmp($transaction_id){
		mysql_query("delete from widget_tmp where transaction_id = '$transaction_id'");
	}

	function delete_widget_tmp_details($transaction_id){
		$wt_id= mysql_query("select * from widget_tmp where transaction_id = '$transaction_id'");
		while($r_widget_detail = mysql_fetch_array($wt_id)){
				mysql_query("delete from widget_tmp_details where wt_id = '".$r_widget_detail['wt_id']."'");
		}
	}

	function get_discount_type($member_id){
	$query = mysql_query("select member_discount_type from members where member_id = '$member_id'");
	$row = mysql_fetch_array($query);
	$result = ($row['member_discount_type']);
	return $result;
	}

	function update_stock($item_id, $qty, $branch_id){
		mysql_query("update item_stocks set item_stock_qty = item_stock_qty - $qty
								 where item_id = '$item_id' and branch_id = '$branch_id'");
	}

function get_bank_account($id){
	$query = mysql_query("select bank_account_number from banks where bank_id = '$id'");
	$row = mysql_fetch_array($query);
	$result = ($row['bank_account_number']);
	return $result;
}

function get_item_stock_now($id,$branch_id){
	$query = mysql_query("select item_stock_qty from item_stocks where item_id = '$id' and branch_id = '$branch_id'");
	$row = mysql_fetch_array($query);
	$result = ($row['item_stock_qty']);
	return $result;
}

function get_item_detail($id){
$query = mysql_query("SELECT a.*, b.* FROM items a
											LEFT JOIN item_details b ON b.item_id = a.item_id
											WHERE a.item_id = '$id'");
	return $query;
}

function select_item($id,$branch_id){
	$query = mysql_query("SELECT a.*,b.*, c.item_original_price, c.item_hpp_price,
												c.item_margin_price, c.item_price  FROM item_stocks a
												JOIN items b ON b.item_id = a.item_id
												left JOIN item_harga c ON c.item_id = b.item_id
												WHERE b.sub_kategori_id = '$id'
												AND a.branch_id = '$branch_id'
												ORDER BY a.item_id
											");
	return $query;
}

function select_item_2($id,$branch_id){
	$query = mysql_query("SELECT a.*,b.*,  c.item_original_price, c.item_hpp_price,
												c.item_margin_price, c.item_price FROM item_stocks a
												JOIN items b ON b.item_id = a.item_id
												left JOIN item_harga c ON c.item_id = b.item_id
												WHERE b.kategori_id = '$id'
												AND a.branch_id = '$branch_id'
												ORDER BY a.item_id
											");
	return $query;
}

function select_satuan_item($id){
	$query = mysql_query("SELECT a.* FROM units a
												JOIN unit_konversi b ON b.unit_konversi = a.unit_id
												WHERE b.item_id = '$id'");
	return $query;
}
function get_stock_dari_satuan($i_unit,$item_id){
	$query = mysql_query("SELECT  FROM");
}

function get_sisa_satuan_utama($i_unit,$item_id,$qty,$qty_beta){
	$query = mysql_query("SELECT * FROM unit_konversi WHERE item_id = '$item_id' and unit_konversi = '$i_unit'");
	$row = mysql_fetch_array($query);
	if ($row['unit_konversi_jml'] < $row['unit_jml']) {
			$qty_beta = $qty_beta * $row['unit_jml'];
			$qty = $qty * $row['unit_jml'];
			$qty = $qty_beta - $qty;
	}else {
		$qty_beta = $qty_beta / $row['unit_konversi_jml'];
		$qty = $qty / $row['unit_konversi_jml'];
		$qty = $qty_beta - $qty;
	}
	return $qty;
}

function get_unit_utama_name($id){
	$query = mysql_query("SELECT b.unit_name as result from items a
												LEFT JOIN units b on b.unit_id = a.unit_id
												WHERE a.item_id = '$id'");
	$row = mysql_fetch_array($query);
	$result = $row['result'];
	return $result;
}

function get_unit_utama_id($id){
	$query = mysql_query("SELECT a.unit_id as result from items a
												WHERE a.item_id = '$id'");
	$row = mysql_fetch_array($query);
	$result = $row['result'];
	return $result;
}

function get_qty_asli($item_id,$i_unit,$i_qty){
	$qty = $i_qty;
	$query = mysql_query("SELECT * FROM unit_konversi WHERE item_id = '$item_id' and unit_konversi = '$i_unit'");
	if ($query == true) {
		$row = mysql_fetch_array($query);
		if ($row['unit_konversi_jml'] < $row['unit_jml']) {
			$qty = $qty * $row['unit_jml'];
		}else {
			$qty = $qty / $row['unit_konversi_jml'];
		}
	}
	return $qty;
}

function get_harga_konversi($i_unit, $item_id){
	$query = mysql_query("SELECT harga_konversi as result FROM unit_konversi WHERE item_id = '$item_id' AND  unit_konversi = '$i_unit'");
	$row = mysql_fetch_array($query);
	$result = $row['result'];
	return $result;
}

function get_harga($id){
	$query = mysql_query("SELECT item_price as result FROM item_harga WHERE item_id = '$id'");
	$row = mysql_fetch_array($query);
	$result = $row['result'];
	return $result;
}


function select_transaction_tmp($id){
	$query =  mysql_query("SELECT a.*, b.*, c.*
												 FROM transactions_tmp a
												 LEFT JOIN transaction_tmp_details b ON b.transaction_id = a.transaction_id
												 LEFT JOIN items c ON c.item_id = b.item_id
												 WHERE a.transaction_id = '$id'
							");
	return $query;
}

function select_member_1($id){
	$query = mysql_query("SELECT a.*,b FROM members a
												LEFT JOIN type_pembeli b ON b.type_id_pembeli = c.type_id_pembeli
												WHERE a.member_id = '$id'");
	return $query;
}

function select_all_stock($s_cabang){
	$query = mysql_query("SELECT a.*, c.item_original_price, c.item_hpp_price,
												c.item_margin_price, c.item_price FROM items a
												JOIN item_stocks b ON b.item_id = a.item_id
												LEFT JOIN item_harga c ON c.item_id = b.item_id
												WHERE b.branch_id = '$s_cabang'
												group by a.item_id
												order by a.item_id
												");
	return $query;
}

function select_same_word($word, $s_cabang){
	$query = mysql_query("SELECT a.*, c.* from items a
												JOIN item_stocks b ON a.item_id = b.item_id
												LEFT JOIN item_harga c ON c.item_id = b.item_id
												WHERE b.branch_id = '$s_cabang'
												AND a.item_name like '%$word%'
												group by a.item_id
												order by a.item_id
												");
	return $query;
}

function select_all_stock_2($s_cabang,$sql){
	$query = mysql_query("SELECT a.*, c.* from items a
												JOIN item_stocks b ON a.item_id = b.item_id
												LEFT JOIN item_harga c ON c.item_id = b.item_id
												WHERE b.branch_id = '$s_cabang'
												$sql
												group by a.item_id
												order by a.item_id
												");
	return $query;
}

function  select_diskon($id){
	$query = mysql_query("SELECT b.*, c.item_name, c.item_type, a.member_id, a.transaction_code, e.nilai_diskon,
												e.nominal_diskon
												FROM transaction_tmp_details b
												JOIN transactions_tmp a ON a.transaction_id = b.transaction_id
												JOIN items c ON c.item_id = b.item_id
												LEFT JOIN item_harga d ON d.item_id = b.item_id
												LEFT JOIN (
														SELECT a.member_id, a.member_name, a.tipe_pembeli, b.type_pembeli_name, c.nilai_diskon,
														c.nominal_diskon
														FROM members a
														LEFT JOIN type_pembeli b ON b.type_id_pembeli = a.tipe_pembeli
														LEFT JOIN tipe_pembeli_diskon c ON c.tipe_pembeli = a.tipe_pembeli
														LEFT JOIN transaction_tmp_details d ON d.kategori = c.kategori_item
														WHERE d.transaction_id = '$id'
													) AS e ON e.member_id = a.member_id
												WHERE a.transaction_id = '$id'");
	return $query;
}

function select_diskon_member($member_id,$kategori_id){
	$query = mysql_query("SELECT a.*, b.* FROM tipe_pembeli_diskon a
												JOIN kategori b ON b.kategori_id = a.kategori_item
												LEFT JOIN members c ON c.tipe_pembeli = a.tipe_pembeli
												WHERE c.member_id = '$member_id'
												AND a.kategori_item = '$kategori_id'");
	return $query;
}

function select_member($id){
	$query = mysql_query("SELECT a.*, b.*, c.* FROM members a
												LEFT JOIN type_pembeli b on b.type_id_pembeli = a.tipe_pembeli
												LEFT JOIN tipe_pembeli_diskon c on c.tipe_pembeli = a.tipe_pembeli
												where a.member_id = '$id'");
	return $query;
}

function select_trans_diskon($id,$kategori,$tipe_pembeli){
	$query = mysql_query("SELECT a.*, c.item_name, c.item_id, e.nilai_diskon, e.nominal_diskon FROM transactions_tmp a
												LEFT JOIN transaction_tmp_details b on b.transaction_id = a.transaction_id
												LEFT JOIN items c on c.item_id = b.item_id
												LEFT JOIN kategori d on d.kategori_id = c.kategori_id
												LEFT JOIN tipe_pembeli_diskon e on e.kategori_item = b.kategori
												WHERE a.transaction_id = '$id'
												AND e.tipe_pembeli = '$tipe_pembeli'
												AND e.kategori_item = '$kategori'
												");
	return $query;
}

function get_kategori($id){
	$query 	= mysql_query("SELECT kategori_id as result FROM items WHERE item_id = '$id'");
	$row 		= mysql_fetch_array($query);
	$result = $row['result'];
	return $result;
}

function get_tipe_pembeli($id){
	$query 	= mysql_query("SELECT tipe_pembeli as result FROM members WHERE member_id = '$id'");
	$row 		= mysql_fetch_array($query);
	$result = $row['result'];
	return $result;
}

function get_diskon_berlaku($id){
	$query 	= mysql_query("SELECT tipe_diskon_berlaku as result FROM type_pembeli WHERE type_id_pembeli = '$id'");
	$row 		= mysql_fetch_array($query);
	$result = $row['result'];
	return $result;
}

function select_widget_tranksasi($id){
	$query = mysql_query("SELECT a.*, b.item_name, b.item_type, c.item_price, d.item_type_name, b.unit_id,
											  e.unit_name, f.harga_konversi,
											  IF(f.harga_konversi != 0 && b.unit_id != e.unit_id, f.harga_konversi, c.item_price) AS harga
											  FROM widget_tmp a
											  JOIN items b ON b.item_id = a.stock_id
											  LEFT JOIN item_harga c ON c.item_id = b.item_id
											  LEFT JOIN items_types d ON d.item_type_id = b.item_type
											  LEFT JOIN units e ON e.unit_id = a.unit_id
											  LEFT JOIN unit_konversi f ON f.item_id = b.item_id
											  where transaction_id = '".$id."'
											  GROUP BY transaction_id, b.item_id
											  order by a.wt_id
											");
	return $query;
}

function select_validasi_transaction($id){
	$query = mysql_query("SELECT COUNT(*) as jml, transaction_detail_qty  FROM transaction_tmp_details
												WHERE transaction_id = '$id'");
	return $query;
}

function get_member_tanggungan($id){
	$query = mysql_query("SELECT COUNT(*) as result FROM kredit WHERE member_id = '$id' AND lunas = 1");
	$row 		= mysql_fetch_array($query);
	$result = $row['result'];
	return $result;
}

?>
