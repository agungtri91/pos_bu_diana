<style media="screen">
  .center {
    text-align: center;
  }
  .active{

  }
</style>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel">Piutang / Kredit Detail</h4>
</div>
<form class="" action="<?= $action ?>" method="post">
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="box-body">
          <div class="row">
            <div class="col-md-8">
              <input type="hidden" name="kredit_id" value="<?= $kredit_id?>">
              <input type="hidden" name="member_id" value="<?= $member_id?>">
              <input type="hidden" name="transaction_id" value="<?= $transaction_id?>">

              <input type="hidden" id="param_tombol_submit" name="param_tombol_submit" value="0">
              <table>
                <tr>
                  <td>Nama Barang</td><td>&nbsp;&nbsp;&nbsp;:</td><td>&nbsp;<?= $item_name?></td>
                </tr>
                <tr>
                  <td>Nama </td><td>&nbsp;&nbsp;&nbsp;:</td><td>&nbsp;Rp.<?= format_rupiah($r_item_kredit['item_price'])?>,00</td>
                </tr>
                <tr>
                  <td>Tanggal </td><td>&nbsp;&nbsp;&nbsp;:</td><td>&nbsp;<?= format_date_only($r_item_kredit['kredit_date'])?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <?php if ($r_item_kredit['lunas'] == 1): ?>
                  <tr>
                    <td>Biaya Adminstrasi</td><td>&nbsp;&nbsp;&nbsp;:</td><td>&nbsp;Rp.<?= format_rupiah($r_item_kredit['administrasi'])?>,00</td>
                  </tr>
                  <tr>
                    <td>Uang Muka</td><td>&nbsp;&nbsp;&nbsp;:</td><td>&nbsp;Rp.<?= format_rupiah($r_item_kredit['uang_muka_barang'])?>,00</td>
                  </tr>
                  <tr>
                    <td>Angsuran</td><td>&nbsp;&nbsp;&nbsp;:</td><td>&nbsp;<?= $r_item_kredit['lama_angsuran']?> <?= $periode_name?></td>
                  </tr>
                  <tr>
                    <td>Angsuran Per Tanggal</td><td>&nbsp;&nbsp;&nbsp;:</td>
                    <td>&nbsp;<?= $r_item_kredit['pembayaran_per_tanggal_1'].'-'.$r_item_kredit['pembayaran_per_tanggal_2']?></td>
                  </tr>
                  <tr>
                    <td>Angsuran Per Bulan</td><td>&nbsp;&nbsp;&nbsp;:</td><td>&nbsp;Rp.<?= format_rupiah($r_item_kredit['angsuran_per_bulan'])?>,00</td>
                  </tr>
                <?php endif; ?>
              </table>
            </div>
            <div class="col-md-4">
              <div class="form-group" style="width:210px;height:auto;">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <center>
                      <?php
                      $item_gambar = $item_gambar ? "../img/menu/".$item_gambar : "../img/img_not_found.png"; ?>
                      <img src="<?= $item_gambar ?>" style="max-width:150px;max-height:150px;"/>
                    </center>
                  </div>
                </div>
              </div>
            </div>
            <div class="">
              <div class="box box-body2 table-responsive">
                <table id="tb_pengangsuran_piutang" class="table table-bordered table-striped" style="width:100%;">
                  <thead>
                    <tr>
                      <th class="center" style="width:5%;">No.</th>
                      <th class="center">Jumlah Angsuran</th>
                      <th class="center">Periode</th>
                      <th class="center">Tanggal</th>
                      <th class="center">Ket.</th>
                      <th class="center">Denda</th>
                      <th class="center">Config.</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $berapa_kali = $r_item_kredit['lama'];
                    for ($i=0; $i < $berapa_kali; $i++) {?>
                      <tr>
                        <td class="center"><?= $no?></td>
                        <td class="center">Rp.<?= format_rupiah($r_item_kredit['angsuran_per_bulan'])?></td>
                        <?php
                        $bulan = $r_item_kredit['kredit_date'];
                        $tanggal = date('m',strtotime($bulan));
                        $bulan_angsuran = $i + $tanggal;
                        $bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
                        $bulan_angsuran = $bulan[$bulan_angsuran];
                        ?>
                        <td class="center">
                        <?php if ($r_item_kredit['periode']==3): ?>
                          <?= $bulan_angsuran?>
                        <?php else: ?>
                          Minggu ke - <?= $i+1?>
                        <?php endif; ?>
                        </td>
                        <td class="center"><?= $r_item_kredit['pembayaran_per_tanggal_1']." - ".$r_item_kredit['pembayaran_per_tanggal_2']?></td>
                        <td class="center">
                          <?php
                          $tanggal_batas_real = $r_item_kredit['pembayaran_per_tanggal_2'];
                          $tanggal_batas = (int) $tanggal_batas_real;

                          $tanggal = new_date();
                          $hari     = date('d',strtotime($tanggal));
                          $bulan    = date('m',strtotime($tanggal));
                          $tahun    = date('Y',strtotime($tanggal));

                          $tanggal_skrg_aktif = format_date_only($tanggal);

                          $bulan_angsuran = $i + $bulan;
                          $tanggal_selama_angsuran = $tahun.'-'.$bulan_angsuran.'-'.$hari;
                          $tanggal_selama_angsuran = date('d/m/Y',strtotime($tanggal_selama_angsuran));
                          $tanggal_explode = explode('/',$tanggal_selama_angsuran);

                          $tanggal_explode_hari   = (int) $tanggal_explode[0];
                          $tanggal_explode_bulan  = (int) $tanggal_explode[1];
                          $tanggal_explode_tahun  = (int) $tanggal_explode[2];

                          $tanggal_kredit = $r_item_kredit['kredit_date'];
                          $tahun_kredit = date("Y", strtotime($tanggal_kredit));
                          $status = 0;
                          if ($telah_diangsur >= $no){
                            echo "Sudah Dibayar";
                          }elseif ($tanggal_batas < $hari && $tanggal_explode_bulan > $bulan && $tanggal_explode_tahun > $tahun_kredit) {
                            $status=1;
                            echo "Telat";
                          } elseif ($tanggal_batas > $hari && $tanggal_explode_bulan > $bulan && $tanggal_explode_tahun > $tahun_kredit) {
                            $status=1;
                            echo "Telat";
                          } elseif ($tanggal_batas > $hari && $tanggal_explode_bulan > $bulan && $tanggal_explode_tahun == $tahun_kredit) {
                            $status=1;
                            echo "Telat";
                          } elseif ($tanggal_batas < $hari && $tanggal_explode_bulan == $bulan && $tanggal_explode_tahun == $tahun_kredit) {
                            $status=1;
                            echo "Telat";
                          } elseif ($tanggal_batas > $hari && $tanggal_explode_bulan == $bulan && $tanggal_explode_tahun == $tahun_kredit) {
                            $status=1;
                            echo "Telat";
                          } elseif ($tanggal_batas < $hari && $tanggal_explode_bulan > $bulan && $tanggal_explode_tahun == $tahun_kredit) {
                            $status=0;
                            echo "Aman";
                          } elseif ($tanggal_batas > $hari && $tanggal_explode_bulan > $bulan && $tanggal_explode_tahun <= $tahun_kredit) {
                            $status=0;
                            echo "Aman";
                          }
                          error_reporting(0);
                          ?>
                          <input type="hidden" id="i_status" name="i_status[]" value="<?= $status?>">
                        </td>
                        <td class="center">
                          <?php if ($status==1){
                            $denda = get_denda_persen($r_item_kredit['periode']);
                            echo $denda ." %";
                            }?>
                        </td>
                        <td class="center">
                          <a type="button" class="btn btn-default" <?php if ($telah_diangsur >= $no){echo "disabled";}?>
                          href="javascript:void(0);" onclick="checked_bayar(<?= $no?>)">
                            <i id="icon_<?= $no?>" class="fa fa-times"></i>
                            <input type="hidden" id="input_<?= $no?>" name="input[]" value="0">
                          </a>
                        </td>
                      </tr>
                    <? $no++; }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary" id="button_submit" name="button_submit" disabled="true">Bayar</button>
    <button type="button" class="btn btn-danger" name="close" data-dismiss="modal">Keluar</button>
  </div>
</form>
<script type="text/javascript">

function telat_bayar(){
  $('#small_modal').modal();
  var url = 'angsuran.php?page=telat_bayar_popmodal';
    $('#small_modal_content').load(url,function(result){
  });
}

  function checked_bayar(id) {
    var id_active = '#icon_'+id;
    var button_active = $(id_active);
    var param = $('#input_'+id).val();
    var x = $('#input_'+id).val();
    var tot = $('#param_tombol_submit').val();
    if (param == 0) {
      button_active.removeClass('fa-times');
      button_active.addClass('fa-check');
      $('#input_'+id).val(1);
      tot = parseInt(tot)+1;
    } else {
      button_active.addClass('fa-times');
      button_active.removeClass('fa-check');
      $('#input_'+id).val(0);
      tot = parseInt(tot)-1;
    }
    $('#param_tombol_submit').val(tot)
    var button_submit = $('#button_submit');
    if (tot != 0) {
      button_submit.removeAttr('disabled','true');
    } else {
      button_submit.attr('disabled','false');
    }
  }
</script>
