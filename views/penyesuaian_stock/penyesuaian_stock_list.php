<?php if(isset($_GET['did']) && $_GET['did'] == 1){ ?>
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
<?php }else if(isset($_GET['did']) && $_GET['did'] == 3){ ?>
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
<?php var_dump($_SESSION) ?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="title_page"> <?= $title?></div>
        <div class="box">
          <div class="box-body2 table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Item Name</th>
                  <th>Harga Item</th>
                  <th>Kategori Item</th>
                  <th>Jumlah Stock</th>
                  <th>Cabang</th>
                  <th style="text-align:center;">Config</th>
                </tr>
              </thead>
            <tbody>
            <?php
            $no = 1;
            while($row = mysql_fetch_array($query)){ ?>
              <tr>
                <td><?= $no?></td>
                <td><?= $row['item_name']?></td>
                <td style="text-align:right;"><?= format_rupiah($row['item_price'])?></td>
                <td><?= $row['kategori_name']?></td>
                <td style="text-align:right;"><?= format_rupiah($row['item_stock_qty'])?></td>
                <td><?= $row['branch_name']?></td>
                <td style="text-align:center;">
                  <?php if (strpos($permit, 'c') !== false ): ?>
                  <a href="penyesuaian_stock.php?page=form&id=<?= $row['item_id']?>&branch_id=<?= $row['branch_id']?>"
                    class="btn btn-default" >
                    <i class="fa fa-pencil"></i>
                  </a>
                <?php endif;?>
                </td>
              </tr>
            <?php $no++; } ?>
            </tbody>
            <tfoot>
                            <tr>
                                <td colspan="5">
                                  <a href="penyesuaian_stock.php?page=form"class="btn btn-danger " >Tambah</a>
                                </td>
                            </tr>
                        </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
  </div>
</section><!-- /.content -->
