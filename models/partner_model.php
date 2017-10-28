<?php
function update($data, $id){
	mysql_query("update partners set ".$data." where partner_id = '$id'");
}

function delete($id){
	mysql_query("delete from partners where partner_id = '$id'");
}

?>
