<style media="screen">
  .center{
    text-align: center;
  }
</style>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <br>
          <div class="title_page"><?= $member_name ?></div>
        <div class="box-body2 table-responsive">
          <table id="example1" style="width:100%;" class="table table-bordered table-striped">
            <thead>
              <tr class="center">
                <th class="center" style="width:5%;">No.</th>
                <th class="center">Tanggal</th>
                <th class="center">Admin</th>
                <th class="center">Config.</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              while ($row = mysql_fetch_array($q_piutang_pembeli)) {?>
                <tr>
                  <td class="center" style="width:5%;"><?= $no;?></td>
                  <td class="center"><?= format_date_only($row['kredit_date'])?></td>
                  <td class="center"><?= $row['admin']?></td>
                  <td class="center">
                    <a type="button" class="btn btn-default" href="javascript:void(0);" onclick="piutang_detail_popmodal(<?= $row['kredit_id']?>)">
                      <i class="fa fa-search"></i>
                    </a>
                  </td>
                </tr>
              <? $no++; } ?>
            </tbody>
          </table>
        </div>
        <div class="box-footer">
          <a href="<?= $close_button?>">
            <button type="button" name="button" class="btn btn-danger">
                Keluar
            </button>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<div id="large_popmodal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width:900px;">
    <div class="modal-content"  id="large_popmodal_content" style="border-radius:0;">

    </div>
  </div>
</div>
<script type="text/javascript">
  function piutang_detail_popmodal(id){
    $('#large_popmodal').modal();
    var url = 'angsuran.php?page=piutang_detail_popmodal&id='+id;
      $('#large_popmodal_content').load(url,function(result){
    });
  }
</script>
