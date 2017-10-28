<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <h4 class="modal-title" id="myModalLabel"><?= $item_name?></h4>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Pembelian</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Penjualan</a></li>
  </ul>
</div>
<div class="modal-body">
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
      <div class="box-body2 table-responsive">
        <table id="item_purchase_tb" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th style="text-align:center;" width="5%">No</th>
              <th style="text-align:center;">Supplier</th>
              <th style="text-align:center;">Tanggal Beli</th>
              <th style="text-align:center;">Jumlah Beli</th>
              <th style="text-align:center;">Jumlah Satuan Utama</th>
              <th style="text-align:center;">Harga Per Item</th>
              <th style="text-align:center;">Harga Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $total_jumlah_pemb = 0;
            while ($row = mysql_fetch_array($q_item_purchase)) {?>
              <tr>
                <td style="text-align:center;"><?= $no;?></td>
                <td><?= $row['supplier_name']?></td>
                <td style="text-align:center;"><?= $row['purchases_date']?></td>
                <td style="text-align:center;"><?= $row['purchase_qty']?> ( <?= $row['unit_name_beli']?> ) </td>
                <td style="text-align:center;"><?= konversi_qty($row['item_id'],$row['unit_id_beli'], $row['purchase_qty'])?></td>
                <td style="text-align:center;"><?= format_rupiah($row['harga_item'])?></td>
                <td style="text-align:center;"><?= format_rupiah($row['harga_item_total'])?></td>
              </tr>
            <? $total_jumlah_pemb = $total_jumlah_pemb + konversi_qty($row['item_id'],$row['unit_id_beli'], $row['purchase_qty']);
           }?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" style="text-align:center;"><strong>TOTAL JUMLAH</strong></td>
              <td style="text-align:center;"><strong><?= $total_jumlah_pemb?></strong></td>
              <td colspan="2"></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">
        <div class="box-body2 table-responsive">
          <table id="item_penjualan_tb" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th style="text-align:center;" width="5%">No</th>
                <th style="text-align:center;">Pembeli</th>
                <th style="text-align:center;">Tanggal Jual</th>
                <th style="text-align:center;">Jumlah Jual</th>
                <th style="text-align:center;">Jumlah Satuan Utama</th>
                <th style="text-align:center;">Harga Jual</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $total_jumlah_penj = 0;
              $no = 1;
              while ($row = mysql_fetch_array($q_item_penjualan)) {?>
                <tr>
                  <td style="text-align:center;"><?= $no;?></td>
                  <td style="text-align:center;"><?= $row['member_name']?></td>
                  <td style="text-align:center;"><?= $row['transaction_date']?></td>
                  <td style="text-align:center;"><?= $row['transaction_detail_qty']?> ( <?= $row['unit_name_jual']?> ) </td>
                  <td style="text-align:center;"><?= $row['transaction_detail_qty_real']?> ( <?= $row['unit_name_jual']?> )</td>
                  <td style="text-align:center;"><?= format_rupiah($row['transaction_detail_original_price'])?></td>
                </tr>
              <? $total_jumlah_penj = $total_jumlah_penj + $row['transaction_detail_qty_real'];
              }
            ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4" style="text-align:center;"><strong>TOTAL JUMLAH</strong></td>
                <td style="text-align:center;"><strong><?= $total_jumlah_penj?></strong></td>
                <td colspan="2"></td>
              </tr>
            </tfoot>
          </table>
      </div>
    </div>
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
          }
  ,
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

  $('#item_penjualan_tb').DataTable( {
      dom: 'Bfrtip',
      buttons: [

          {
              extend: 'pageLength'
          }
  ,
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
