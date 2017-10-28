<?php
function select_gadai_barang($where){
  $query = mysql_query("SELECT a.*, b.kategori_name, c.member_name, IF(d.mutasi_barang > 0, 1, 0) AS mutasi_barang FROM gadai_tmp a
                        LEFT JOIN kategori b ON b.kategori_id = a.kategori
                        LEFT JOIN members c ON c.member_id = a.member_id
                        LEFT JOIN (
                                    SELECT a.gadai_id, COUNT(*) AS mutasi_barang FROM mutasi_barang a
                                    JOIN gadai_tmp b ON b.gadai_id = a.gadai_id
                                  ) AS d ON d.gadai_id = a.gadai_id
                        $where");
  return $query;
}

function select_gadai_detail($id){
  $query = mysql_query("SELECT a.*, b.member_name, c.kategori_name, d.*  FROM gadai_tmp a
                        LEFT JOIN members b on b.member_id = a.member_id
                        LEFT JOIN kategori c on c.kategori_id = a.kategori
                        LEFT JOIN periode d on d.periode_id = a.periode
                        WHERE a.gadai_id = '$id'");
  $result = mysql_fetch_object($query);
  return $result;
}
 ?>
