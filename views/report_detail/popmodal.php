
<div class="modal-header" style="border-radius:0px">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Detail Pembelian</h4>
</div>
<div class="modal-header">
  <label> Kode Pembelian : <?= $purchase_code?></label>
</div>
<div class="modal-body">
  <table style="line-height:25px;">
    <tr>
      <td>Nama Supplier</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
      <td><?= $supplier_name?></td>

      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

      <td>Uang Muka</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
      <td><?= format_rupiah($r_hutang['uang_muka_barang']) ? format_rupiah($r_hutang['uang_muka_barang']) : "" ?></td>

      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

      <td>Bank</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
      <td><?= get_bank_name($r_hutang['bank_id_angsuran']) ? get_bank_name($r_hutang['bank_id_angsuran']) : ""?></td>
    </tr>
    <tr>
      <td>Cara Pembayaran</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
      <td><?= $payment_method_name?></td>

      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

      <td>Angsuran Nominal</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
      <td><?= format_rupiah($r_hutang['angsuran_per_bulan']) ? format_rupiah($r_hutang['angsuran_per_bulan']): ""?></td>

      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

      <td>Rekening Bank</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
      <td><?= $r_hutang['bank_account_angsuran']?></td>
    </tr>
  </table>
  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th width="5%">No</th>
        <th>Nama Item</th>
        <th>Jumlah</th>
        <th>Satuan</th>
        <th>Harga Pembelian/qty</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no=1;
       while ($row = mysql_fetch_array($q_detail_trans)) { ?>
        <tr>
          <td><?= $no;?></td>
          <td><?= $row['item_name']?></td>
          <td><?= $row['purchase_qty']?></td>
          <td><?= $row['unit_name']?></td>
          <td><?= format_rupiah($row['purchase_price'])?></td>
          <td><?= format_rupiah($row['p_total'])?></td>
        </tr>
      <?$no++;}?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="5" style="text-align:right;font-size:22px; font-weight:bold;">Harga Total</td>
        <td style="text-align:center;font-size:22px; font-weight:bold;">Rp. <?= format_rupiah($purchase_total)?>,00</td>
      </tr>
    </tfoot>
  </table>
</div>
<div class="modal-footer">
  <a href="print.php?page=print_purchase&id=<?= $purchase_id?>">
    <button type="button" class="btn btn-success">
      <i class="fa fa-print"></i>
      Print
    </button>
  </a>
  <?php if ($permit == 1): ?>
    <button type="button" class="btn btn-danger"
    onclick="confirm_delete_3(<?= $purchases_code ?>,<?= $branch_id?>,'report_detail.php?page=delete_purchase&purchases_code=','&branch_id=')"
    data-dismiss="modal">
      Hapus
    </button>
  <?php endif; ?>
  <button type="button" class="btn btn-primary" data-dismiss="modal">Keluar</button>
</div>
