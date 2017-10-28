<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/home_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("Home");

$_SESSION['menu_active'] = '';

switch ($page) {
  case 'list':
    include '../views/uang_kasir/uang_kasir_popmodal.php';
    break;
}
