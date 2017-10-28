<!-- Content Header (Page header) -->
<!-- Main content -->
  <section class="content">
    <div class="row">
    <!-- right column -->
      <div class="col-md-12">
      <!-- general form elements disabled -->
        <div class="box box-cokelat">
          <br>
          <br>
          <div class="title_page"> <?= $title ?></div>
          <div class="box-body" style="padding:20px;">
            <div class="col-md-9">
              <div class="form-group">
                <table style="line-height:30px;">
                  <tr>
                    <td>Nama </td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?= $r_member['member_name']?></td>
                  </tr>
                  <tr>
                    <td>Alamat </td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?= $r_member['member_alamat']?></td>
                  </tr>
                  <tr>
                    <td>No. Telp </td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?= $r_member['member_phone']?></td>
                  </tr>
                </table>
              </div>
            </div>
            <div style="clear:both;"></div>
          </div><!-- /.box-body -->
          <div class="box-body2 table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                  <tr>
                      <th style="text-align:center;" width="5%">No.</th>
                      <th style="text-align:center;" width="5%">Kode Transaksi</th>
                      <th style="text-align:center;">Nama Barang</th>
                      <th style="text-align:center;">Harga barang</th>
                      <th style="text-align:center;">Tanggal</th>
                      <th style="text-align:center;">Lama Angsuran</th>
                      <th style="text-align:center;">Sisa Angsuran</th>
                      <th style="text-align:center;">Nominal Angsuran</th>
                      <th style="text-align:center;">Keterangan</th>
                      <th style="text-align:center;">Config.</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  $no = 1;
                  $piutang = 0;
                  $tot_piutang = 0;
                  while($r_piutang = mysql_fetch_array($q_piutang)){ ?>
                <tr>
                  <td style="text-align:center;"><?= $no?></td>
                  <td style="text-align:center;"><?= $r_piutang['transaction_code']?></td>
                  <td style="text-align:center;"><?= $r_piutang['item_name']?></td>
                  <td style="text-align:center;">Rp.<?= format_rupiah($r_piutang['transaction_detail_original_price'])?>,00</td>
                  <td style="text-align:center;"><?= format_date_only($r_piutang['transaction_date'])?></td>
                  <td style="text-align:center;"><?= $r_piutang['lama_angsuran']?></td>
                  <?php
                  $count = get_count_angsuran($r_piutang['transaction_id'], $r_piutang['member_id']);
                  $sisa = $r_piutang['lama_angsuran'] - $count;
                   ?>
                  <td style="text-align:center;"><?= $sisa?></td>
                  <td style="text-align:center;">Rp.<?= format_rupiah($r_piutang['angsuran_per_bulan'])?>,00</td>
                  <td>
                    <?php if ($r_piutang['lunas']==0) { echo "Lunas";}?>
                    <?php if ($r_piutang['lunas']==1) { echo "Belum Lunas";}?>
                    <?php if ($r_piutang['lunas']==2) { echo "Sudah Lunas";}?>
                  </td>

                  <td style="text-align:center;">
                    <a type="button" class="btn btn-default" href="#"
                    onclick="piutang_popmodal(<?= $r_piutang['transaction_id']?>,<?= $r_piutang['member_id']?>)">
                      <i class="fa fa-search"></i>
                    </a>
                  </td>
                </tr>
                <?php
                $piutang = $sisa * $r_piutang['angsuran_per_bulan'];
                $tot_piutang = $tot_piutang + $piutang;
                $no++; }?>
              </tbody>
              <tfoot>
                <tr class="totalColumn" style="font-size:22px; font-weight:bold;text-align:center;">
                  <td colspan="4">
                    <div class="row">
                      <a type="button" name="button" class="btn btn-danger" href="piutang.php">Kembali</a>
                      <a type="button" name="button" class="btn btn-primary btn-xs" href="<?= $close_button?>">Kembali Daftar Pembeli</a>
                    </div>
                  </td>
                  <td colspan="3" class="text-center">TOTAL ANGSURAN SAAT INI : </td>
                  <td class="colTotal">Rp.<?= format_rupiah($tot_piutang)?>,00</td>
                  <td></td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /.content -->
<script type="text/javascript">
  function piutang_popmodal(id, member_id){
    $('#large_modal').modal();
  	var url = 'piutang.php?page=piutang_popmodal&id='+id+'&member_id='+member_id;
  		$('#large_modal_content').load(url,function(result){
  	});
  }
</script>
