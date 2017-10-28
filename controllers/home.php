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
			get_header($title);
		if($_SESSION['user_type_id']==1 || $_SESSION['user_type_id']==2){
			$where_branch = "";
		}else{
			$where_branch = " and branch_id = '".$_SESSION['branch_id']."' ";
		}
		$date_default = "";
		$date1 = "";
		$date2 = "";
		if(isset($_GET['preview'])){
			$i_date = get_isset($_GET['date']);
			$date = explode("-", str_replace(" ", "", $i_date));
			$date1 = format_back_date($date[0]);
			$date2 = format_back_date($date[1]);
			$date_default = $i_date;
		}
		$action = "home.php?page=form_result&preview=1";
		$cabang_active = get_cabang_name($s_cabang);
		$jumlah_penjualan = get_jumlah_penjualan(date("Y-m-d"),$s_cabang);
		$jumlah_pembelian = get_jumlah_pembelian(date("Y-m-d"),$s_cabang);
		// $total_omset = number_format(get_total_omset(date("Y-m-d"), $where_branch), "0", ".", ".");
		$total_omset = number_format(get_total_omset(date("Y-m-d"),$s_cabang), "0", ".", ".");
		$total_pengeluaran = number_format(get_total_pengeluaran(date("Y-m-d"),$s_cabang), "0", ".", ".");
		$date_now = format_date(date("Y-m-d"));
		$menu_terlaris = get_item_terlaris(date("Y-m-d"), $s_cabang);
		$query_top_food = select_top_food($date1, $date2, $s_cabang);
		$query_stock_limit = select_stock_limit($s_cabang);

		$where = "WHERE branch_id = '$s_cabang'";
		$q_piutang_telat = select_kredit_telat($s_cabang);

		$query_history = select_history();
		$uang_kasir = (isset($_GET['uang_kasir'])) ? $_GET['uang_kasir'] : 0;
		$log_out = (isset($_GET['log_out'])) ? $_GET['log_out'] : 0;
		$where = '';
		$q_item = select_config('items', $where);
		$action_kasir = "home.php?page=save&log_out=$log_out";
		include '../views/layout/home.php';
		get_footer();
	break;

	case 'form_result':

			extract($_POST);
			$i_date = (isset($_POST['i_date'])) ? $_POST['i_date'] : null;
			//$date_url = str_replace(" ","", $i_date);
			$date_default = $i_date;

		header("Location: home.php?page=list&preview=1&date=$date_default");
	break;

	case 'save':
		$log_out = $_GET['log_out'];
		$uang_kasir = $_POST['uang_kasir'];
		$now_date = new_date();
		$date = "'',
						 '".$_SESSION['user_id']."',
						 '$now_date',
						 '$uang_kasir',
						 '$s_cabang'
						 ";
		create_config("uang_kasir",$date);
		if ($log_out!=0) {
			header("Location: logout.php");
		}else {
			header("Location: home.php?page=list");
		}
		break;

		case 'grafik_transaksi':
			$tanggal = new_date();
			$where = "WHERE a.branch_id = '$s_cabang' AND YEAR(a.transaction_date) = YEAR('$tanggal')
								AND YEAR(b.purchases_date) = YEAR('$tanggal')";
			$q_grafik = select_transaction($where);
			while ($r_grafik = mysql_fetch_array($q_grafik)) {
				$transaction_total =	$r_grafik['transaction_total'] ? $r_grafik['transaction_total'] : 0;
				$purchase_total	= $r_grafik['purchase_total'] ? $r_grafik['purchase_total'] : 0;
				$transaction_total = $r_grafik['transaction_total'] ? $r_grafik['transaction_total'] : 0;
				$purchase_total = $r_grafik['purchase_total'] ? $r_grafik['purchase_total'] : 0;
				$data['data'][] = array(
					'transaction_date'   			=> $r_grafik['transaction_date'],
					'transaction_grand_total' => $transaction_total,
					'purchase_total' 					=> $purchase_total,
				);
				// $monthvalues[$r_transaction[0]]= (int)$r_transaction[1];
			}
			echo json_encode($data);
			break;

		case 'item_chart':
			$item_id = $_POST['item_id'];
			$query = select_item_penjualan($item_id);
			while ($r_grafik = mysql_fetch_array($query) ) {
				$data[] = array(
					'total_penjualan'   			=> $r_grafik['total_penjualan'],
					'total_pembelian'   			=> $r_grafik['total_pembelian'],
					'tanggal'   							=> $r_grafik['tanggal'],
				);
			};
			echo json_encode($data);
			break;

		case 'home_popmodal':
			$log_out = $_GET['log_out'];
			$action_kasir = "home.php?page=save&log_out=$log_out";
			include '../views/layout/uang_kasir_popmodal.php';
			break;

		case 'get_data_telat':
			$where = '';
			$telah_diangsur = 0;
			$q_piutang = select_config('kredit', $where);
			while ($r_piutang_telat = mysql_fetch_array($q_piutang)) {
				$lama_angsuran = $r_piutang_telat['lama_angsuran'];
				$no_2 = 1;
				$kredit_id = $r_piutang_telat['kredit_id'];

				for ($i=0; $i < $lama_angsuran; $i++) {

						$bulan = $r_piutang_telat['kredit_date'];

						$bulan_i = date('m',strtotime($bulan));
						$bulan_angsuran_i = $i + $bulan_i;
						$bulan_ar = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
						$bulan_angsuran = $bulan_ar[$bulan_angsuran_i];

						$where_kredit_id = "WHERE kredit_id = '$kredit_id'";
				    $angsuran_kredit_id = select_config_by('angsuran_kredit', 'angsuran_kredit_id', $where_kredit_id);

				    $where_angsuran_kredit_id = "WHERE angsuran_kredit_id = '$angsuran_kredit_id'";
				    $telah_diangsur = select_config_by('angsuran_kredit_details', 'COUNT(*)', $where_angsuran_kredit_id);

						$member_id = $r_piutang_telat['member_id'];
						$where_member_id = "WHERE member_id = $member_id";
						$member_name = select_config_by('members', 'member_name', $where_member_id);

						$periode_id = $r_piutang_telat['periode'];
						$where_periode_id = "WHERE periode_id = '$periode_id'";
						$periode_name = select_config_by('periode', 'periode_name', $where_periode_id);
						if ($i >= $telah_diangsur && $bulan_angsuran_i == $bulan_i) {
							$bulan_yang_belum_diangsur = $bulan_ar[$bulan_angsuran_i];
							$data[] = array(
																'member_id'						=>  $r_piutang_telat['member_id'],
																'nama' 								=> 	$member_name,
																'bulan' 							=> 	$bulan_yang_belum_diangsur,
																'tanggal_angsuran_1'	=> 	$r_piutang_telat['pembayaran_per_tanggal_1'],
																'tanggal_angsuran_2'	=>	$r_piutang_telat['pembayaran_per_tanggal_2'],
																'periode_name'				=> 	$periode_name
															 );
						}
					}
				}
				echo json_encode($data);
			break;
}

?>
