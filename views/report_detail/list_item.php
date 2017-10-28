<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body2 table-responsive">
        <div class="box-header" style="cursor: move;">
          <h3 class="box-title"><strong>Detail Per Item Penjualan</strong></h3>
        </div>
        <table id="list_item" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th width="5%" style="text-align:center;">No</th>
              <th style="text-align:center;">Nama Item</th>
              <th style="text-align:center;">Qty</th>
              <th style="text-align:center;">Item price</th>
              <th style="text-align:center;">Cabang</th>
              <th style="text-align:center;">Omset</th>
              <th style="text-align:center;">Config.</th>
            </tr>
          </thead>
        <tbody>
        <?php
          $no_item = 1;
          $grand_total_dasar = 0;
          $grand_total_omset = 0;
          while($row_item = mysql_fetch_array($query_item)){
            $jumlah = ($row_item['jumlah']) ? $row_item['jumlah'] : 0;
            $total = $jumlah * $row_item['item_price'];?>
          <tr>
            <td  style="text-align:center;">
              <?= $no_item ?>
            </td>
            <td>
              <?= $row_item['item_name']; ?>
            </td>
            <td style="text-align:center;">
              <?= tool_format_number($jumlah)?>
            </td>
            <td>
              <?= tool_format_number($row_item['item_price'])?>
            </td>
            <td style="text-align:center;">
              <?= $row_item['branch_name']?>
            </td>
            <td>
              <?= tool_format_number($row_item['jumlah_omset'])?>
            </td>
            <td style="text-align:center;"><button type="button" class="btn btn-default"
              onclick="detail_item(<?= $row_item['item_id']?>)">
              <i class="fa fa-search"></i></button>
            </td>
          </tr>
        <?php
          $grand_total_dasar = $grand_total_dasar + $row_item['jumlah_dasar'];
          $grand_total_omset = $grand_total_omset + $row_item['jumlah_omset'];
          $no_item++; } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5" align="right"  style="font-size:22px; font-weight:bold;">TOTAL</td>
            <td><?= tool_format_number_report($grand_total_omset)?></td>
            <td></td>
          </tr>
        </tfoot>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>
<div id="popmodal_item" class="modal fade bs-example-modal-lg" tabindex="-1"
role="dialog" aria-labelledby="myLargeModalLabel" style="z-index:888888;">
  <div class="modal-dialog modal-lg" role="document"  style="width:1100px;">
    <div id="popmodal_item_content" class="modal-content" style="border-radius:0;">

    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
$('#list_item').DataTable( {
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
function detail_item(x,y){
  $('#popmodal_item').modal();
  $(function(){
    var url = "report_detail.php?page=popmodal_item_detail&item_id="+x
      $('#popmodal_item_content').load(url,function(result){
    });
  })
}
</script>
