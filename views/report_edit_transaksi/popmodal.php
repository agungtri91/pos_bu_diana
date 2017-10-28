
<div class="modal-header" style="border-radius:0px">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Detail Pembelian</h4>
</div>
<div class="modal-header">
  <label> Kode Pembelian : <?= $purchases_code?></label>
</div>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th width="5%">No</th>
      <th>Nama Item</th>
      <th>Jumlah</th>
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
        <td><?= format_rupiah($row['purchase_price'])?></td>
        <td ><?= format_rupiah($row['purchase_total'])?></td>
      </tr>
    <?$no++;}?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="4" style="text-align:right;font-size:22px; font-weight:bold;">Harga Total</td>
      <td style="text-align:center;font-size:22px; font-weight:bold;"><?= format_rupiah($purchase_total)?></td>
    </tr>
  </tfoot>
</table>
<div class="modal-footer">
  <button type="button" class="btn btn-primary" data-dismiss="modal">Keluar</a></button>
  <!-- <button type="button" class="btn btn-danger" onclick="confirm_delete_3(<?= $purchases_code ?>,<?= $branch_id?>,'report_detail.php?page=delete_purchase&purchases_code=','&branch_id=')" data-dismiss="modal">Hapus</a></button> -->
</div>
