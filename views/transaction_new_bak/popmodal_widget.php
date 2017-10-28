<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="box-body2 table-responsive">
      <table id="widget_tb" class="table table-bordered table-striped" style="width:100%;">
        <thead>
          <tr>
            <th style="text-align:center;width:5%;">No.</th>
            <th>Nama Item</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Harga Total</th>
  					<th>Config</th>
          </tr>
        </thead>
      <tbody >
        <?php
          $no = 1;
        while($row_widget = mysql_fetch_array($query_widget)){ ?>
        <tr>
          <td style="text-align:center;"><?= $no?></td>
          <td><?= $row_widget['item_name']?></td>
          <td><?= $row_widget['jumlah_konversi']?></td>
          <td><?= $row_widget['unit_name']?></td>
          <td><?= format_rupiah($row_widget['harga'])?></td>
          <td><?= format_rupiah($row_widget['jumlah_konversi'] * $row_widget['harga'])?></td>
          <td style="text-align:center;">
            <a href="javascript:void(0)"
            onclick="confirm_delete(<?= $row_widget['wt_id']; ?>,
            'transaction_new.php?page=delete_widget&transaction_id=<?= $transaction_id ?>&id=')"
            class="btn btn-default" >
              <i class="fa fa-trash-o"></i>
            </a>
          </td>
        </tr>
         <? $no++;} ?>
      </tbody>
      </table>
    </div>
</div>
<div class="modal-footer">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-6">
        <a type="button" href="transaction_new.php?page=reset&transaction_id=<?= $transaction_id ?>"
        class="btn btn-danger btn-block " >Reset</a>
      </div>
      <div class="col-md-6">
        <a type="button" href="transaction_new.php?page=close&transaction_id=<?= $transaction_id ?>"
        class="btn btn-default btn-block " >Close</a>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $('#widget_tb').dataTable({
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
