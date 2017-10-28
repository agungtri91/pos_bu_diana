<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div id="list_transaction_box" class="box-body2 table-responsive">
        <div class="box-header" style="cursor: move;">
          <h3 class="box-title"><strong>List Penjualan</strong></h3>
        </div>
        <table id="list_transaction" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th>Tanggal</th>
              <th>Transaksi Kode</th>
              <th>User</th>
              <th>Total</th>
              <th>Member</th>
              <th>Cabang</th>
              <th>Ket.</th>
              <th>Config</th>
            </tr>
          </thead>
        <tbody>
        <?php
          $no_tr = 1;
          while($row_tr = mysql_fetch_array($query_tr)){ ?>
            <tr>
              <td><?= $no_tr?></td>
              <td><?= format_date_only($row_tr['transaction_date'])?></td>
              <td><?= $row_tr['transaction_code']?></td>
              <td><?= $row_tr['user_name']?></td>
              <td><?= tool_format_number($row_tr['transaction_grand_total'])?></td>
              <td><?= $row_tr['member_name']?></td>
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
                onclick="detail_trans(<?= $row_tr['transaction_code']?>,<?= $row_tr['branch_id']?>)">
                  <i class="fa fa-search"></i>
                </button>
              </td>
            </tr>
        <?php $no_tr++; } ?>
        </tbody>
        <tfoot>
        </tfoot>
        </table>
      </div><!-- /.box-body -->
      <div class="box-footer">
        <button type="button" id="grafik" name="grafik" class="btn btn-primary">Grafik</button>
      </div>
    </div><!-- /.box -->
  </div>
</div>
<div id="modal_penjualan" class="modal fade bs-example-modal-lg" tabindex="-1"
role="dialog" aria-labelledby="myLargeModalLabel" style="z-index:888888;">
  <div class="modal-dialog modal-lg" role="document"  style="width:1100px;">
    <div class="modal-content" style="border-radius:0;">

    </div>
  </div>
</div>
<script>

  $("#grafik").click(function(){
        $("#list_transaction_box").slideUp();
    });

  function detail_trans(x,y) {
    $('#modal_penjualan').modal();
  $(function(){
    var url = "report_detail.php?page=popmodal_penjualan&transaction_code="+x+"&branch_id="+y;
      $('.modal-content').load(url,function(result){
    });
  })
}

$(document).ready(function() {
  $('#list_transaction').DataTable( {
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

$(document).ready(function() {
  $('.foot').click(function() {
      if($('.foot').hasClass('slide-up')) {
        $('.foot').addClass('slide-down', 1000, 'easeOutBounce');
        $('.foot').removeClass('slide-up');
      } else {
        $('.foot').removeClass('slide-down');
        $('.foot').addClass('slide-up', 1000, 'easeOutBounce');
      }
  });
});

</script>
