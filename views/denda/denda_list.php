
<?php
if(isset($_GET['did']) && $_GET['did'] == 1){ ?>
<section class="content_new">
  <div class="alert alert-info alert-dismissable">
    <i class="fa fa-check"></i>
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
    <b>Sukses !</b>
    Simpan Berhasil
  </div>
</section>
<?php }else if(isset($_GET['did']) && $_GET['did'] == 2){ ?>
<section class="content_new">
  <div class="alert alert-info alert-dismissable">
    <i class="fa fa-check"></i>
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
    <b>Sukses !</b>
    Edit Berhasil
  </div>
</section>
<?php
}else if(isset($_GET['did']) && $_GET['did'] == 3){
?>
<section class="content_new">
  <div class="alert alert-info alert-dismissable">
    <i class="fa fa-check"></i>
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
    <b>Sukses !</b>
    Delete Berhasil
  </div>
</section>
<?php } ?>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="title_page"> <?= $title ?></div>
      <div class="box">
        <div class="box-body2 table-responsive">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th style="text-align:center;">Nama Denda</th>
              <th style="text-align:center;">Jenis Denda</th>
              <th style="text-align:center;">Denda ( % )</th>
              <th style="text-align:center;">Config</th>
            </tr>
          </thead>
        <tbody>
        <?php
        $no = 1;
        while($row = mysql_fetch_array($q_denda)){ ?>
          <tr>
            <td width="5%" style="text-align:center;"><?= $no?></td>
            <td style="text-align:center;"><?= $row['denda_name']?></td>
            <td style="text-align:center;"><?= get_jenis_denda($row['jenis_denda']);?></td>
            <td style="text-align:center;"><?= format_rupiah($row['denda_persen'])?></td>
            <td style="text-align:center;">
              <?php if (strpos($permit, 'u') !== false || strpos($permit, 'r') !== false):?>
                <a type="button" class="btn btn-default" href="denda.php?page=form&id=<?= $row['denda_id']?>">
                  <i class="fa fa-pencil"></i>
                </a>
              <?php endif; ?>
              <?php if (strpos($permit, 'd') !== false): ?>
                <a type="button" class="btn btn-default" href="javscrip:void(0);"
                onclick="confirm_delete(<?= $row['denda_id']; ?>,'denda.php?page=delete&id=')">
                  <i class="fa fa-trash-o"></i>
                </a>
              <?php endif; ?>
            </td>
          </tr>
        <?php $no++; } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="6">
              <?php if (strpos($permit, 'c') !== false): ?>
                <a href="<?= $add_button ?>" class="btn btn-danger " >Tambah</a>
              <?php endif; ?>
            </td>
          </tr>
        </tfoot>
        </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
</section><!-- /.content -->
