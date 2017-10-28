<?php

function select_transaction($where){
						$query = mysql_query("SELECT b.*, c.user_name, e.member_name, f.branch_name
														from transactions b
														JOIN users c on c.user_id = b.user_id
														left JOIN branches d on d.branch_id = b.branch_id
														JOIN members e on e.member_id = b.member_id
														LEFT JOIN branches f on f.branch_id = b.branch_id
														$where
														order by transaction_id
											");

	return $query;
}
 ?>
