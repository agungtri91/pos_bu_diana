<div class="modal-header">

</div>
<div class="modal-body">
  <div class="box-body2 table-responsive">
    <table id="widget_tb_purchase" class="table table-bordered table-striped" style="width:100%;">
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
         <td><?= $row_widget['item_stock_qty']?></td>
         <td><?= $row_widget['unit_name']?></td>
         <td><?= format_rupiah($row_widget['harga'])?></td>
         <td><?= format_rupiah($row_widget['harga_total'])?></td>
         <td style="text-align:center;">
           <a href="javascript:void(0)"
           onclick="confirm_delete(<?= $row_widget['purchases_id']; ?>,'purchase.php?page=delete_widget&id=<?= $row_widget['item_id']?>id=')"
           class="btn btn-default" >
             <i class="fa fa-trash-o"></i>
           </a>
         </td>
       </tr>
       <?php $no++; } ?>
      </tbody>
    </table>
  </div>
</div>
<div class="modal-footer">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-6">
        <a href="purchase.php?page=reset&purchases_id=<?= $purchase_id ?>"
          class="btn btn-danger btn-block " >
          Reset
        </a>
      </div>
      <div class="col-md-6">
        <a type="button" class="btn btn-default btn-block" data-dismiss="modal" >Keluar</a>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $('#widget_tb_purchase').dataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "sDom": 'lfrtip',
      "scrollCollapse": true,
      lengthMenu: [
          [ 5 ]
      ]
        });
  });
</script>
