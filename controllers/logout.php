<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/transaction_new_model.php';
session_start();
mysql_query("DELETE from widget_tmp where user_id = '".$_SESSION['user_id']."' ");
mysql_query("DELETE from item_tmp");
session_destroy();
header("Location: ../login.php");


?>