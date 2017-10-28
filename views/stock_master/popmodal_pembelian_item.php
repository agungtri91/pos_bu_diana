<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <h4 class="modal-title" id="myModalLabel"><?= $item_name?></h4>
</div>
<div class="modal-body">
  <div class="box-body2 table-responsive">
    <table id="item_purchase_tb" class="table table-bordered table-striped" width="100%">
      <thead>
        <tr>
          <th style="text-align:center;" width="5%">No</th>
          <th style="text-align:center;">Supplier</th>
          <th style="text-align:center;">Tanggal Beli</th>
          <th style="text-align:center;">Jumlah Beli</th>
          <!-- <th style="text-align:center;">Jumlah Satuan</th> -->
          <th style="text-align:center;">Harga</th>
          <th style="text-align:center;">Harga Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $total_jumlah = 0;
        $total_pembelian = 0;
        while ($row = mysql_fetch_array($q_item_purchase)) {?>
          <tr>
            <td><?= $no;?></td>
            <td><?= $row['supplier_name']?></td>
            <td style="text-align:center;"><?= format_date_only($row['purchases_date'])?></td>
            <td style="text-align:center;"><?= format_rupiah($row['purchase_qty'])?></td>
            <!-- <td style="text-align:center;"><?= konversi_ke_satuan_utama($row['item_id'],$row['unit_id_beli'], $row['purchase_qty'])?></td> -->
            <td style="text-align:center;"><?= format_rupiah($row['harga_item'])?></td>
            <td style="text-align:center;"><?= format_rupiah($row['harga_item_total'])?></td>
          </tr>
        <?
        $total_jumlah = $total_jumlah + $row['purchase_qty'];
        $total_pembelian = $total_pembelian + $row['harga_item_total'];
       }?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2" style="text-align:center;"><strong>TOTAL JUMLAH</strong></td>
          <td style="text-align:center;"><strong><?= $total_jumlah?></strong></td>
          <td colspan="2"><strong>TOTAL PENGELUARAN PEMBELIAN</strong></td>
          <td style="text-align:center;"><strong><?= format_rupiah($total_pembelian)?></strong></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-danger" data-dismiss="modal">Keluar</button>
</div>
<script type="text/javascript">
$(document).ready(function() {
  $('#item_purchase_tb').DataTable( {
      dom: 'Bfrtip',
      buttons: [

          {
              extend: 'pageLength'
          },
          {
              extend: 'copy'
          },
          {
              extend: 'excel'
          },
          {
              extend: 'pdf'
          }
      ],
      lengthMenu: [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ]
  } );
} );
</script>
