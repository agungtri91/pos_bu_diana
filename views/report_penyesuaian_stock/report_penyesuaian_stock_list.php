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
<section class="content">
<div class="row">
<div class="col-xs-12">
<div class="title_page"> <?= $title ?></div>
<div class="box">
              <form method="POST" action="">
              <div class="col-md-2">
                <div id="i_member" class="form-group">
                  <label>Cabang :</label>
                  <select name="i_branch_id" id="i_branch_id" class="selectpicker show-tick form-control" data-live-search="true" value="0">
                    <option value="0"></option>
                    <?php
                    if ($_SESSION['branch_id_1']) {
                      $type = $_SESSION['branch_id_1'];
                    }
                      else {
                        $type = $_SESSION['branch_id'];
                      }
                    $query=mysql_query("select * from branches order by branch_name");
                    while($row_branch=mysql_fetch_array($query)){
                      ?><option value="<?= $row_branch['branch_id']?>"<?php if($type == $row_branch['branch_id']){echo "Selected";} ?>>
                        <?= $row_branch['branch_name']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                <label>Dari :</label>
                  <input type="date" name="from_date" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                <label>Sampai :</label>
                  <input type="date" name="to_date" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary" style="margin-top:25px;">Go</button>
              </div>
              </form>
  <div class="box-body2 table-responsive">
      <table id="example1" class="table table-bordered table-striped">
          <thead>
              <tr>
              <th width="5%">No</th>
                  <th>Nama Item</th>
                  <th>Tanggal penyesuaian</th>
                  <th>Jumlah Awal</th>
                  <th>Jumlah Akhir</th>
                  <th>Admin</th>
              </tr>
          </thead>
          <tbody>
              <?php
             $no = 1;
              while($row = mysql_fetch_array($query)){ ?>
              <tr>
                  <td><?= $no?></td>
                   <td><?= $row['item_name']?></td>
                   <td><?= $row['date_penyesuaian']?></td>
                   <td><?= $row['item_qty_awal']?></td>
                   <td><?= $row['item_qty_new']?></td>
                   <td><?= $row['user_name']?></td>
              </tr>
              <?php $no++; } ?>
          </tbody>
            <tfoot>
              <!-- <tr>
                  <td colspan="7"><a href="<?= $add_button ?>" class="btn btn-danger " >Add</a></td>
              </tr> -->
          </tfoot>
      </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>
</section><!-- /.content -->
