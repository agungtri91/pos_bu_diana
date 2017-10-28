
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <div class="popmodal_title" style="font-size: 18px; margin-bottom:0;text-align:center;">Tambah Pembeli</div>
  <div id="tabs">
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active">
        <a href="#tab_1" aria-controls="home" role="tab" data-toggle="tab">Data Pribadi&nbsp;<i id="t_1" style="color:#dd0d0d;font-size:20px;"></i></a>
      </li>
      <li role="presentation">
        <a href="#tab_2" aria-controls="profile" role="tab" data-toggle="tab">Darurat&nbsp;<i id="t_2" style="color:#dd0d0d;font-size:20px;"></i></a>
      </li>
      <li role="presentation">
        <a href="#tab_3" aria-controls="messages" role="tab" data-toggle="tab">Data Pekerjaan&nbsp;<i id="t_3" style="color:#dd0d0d;font-size:20px;"></i></a>
      </li>
    </ul>
  </div>
</div>
<form id="accountForm" method="post" enctype="multipart/form-data" role="form">
<div class="modal-body">
    <!-- Main content -->
    <div class="box">
      <div class="box-body">
        <div class="">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" name="transaction_id" value="<?= $transaction_id?>">
              <div class="">
                <div class="tab-content">
                  <br>
                  <div role="tabpanel" class="tab-pane active" id="tab_1">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="hidden" name="member_id" id="member_id" value="">
                        <label>Nama </label>
                        <input  type="text" id="i_name" name="i_name" class="form-control"
                        placeholder="Masukkan Nama..."
                        value="" onkeyup="lookup(this);"/>
                      </div>
                      <div class="form-group ">
                        <input type="hidden" name="member_id" id="member_id" value="">
                        <label>NIK </label>
                        <input  type="text" id="i_nik" name="i_nik" class="form-control"
                        placeholder="Masukkan NIK..."
                        value="" onkeyup="lookup(this);"/>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group ">
                            <label>Alamat</label>
                            <input  type="text" id="i_alamat" name="i_alamat" class="form-control"
                            placeholder="Masukkan Alamat..."
                            value="" onkeyup="lookup(this);"/>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group ">
                            <label>Kode Pos</label>
                            <input  type="text" id="i_kode_pos" name="i_kode_pos" class="form-control"
                            placeholder="Kode Pos..."
                            value="" onkeyup="lookup(this);"/>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group ">
                                  <label>RT</label>
                                  <input  type="text" id="i_rt" name="i_rt" class="form-control"
                                  placeholder="RT.."
                                  value="" onkeyup="lookup(this);"/>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group ">
                                  <label>RW</label>
                                  <input  type="text" id="i_rw" name="i_rw" class="form-control"
                                  placeholder="RW.."
                                  value="" onkeyup="lookup(this);"/>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group ">
                            <label>Kelurahan</label>
                            <input  type="text" id="i_kelurahan" name="i_kelurahan" class="form-control"
                            placeholder="Masukkan Kelurahan..."
                            value="" onkeyup="lookup(this);"/>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group ">
                            <label>Kecamatan</label>
                            <input  type="text" id="i_kecamatan" name="i_kecamatan" class="form-control"
                            placeholder="Masukkan Kecamatan..."
                            value="" onkeyup="lookup(this);"/>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group ">
                            <label>Kota</label>
                            <input  type="text" id="i_kota" name="i_kota" class="form-control"
                            placeholder="Masukkan Kota..."
                            value="" onkeyup="lookup(this);"/>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Nama Ibu Kandung</label>
                        <input  type="text" id="i_ibu" name="i_ibu" class="form-control"
                        placeholder="Masukkan Nama Ibu Kandung..."
                        value="" onkeyup="lookup(this);"/>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group ">
                            <label>Tempat Lahir</label>
                            <input  type="text" id="i_tempat_lahir" name="i_tempat_lahir" class="form-control"
                            placeholder="Masukkan Tempat Lahir..."
                            value="" onkeyup="lookup(this);"/>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group ">
                            <label>Tanggal Lahir</label>
                            <input type="text" class="form-control pull-right"
                            id="date_picker2" name="i_tanggal_lahir" value="" onkeyup="lookup(this);"/>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Status Perkawinan</label>
                            <select id="i_status_kawin" name="i_status_kawin" size="1" class="selectpicker show-tick form-control"
                            data-live-search="true" dropupAuto="true">
                              <option value="0"></option>
                              <option value="1">Kawin</option>
                              <option value="2">Cerai</option>
                              <option value="3">Belum Kawin</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group ">
                            <label>Jumlah Tanggungan</label>
                            <input  type="text" id="i_tanggungan" name="i_tanggungan" class="form-control"
                            placeholder="Masukkan Jumlah Tanggungan..."
                            value="" onkeyup="lookup(this);"/>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group ">
                            <label>Tlp. Rumah</label>
                            <input  type="text" id="i_phone_rumah" name="i_phone_rumah" class="form-control"
                            placeholder="Masukkan Tlp. Rumah..."
                            value="" onkeyup="lookup(this);"/>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group ">
                            <label>Handphone</label>
                            <input  type="text" id="i_phone" name="i_phone" class="form-control"
                            placeholder="Masukkan Handphone..."
                            value="" onkeyup="lookup(this);"/>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Status Rumah</label>
                            <select id="i_status_rumah" name="i_status_rumah" size="1" class="selectpicker show-tick form-control"
                            data-live-search="true">
                              <option value="0"></option>
                              <option value="1">Sendiri</option>
                              <option value="2">Keluarga</option>
                              <option value="3">Dinas</option>
                              <option value="4">Sewa</option>
                              <option value="5">KPR</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Lama Tinggal</label>
                            <input  type="text" id="i_lama_tinggal" name="i_lama_tinggal" class="form-control"
                            placeholder="Masukkan Handphone..."
                            value="" onkeyup="lookup(this);"/>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Pendidikan Terakhir</label>
                        <select id="i_pendidikan" name="i_pendidikan" size="1" class="selectpicker dropup show-tick form-control"
                        data-live-search="true">
                          <option value="0"></option>
                          <option value="1">SD</option>
                          <option value="2">SMP</option>
                          <option value="3">SMA</option>
                          <option value="4">D3</option>
                          <option value="5">S1</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input  type="email" id="i_email" name="i_email" class="form-control"
                        placeholder="Masukkan email member..."
                        value="" onkeyup="lookup(this);"/>
                      </div>
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="tab_2">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" id="nama_darurat" name="nama_darurat" class="form-control" value=""
                        placeholder="Masukkan Nama..." onkeyup="lookup(this);"/>
                      </div>
                      <div class="form-group">
                        <label for="">Hubungan</label>
                        <select id="i_hubungan" name="i_hubungan" size="1" class="selectpicker show-tick form-control"
                        data-live-search="true">
                          <option value="0"></option>
                          <option value="1">Orang Tua</option>
                          <option value="2">Kakak</option>
                          <option value="3">Adik</option>
                          <option value="4">Anak</option>
                          <option value="5">Lainnya</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">Alamat</label>
                        <input type="text" id="alamat_darurat" name="alamat_darurat" class="form-control" value=""
                        placeholder="Masukkan Alamat..." onkeyup="lookup(this);"/>
                      </div>
                      <div class="form-group">
                        <label for="">No. Telp</label>
                        <input type="text" id="telp_darurat" name="telp_darurat" class="form-control" value=""
                        placeholder="Masukkan No. Telp..." onkeyup="lookup(this);"/>
                      </div>
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="tab_3">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="">Nama Perusahaan</label>
                        <input type="text" id="nama_perusahaan" name="nama_perusahaan" class="form-control" value=""
                        placeholder="Masukkan Nama Perusahaan..." onkeyup="lookup(this);"/>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Alamat</label>
                            <input type="text" id="alamat_perusahaan" name="alamat_perusahaan" class="form-control" value=""
                            placeholder="Masukkan Alamat Perusahaan..." onkeyup="lookup(this);"/>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label for="">Kode Pos</label>
                            <input type="text" id="kode_pos_perusahaan" name="kode_pos_perusahaan" class="form-control" value=""
                            placeholder="Kode Pos..." onkeyup="lookup(this);"/>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">RT</label>
                              <input type="text" id="rt_perusahaan" name="rt_perusahaan" class="form-control" value=""
                              placeholder="RT..." onkeyup="lookup(this);"/>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">RW</label>
                              <input type="text" id="rw_perusahaan" name="rw_perusahaan" class="form-control" value=""
                              placeholder="RW..." onkeyup="lookup(this);"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Kelurahan</label>
                            <input type="text" id="kel_perusahaan" name="kel_perusahaan" class="form-control" value=""
                            placeholder="Masukkan Kel. Perusahaan..." onkeyup="lookup(this);"/>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Kecamatan</label>
                            <input type="text" id="kec_perusahaan" name="kec_perusahaan" class="form-control" value=""
                            placeholder="Masukkan Kec. Perusahaan..." onkeyup="lookup(this);"/>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Kota</label>
                            <input type="text" id="kota_perusahaan" name="kota_perusahaan" class="form-control" value=""
                            placeholder="Masukkan Kota..." onkeyup="lookup(this);"/>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Telepon</label>
                            <input type="text" id="telp_perusahaan" name="telp_perusahaan" class="form-control" value=""
                            placeholder="Masukkan Telp..." onkeyup="lookup(this);"/>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="">Jenis Pekerjaan</label>
                        <input type="text" id="jenis_pekerjaan" name="jenis_pekerjaan" class="form-control" value=""
                        placeholder="Masukkan Jenis Pekerjaan..." onkeyup="lookup(this);"/>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan" class="form-control" value=""
                            placeholder="Masukkan Jabatan..." onkeyup="lookup(this);"/>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Lama Bekerja</label>
                            <div class="row">
                              <div class="col-md-6">
                                <input type="text" id="lama_bekerja_tahun" name="lama_bekerja_tahun" class="form-control" value=""
                                placeholder="Masukkan Tahun..." onkeyup="lookup(this);"/>
                              </div>
                              <div class="col-md-6">
                                <input type="text" id="lama_bekerja_bulan" name="lama_bekerja_bulan" class="form-control" value=""
                                placeholder="Masukkan Bulan..." onkeyup="lookup(this);"/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Penghasilan</label>
                            <input type="text" id="penghasilan_currency" name="penghasilan_currency" class="form-control" value=""
                            placeholder="Masukkan Penghasilan..." onkeyup="lookup(this);"/>
                            <input type="hidden" id="penghasilan" name="penghasilan" class="form-control" value=""
                            placeholder="Masukkan Penghasilan..."/>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Pengeluaran Rata-Rata</label>
                            <input type="text" id="pengeluaran_currency" name="pengeluaran_currency" class="form-control" value=""
                            placeholder="Masukkan Pengeluaran..."  onkeyup="lookup(this);"/>
                            <input type="hidden" id="pengeluaran" name="pengeluaran" class="form-control" value=""
                            placeholder="Masukkan Pengeluaran..."/>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Penghasilan Lain</label>
                            <input type="text" id="penghasilan_lain_currency" name="penghasilan_lain_currency" class="form-control" value=""
                            placeholder="Masukkan Penghasilan..."  onkeyup="lookup(this);"/>
                            <input type="hidden" id="penghasilan_lain" name="penghasilan_lain" class="form-control" value=""
                            placeholder="Masukkan Penghasilan..."/>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Sumber Penghasilan Lain</label>
                            <select id="sumber_penghasilan_lain" name="sumber_penghasilan_lain" size="1"
                             class="selectpicker show-tick form-control"
                            data-live-search="true">
                              <option value="0"></option>
                              <option value="1">Suami / Istri</option>
                              <option value="2">Orang Tua</option>
                              <option value="3">Usaha Lain</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
  <div class="modal-footer">
      <?php if (strpos($permit, 'u') !== false){ ?>
        <button type="button" id="submit" class="btn btn-primary">Simpan</button>
      <?php } ?>
      <a data-dismiss="modal"class="btn btn-danger" >Batal</a>
  </div>
