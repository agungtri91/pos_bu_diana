<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body2 table-responsive">
        <div class="box-header" style="cursor: move;">
          <h3 class="box-title"><strong>List Penjualan</strong></h3>
        </div>
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th>User Hapus</th>
              <th>Tanggal</th>
              <th>Transaksi Kode</th>
              <th>User Input</th>
              <th>Total</th>
              <th>Bayar</th>
              <th>Tipe Pembayaran</th>
              <th>Bank Kita</th>
              <th>No. Rek</th>
              <th>Bank Costumer</th>
              <th>No. Rek</th>
              <th>Kembali</th>
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
              <td><?= $row_tr['user_hapus']?></td>
              <td><?= $row_tr['transaction_date']?></td>
              <td><?= $row_tr['transaction_code']?></td>
              <!-- <td><?php
              $building = ($row_tr['table_id']!=0) ? " (".$row_tr['building_name'].")" : "";
              echo $row_tr['table_name'].$building; ?></td> -->
              <td><?= $row_tr['user_name']?></td>
              <td><?= tool_format_number($row_tr['transaction_grand_total'])?></td>
              <td><?= tool_format_number($row_tr['transaction_payment'])?></td>
              <?php
                $q_payment_method = mysql_query("SELECT * from payment_methods WHERE payment_method_id = ".$row_tr['payment_method_id']);
                $r_payment_method = mysql_fetch_array($q_payment_method);
              ?>
              <td><?= $r_payment_method['payment_method_name']?></td>
              <?php
                $q_bank = mysql_query("SELECT * from banks WHERE bank_id = ".$row_tr['bank_id']);
                $r_bank = mysql_fetch_array($q_bank);
              ?>
              <td><?= $r_bank['bank_name']?></td>
              <td><?= $row_tr['i_bank_account']?></td>
              <?php
                $q_bank = mysql_query("SELECT * from banks WHERE bank_id = ".$row_tr['bank_id_to']);
                $r_bank_to = mysql_fetch_array($q_bank);
              ?>
              <td><?= $r_bank_to['bank_name']?></td>
              <td><?= $row_tr['i_bank_account_to']?></td>
              <td><?= tool_format_number($row_tr['transaction_change'])?></td>
              <td><?= $row_tr['member_name']?></td>
              <td><?= $row_tr['branch_name']?></td>
              <?php if($row_tr['lunas'] == 1){?>
                <td>Belum lunas</td>
              <?} elseif ($row_tr['lunas'] == 2) {?>
                <td>Sudah lunas</td>
              <?} else{?>
                <td>Lunas</td>
              <?}?>
              <td style="text-align:center;"><button type="button" class="btn btn-default"
                onclick="detail_trans(<?= $row_tr['transaction_code']?>,<?= $row_tr['branch_id']?>)"><i class="fa fa-search"></i></button></td>
            </tr>
        <?php $no_tr++; } ?>
        </tbody>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>
<div id="modal_penjualan" class="modal fade bs-example-modal-lg" tabindex="-1"
role="dialog" aria-labelledby="myLargeModalLabel" style="z-index:888888;border-radius:0;">
  <div class="modal-dialog modal-lg" role="document"  style="width:1100px;">
    <div class="modal-content" style="border-radius:0;">

    </div>
  </div>
</div>
<script>
  function detail_trans(x,y) {
    $('#modal_penjualan').modal();
  $(function(){
    var url = "report_edit_transaksi.php?page=popmodal_penjualan&transaction_code="+x+"&branch_id="+y;
      $('.modal-content').load(url,function(result){
    });
  })
}
</script>
