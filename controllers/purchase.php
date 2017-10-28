<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/purchase_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "form";
$title = ucfirst("Pembelian");

$_SESSION['menu_active'] = 3;
$_SESSION['sub_menu_active'] = 3;

$s_cabang = $_SESSION['branch_id'];
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
	case 'form':
		get_header();
		$date = format_date(date("Y-m-d"));
		$close_button = "purchase.php?page=list";
		$query_supplier = select_supplier();
		$where="";
		$query_item = select_item($where);
		$query_item_type = select_item_type();
		$query_branch = select_branch();
		$id = (isset($_GET['id'])) ? $_GET['id'] : null;
		$row = new stdClass();
		$q_kategori = select_kategori();
		$action = "purchase.php?page=save";
		$action = "purchase.php?page=save";
		include '../views/purchase/form.php';
		get_footer();

	break;

	case 'strcmp':
 		$data_baru = $_POST['x'];
 		$query = select_baru($data_baru);
 		$row = mysql_fetch_array($query);
 		$data = $row['result'];
 		echo json_encode($data);
 		break;

	case 'save':

		extract($_POST);

		$i_date = get_isset($i_date);
		$i_date_asli = get_isset($i_date);
		$i_date = format_back_date($i_date);
		$i_jam = date("H:i:s");
		$tanggal = $i_date." ".$i_jam;
		$purchase_id = get_isset($purchase_id);
		$i_total_harga = get_isset($i_total_harga);
		$branch_id = get_isset($i_branch_id);
		$action1="purchase.php?page=save_payment";
		$close="purchase.php?page=close&purchase_id=$purchase_id";
		$i_supplier = get_isset($i_supplier);

		if ($i_total_harga>0) {
		$data = "'$purchase_id',
						'".$_SESSION['user_id']."',
						'".$tanggal."',
						'".time()."',
						'".$i_supplier."',
						'".$branch_id."'
		";
			create($data);
			$data_id = mysql_insert_id();
			$query = select_item_tmp($purchase_id);
			while($r_item_id = mysql_fetch_array($query)){
				$data_detail = "'',
							'$purchase_id',
							'$tanggal',
							'".$r_item_id['item_types']."',
							'".$r_item_id['item_id']."',
							'".$r_item_id['item_stock_qty']."',
							'".$r_item_id['harga']."',
							'".$r_item_id['harga_total']."',
							'".$r_item_id['unit_id']."'
							";
				create_details($data_detail);
			}

			$_SESSION['i_supplier'] = $i_supplier;
			$_SESSION['branch_id_1'] = $branch_id;
			$_SESSION['tanggal'] = $i_date_asli;

			$where = '';
			$q_bank 		= select_config('banks', $where);
			$q_bank_to 	= select_config('banks', $where);

			// include '../views/purchase/pp_list.php';
			 	$status['status'] = 200;
		}else {
				$status['status'] = 100;
		// header('Location: purchase.php?page=form&err=1');
		}
		echo json_encode($status);
	break;

	case 'simpan_transaksi':
		$purchase_id = $_GET['id'];
		$total_price = 0;
		$where_purchases_id = "WHERE purchases_id = '$purchase_id'";

		$purchases_code = select_config_by('purchases_tmp', 'purchases_code', $where_purchases_id);

		$where_purchase_id = "WHERE purchase_id = '$purchase_id'";
		$q_purchases_details_tmp = select_config('purchases_details_tmp', $where_purchase_id);

		while($row_item_details = mysql_fetch_array($q_purchases_details_tmp)){
			$total_price = $total_price + $row_item_details['purchase_total'];
			}
		$totalawal  = $total_price;
		$totalkedua =	$totalawal;
		$totalkedua = ceil($totalkedua);
		if (substr($totalkedua,-2)!=00){
		if(substr($totalkedua,-2)<50){
		$totalkedua=round($totalkedua,-2)+100;
		}else{
		$totalkedua=round($totalkedua,-2);
		} }

		$where = 'WHERE payment_method_id = 1 or payment_method_id =5 or payment_method_id = 6 ORDER BY payment_method_id DESC';
		$q_payment_method = select_config('payment_methods', $where);

		include '../views/purchase/popmodal_simpan_transaksi.php';
		break;


	case 'edit':

		extract($_POST);

		$id = get_isset($_GET['id']);
		$q_purchases = select($where_branch);
		$r_purchases = mysql_fetch_array($q_purchases);
		$i_date = get_isset($i_date);
		$i_date = format_back_date($i_date);
		$i_item_id = get_isset($i_stock_id);
		$i_harga = get_isset($i_harga);
		$i_qty = get_isset($i_qty);
		//$i_total = get_isset($i_total);
		$i_supplier = get_isset($i_supplier);
		$i_branch_id = get_isset($i_branch_id);
		$payment_method = get_isset($i_branch_id);
					$data = " purchase_date = '$i_date',
					stock_id = '$i_stock_id',
					purchase_qty = '$i_qty',
					purchase_price = '$i_harga',
					purchase_total = '0',
					supplier_id = '$i_supplier',
					branch_id = '$s_cabang'
					";

			update($data, $id);

			header('Location: purchase.php?page=list&did=2');



	break;

	case 'delete':

		$id = get_isset($_GET['id']);

		delete($id);

		header('Location: purchase.php?page=list&did=3');

	break;

	case 'simpan_order':
		$i_limit= $_POST['i_limit'];
		$nama_brg = $_POST['nama_brg'];
		$kode_barang = $_POST['kode_barang'];
		$tipe_barang = $_POST['tipe_barang'];
		$path = "../img/menu/";
		$i_img_tmp = $_FILES['i_img']['tmp_name'];

		$merk_barang = $_POST['merk_barang'];
		$tipe_barang = $_POST['tipe_barang'];

		$i_img = ($_FILES['i_img']['name']) ? time()."_".$_FILES['i_img']['name'] : "";
		$data = "'',
						 '',
						 '',
						 '',
						 '$nama_brg',
						 '',
						 '$i_limit',
						 '$i_img',
						 '$kode_barang'";
		create_config('items', $data);
		$item_id = mysql_insert_id();
		var_dump($data);
		if($i_img){
			move_uploaded_file($i_img_tmp, $path.$i_img);
		}

		$data_details = "'',
										 '$item_id',
										 '$merk_barang',
										 '$tipe_barang',
										 '',
										 '',
										 '',
										 '',
										 '',
										 ''";

		create_config('item_details', $data_details);
		header('Location: purchase.php?page=form&did=1');
		break;

		case 'reset':
			$purchase_id = get_isset($_GET['purchases_id']);
			$where_purchase_id = "purchases_id = '$purchase_id'";
			$where_purchase_id_ = "purchase_id = '$purchase_id'";
			delete_config("purchases_tmp", $where_purchase_id);
			delete_config("purchases_details_tmp", $where_purchase_id_);
			delete_config("item_tmp", $where_purchase_id);
			header("Location: purchase.php?page=form");
			break;

		case 'close':
			$purchase_id = $_POST['purchase_id'];
			delete_config("purchases_details_tmp", "purchase_id = ".$purchase_id);
			delete_config("purchases_tmp", "purchases_id = '$purchase_id'");
			header("Location: home.php");
			break;

		case 'save_payment':
			$purchase_id 				= $_POST['purchase_id'];
			$i_payment 					= $_POST['i_payment'];
			$i_change 					= $_POST['i_change'];
			$i_bank_id					= $_POST['i_bank_id'];
			$i_bank_id 					= $_POST['i_bank_id'];
			$i_payment_method 	= $_POST['i_payment_method'];
			$i_tgl 							= $_POST['i_sisa_pembayaran'];
			$i_tgl 							= format_back_date($i_tgl);
			$i_bank_id  				= $_POST['i_bank_id'];
			$i_bank_account 		= get_bank_account($i_bank_id);
			$i_bank_id_to  			= $_POST['i_bank_id_to'];
			$i_bank_account_to  = $_POST['i_bank_account_to'];
			$purchase_desc 			= $_POST['purchase_desc'];
			$i_change 					= $_POST['i_change'];
			$i_total_a 					= $_POST['i_total_a'];

			$q_purchases 				= select_purchases($purchase_id) ;
			$r_purchases 				= mysql_fetch_array($q_purchases);
			$hutang_code 				= "5".time();
			$lunas = 0;

			if($i_payment_method == 5){
				$lunas=1;
				$uang_sisa = $_POST['i_sisa_pembayaran'];
				$data_hutang ="'',
											'$purchase_id',
											'".$r_purchases['purchases_date']."',
											'$i_tgl',
											'$hutang_code',
											'".$_SESSION['user_id']."',
											'".$r_purchases['supplier_id']."',
											'$i_payment',
											'',
											'',
											'',
											'',
											'',
											''";
			create_config('hutang', $data_hutang);
		}
			$data = "'$purchase_id',
							'".$_SESSION['user_id']."',
							'".$r_purchases['purchases_date']."',
							'".time()."',
							'".$r_purchases['supplier_id']."',
							'".$r_purchases['branch_id']."',
							'$i_bank_id',
							'$i_bank_account',
							'$i_bank_id_to',
							'$i_bank_account_to',
							'$i_payment_method',
							'$i_total_a',
							'$i_payment',
							'$i_change',
							'$lunas',
							'$purchase_desc'
			";
			create_config('purchases', $data);
			$q_purchases_details = select_purchases_details($purchase_id) ;
			$i_grand_total ='';
			while ($r_purchases_details = mysql_fetch_array($q_purchases_details)) {
				$data_detail = "'',
											 '$purchase_id',
											 '".$r_purchases_details['purchase_date']."',
											 '".$r_purchases_details['item_id']."',
											 '".$r_purchases_details['purchase_qty']."',
											 '".$r_purchases_details['purchase_price']."',
											 '".$r_purchases_details['purchase_total']."',
											 '',
											 '".$r_purchases_details['unit_id']."'
											 ";
			create_config('purchases_details', $data_detail);
			$item_id = $r_purchases_details['item_id'];
			$unit_id = $r_purchases_details['unit_id'];
			$qty = $r_purchases_details['purchase_qty'];
			$unit_id_utama = get_unit_id($item_id);
			if ( $unit_id_utama != $unit_id && $unit_id != 0 ) {
				$qty = get_konversi_qty($item_id,$unit_id,$qty);
			}
			add_stock($r_purchases_details['item_id'], $r_purchases_details['item_type'],$i_supplier,
								$qty,$r_purchases['branch_id'],$r_purchases_details['unit_id']);
								$i_grand_total = $i_grand_total + $r_purchases_details['purchase_total'];
			}

			delete_config("item_tmp", "purchases_id = ".$purchase_id);
			delete_config("purchases_details_tmp", "purchase_id = ".$purchase_id);
			delete_config("purchases_tmp", "purchases_id = '$purchase_id'");
			if($i_payment_method == 5){
				create_journal(time(), "purchases.php?page=save_payment(Belum lunas)", 2, $i_payment_method, $i_payment,
											 $uang_sisa, $purchase_desc, $i_bank_id_to, $i_bank_account_to, $i_bank_id, $i_bank_account, $r_purchases['branch_id']);
			}else {
				create_journal(time(), "purchases.php?page=save_payment(lunas)", 2, $i_payment_method, $i_grand_total,'',
											 $purchase_desc, $i_bank_id_to,$i_bank_account_to,$i_bank_id,$i_bank_account, $r_purchases['branch_id']);
			}
			unset($_SESSION['i_supplier']);
			unset($_SESSION['branch_id_1']);
			unset($_SESSION['tanggal']);
			header("location: print.php?page=print_purchase&id=$purchase_id");
			break;

			case 'img_view':

					$id = $_POST['x'];
					$query=mysql_query("SELECT a.stock_img, b.item_type_name FROM items a
															JOIN items_types b ON b.item_type_id WHERE a.item_id = '".$id."'");
					$q_img = mysql_fetch_array($query);
					$img['data'][] = array(
							'stock_img' => $q_img['stock_img'],
							'item_type_name' => $q_img['item_type_name']
						);
						echo json_encode($img);
				break;

				case 'menu';

				$query = mysql_query("SELECT * from items ");
				while($r_stocks = mysql_fetch_array($query)){
				if ($r_stocks['stock_img']) {
					$stock['data'][] = array(
							'item_id'   => $r_stocks['item_id'],
							'item_name' => $r_stocks['item_name'],
							'stock_img' => $r_stocks['stock_img'],
							'kode_barang' => $r_stocks['kode_barang']
						);
				}else {
					$stock['data'][] = array(
							'item_id'   => $r_stocks['item_id'],
							'item_name' => $r_stocks['item_name'],
							'stock_img' => 'default.jpg',
							'kode_barang' => $r_stocks['kode_barang']
						);
					}
				};
				echo json_encode($stock);
				break;

		case 'menu_search':
			$word = $_POST['z'];
			$query =select_same_word($word);
			while($r_stocks = mysql_fetch_array($query)){
				$stock[] = array(
						'item_id'   => $r_stocks['item_id'],
						'item_name' => $r_stocks['item_name'],
						'stock_img' => $r_stocks['stock_img'] ? $r_stocks['stock_img'] : "default.jpg",
						'kode_barang' => $r_stocks['kode_barang']
					);
			};
			echo json_encode($stock);
			break;

		case 'sub_menu':
			$id = $_POST['x'];
			$query = mysql_query("select * from sub_kategori where kategori_utama_id = ".$id);
			while($r_submenu = mysql_fetch_array($query)) {
				$data[] = array(
										'sub_kategori_id'   => $r_submenu['sub_kategori_id'],
										'sub_kategori_name' => $r_submenu['sub_kategori_name']);
			};
			echo json_encode($data);
			break;

			case 'menu_sub';
				$id = $_POST['x'];
				$query = select_item_2($id);
				while($menu_sub = mysql_fetch_array($query)){
					if ($menu_sub['stock_img']) {
					$menu[] = array(
						'item_id'   => $menu_sub['item_id'],
						'item_name' => $menu_sub['item_name'],
						'stock_img' => $menu_sub['stock_img'],
						'item_price' => $menu_sub['item_price'],
						'kode_barang' => $menu_sub['kode_barang'],
					);}else {
						$menu[] = array(
							'item_id'   => $menu_sub['item_id'],
							'item_name' => $menu_sub['item_name'],
							'stock_img' => 'default.jpg',
							'item_price' => $menu_sub['item_price'],
							'kode_barang' => $menu_sub['kode_barang'],
						);
					}
				};
				echo json_encode($menu);
				break;

		case 'menu_sub_2';
			$id = $_POST['x'];
			$where_kategori_id = "WHERE kategori_id = '$id'";
			$query = select_config('items', $where_kategori_id);
			while($menu_sub = mysql_fetch_array($query)){
				$menu[] = array(
					'item_id'   => $menu_sub['item_id'],
					'item_name' => $menu_sub['item_name'],
					'stock_img' => $menu_sub['stock_img'] ? $menu_sub['stock_img']:"default.jpg",
					'kode_barang' => $menu_sub['kode_barang']
				);
			};
			echo json_encode($menu);
			break;

				case 'popmodal':
					$item_id = $_GET['item_id'];
					$supplier_id = $_GET['supplier_id'];
					$branch_id = $_GET['branch_id'];
					$q_item = get_item_name($item_id);
			    $r_item_name = mysql_fetch_array($q_item);
			    $item_name = $r_item_name['item_name'];
					$purchase_id= $_GET['purchase_id'];
					$q_unit_item = select_unit_item($item_id);
					$tanggal = $_GET['tanggal'];
					$action = "purchase.php?page=create_note";
					include '../views/purchase/popmodal.php';

				break;

				case 'select_satuan':
					$item_id = $_POST['item_id'];
					$query = select_satuan_item($item_id);
					while($row = mysql_fetch_array($query)) {
						$response[] = array(
							'unit_id'   => $row['unit_id'],
							'unit_name' => $row['unit_name']
						);
					};
					echo json_encode($response);
					break;

				case 'create_note':
					$purchase_id = $_POST['purchase_id'];
					$i_qty = $_POST['i_qty'];
					$item_id = $_POST['item_id'];
					$i_unit = $_POST['i_unit'];
					if ($i_unit == 0) {
						$i_unit = get_unit_id($item_id);
					}
					$i_harga = $_POST['i_harga'];
					$i_supplier = $_POST['i_supplier'];
					$i_branch_id = $_POST['i_branch_id'];
					$i_item_type = get_item_type($item_id);
					$tanggal = $_POST['tanggal'];
					$harga_total = $i_harga * $i_qty;

					$data = "'',
									'$i_item_type',
									'$item_id',
									'$i_harga',
									'$i_qty',
									'$harga_total',
									'$i_unit',
									'$i_supplier',
									'$i_branch_id',
									'$purchase_id'
					";
					var_dump($data);
					create_item_tmp($data);
					$_SESSION['i_supplier'] = $i_supplier;
					$_SESSION['branch_id_1'] = $i_branch_id;
					$_SESSION['tanggal'] = $tanggal;
					header("Location: purchase.php?page=form");
				break;

				case 'widget_modal':
					$purchase_id = $_GET['id'];
					$query_widget = select_widget_purchase($purchase_id);
					include '../views/purchase/popmodal_widget.php';
					break;

				case 'delete_widget':
					$id = get_isset($_GET['id']);
					delete_config("item_tmp", "item_id = '$id'");
					$_SESSION['tanggal'] = $tanggal;
					header("Location: purchase.php?purchase_id=$id&did=3");
				break;

				case 'delete_purchases_tmp':
				$id = get_isset($_GET['id']);
				delete_purchases_details_tmp($id);
				delete_purchases_tmp($id);
				header("Location: purchase.php?purchase_id=$id");
					break;

				case 'bank_to':
					$id = $_POST['x'];
					$query=mysql_query("SELECT * from banks WHERE bank_id = ".$id);
					$r_bank=mysql_fetch_array($query);
					$bank['data'][] = array(
						'bank_name'   => $r_bank['bank_name'],
						'bank_account_number' => $r_bank['bank_account_number'],
					);
				$menu['status'] = '200';
				echo json_encode($bank);
					break;

		case 'tambah_supplier_popmodal':
			$purchase_id = $_GET['purchase_id'];
			$branch_id = $_GET['branch_id'];
			$tanggal = $_GET['tanggal'];
			$_SESSION['tanggal'] = $tanggal;
			$action = "purchase.php?page=save_supplier";
			include '../views/purchase/tambah_suplier_popmodal.php';
			break;

		case 'save_supplier':

			$i_name = $_POST['i_name'];
			$i_telp = $_POST['i_telp'];
			$i_email = $_POST['i_email'];
			$i_alamat = $_POST['i_alamat'];

			$data = "'',
						'$i_name',
						'$i_telp',
						'$i_email',
						'$i_alamat'
				";
				create_config("suppliers",$data);
				header("Location: purchase.php?page=form");
			break;

}

?>
