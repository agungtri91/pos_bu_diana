<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/stock_master_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("STOCK");

$_SESSION['menu_active'] = 1;
$_SESSION['sub_menu_active'] = 12;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
	case 'list':
		get_header($title);
		$count = 0;
		if ($_SESSION['branch_id'] == 3) {
				$where_branch = "";
			}else{
				$where_branch = " where a.branch_id = '".$_SESSION['branch_id']."' ";
			}
		$branch_active = get_branch($s_cabang);
		$query = select($where_branch);
		$add_button = "stock_master.php?page=form";
		include '../views/stock_master/list.php';
		get_footer();
	break;

	case 'form':

		get_header($title);
		$close_button = "stock_master.php?page=list";
		$query_item_type = select_item_type();
		$id = (isset($_GET['id'])) ? $_GET['id'] : null;
		$branch_id = (isset($_GET['branch_id'])) ? $_GET['branch_id'] : null;
		$row = read_id($id,$branch_id);
		$row2 = read_stock($id,$branch_id);
		$get_new_date = get_new_date($id,$branch_id);
		$stock_buy = read_stock_buy($get_new_date,$branch_id);
		$unit_id_new_buy = get_unit_id_new_buy($id,$branch_id);
		$q_type_pembeli = get_type_pembeli();
		// var_dump($stock_buy);
		if($row2){
			$action = "stock_master.php?page=edit&id=$id";
		} else{
			//inisialisasi
			$action = "stock_master.php?page=save&id=$id";
		}
		include '../views/stock_master/form.php';
		get_footer();
		break;

		case 'delete':

			$id = get_isset($_GET['id']);
			delete($id);
			header('Location: stock_master.php?page=list&did=3');
			break;

		case 'edit':
			extract($_POST);
			// $item_id = $_POST['id'];
			$item_id = get_isset($_GET['id']);
			$item_type_id = get_isset($item_type_id);
			$stock_id = get_isset($stock_id);
			$i_original_price = get_isset($i_original_price);
			$i_margin_price = '';
			$i_price = get_isset($i_price);
			$data_new = "'',
						'$item_id',
						'$item_type_id',
						'$i_original_price',
						'$i_margin_price',
						'$i_price'
				";
			$data = " item_original_price = '$i_original_price',
								item_margin_price = '$i_margin_price',
								item_price = '$i_price'
								";
			update_stock($data,$item_id,$data_new);
			var_dump($data);
			header('Location: stock_master.php?page=list&did=3');
			break;

		case 'save':

			extract($_POST);

			$item_id = get_isset($_GET['id']);
			$item_type_id = get_isset($item_type_id);
			$i_original_price = get_isset($i_original_price);
			$i_margin_price = '';
			$i_price = get_isset($i_price);
			$data = "'',
						'$item_id',
						'$item_type_id',
						'$i_original_price',
						'$i_margin_price',
						'$i_price'
				";
			var_dump($data);
			create_stock($data);
			header('Location: stock_master.php?page=list&did=2');
			break;

		case 'popmodal_pembelian_item':
			$item_id = $_GET['item_id'];
			$branch_id = $_GET['branch_id'];
			$q_item = get_item_name($item_id);
			$row = mysql_fetch_array($q_item);
			$item_name = $row['item_name'];
			$q_item_purchase = select_item_purchase($item_id);
			include '../views/stock_master/popmodal_pembelian_item.php';
			break;

		case 'popmodal_penjualan_item':
			$item_id = $_GET['item_id'];
			$branch_id = $_GET['branch_id'];
			$q_item = get_item_name($item_id);
			$row = mysql_fetch_array($q_item);
			$item_name = $row['item_name'];
			$q_item_penjualan = select_item_penjualan($item_id);
			include '../views/stock_master/popmodal_penjualan_item.php';
			break;

		case 'form_keterangan':
			get_header();
			$branch_id = $_GET['branch_id'];
			$id = $_GET['id'];
			$where = '';
			$where_item_id = "WHERE item_id = '$id'";
			$kategori_id = select_config_by('items', 'kategori_id', $where_item_id);
			$where_kategori_id = "WHERE kategori_id = '$kategori_id'";
			$item_qty = select_config_by('item_stocks', 'item_stock_qty', $where_item_id);
			$q_kategori_keterangan = select_config('kategori_keterangan', $where);
			$q_kategori_keterangan_2 = select_config('kategori_keterangan', $where);
			$q_kategori_keterangan_details = select_kategori_keterangan_details($id);
			$action = "stock_master.php?page=save_keterangan_item";
			$close_button = "stock_master.php?page=list";
			include '../views/stock_master/form_keterangan_item.php';
			get_footer();
			break;

	case 'kategori_keterangan_details':
		$id = $_GET['id'];
		$where = '';
		$where_kategori_id = "WHERE kategori_id = '$id'";
		$q_kategori_keterangan = select_config('kategori_keterangan', $where);
		include '../views/stock_master/popmodal_keterangan_details.php';
		break;

	case 'supplier':
		$where = '';
		$query = select_config('suppliers', $where);
		while ($row = mysql_fetch_array($query)) {
			$data[] = array(
				'supplier_id' => $row['supplier_id'],
				'supplier_name' => $row['supplier_name']);
		}
		echo json_encode($data);
		break;

	case 'save_keterangan_item':
		var_dump($_POST);
		break;
	}
?>
