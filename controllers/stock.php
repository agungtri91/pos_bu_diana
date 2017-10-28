<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/stock_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("Item Stock");

$_SESSION['menu_active'] = 1;
$_SESSION['sub_menu_active'] = 11;
$s_cabang = $_SESSION['branch_id'];
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);

switch ($page) {
	case 'list':
		get_header($title);
			$count_unit = 0;
		if($_SESSION['user_type_id']==1 || $_SESSION['user_type_id']==2){
			$where_branch = "";
		}else{
			$where_branch = " where branch_id = '".$_SESSION['branch_id']."' ";
		}
		$q_unit_1 = select_unit();
		$query = select();
		$q_branch = select_branch($where_branch);
		$q_branch2 = select_branch($where_branch);

		$add_button = "stock.php?page=form";
		include '../views/stock/list.php';
		unset($_SESSION['unit_id']);
		get_footer();
	break;

	case 'form':
		get_header();
		$q_unit = select_unit();
		$query_unit = select_unit();
		$query_item_type = select_item_type();
		$q_kategori_id = select_kat_item();
		$q_unit = select_unit();
		$id = (isset($_GET['id'])) ? $_GET['id'] : null;
		$status = (isset($_GET['status'])) ? $_GET['status'] : null;
		if ($status) {
			$close_button = "stock_gadai.php?page=form&id=$id";
		} else {
			$close_button = "stock.php?page=list";
		}
		if($id){
			$row = read_id($id);
			$row2 = read_detail($id);
			$row3 = read_unit_konversi($id);
			if ($row2==null) {
				$row2 = new stdClass();
				$row2->item_p = false;
				$row2->item_l = false;
				$row2->item_t = false;
				$row2->item_berat = false;
				$row2->item_penerbit = false;
				$row2->item_desc = false;
			}
			if ($row3 == null) {
				$row3 = new stdClass();
				$row3->unit_id = false;
			}
			$action = "stock.php?page=edit&id=$id";
		} else{
			//inisialisasi
			$row = new stdClass();
			$row->item_type = false;
			$row->kategori_id = false;
			$row->item_name = false;
			$row->unit_id = false;
			$row->item_limit = false;
			$row->stock_img = false;
			$row->kode_barang = false;
			$row->item_hpp_price = false;
			$row->item_price = false;
				$row2 = new stdClass();
				$row2->item_merk = false;
				$row2->item_tipe = false;
				$row2->item_p = false;
				$row2->item_l = false;
				$row2->item_t = false;
				$row2->item_berat = false;
				$row2->item_penerbit = false;
				$row2->item_desc = false;
			$action = "stock.php?page=save";
		}
		$get_new_date = get_new_date($id,$s_cabang);
		$stock_buy = read_stock_buy($get_new_date,$s_cabang);
		$where_item_id = "WHERE item_id = '$id' ORDER BY purchase_detail_id DESC LIMIT 1";
		$unit_id_new_buy = select_config_by('purchases_details', 'unit_id', $where_item_id);
		$where_unit_id_new_buy = "WHERE unit_id = '$unit_id_new_buy'";
		$unit_id_new_buy_name = select_config_by('units', 'unit_name', $where_unit_id_new_buy);
		$stock_buy = select_config_by('purchases_details', 'purchase_price', $where_item_id);
		include '../views/stock/form.php';
		get_footer();
	break;

	case 'save':

		extract($_POST);
		$i_item_type = get_isset($i_item_type);
		$kategori_id = get_isset($kategori_id);
		$sub_kategori_item = get_isset($sub_kategori_item);
		$i_name = get_isset($i_name);
		$i_item_limit = get_isset($i_item_limit);
		$kode_barang = get_isset($kode_item);
		$item_penerbit = get_isset($item_penerbit);
		$merk_item = get_isset($merk_item);
		$tipe_item = get_isset($tipe_item);
 		$item_p = get_isset($item_p);
		$item_l = get_isset($item_l);
		$item_t = get_isset($item_t);
		$item_berat = get_isset($item_berat);
		if($item_desc<>false){
			$item_desc = get_isset($item_desc);
		}
		$path = "../img/menu/";
		$i_img_tmp = $_FILES['i_img']['tmp_name'];
		$i_img = ($_FILES['i_img']['name']) ? time()."_".$_FILES['i_img']['name'] : "";
		$data = "'',
						'$i_item_type',
						'$kategori_id',
						'$sub_kategori_item',
						'$i_name',
						'$i_unit_id',
						'$i_item_limit',
						'$i_img',
						'$kode_barang'
						";
						create_config("items",$data);
			if($i_img){
				move_uploaded_file($i_img_tmp, $path.$i_img);
			}
			$item_id = mysql_insert_id();
			$data_detail="'',
										'$item_id',
										'$merk_item',
										'$tipe_item',
										'$item_berat',
										'$item_p',
										'$item_l',
										'$item_t',
										'$item_penerbit',
										'$item_desc'
										";
			create_item_detail($data_detail);

			$i_hpp = get_isset($i_hpp);
			$i_harga_jual = get_isset($i_harga_jual);
			$i_original_buy_price = get_isset($i_original_buy_price);
			$data_harga = "'',
						'$item_id',
						'$i_original_buy_price',
						'$i_hpp',
						'',
						'$i_harga_jual'
				";
			create_config("item_harga",$data_harga);
			header("Location: stock.php?page=form&id=$item_id");
	break;

	case 'edit':

		extract($_POST);

		$id = get_isset($_GET['id']);
		$i_name = get_isset($i_name);
		// $i_unit_id = get_unit_id($id);
		$i_unit_id = $_POST['i_unit'];
		$kategori_id = get_isset($kategori_id);
		$sub_kategori_item = get_isset($sub_kategori_item);
		$i_item_limit = get_isset($i_item_limit);
		$i_item_type = get_isset($i_item_type);
		$kode_barang = get_isset($kode_item);
		$item_penerbit = get_isset($item_penerbit);

		$merk_item = get_isset($merk_item);
		$tipe_item = get_isset($tipe_item);
		$item_p = get_isset($item_p);
		$item_l = get_isset($item_l);
		$item_t = get_isset($item_t);
		$item_berat = get_isset($item_berat);
		$item_desc = get_isset($item_desc);
		$path = "../img/menu/";
		$i_img_tmp = $_FILES['i_img']['tmp_name'];
		$i_img = ($_FILES['i_img']['name']) ? time()."_".$_FILES['i_img']['name'] : "";
		if($i_img){
			if($i_img){
			if(move_uploaded_file($i_img_tmp, $path.$i_img)){
				$get_img_old = get_img_old($id);
				if($get_img_old){
					if(file_exists($path.$get_img_old)){
						unlink($path . $get_img_old);
						}
					}
					$data = "
									item_type = '$i_item_type',
									kategori_id = '$kategori_id',
									sub_kategori_id = '$sub_kategori_item',
									item_name = '$i_name',
									unit_id = '$i_unit_id',
									item_limit = '$i_item_limit',
									stock_img = '$i_img',
									kode_barang = '$kode_barang'
					";
					}
				}
				$data_detail="
											item_merk = '$merk_item',
											item_tipe = '$tipe_item',
											item_berat = '$item_berat',
											item_p = '$item_p',
											item_l = '$item_l',
											item_t ='$item_t',
											item_penerbit ='$item_penerbit',
											item_desc = '$item_desc'
											";
			}else {
				$data = "
								item_type = '$i_item_type',
								kategori_id = '$kategori_id',
								sub_kategori_id = '$sub_kategori_item',
								item_name = '$i_name',
								unit_id = '$i_unit_id',
								item_limit = '$i_item_limit',
								kode_barang = '$kode_barang'
				";
				$data_detail="
											item_merk = '$merk_item',
											item_tipe = '$tipe_item',
											item_berat = '$item_berat',
											item_p = '$item_p',
											item_l = '$item_l',
											item_t ='$item_t',
											item_penerbit ='$item_penerbit',
											item_desc = '$item_desc'
											";

			}

			update($data, $id, $s_cabang);
			update_detail($data_detail,$id,$item_berat,$item_p,$item_l,$item_t,$item_penerbit,$item_desc);

			$i_hpp = get_isset($i_hpp);
			$i_harga_jual = get_isset($i_harga_jual);
			$i_original_buy_price = get_isset($i_original_buy_price);
			$query = mysql_query("SELECT * FROM item_harga WHERE item_id = '$id'");
			$result = mysql_fetch_array($query);
			if ($result) {
			$data_update = "
								item_hpp_price = '$i_hpp',
								item_original_price = '$i_original_buy_price',
								item_price = '$i_harga_jual'
								";

			update_config("item_harga",$data_update,"item_id", "$id");
		}else {
			$data_harga = "'',
						'$id',
						'$i_original_buy_price',
						'$i_hpp',
						'',
						'$i_harga_jual'
				";
			create_config("item_harga",$data_harga);
		}
			unset($_SESSION['unit_id']);
			header('Location: stock.php?page=list&did=2');
	break;


	case 'delete':
		$id = get_isset($_GET['id']);
		delete($id);
		$where_item_id = "item_id = '$id'";
		delete_config('item_harga',$where_item_id);
		header('Location: stock.php?page=list&did=3');
	break;

	case 'sub_kategori_item':
		$id = $_POST['x'];
		$item_id = $_POST['y'];
		$query = select_kategori($id,$item_id);
		while($r_submenu = mysql_fetch_array($query)) {
			$data[] = array('sub_kategori_name' 	=> $r_submenu['sub_kategori_name'],
											'sub_kategori_id' 		=> $r_submenu['sub_kategori_id'],
											'id'			 						=> $r_submenu['id']);
		};
		echo json_encode($data);
		break;

	case 'konversi_list':
		$query = select_config('units','');
		while ($row = mysql_fetch_array($query)) {
			$data[] = array('unit_id' 	=> $row['unit_id'],
										'unit_name' => $row['unit_name']
		 );
		}
		echo json_encode($data);
		break;

	case 'table_konversi':
		$item_id = $_POST['item_id'];
		$where_item_id = "WHERE item_id = '$item_id'";
		$query = select_config('unit_konversi', $where_item_id);
		while ($row = mysql_fetch_array($query)) {
			$data[] = array('unit_konversi_id' => $row['unit_konversi_id'],
		 									'jumlah_acuan' => $row['unit_jml'],
											'unit_1' => $row['unit_id'],
											'jumlah_konversi' => $row['unit_konversi_jml'],
											'unit_2' => $row['unit_konversi'],
											'harga_konversi' => $row['harga_konversi'],
										);}
		echo json_encode($data);
		break;

	case 'delete_unit_konversi':
		$unit_konversi_id = $_POST['unit_konversi_id'];
		$where_unit_konversi_id = "unit_konversi_id = '$unit_konversi_id'";
		delete_config('unit_konversi', $where_unit_konversi_id);
		break;

	case 'popmodal_konversi':
		$item_id = $_GET['item_id'];
		$unit_id = $_GET['unit_id'];
		$id = (isset($_GET['id'])) ? $_GET['id'] : null;
		$where_item_id = "WHERE item_id = '$item_id'";
		$item_name = select_config_by('items', 'item_name', $where_item_id);
		$item_harga_jual = select_config_by('items', 'item_name', $where_item_id);
		$unit_name = get_unit_name($unit_id);
		$query = select_unit_turunan($unit_id);
		$item_price = select_config_by('item_harga', 'item_price', $where_item_id);
		$unit_konversi = (isset($_GET['unit_konversi'])) ? $_GET['unit_konversi'] : null;

		$q_unit = select_config('units', '');
		if ($id == 2) {
			$r_unit = read_id_unit($unit_konversi);
			$action = "stock.php?page=edit_unit_konversi_tmp";
		}else {
			$r_unit = new stdClass();
			$r_unit->unit_konversi_id = false;
			$r_unit->unit_id = false;
			$r_unit->unit_jml = false;
			$r_unit->unit_konversi = false;
			$r_unit->unit_konversi_jml = false;
			$r_unit->harga_konversi = false;
			$action = "stock.php?page=save_unit_konversi";
		}
		$_SESSION['unit_id'] = $unit_id;
		include '../views/stock/popmodal_konversi.php';
		break;

	case 'simpan_konversi':
		$item_id = $_GET['item_id'];
		$jumlah_acuan = $_POST['jumlah_acuan'];
		$unit_1 = $_POST['unit_1'];
		$jumlah_konversi = $_POST['jumlah_konversi'];
		$unit_2 = $_POST['unit_2'];
		$harga_konversi = $_POST['harga_konversi'];

		$xx = $_POST['xx'];
		$where_item_id = "item_id = '$item_id'";
		delete_config('unit_konversi', $where_item_id);

		for ($i=0; $i < $xx; $i++) {
				$data_konversi = "'',
													'".$item_id."',
													'".$jumlah_acuan[$i]."',
													'".$unit_1[$i]."',
													'".$jumlah_konversi[$i]."',
													'".$unit_2[$i]."',
													'".$harga_konversi[$i]."'
													";
				create_config('unit_konversi', $data_konversi);
				var_dump($data_konversi);
		}
		break;

	case 'edit_unit_konversi_tmp':
		$unit_konversi_id = $_POST['unit_konversi_id'];
		$item_id = $_POST['item_id'] ? $_POST['item_id'] : null;
		$unit_id = $_POST['unit_id'];
		$i_jumlah_utama = $_POST['i_jumlah_utama'];
		$i_unit_2 = $_POST['i_unit_2'];
		$i_jumlah_turunan = $_POST['i_jumlah_turunan'];
		$i_harga_konversi = $_POST['i_harga_konversi'];
		$data = "
						unit_jml 					=	'$i_jumlah_utama',
						unit_konversi 		=	'$i_unit_2',
						unit_konversi_jml = '$i_jumlah_turunan',
						harga_konversi		=	'$i_harga_konversi'
		";
		var_dump($data);
			update_stock_unit($unit_konversi_id,$data);
		header("Location: stock.php?page=form&id=$item_id");
		break;

	case 'delete_diskon':
		$id = $_GET['id'];
		$item_id = $_GET['item_id'];
		delete_config("unit_konversi", "unit_konversi_id = '$id'");
		header("Location: stock.php?page=form&id=$item_id");
		break;

	case 'strcmp':
		$data_baru = $_POST['x'];
		$item_id = $_POST['item_id'];
		$query = select_baru($data_baru,$item_id);
		$row = mysql_fetch_array($query);
		$data = $row['result'];
		echo json_encode($data);
		break;
}

?>
