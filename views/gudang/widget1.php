<style>
.bootstrap-select.btn-group .dropdown-menu {
  min-width: 100%;
  z-index: 99999;
}
</style>
<div style="position:fixed;">
  <div class="box" style="margin-bottom:0px; padding-bottom:0px;">
    <table id="" class="" style="margin-bottom:0px;width:100%px;">
      <thead style="color:#fff; background:#d82827; height:30px; line-height:30px;">
        <tr>
          <th style="padding:10px;width:110px;">Jumlah</th>
          <th style="padding:10px;width:450px;">Nama Item</th>
					<th style="padding:20px;">Config</th>
        </tr>
      </thead>
    </table>
  </div><!-- /.box -->
  <div class="box" style="margin-bottom:0px; padding-bottom:0px; overflow-y:auto; overflow-x:hidden; height:335px; background:#fff;">
    <div class="">
      <table id="" class="table table-bordered">
        <tbody>
          <?php
            $no = 1;
            $query_widget = mysql_query("SELECT a.*, b.item_name FROM mutasi_tmp a
                                         JOIN items b on b.item_id = a.item_id
                                         WHERE gudang_id ='$id'");
          while($row_widget = mysql_fetch_array($query_widget)){ ?>
          <tr>
            <td ><?= $row_widget['item_qty']?></td>
            <td><?= $row_widget['item_name']?></td>
            <td style="text-align:center;">
            <a href="javascript:void(0)" onclick="confirm_delete_mutasi_tmp('<?= $row_widget['item_id']?>')" class="btn btn-default" ><i class="fa fa-trash-o"></i></a></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
  <div class="box" style="padding:10px;">
    <div class="row">
        <div class="row">
          <a href="#" onclick="kirim_item_cabang('<?= $id?>')" class="btn btn-default btn-block" >Cabang</a>
          <a href="#" onclick="kirim_item_gudang('<?= $id?>')" class="btn btn-default btn-block" >Gudang</a>
          <a href="gudang.php?page=reset&gudang_id=<?= $id?>" class="btn btn-danger btn-block" >Reset</a>
        </div>
    </div>
  </div>
</div>

<div id="kirim_item" class="dialog_content" style="display:none;">
  <form action="gudang.php?page=kirim1" method="post">
    <div class="dialogModal_header"></div>
    	<div class="dialogModal_content" style="padding-top:0;">

    	</div>
  	<div class="dialogModal_footer"></div>
    <div class="dialogModal_footer">
    		<input type="submit" class="btn btn-primary" id="i_save" name="i_save" data-dialogmodal-but="next" value="Save"></input>
    		<button type="button" class="btn btn-default"data-dialogmodal-but="cancel">Cancel</button>
    </div>
  </form>
</div>

<script type="text/javascript">
function kirim_item_cabang(x){
  // var gudang_id = document.getElementById('i_gudang_id').value;
  $('#kirim_item').dialogModal({
    onLoad: function() {
      $(".dialogModal_content").load('gudang.php?page=kirim_cabang&gudang_id='+x);
    }
  });
}

function kirim_item_gudang(x){
  // var gudang_id = document.getElementById('i_gudang_id').value;
  $('#kirim_item').dialogModal({
    topOffset: 0,
    onOkBut: function() {},
    onCancelBut: function() {},
    onLoad: function() {
      $(".dialogModal_content").load('gudang.php?page=kirim_gudang&gudang_id='+x);
    },
    onClose: function() {},
  });
}

</script>
