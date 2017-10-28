<style media="screen">
  .center{
    text-align: center;
  }
  .right{
    text-align: right;;
  }
</style>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= $transaction_code?></h4>
</div>
<div class="modal-body">
  <div class="form-group">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-10">
          <table style="line-height:25px;">
            <tr>
              <td>Nama Pembeli</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
              <td><?= $member_name?></td>

              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

              <td>Uang Muka</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
              <td><?= format_rupiah($r_kredit['uang_muka_barang'])?></td>

              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

              <td>Bank</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
              <td><?= get_bank_name($r_kredit['bank_id_angsuran'])?></td>
            </tr>
            <tr>
              <td>Cara Pembayaran</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
              <td><?= $payment_method_name?></td>

              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

              <!--<td>Angsuran Nominal</td>-->
              <!--<td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>-->
              <!--<td><?= format_rupiah($r_kredit['angsuran_per_bulan'])?></td>-->

              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

              <td>Rekening Bank</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
              <td><?= $r_kredit['bank_account_angsuran']?></td>
            </tr>
          </table>
        </div>
        <?php if ($kredit_id != null): ?>
        <div class="col-md-2">
            <a type="button" name="button" class="btn btn-primary btn-xs"
            href="piutang.php?page=form&id=<?= $member_id?>&member_detail=1">Daftar Kredit</a>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="box-body2 table-responsive">
    <table id="tb_detail_transaksi" class="table table-bordered table-striped" width="100%">
      <thead>
        <tr>
          <th class="center">No</th>
          <th class="center">Nama Item</th>
          <th class="center">Jumlah</th>
          <th class="center">Satuan</th>
          <th class="center">Harga Item</th>
          <th class="center">Harga Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($row = mysql_fetch_array($q_transaction_detail)) { ?>
          <tr>
            <td class="center"><?= $no?></td>
            <td class="center"><?= $row['item_name']?></td>
            <td class="center"><?= $row['transaction_detail_qty']?></td>
            <td class="center"><?= $row['unit_name']?></td>
            <td class="center"><?= $row['transaction_detail_original_price']?></td>
            <td class="center"><?= $row['transaction_detail_total']?></td>
          </tr>
        <? $no++;} ?>
      </tbody>
      <tfoot>
        <tr>
          <td class="right" colspan="5">Transaksi Diskon Persen(<?= $row['transaction_discount']?>)</td>
          <td class="right"><?= $r_transaction['total_discount_persen']?></td>
        </tr>
        <tr>
          <td class="right" colspan="5">Transaksi Diskon Nominal</td>
          <td class="right"><?= $r_transaction['transaction_discount_nominal']?></td>
        </tr>
        <tr>
          <td class="right" colspan="5">Transaksi Total</td>
          <td class="right"><?= $r_transaction['transaction_grand_total']?></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<div class="modal-footer">

</div>
<script type="text/javascript">
$(document).ready(function() {
  $('#tb_detail_transaksi').DataTable( {
    //   dom: 'Bfrtip',
    //   buttons: [
    //
    //       {
    //           extend: 'pageLength'
    //       },
    //       {
    //           extend: 'copy'
    //       },
    //       {
    //           extend: 'excel'
    //       },
    //       {
    //           extend: 'pdf'
    //       }
    //   ],
    //   lengthMenu: [
    //       [ 10, 25, 50, -1 ],
    //       [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    //   ]
    // } );
  } );
</script>
