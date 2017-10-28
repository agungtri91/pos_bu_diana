<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/gadai_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucwords("gadai");

$_SESSION['menu_active'] = 3;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['menu_active']);
switch ($page) {
  case 'list':
    get_header();
    $date = isset($_SESSION['tanggal']) ? $_SESSION['tanggal'] : format_date(date("Y-m-d"));
    $where = '';
    $q_branch = select_config('branches', $where);
    $q_member = select_config('members', $where);
    include '../views/gadai/list.php';
    get_footer();
    break;

  case 'tambah_member_popmodal':
    $gadai = $_GET['gadai'];
    $branch_id = $_GET['branch_id'];
    $tanggal = $_GET['tanggal'];
    $where = "WHERE branch_id = '$s_cabang'";
    $q_tipe_pembeli = select_config('type_pembeli',$where);
    $action = 'gadai.php?page=save_member';
    include '../views/gadai/tambah_member_popmodal.php';
    break;

   case 'save_member':
    $i_name = $_POST['i_name'];
    $i_phone = $_POST['i_phone'];
    $i_alamat = $_POST['i_alamat'];
    $i_email = $_POST['i_email'];
    $tipe_pembeli = $_POST['tipe_pembeli'];
    $gadai_id = $_POST['gadai_id'];
    $data = "'',
        '$i_name',
        '$i_phone',
        '$i_email',
        '$i_alamat',
        '',
        '$tipe_pembeli'";

    create_config("members",$data);
     break;

 case 'select_tipe_pembeli':
   $where = '';
   $query = select_config('type_pembeli',$where);

   while ($row = mysql_fetch_array($query)) {
     $data[] = array('type_id_pembeli'    => $row['type_id_pembeli'],
                     'type_pembeli_name'  => $row['type_pembeli_name']);
   }
   echo json_encode($data);
   break;

case 'ket_member':
  $i_member = $_POST['i_member'];
  $where = "where member_id = '$i_member'";
  $query = select_config('members', $where);
  $row = mysql_fetch_array($query);
  $data = array('member_name' => $row['member_name'],
                'member_id'  => $row['member_id'],
                'member_nik'  => $row['member_nik']);
  echo json_encode($data);
  break;

  default:

    break;
 case 'simpan_member':
   extract($_POST);

   $i_name = get_isset($i_name);
   $i_phone = get_isset($i_phone);
   $i_email = get_isset($i_email);
   $i_discount = '';
   $i_nik = get_isset($i_nik);
   $i_alamat = get_isset($i_alamat);
   $i_kode_pos = get_isset($i_kode_pos);
   $i_rt = get_isset($i_rt);
   $i_rw = get_isset($i_rw);
   $i_kelurahan = get_isset($i_kelurahan);
   $i_kecamatan = get_isset($i_kecamatan);
   $i_kota = get_isset($i_kota);
   $i_ibu = get_isset($i_ibu);
   $i_tanggal_lahir = get_isset($i_tanggal_lahir);
   $i_tanggal_lahir = format_back_date($i_tanggal_lahir);
   $i_tempat_lahir = get_isset($i_tempat_lahir);
   $i_status_kawin = get_isset($i_status_kawin);
   $i_tanggungan = get_isset($i_tanggungan);
   $i_phone_rumah = get_isset($i_phone_rumah);
   $i_phone = get_isset($i_phone);
   $i_status_rumah = get_isset($i_status_rumah);
   $i_lama_tinggal = get_isset($i_lama_tinggal);
   $i_pendidikan = get_isset($i_pendidikan);
   $i_email = get_isset($i_email);

   $nama_darurat = get_isset($nama_darurat);
   $i_hubungan = get_isset($i_hubungan);
   $alamat_darurat = get_isset($alamat_darurat);
   $telp_darurat = get_isset($telp_darurat);

   $nama_perusahaan = get_isset($nama_perusahaan);
   $alamat_perusahaan = get_isset($alamat_perusahaan);
   $i_kode_pos_perusahaan = get_isset($kode_pos_perusahaan);
   $i_rt_perusahaan = get_isset($rt_perusahaan);
   $i_rw_perusahaan = get_isset($rw_perusahaan);
   $kel_perusahaan = get_isset($kel_perusahaan);
   $kec_perusahaan = get_isset($kec_perusahaan);
   $kota_perusahaan = get_isset($kota_perusahaan);
   $telp_perusahaan = get_isset($telp_perusahaan);
   $jenis_pekerjaan = get_isset($jenis_pekerjaan);
   $jabatan = get_isset($jabatan);
   $lama_bekerja_tahun = get_isset($lama_bekerja_tahun);
   $lama_bekerja_bulan = get_isset($lama_bekerja_bulan);
   $penghasilan = get_isset($penghasilan);
   $pengeluaran = get_isset($pengeluaran);
   $penghasilan_lain = get_isset($penghasilan_lain);
   $sumber_penghasilan_lain = get_isset($sumber_penghasilan_lain);
   $tipe_pembeli = '';
   $data = "'',
           '$i_name',
           '$i_phone',
           '$i_email',
           '$i_alamat',
           '$i_discount',
           '$i_nik',
           '$i_kelurahan',
           '$i_kecamatan',
           '$i_rt',
           '$i_rw',
           '$i_kode_pos',
           '$i_kota',
           '$i_ibu',
           '$i_tempat_lahir',
           '$i_tanggal_lahir',
           '$i_status_kawin',
           '$i_tanggungan',
           '$i_phone_rumah',
           '$i_status_rumah',
           '$i_lama_tinggal',
           '$i_pendidikan',
           '$tipe_pembeli'";

   create_config('members', $data);
   $member_id = mysql_insert_id();

   $data_darurat = "'',
                    '$member_id',
                    '$nama_darurat',
                    '$i_hubungan',
                    '$alamat_darurat',
                    '$telp_darurat'";

   create_config('members_darurat', $data_darurat);
   $data_kerja = "'',
                  '$member_id',
                  '$nama_perusahaan',
                  '$alamat_perusahaan',
                  '$i_rt_perusahaan',
                  '$i_rw_perusahaan',
                  '$i_kode_pos_perusahaan',
                  '$kel_perusahaan',
                  '$kec_perusahaan',
                  '$kota_perusahaan',
                  '$telp_perusahaan',
                  '$jenis_pekerjaan',
                  '$jabatan',
                  '$lama_bekerja_tahun',
                  '$lama_bekerja_bulan',
                  '$penghasilan',
                  '$pengeluaran',
                  '$penghasilan_lain',
                  '$sumber_penghasilan_lain'
                  ";

   create_config('members_pekerjaan', $data_kerja);
   $_SESSION['member_id'] = $member_id;
   header("Location: gadai.php?page=list");
   break;

   case 'select_periode':
     $table = $_POST['table'];
     $where = 'WHERE periode_id != 1 and periode_id != 4';
     $query = select_config($table, $where);
     while ($row = mysql_fetch_array($query)) {
       $data[] = array( 'id'    => $row['periode_id'],
                        'name'  => $row['periode_name']);
     };
     echo json_encode($data);
     break;

   case 'select_tipe_barang':
     $table = $_POST['table'];
     $where = '';
     $query = select_config($table, $where);
     while ($row = mysql_fetch_array($query)) {
       $data[] = array( 'id'    => $row['kategori_id'],
                        'name'  => $row['kategori_name']);
     };
     echo json_encode($data);
     break;

   case 'select_payment':
     $table = $_POST['table'];
     $where = 'WHERE payment_method_id = 1 OR payment_method_id = 3';
     $query = select_config($table, $where);
     while ($row = mysql_fetch_array($query)) {
       $data[] = array( 'id'    => $row['payment_method_id'],
                        'name'  => $row['payment_method_name']);
     };
     echo json_encode($data);
     break;

  case 'session_destroy':
    unset($_SESSION['member_id']);
    unset($_SESSION['tanggal']);
    header("Location: gadai.php?page=list");
    break;

  case 'save_gadai':
    $i_kode_program = $_POST['i_kode_program'];
    $i_nama_barang = $_POST['i_nama_barang'];
    $i_jenis_barang = $_POST['i_jenis_barang'];
    $merk_barang = $_POST['merk_barang'];
    $i_tipe_barang = $_POST['i_tipe_barang'];
    $i_adminstrasi = $_POST['i_adminstrasi'];
    $i_harga_barang = $_POST['i_harga_barang'];
    $i_uang_muka_barang = '';
    $i_cara_pembayaran = $_POST['i_cara_pembayaran'];
    $i_nilai_pembiayaan = $_POST['i_nilai_pembiayaan'];
    $i_periode_angsuran = $_POST['i_periode_angsuran'];
    $i_lama_angsuran = $_POST['i_lama_angsuran'];
    $i_angsuran_per_bulan = $_POST['i_angsuran_per_bulan'];
    $i_date_pembayaran = $_POST['i_date_pembayaran'];
    $i_date = explode("-",$i_date_pembayaran);
    $i_date1 = $i_date[0];
    $i_date2 = $i_date[1];

    $i_date_gadai = $_GET['i_date'];
    $i_date_gadai = format_back_date($i_date_gadai);
    $i_branch_id = $_GET['i_branch_id'];
    $i_member = $_GET['i_member'];
    $img_val = $_GET['img_val'];

    $gadai_code = 'K_'.time();

    $data_gadai_tmp = "'',
                        '$gadai_code',
                        '".$_SESSION['user_id']."',
                        '$i_member',
                        '$i_nama_barang',
                        '$i_jenis_barang',
                        '$merk_barang',
                        '$i_tipe_barang',
                        '$i_adminstrasi',
                        '$i_harga_barang',
                        '$i_uang_muka_barang',
                        '$i_cara_pembayaran',
                        '$i_nilai_pembiayaan',
                        '$i_periode_angsuran',
                        '$i_lama_angsuran',
                        '$i_angsuran_per_bulan',
                        '$i_date1',
                        '$i_date2',
                        '$i_date_gadai',
                        '',
                        '$s_cabang',
                        '0'";
    create_config('gadai_tmp',$data_gadai_tmp);
    $gadai_id = mysql_insert_id();

    $total = count($i_img_tmp = $_FILES['i_img']['tmp_name']);
    $path = "../img/item_gadai/";
    for ($i=0; $i < $total; $i++) {
        $i_img_tmp = $_FILES['i_img']['tmp_name'][$i];
        $i_img = ($_FILES['i_img']['name'][$i]) ? $_FILES['i_img']['name'][$i] : "";
        if ($i_img) {
          $data_gadai_tmp_details = "'',
                                     '$gadai_id',
                                     '$i_img'";
         create_config('gadai_tmp_details',$data_gadai_tmp_details);
         move_uploaded_file($i_img_tmp, $path.$i_img);
        }
    }
    header("location:gadai.php?page=list");
    break;
}

 ?>
