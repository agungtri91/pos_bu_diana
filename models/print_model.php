<?php
function select($transaction_id){
	$query = mysql_query("SELECT a.*, d.user_name, e.*, f.branch_name
												FROM transactions a
												LEFT JOIN users d ON d.user_id = a.user_id
												JOIN transaction_details e ON e.transaction_id = a.transaction_id
												LEFT JOIN branches f ON f.branch_id = a.branch_id
												WHERE a.transaction_id = '".$transaction_id."'");
	return $query;
}


function select_member($transaction_id){
	$query = mysql_query("SELECT a.member_id, b.* from transactions a
												JOIN members b on b.member_id = a.member_id
												WHERE a.transaction_id = '".$transaction_id."'");
	return $query;
}

function select_item($transaction){
	$query = mysql_query("select b.*, c.menu_name
							  from transactions a
							  join transaction_details b on b.transaction_id = a.transaction_id
							  join menus c on c.menu_id = b.menu_id
							  where a.transaction_id = '".$transaction."' AND c.menu_price !=0");
	return $query;
}

function select_purchases_supplier($id){
	$query = mysql_query("SELECT a.*,b.* from purchases a
												JOIN suppliers b on b.supplier_id = a.supplier_id
												WHERE a.purchases_id = '$id'
												");
	return $query;
}

function selectbydate($start, $end){
	$query = mysql_query("SELECT
								a.*, c.member_name, e.user_name
							FROM
								transactions a
							LEFT JOIN members c ON c.member_id = a.member_id
							left join users e on e.user_id = a.user_id
							WHERE
								transaction_date BETWEEN '$start'
							AND '$end'");
	return $query;
}
function selectitembydate($start, $end){
	$query = mysql_query("SELECT
							date(a.transaction_date) AS date,
							b.item_id,
							sum(b.transaction_detail_qty) AS qty,
							b.transaction_detail_original_price,
							c.item_name
						FROM
							transactions a
						LEFT JOIN transaction_details b ON b.transaction_id = a.transaction_id
						LEFT JOIN items c ON c.item_id = b.item_id
						WHERE
							transaction_date BETWEEN '$start'
						AND '$end'
						GROUP BY
							date,
							item_id
						ORDER BY
							date");
	return $query;
}

function select_purchases($id){
	$query = mysql_query("SELECT a.*, b.*, c.branch_name FROM purchases a
												JOIN purchases_details b on b.purchase_id = a.purchases_id
												LEFT JOIN branches c on c.branch_id = a.branch_id
												WHERE a.purchases_id = '".$id."'
												 ");
	return $query;
}

function select_purchases_tot($id){
	$query = mysql_query("SELECT a.* FROM purchases a
												WHERE a.purchases_id = '$id'
												 ");
	return $query;
}
function select_supplier($id){
	$query = mysql_query("SELECT a.*,b.* from purchases a
												JOIN suppliers b on b.supplier_id = a.supplier_id
												WHERE a.purchases_id = '".$id."'
												");
	return $query;
}

function get_hutang($id_pengangsuran){
	$query=  mysql_query("SELECT a.*, c.*, d.*, f.* FROM purchases a
												JOIN purchases_details e ON e.purchase_id = a.purchases_id
												JOIN items c ON c.item_id = e.item_id
												JOIN suppliers d ON d.supplier_id = a.supplier_id
												JOIN pengangsuran_hut f ON f.purchase_id = a.purchases_id
												WHERE f.id_pengangsuran = '".$id_pengangsuran."'");
	return $query;
}

function get_piutang($id_pengangsuran){
	$query=  mysql_query("SELECT b.*, c.*, d.*, f.* FROM transactions b
												JOIN transaction_details e ON e.transaction_id = b.transaction_id
												JOIN items c ON c.item_id = e.item_id
												JOIN members d ON d.member_id = b.member_id
												JOIN pengangsuran_piutang f ON f.transaction_id = b.transaction_id
												WHERE f.id_pengangsuran = '".$id_pengangsuran."'");
	return $query;
}

function get_id_pengangsuran($id_hutang){
	$query = mysql_query("SELECT MAX(id_pengangsuran) AS id_pengangsuran_akhir from pengangsuran_hut
												WHERE id_hutang = '".$id_hutang."'
												");
	$row = mysql_fetch_array($query);
	$id= ($row['id_pengangsuran_akhir']) ? $row['id_pengangsuran_akhir'] : 0;
	return $id;
}

function get_id_pengangsuran_piutang($transaction_id){
	$query = mysql_query("SELECT MAX(id_pengangsuran) AS id_pengangsuran_akhir from pengangsuran_piutang
												WHERE transaction_id = '".$transaction_id."'
												");
	$row = mysql_fetch_array($query);
	$id= ($row['id_pengangsuran_akhir']) ? $row['id_pengangsuran_akhir'] : 0;
	return $id;
}

// function get_bank_name($id){
// 	$query = mysql_query("SELECT bank_name from banks WHERE bank_id = '".$id."'
// 												");
// 	$row_bank = mysql_fetch_array($query);
// 	$id= ($row_bank['bank_name']) ? $row_bank['bank_name'] : "-";
// 	return $id;
// }

function get_payment_method($id){
	$query = mysql_query("SELECT payment_method_name from payment_methods WHERE payment_method_id = '$id'");
	$row_payment_method = mysql_fetch_array($query);
	$id= ($row_payment_method['payment_method_name']) ? $row_payment_method['payment_method_name'] : 0;
	return $id;
}

function select_hutang($id){
	$query = mysql_query("SELECT * from hutang WHERE purchase_id = '$id'");
	return $query;
}

function get_payment_method_id($object,$table,$id,$param){
	$query = mysql_query("SELECT $object as result from $table WHERE  $param = '".$id."'");
	$row_payment_method = mysql_fetch_array($query);
	$result = $row_payment_method['result'];
	return $result;
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

function select_pembayaran_piutang($id){
	$query = mysql_query("SELECT * FROM piutang WHERE transaction_id = '$id' ");
	return $query;
}

function select_pembayaran_hutang($id){
	$query = mysql_query("SELECT b.*, c.*, d.*,e.*, g.unit_name FROM purchases b
												JOIN purchases_details e ON e.purchase_id = b.purchases_id
												JOIN items c ON c.item_id = e.item_id
												JOIN suppliers d ON d.supplier_id = b.supplier_id
												left JOIN units g on g.unit_id = c.unit_id
												JOIN pengangsuran_hut f ON f.purchase_id = b.purchases_id
												WHERE f.angsuran_date = '$id'");
	return $query;
}

function select_retur_penjualan($id){
	$query=mysql_query("SELECT a.*, b.transaction_code FROM retur a
											JOIN transactions b on b.transaction_id = a.transaction_id
											WHERE a.transaction_id =".$id);
	return $query;
}

function select_retur_detail($id){
	$query=mysql_query("SELECT a.* FROM retur_details a
											JOIN retur b on b.retur_id = a.retur_id
											WHERE a.transaction_id =".$id);
	return $query;
}

function select_member_retur($id){
	$query = mysql_query("SELECT a.member_id,a.lunas, b.* from transactions a
												JOIN members b on b.member_id = a.member_id
												WHERE a.transaction_id = ".$id);
	return $query;
}

function select_retur_pembelian($id){
	$query=mysql_query("SELECT a.*, b.purchases_code FROM retur_pembelian a
											JOIN purchases b on b.purchases_id = a.purchase_id
											WHERE a.purchase_id =".$id);
	return $query;
}

function select_retur_pembelian_detail($id){
	$query=mysql_query("SELECT a.* FROM retur_pembelian_details a WHERE a.purchase_id =".$id);
	return $query;
}

function select_supplier_retur($id){
	$query = mysql_query("SELECT a.supplier_id, a.lunas, b.* from purchases a
												JOIN suppliers b on b.supplier_id = a.supplier_id
												WHERE a.purchases_id = ".$id);
	return $query;
}

function get_id_mutasi(){
  $query = mysql_query("SELECT max(id_mutasi) as result FROM mutasi_barang");
  $r_id= mysql_fetch_array($query);
  return $r_id['result'];
}

function get_mutasi($id){
  $query = mysql_query("SELECT a.* FROM mutasi_barang a
												WHERE a.id_mutasi = ".$id);
  return $query;
}

function get_gudang($id){
  $query = mysql_query("SELECT a.* FROM gudang_identitas a
												WHERE a.gudang_id = ".$id);
  return $query;
}

function get_cabang($id){
	$query = mysql_query("SELECT a.* FROM branches a
												WHERE a.branch_id = ".$id);
  return $query;
}

function get_mutasi_details($id){
	$query = mysql_query("SELECT a.*, b.item_name, c.unit_name FROM mutasi_details a
												JOIN items b ON b.item_id = a.item_id
												left JOIN units c ON c.unit_id = b.unit_id
												WHERE a.mutasi_id =  ".$id);
  return $query;
}

function get_detail_transaction($id){
	$query = mysql_query("SELECT a.*, b.*, c.*, d.unit_name AS unit_konversi_name, b.transaction_detail_unit,
												j.unit_name AS unit_utama_name, e.*, f.item_type_name, g.*
												FROM transactions a
												JOIN transaction_details b ON b.transaction_id = a.transaction_id
												JOIN items c ON c.item_id = b.item_id
												LEFT JOIN units d ON d.unit_id = b.transaction_detail_unit
												LEFT JOIN item_harga e ON e.item_id = b.item_id
												LEFT JOIN items_types f ON f.item_type_id = c.item_type
												LEFT JOIN item_details g ON g.item_id = b.item_id
												LEFT JOIN members h ON h.member_id = a.member_id
												LEFT JOIN units j ON j.unit_id = c.unit_id
												WHERE a.transaction_id = '$id' GROUP BY b.item_id");
	return $query;
}

function get_detail_transaction_piutang($id){
	$q_invo = mysql_query("SELECT a.*, b.*, c.*, d.unit_name, e.*, f.item_type_name, g.*
												FROM transactions a
												JOIN transaction_details b ON b.transaction_id = a.transaction_id
												JOIN items c ON c.item_id = b.item_id
												JOIN units d on d.unit_id = b.transaction_detail_unit
												JOIN item_harga e on e.item_id = b.item_id
												LEFT JOIN items_types f on f.item_type_id = c.item_type
												LEFT join item_details g on g.item_id = b.item_id
												WHERE a.transaction_id = '$id'");
		return $query;
}

function get_user_name($id){
	$query = mysql_query("SELECT user_name from users where user_id = '$id'");
	$row = mysql_fetch_array($query);
	$result = $row['user_name'];
	return $result;
}

function get_purchase($id){
	$query = mysql_query("SELECT a.*, b.*, c.unit_name, d.lunas, d.purchase_total FROM purchases_details a
                          JOIN items b ON b.item_id = a.item_id
                          left JOIN units c ON c.unit_id = a.unit_id
                          JOIN purchases d ON d.purchases_id = a.purchase_id
                          WHERE a.purchase_id = '$id' group by a.item_id");
	return $query;
}

function get_branch_name($id){
	$query = mysql_query("SELECT branch_name FROM branches WHERE branch_id = $id");
	$row = mysql_fetch_array($query);
	return $row;
}

function select_member_detail($id){
	$query = mysql_query("SELECT a.*, b.*, c.jenis_pekerjaan, c.jabatan FROM members a
												LEFT JOIN members_darurat b ON b.member_id = a.member_id
												LEFT JOIN members_pekerjaan c ON c.member_id = c.member_id
												WHERE a.member_id = '$id'
												");
	return $query;
}

function select_item_detail($id){
	$query = mysql_query("SELECT a.*, b.*, c.*, d.*, e.* FROM transaction_details a
												LEFT JOIN kredit b ON b.transaction_id  = a.transaction_id
												LEFT JOIN items c ON c.item_id = a.item_id
												LEFT JOIN item_details d ON d.item_id = a.item_id
												LEFT JOIN kategori e ON e.kategori_id = c.kategori_id
												WHERE a.item_id = '$id'
												");
	return $query;
}

function select_angsuran_kredit($id, $id2){
	$query = mysql_query("SELECT a.*, b.*, c.user_name, b.payment_method as cara_bayar_angsuran, d.*,
												e.transaction_code, e.transaction_date, f.kredit_code FROM angsuran_kredit a
												LEFT JOIN angsuran_kredit_details b on b.angsuran_kredit_id = a.angsuran_kredit_id
												LEFT JOIN users c on c.user_id = b.user_id
												LEFT JOIN members d on d.member_id = a.member_id
												LEFT JOIN transactions e on e.transaction_id = a.transaction_id
												LEFT JOIN kredit f on f.transaction_id = a.transaction_id
												WHERE a.kredit_id = '$id' AND b.angsuran_kredit_details_code = '$id2'
												");
	return $query;
}
?>
