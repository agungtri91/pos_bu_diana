<section class="content">
  <div class="row">
  <!-- right column -->
    <div class="col-md-12">
         <div class="box">
          <input type="hidden" id="branch_id" name="branch_id" value="<?= $branch_id?>">
          <div class="box-body2 table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                      <tr>
                        <th style="text-align:center;width:5%;">No</th>
                        <th>Kategori Item</th>
                        <th style="text-align:center;">Nilai Diskon</th>
                        <th style="text-align:center;">Diskon Nominal</th>
                        <th style="text-align:center;">Config</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysql_fetch_array($q_diskon)) {?>
                      <tr>
                        <td style="text-align:center;width:5%;">
                          <?= $no?>
                          <input type="hidden" id="tipe_pembeli_diskon_id"
                          name="tipe_pembeli_diskon_id" value="<?= $row['tipe_pembeli_diskon_id']?>">
                          <input type="hidden" id="kategori" name="kategori" value="<?= $row['kategori_item']?>">
                        </td>
                        <td>
                          <?= $row['kategori_name']?>
                        </td>
                        <td style="text-align:center;">
                          <?= $row['nilai_diskon']?> %
                        </td>
                        <?php
                          $nominal_diskon = format_rupiah($row['nominal_diskon']);
                          $nominal_diskon = $nominal_diskon ? $nominal_diskon : "-";
                        ?>
                        <td style="text-align:center;">
                          <?= $nominal_diskon ?>
                        </td>
                        <td align="center">
                          <a type="button"
                          href="tipe_pembeli.php?page=delete_diskon&id=<?= $row['tipe_pembeli_diskon_id']?>&tipe_pembeli=<?= $row['tipe_pembeli']?>&branch_id=<?= $branch_id?>"
                          class="btn btn-default">
                            <i class="fa fa-trash-o"></i>
                          </a>
                          <a type="button" href="javascript:void(0)" class="btn btn-default"
                          onclick="diskon_modal(2,<?= $row['tipe_pembeli_diskon_id']?>)">
                            <i class="fa fa-pencil"></i>
                          </a>
                        </td>
                      </tr>
                    <? $no++; }?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="5">
                        <?php if (strpos($permit, 'c') !== false): ?>
                          <button type="button" name="button" class="btn btn-danger"
                          onclick="diskon_modal(1,'')">Tambah diskon</button>
                        <?php endif; ?>
                      </td>
                    </tr>
                  </tfoot>
              </table>
          </div><!-- /.box-body -->
      </div>
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->

<script type="text/javascript">
  function diskon_modal(x,y){
    var tipe_pembeli = <?php echo $id ?>;
    var kategori = $('#kategori').val();
    var branch_id = $('#branch_id').val();
    $('#medium_modal').modal({
      backdrop  : 'static',
      keyboard  : 'false'
    });
		var url = 'tipe_pembeli.php?page=popmodal&id='+x+'&kategori_item='+kategori+'&tipe_pembeli='+tipe_pembeli+'&branch_id='+branch_id+'&tipe_pembeli_diskon_id='+y;
      $('#medium_modal_content').load(url,function(result){
    });
  }
</script>
