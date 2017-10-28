<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body2 table-responsive">
        <div class="box-header" style="cursor: move;">
          <h3 class="box-title"><strong>List Pembelian</strong></h3>
        </div>
        <table id="list_pembelian" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th>Tanggal</th>
              <th>Purchase code</th>
              <th>User</th>
              <th>Total</th>
              <th>Supplier</th>
              <th>Cabang</th>
              <th>Ket.</th>
              <th>Config</th>
            </tr>
          </thead>
        <tbody>
        <?php
          $no_tr = 1;
          while($row_tr = mysql_fetch_array($query_purchase)){ ?>
            <tr>
              <td><?= $no_tr?></td>
              <td><?= format_date_only($row_tr['purchases_date'])?></td>
              <td><?= $row_tr['purchases_code']?></td>
              <td><?= $row_tr['user_name']?></td>
              <td><?= tool_format_number($row_tr['purchase_total'])?></td>
              <td><?= $row_tr['supplier_name']?></td>
              <td><?= $row_tr['branch_name']?></td>
              <?php if($row_tr['lunas'] == 1){?>
                <td>Belum lunas</td>
              <?} elseif ($row_tr['lunas'] == 2) {?>
                <td>Sudah lunas</td>
              <?} else{?>
                <td>Lunas</td>
              <?}?>
              <td style="text-align:center;">
                <button type="button" class="btn btn-default"
                onclick="detail_purchase(<?= $row_tr['purchases_code']?>,<?= $row_tr['branch_id']?>)">
                  <i class="fa fa-search"></i>
                </button>
              </td>
            </tr>
        <?php $no_tr++; } ?>
        </tbody>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>
<div id="modal_pembelian" class="modal fade bs-example-modal-lg" tabindex="-1"
role="dialog" aria-labelledby="myLargeModalLabel" style="z-index:888888;">
  <div class="modal-dialog modal-lg" role="document"  style="width:1100px;">
    <div class="modal-content" style="border-radius:0;">

    </div>
  </div>
</div>
<script>
  function detail_purchase(x,y) {
    $('#modal_pembelian').modal();
  $(function(){
    var url = "report_detail.php?page=popmodal&purchases_code="+x+"&branch_id="+y;
      $('.modal-content').load(url,function(result){
    });
  })
}


  $(document).ready(function() {
    $('#list_pembelian').DataTable( {
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
