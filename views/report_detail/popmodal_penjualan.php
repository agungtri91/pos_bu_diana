<div class="modal-header" style="border-radius:0px">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Detail Penjualan</h4>
</div>
<div class="modal-header">
  <label> Kode Penjualan : <?= $transaction_code?></label>
</div>
<div class="modal-body">
  <div class="form-group">
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

        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

        <td>Nama Partner</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
        <td></td>
      </tr>
      <tr>
        <td>Cara Pembayaran</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
        <td><?= $payment_method_name?></td>

        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

        <td>Angsuran Nominal</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
        <td><?= format_rupiah($r_kredit['angsuran_per_bulan'])?></td>

        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

        <td>Rekening Bank</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
        <td><?= $r_kredit['bank_account_angsuran']?></td>

        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
    </table>
  </div>
  <div class="box-body2 table-responsive">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th width="5%">No</th>
          <th>Nama Item</th>
          <th>Jumlah</th>
          <th>Satuan</th>
          <th>Harga Penjualan/qty</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no=1;
         while ($row = mysql_fetch_array($q_detail_transaction)) { ?>
          <tr>
            <td><?= $no;?></td>
            <td><?= $row['item_name']?></td>
            <td><?= $row['transaction_detail_qty_real']?></td>
            <td><?= $row['unit_name']?></td>
            <td><?= format_rupiah($row['transaction_detail_price'])?></td>
            <td ><?= format_rupiah($row['transaction_detail_total'])?></td>
          </tr>
        <?$no++;}?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5" style="text-align:right;font-size:22px; font-weight:bold;">Harga Total</td>
          <td style="text-align:center;font-size:22px; font-weight:bold;">Rp. <?= format_rupiah($total_all)?>,00</td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<div class="modal-footer">
  <?php
  $transaction_id=$r_transaction_id['transaction_id'];
  if (!$r_kredit['uang_muka_barang']) {
    $action = "print.php?page=list&transaction_id=$transaction_id&branch_id=$branch_id&print_tipe=1";
  } else {
    $action = "print.php?page=perjanjian_kredit&id=$transaction_id";
  }
   ?>
  <a href="<?= $action?>">
    <button type="button" class="btn btn-success">
      <i class="fa fa-print"></i>
      Print
    </button>
  </a>
  <?php if ($permit == 1): ?>
    <button type="button" class="btn btn-danger"
    onclick="confirm_delete_3(<?= $transaction_code ?>,<?= $branch_id?>,'report_detail.php?page=delete_transaction&transaction_code=','&branch_id=')"
    data-dismiss="modal">Hapus
    </button>
  <?php endif; ?>
  <button type="button" class="btn btn-primary" data-dismiss="modal">Keluar</button>
</div>
