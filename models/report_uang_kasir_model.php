<?php

function select_uang_kasir($branch_id){
    $query = mysql_query("SELECT a.*, b.user_name, c.tanggal_input,
                          MIN(TIME(a.uang_kasir_date)) AS jam_awal, MAX(TIME(a.uang_kasir_date)) AS jam_akhir,
                          MIN(a.uang_kasir_date) AS tanggal_awal, MAX(a.uang_kasir_date) AS tanggal_akhir
                          FROM uang_kasir a
                          LEFT JOIN users b ON b.user_id = a.user_id
                          LEFT JOIN(
                          		SELECT DATE(a.uang_kasir_date)  AS tanggal_input,
                          		a.user_id
                          		FROM uang_kasir a WHERE a.branch_id = 3
                          		GROUP BY DATE(a.uang_kasir_date )
                          		) AS c ON c.user_id = a.user_id
                          WHERE a.branch_id = '$branch_id'
                          GROUP BY DATE(a.uang_kasir_date)
                          ");
    return $query;
}

function get_uang_kasir($date){
  $query = mysql_query("SELECT nilai_uang_kasir as result FROM uang_kasir
                        WHERE uang_kasir_date = '$date'");
  $row = mysql_fetch_array($query);
  $result = $row['result'] ;
  return $result;
}
 ?>
