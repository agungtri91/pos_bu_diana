<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body2 table-responsive">
        <div class="box-header" style="cursor: move;">
          <h3 class="box-title"><strong>List Retur Pembelian</strong></h3>
        </div>
        <table id="list_retur_pembelian" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th style="text-align:center;" width="5%">No</th>
              <th style="text-align:center;">Tanggal Retur</th>
              <th style="text-align:center;">Tanggal Pembelian</th>
              <th style="text-align:center;">User</th>
            </tr>
          </thead>
        <tbody>
        <?php
          $no_tr = 1;
          while($row_tr = mysql_fetch_array($query_retur_pembelian)){?>
            <tr>
              <td style="text-align:center;"><?= $no_tr?></td>
              <td style="text-align:center;"><?= format_date_only($row_tr['retur_date'])?></td>
              <td style="text-align:center;"><?= format_date_only($row_tr['purchase_date'])?></td>
              <td style="text-align:center;"><?= $row_tr['user_name']?></td>
            </tr>
        <?php $no_tr++; } ?>
        </tbody>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
$('#list_retur_pembelian').DataTable( {
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
