<?php
ob_start();
session_start();
$con = mysql_connect("jasa-programmer-jakarta.com","jasaprog_pos-bu-diana","4}R)fny6ngxK");
mysql_select_db("jasaprog_pos_bu_diana", $con);
unset($_SESSION['menu_active']);
unset($_SESSION['sub_menu_active']);
?>
