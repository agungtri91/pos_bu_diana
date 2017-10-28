<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/bank_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucwords("BANK");

$_SESSION['menu_active'] = 1;
$_SESSION['sub_menu_active'] = 21;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
  case 'list':
		get_header($title);

		$query = select();
		$add_button = "bank.php?page=form";

		include '../views/bank/bank_list.php';
		get_footer();
	break;

  case 'form':
		get_header();

		$close_button = "bank.php?page=list";
		$id = (isset($_GET['id'])) ? $_GET['id'] : null;
		if($id){
			$row = read_id($id);
			$action = "bank.php?page=edit&id=$id";
		} else{
			//inisialisasi
			$row = new stdClass();
			$row->bank_name = false;
			$row->bank_account_number = false;
			$action = "bank.php?page=save";
		}
		include '../views/bank/bank_form.php';
		get_footer();
	break;

  case 'save':
  extract($_POST);

  $bank_name = get_isset($bank_name);
  $bank_account_number = get_isset($bank_account_number);
  $data="'',
        '$bank_name',
        '$bank_account_number'
        ";
  create_data($data);
  header("Location: bank.php?page=list&did=1");
    break;

  case 'delete':
  $id = get_isset($_GET['id']);
  delete($id);
  header('Location: bank.php?page=list&did=3');
    break;

    case 'edit':

  		extract($_POST);

  		$id = get_isset($_GET['id']);
      $bank_name = get_isset($bank_name);
      $bank_account_number = get_isset($bank_account_number);
  					$data = " bank_name = '$bank_name',
  							bank_account_number = '$bank_account_number'
  							";
        // var_dump($data);
  			update($data, $id);
  			header('Location: bank.php?page=list&did=1');
  	break;

}

 ?>
