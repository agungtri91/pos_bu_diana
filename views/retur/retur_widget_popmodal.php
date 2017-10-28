<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
  <div class="box-body2 table-responsive">
    <table id="widget_retur_tb" class="table table-bordered table-striped" style="width:100%;">
      <thead>
        <tr>
          <th style="padding:10px;text-align:center;">No</th>
          <th style="padding:10px;">Nama Item</th>
          <th style="text-align:center;padding:10px;">Jumlah</th>
          <th style="padding:10px;">Satuan</th>
          <th style="padding:10px;">Harga Konversi</th>
          <th style="padding:10px;">Harga Total</th>
          <th style="padding:20px;">Config</th>
        </tr>
      </thead>
    <tbody >
      <?php
        $no = 1;
        $query_widget = select_widget($transaction_id);
        while($row_widget = mysql_fetch_array($query_widget)){ ?>
        <tr>
          <td style="text-align:center;"><?= $no;?></td>
          <td><?= $row_widget['item_name']?></td>
          <td style="text-align:center;"><?= $row_widget['item_qty']?></td>
          <td style="text-align:center;"><?= get_unit_name($row_widget['unit_id_retur'])?></td>
          <td><?= format_rupiah($row_widget['harga_konversi'])?></td>
          <td><?= format_rupiah($row_widget['item_qty']*$row_widget['harga_konversi'])?></td>
          <td style="text-align:center;">
            <a href="javascript:void(0)" onclick="confirm_delete_retur('<?= $row_widget['retur_tmp_id']?>')"
              class="btn btn-default" ><i class="fa fa-trash-o"></i>
            </a>
          </td>
        </tr>
       <? $no++;
     } ?>
    </tbody>
    </table>
  </div>
</div>
<div class="modal-footer">
  <div class="row">
    <div class="col-md-6">
      <a href="retur.php?page=reset&transaction_id=<?= $transaction_id ?>"
      class="btn btn-danger btn-block " >Reset</a>
    </div>
    <div class="col-md-6">
      <a href="retur.php?page=close&transaction_id=<?= $transaction_id ?>"
      class="btn btn-default btn-block " >Close</a>
    </div>
    </div>
</div>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#widget_retur_tb').dataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": true,
        "sDom": 'lfrtip',
        "scrollCollapse": true,
        lengthMenu: [
            [ 5 ]
        ]
          });
    })
  </script>
