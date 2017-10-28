<?php
  function select(){
      $query = mysql_query("SELECT a.*, b.*, c.* FROM hutang a
                            JOIN purchases b ON b.purchases_id = a.purchase_id
                            JOIN  suppliers c ON c.supplier_id = a.supplier_id GROUP by c.supplier_id");
      return $query;
  }

  function select_hutang($id){
      $query = mysql_query("SELECT a.*, b.*, d.supplier_name FROM hutang a
                            JOIN purchases b ON b.purchases_id = a.purchase_id
                            JOIN  suppliers d ON d.supplier_id = b.supplier_id
                            WHERE a.hutang_id ='".$id."'");
    return $query;
  }

  function get_supplier_id($id){
    $query = mysql_query("SELECT a.supplier_id FROM hutang a WHERE a.hutang_id = '".$id."'");
    $r_lunas = mysql_fetch_array($query);
    return $r_lunas['supplier_id'];
  }

  function ket_lunas($id){
  	$query = mysql_query("SELECT a.lunas FROM purchases a WHERE a.supplier_id = '".$id."'");
  	$r_lunas = mysql_fetch_array($query);
  	return $r_lunas['lunas'];
  }

  function get_tot_hutang($id){
  		$query= mysql_query("SELECT * FROM hutang1 WHERE supplier_id = '".$id."'");
  		return $query;
  }

 ?>