</form>
<script type="text/javascript">

$(function(){
    $("#penghasilan_currency").keyup(function(e){

        var price = $("#penghasilan_currency").val();
        var str = price.toString().replace("Rp. ", "");
        var str = str.toString().replace(/[^0-9\.]+/g, "");

        $("#penghasilan").val(str);

        $(this).val(format_rupiah($(this).val()));
    });

    $("#pengeluaran_currency").keyup(function(e){

        var price = $("#pengeluaran_currency").val();
        var str = price.toString().replace("Rp. ", "");
        var str = str.toString().replace(/[^0-9\.]+/g, "");

        $("#pengeluaran").val(str);

        $(this).val(format($(this).val()));
    });

    $("#penghasilan_lain_currency").keyup(function(e){

        var price = $("#penghasilan_lain_currency").val();
        var str = price.toString().replace("Rp. ", "");
        var str = str.toString().replace(/[^0-9\.]+/g, "");

        $("##penghasilan_lain").val(str);

        $(this).val(format($(this).val()));
    });
});

var elem_id = '';
function lookup(elem) {
  var elem_id = '#'+elem.id;
  $(elem_id).removeClass('error');
}

$(document).ready(function() {
  $('#submit').click(function(){
    var field1_1 = $('#i_name');
    var field1_2 = $('#i_phone');
    var field1_2 = $('#i_phone');
    var field1_3 = $('#i_email');
    var field1_4 = $('#i_nik');
    var field1_5 = $('#i_alamat');
    var field1_6 = $('#i_kode_pos');
    var field1_7 = $('#i_rt');
    var field1_8 = $('#i_rw');
    var field1_9 = $('#i_kelurahan');
    var field1_10 = $('#i_kecamatan');
    var field1_11 = $('#i_kota');
    var field1_12 = $('#i_ibu');
    var field1_13 = $('#date_picker2');
    var field1_14 = $('#i_tanggal_lahir');
    var field1_15 = $('#i_tempat_lahir');
    var field1_16 = $('#i_status_kawin');
    var field1_17 = $('#i_tanggungan');
    var field1_18 = $('#i_phone_rumah');
    var field1_19 = $('#i_phone');
    var field1_20 = $('#i_status_rumah');
    var field1_21 = $('#i_lama_tinggal');
    var field1_22 = $('#i_pendidikan');

    var field2_23 = $('#nama_darurat');
    var field2_24 = $('#i_hubungan');
    var field2_25 = $('#alamat_darurat');
    var field2_26 = $('#telp_darurat');

    var field3_27 = $('#nama_perusahaan');
    var field3_28 = $('#alamat_perusahaan');
    var field3_29 = $('#kode_pos_perusahaan');
    var field3_30 = $('#rt_perusahaan');
    var field3_31 = $('#rw_perusahaan');
    var field3_32 = $('#kel_perusahaan');
    var field3_33 = $('#kec_perusahaan');
    var field3_34 = $('#kota_perusahaan');
    var field3_35 = $('#telp_perusahaan');
    var field3_36 = $('#jenis_pekerjaan');
    var field3_37 = $('#jabatan');
    var field3_38 = $('#lama_bekerja_tahun');
    var field3_39 = $('#lama_bekerja_bulan');
    var field3_40 = $('#penghasilan_currency');
    var field3_41 = $('#pengeluaran_currency');
    var field3_42 = $('#penghasilan_lain_currency');
    var field3_43 = $('#sumber_penghasilan_lain');

    var field = new Array(field1_1, field1_2, field1_3, field1_4, field1_5, field1_6, field1_7, field1_8,
                          field1_9, field1_10, field1_11, field1_12, field1_13, field1_14, field1_15, field1_16,
                          field1_17, field1_18, field1_18, field1_19, field1_20, field1_21, field1_22, field2_23, field2_24,
                          field2_25, field2_26, field3_27, field3_28, field3_29, field3_30, field3_31, field3_32, field3_33, field3_33,
                          field3_34, field3_35, field3_36, field3_37, field3_38, field3_39, field3_40, field3_41, field3_42, field3_43);
    var field_count = field.length;
    var x = 1;
    $('#t_1').removeClass('fa fa-times');
    $('#t_2').removeClass('fa fa-times');
    $('#t_3').removeClass('fa fa-times');
    for (var i = 0; i <= field_count; i++) {
      var elem = field[i];
      var value = field[i].val();
      var parent = $(elem).parent();
      var grandparent = parent.parent() ;
      var master_grandparent = grandparent.parent();
      var id_master = master_grandparent.attr('id');
      if (value == false) {
        $(elem).addClass('error');
        if (id_master == 'tab_1') {
          console.log(id_master);
          $('#t_1').addClass('fa fa-times');
        }
        if (id_master == 'tab_2') {
          $('#t_2').addClass('fa fa-times');
        }
        if (id_master == 'tab_3'){
          $('#t_3').addClass('fa fa-times');
        }
        // console.log(master_grandparent);
      } else {
        $(elem).removeClass('error');
        x++;
      }
      if (x==45) {
        submit_form();
      }
    }
  });
});

function submit_form(){
  var url = "transaction_new.php?page=save_pembeli";
  $.ajax({
       url: url,
       type: 'post',
       dataType: 'json',
       data: $('form#accountForm').serialize()
   });
   location.reload();
}
  $('.selectpicker').selectpicker('refresh');
  $('#date_picker2').datepicker('refresh');
</script>
