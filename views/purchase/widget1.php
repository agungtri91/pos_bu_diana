
<div style="position:fixed;" style="z-index: 120;">
    <div class="box">
      <div class="box-body2 table-responsive">
        <table id="widget_tb_purchase" class="table table-bordered table-striped">
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
           <td><?= format_rupiah($row_widget['harga_kg'])?></td>
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
        <tfoot>
          <tr>
            <td>
              <a href="purchase.php?page=reset&purchases_id=<?= $id2 ?>" class="btn btn-danger btn-block " >Reset</a>
            </td>
            <td>
               <a href="purchase.php?page=close&purchases_id=<?= $id2 ?>"
                 class="btn btn-default btn-block " >Close</a>
            </td>
          </tr>
        </tfoot>
        </table>
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
      "scrollY": "200px",
      "scrollCollapse": true,
      lengthMenu: [
          [ 5 ]
      ]
        });
  });
</script>
