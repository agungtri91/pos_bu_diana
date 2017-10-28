<?php

function select(){
		$query = mysql_query("SELECT a.*,b.* FROM members a
													JOIN transactions b ON b.member_id = a.member_id
													WHERE b.lunas != 0 GROUP BY a.member_id");
	return $query;
}

function select_transaction_piutang($id){
	$query = mysql_query("SELECT a.*, b.*, c.*, d.item_price, e.* FROM transactions a
												LEFT JOIN transaction_details b ON b.transaction_id = a.transaction_id
												LEFT JOIN items c ON c.item_id = b.item_id
												LEFT JOIN item_harga d ON d.item_id = b.item_id
												LEFT JOIN kredit e on e.member_id = a.member_id
												WHERE a.member_id = '$id' AND a.lunas != 0
												GROUP BY a.transaction_id
												");
	return $query;
}

function get_count_angsuran($id, $member_id){
	$query = mysql_query("SELECT count(*) as result FROM kredit
												WHERE transaction_id = '$id' AND member_id = '$member_id'");
	$row = mysql_fetch_array($query);
	$result = $row['result'];
	return $result;
}

function select_angsuran_kredit($id){
	$query = mysql_query("SELECT a.*, b.* FROM angsuran_kredit a
												LEFT JOIN angsuran_kredit_details b on b.angsuran_kredit_id = a.angsuran_kredit_id
												WHERE a.transaction_id = '$id'
											");
	return $query;
}
?>
