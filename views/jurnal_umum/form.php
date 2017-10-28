<!-- Content Header (Page header) -->
<!-- Main content -->
<section class="content">
  <div class="row">
  <!-- right column -->
    <div class="col-md-12">
    <!-- general form elements disabled -->
      <div class="title_page"> <?= $title ?></div>
      <form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form">
        <div class="box box-cokelat">
          <div class="box-body">
            <div class="col-md-6">
              <div class="form-group">
                <label>Tanggal</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" required class="form-control pull-right" id="date_picker1" name="i_journal_date" value="<?= $row->journal_date ?>"/>
                </div><!-- /.input group -->
              </div>
              </div>
            <div class="col-md-6">
                      <div class="form-group">
                      <label>User :</label>
                               <?php
                              $user_data = get_user_data(); ?>
                              <div class="col-md-12">
                                <input type="text" class="form-control" value="<?=$user_data[0];?>" readonly>
                              </div>
                            </div>
              </div>
              <div class="col-md-12">
              <div class="form-group">
                <label>Tipe Jurnal</label>
                <select id="i_journal_type_id" name="i_journal_type_id" size="1" class="selectpicker show-tick form-control" data-live-search="true" onChange="changeTextBox();"/>
                <option value="" selected>- Silahkan Pilih Tipe Jurnal -</option>
                  <?php while($r_journal_type = mysql_fetch_array($q_journal_type)){ ?>
                    <option value="<?= $r_journal_type['journal_type_id'] ?>" <?php if($row->journal_type_id == $r_journal_type['journal_type_id']){ ?> selected="selected"<?php } ?>><?= $r_journal_type['journal_type_name']?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Debit</label>
                <input required type="" id="i_journal_debit_currency" name="i_journal_debit_currency" class="form-control"
                placeholder="" value="Rp. <?= format_rupiah($row->journal_debit) ?>" onkeyup="nilai_currency(this);"/>
                <input required type="hidden" id="i_journal_debit" name="i_journal_debit" class="form-control"
                value=""/>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Credit</label>
                <input required type="text" id="i_journal_credit_currency" name="i_journal_credit_currency" class="form-control"
                placeholder="" value="Rp. <?= format_rupiah($row->journal_credit) ?>" onkeyup="nilai_currency(this);"/>
                <input required type="hidden" id="i_journal_credit" name="i_journal_credit" class="form-control"
                placeholder="" value="<?= $row->journal_credit ?>"/>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Piutang</label>
                <input required type="text" id="i_journal_piutang_currency" name="i_journal_piutang_currency" class="form-control" placeholder=""
                value="Rp. <?= format_rupiah($row->journal_piutang) ?>" onkeyup="nilai_currency(this);"/>
                <input required type="hidden" id="i_journal_piutang" name="i_journal_piutang" class="form-control" placeholder=""
                value="<?= $row->journal_piutang ?>"/>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Hutang</label>
                <input required type="text" id="i_journal_hutang_currency" name="i_journal_hutang_currency" class="form-control" placeholder=""
                value="Rp. <?= format_rupiah($row->journal_hutang) ?>" onkeyup="nilai_currency(this);"/>
                <input required type="hidden" id="i_journal_hutang" name="i_journal_hutang" class="form-control" placeholder=""
                value="<?= $row->journal_hutang ?>"/>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Dari Bank</label>
                <select id="i_bank_id" name="i_bank_id" size="1" class="selectpicker show-tick form-control" data-live-search="true" />
                  <option value="0">-</option>
                  <?php while($r_bank = mysql_fetch_array($q_bank)){ ?>
                  <option value="<?= $r_bank['bank_id'] ?>" <?php if($row->bank_id == $r_bank['bank_id']){ ?> selected="selected"<?php } ?>><?= $r_bank['bank_name']?></option>
                  <?php } ?>
                </select>
              </div>
              <input type="text" class="form-control" name="i_bank_account" id="i_bank_account" value="<?= $row->bank_account?>">
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Tujuan Bank</label>
                <select id="i_bank_id_to" name="i_bank_id_to" size="1" class="selectpicker show-tick form-control" data-live-search="true" />
                  <option value="0">-</option>
                  <?php while($r_bank = mysql_fetch_array($q_bank_to)){ ?>
                  <option value="<?= $r_bank['bank_id'] ?>" <?php if($row->bank_id_to == $r_bank['bank_id']){ ?> selected="selected"<?php } ?>><?= $r_bank['bank_name']?></option>
                  <?php } ?>
                </select>
              </div>
              <input type="text" class="form-control" name="i_bank_account_to" id="i_bank_account_to" value="<?= $row->bank_account_to?>">
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Cabang</label>
                <select id="basic" name="i_branch_id" size="1" class="selectpicker show-tick form-control" data-live-search="true" />
                <?php while($r_branch = mysql_fetch_array($q_branch)){ ?>
                <option value="<?= $r_branch['branch_id'] ?>"<?php if($row->branch_id == $r_branch['branch_id']){ ?> selected="selected"<?php } ?>><?= $r_branch['branch_name']?></option>
                <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Keterangan</label>
                <textarea name="i_journal_desc" cols="5" rows="5" class="form-control"><?= $row->journal_desc ?></textarea>
              </div>
            </div>
            <div style="clear:both;"></div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <input class="btn btn-primary" type="submit" value="Simpan"/>
            <a href="<?= $close_button?>" class="btn btn-danger" >Keluar</a>
          </div>
        </div><!-- /.box -->
      </form>
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
function nilai_currency(elem){
  var elem_id = elem.id;
  var elem = '#'+elem.id;
  var elem_val_curr = $(elem).val();
  var elem_val_curr_no_rupiah = remove_rupiah(elem_val_curr);
  var elem_val_curr_no_currency = elem_val_curr_no_rupiah.toString().replace(/[^0-9\.]+/g, "");

  var elem_str = elem_id.toString();
  var elem_no_cur = elem_str.replace(/_currency/g,'');

  var elem_val_currency = format_rupiah(elem_val_curr);
  $(elem).val(elem_val_currency);
  $('#'+elem_no_cur).val(elem_val_curr_no_currency);
}

function changeTextBox()
{
    var comp = document.getElementById('i_journal_type_id');
    if (comp.value == '3') {
        document.getElementById('i_journal_debit_currency').disabled = true;
        document.getElementById('i_journal_piutang_currency').disabled = true;
        document.getElementById('i_journal_credit_currency').disabled = false;
        document.getElementById('i_journal_hutang_currency').disabled = false;
    } else if (comp.value == '4') {
        document.getElementById('i_journal_debit_currency').disabled = false;
        document.getElementById('i_journal_piutang_currency').disabled = false;
        document.getElementById('i_journal_credit_currency').disabled = true;
        document.getElementById('i_journal_hutang_currency').disabled = true;
    }
}
</script>
