<!-- MEMBER -->
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-body2 table-responsive">

          <div class="title_page"><?= $member_name?></div>
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="text-align:center;" width="5%">No</th>
                <th style="text-align:center;">Kode Transaksi</th>
                <th style="text-align:center;">Total</th>
                <th style="text-align:center;">Ket.</th>
                <th style="text-align:center;">Config</th>
            </tr>
            </thead>
          <tbody>
          <?php
          $no = 1;
          while($row = mysql_fetch_array($query)){ ?>
            <tr>
              <td style="text-align:center;"><?= $no?></td>
              <td><?= $row['transaction_code']?></td>
              <td style="text-align:center;"><?= format_rupiah($row['total_all'])?></td>
              <td style="text-align:center;">
                <?php if ($row['lunas']==0){
                  echo "Lunas";
                  } elseif ($row['lunas']==1){
                  echo "Belum Lunas";
                  } else { echo "Sudah Lunas";} ?>
              </td>
              <td style="text-align:center;">
                <a class="btn btn-default" href="javascript:void(0);" onclick="history_member_modal(<?= $row['transaction_code']?>)">
                  <i class="fa fa-search"></i>
                </a>
              </td>
            </tr>
          <?php $no++; } ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5">
                <a type="button" name="button" class="btn btn-danger" href="member.php?page=list">
                  Kembali
                </a>
              </td>
            </tr>
          </tfoot>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
</section><!-- /.content -->
<script type="text/javascript">
  function history_member_modal(transaction_code){
    $('#large_modal').modal();
    var url = 'member.php?page=history_member_popmodal&code='+transaction_code;
      $('#large_modal_content').load(url,function(result){
    });
  }
</script>
