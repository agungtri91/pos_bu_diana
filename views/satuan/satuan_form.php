<!-- Content Header (Page header) -->
<!-- Main content -->
<link href="../css/panel_drag_and_drop.css" rel="stylesheet" type="text/css" />
<section class="content">
  <div class="row">
  <!-- right column -->
    <div class="col-md-12">
    <!-- general form elements disabled -->
      <div class="title_page"> <?= $title ?></div>
      <form id="form" method="post" enctype="multipart/form-data" role="form" novalidate>
        <div class="box box-cokelat">
          <div class="box-body">
                                <?php
            $user_data = get_user_data(); ?>
                        <div class="col-md-6">
              <input type="text" class="form-control" value="<?=date('Y-m-d');?>" readonly>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" value="<?=$user_data[0];?>" readonly>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Nama Satuan</label>
                <input required type="text" name="i_name" id="i_name" class="form-control"
                placeholder="Masukkan nama ..." value="<?= strtoupper($row->unit_name)?>"/>
              </div>
            </div>
          <div style="clear:both;"></div>
          </div><!-- /.box-body -->
        <div class="box-footer">
          <?php if (strpos($permit, 'c') !== false || strpos($permit, 'u') !== false): ?>
            <?php if ($id): ?>
                <input class="btn btn-info" type="submit"
                onclick="submitForm('satuan.php?page=edit&tipe=2&id=<?= $id?>')" value="Simpan"/>
            <?php else: ?>
              <input class="btn btn-primary" type="button" onclick="check_nama()" value="Simpan"/>
            <?php endif; ?>
          <?php endif; ?>
            <a href="<?= $close_button?>" class="btn btn-danger">Keluar</a>
        </div>
        </div><!-- /.box -->
      </form>
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->

<script type="text/javascript">
  function check_nama() {
    var i_name = $('#i_name').val();
    var url = 'satuan.php?page=save&tipe=2';
    $.ajax({
      type:'POST',
      data:{x:i_name,y:2},
      url: 'satuan.php?page=strcmp',
      dataType:'json',
    }).done(function(data){
        if (data !== null) {
          var a = confirm("Satuan "+i_name+" sudah ada, Simpan atau tidak ?");
          if(a==true){
            submitForm(url);
          }
        }else {
            submitForm(url);
          }
    });
  }

  function submitForm(action){
  document.getElementById('form').action = action;
  document.getElementById('form').submit();
  }

  function get_tingkat(){
    var i_tingkat = $('#i_tingkat').val();
    var counter = 0;
    var counter_tingkat = "";
    $.ajax({
      type:'POST',
      data:{x:i_tingkat},
        url: 'satuan.php?page=get_tingkat',
      dataType:'json',
    }).done(function(data) {
      $('#container2').html('');
      for (var i = 0; i < data.length; i++) {
        $('#container2').append('\
            <div itemid="itm-'+i+'" class="btn btn-warning box-item">\
              '+data[i].unit_name+'\
              <input type="hidden" id="i_unit['+i+']" value="'+data[i].unit_id+'"></input>\
            </div>\
        ');
      }
      $('.box-item').draggable({
        cursor: 'move',
        helper: "clone"
      });

      $("#container1").droppable({
        drop: function(event, ui) {
          var itemid = $(event.originalEvent.toElement).attr("itemid");
          if (counter<=counter_tingkat) {
              counter++;
              $('.box-item').each(function() {
                if ($(this).attr("itemid") === itemid) {
                  $(this).appendTo("#container1");
                   $('input[type="hidden"]').attr("name", "i_unit");
                }
              });
          }
          if (counter===counter_tingkat) {
             $('#container1').droppable("disable");
          }
        }
      });
      $("#container1").sortable({
      update: function(e, ui) {
        $("#container1 div").each(function(i, elm) {
          $elm = $(elm); // cache the jquery object
          $elm.attr("itemid", $elm.index("#container1 div"));
          // below is just for demo purpose
          $elm.text($elm.text().split("itemid")[0] + "itemid: " + $elm.attr("itemid"));
        });
      }
    });
      $("#container2").droppable({
        drop: function(event, ui) {
          var itemid = $(event.originalEvent.toElement).attr("itemid");
          $('.box-item').each(function() {
            if ($(this).attr("itemid") === itemid) {
              $(this).appendTo("#container2");
            }
          });
        }
      });
    });
  }

  $(document).ready(function(){

      var i_tingkat = $('#i_tingkat').val();
      var counter = 0;
      var counter_tingkat = "";
      $.ajax({
        type:'POST',
        data:{x:i_tingkat},
          url: 'satuan.php?page=get_tingkat',
        dataType:'json',
      }).done(function(data) {
        $('#container2').html('');
        for (var i = 0; i < data.length; i++) {
          $('#container2').append('\
              <div itemid="itm-'+i+'" class="btn btn-warning box-item">\
                '+data[i].unit_name+'\
                <input type="hidden" id="i_unit['+i+']" value="'+data[i].unit_id+'"></input>\
              </div>\
          ');
        }
        $('.box-item').draggable({
          cursor: 'move',
          helper: "clone"
        });

        $("#container1").droppable({
          drop: function(event, ui) {
            var itemid = $();
            var itemid = $(event.originalEvent.toElement).attr("itemid");
            if (counter<=counter_tingkat) {
                counter++;
                $('.box-item').each(function() {
                  if ($(this).attr("itemid") === itemid) {
                    $(this).appendTo("#container1");
                  }
                });
            }
            if (counter===counter_tingkat) {
               $('#container1').droppable("disable");
            }
          }
        });

        $("#container2").droppable({
          drop: function(event, ui) {
            var itemid = $(event.originalEvent.toElement).attr("itemid");
            $('.box-item').each(function() {
              if ($(this).attr("itemid") === itemid) {
                $(this).appendTo("#container2");
              }
            });
            counter = counter - 1;
            if (counter<counter_tingkat) {
               $('#container1').droppable("enable");
            }
          }
        });
      });
  });
</script>
<script src="../js/capitalize.js"></script>
