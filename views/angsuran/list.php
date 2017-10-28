<!-- Content Header (Page header) -->
<!-- Main content angsuran piutang -->
<style>
	#payment_type2{
		height:auto;
	}
	#payment_type2 label span{
		text-align:center;
    padding:13px 13px;
    display:block;
    cursor: pointer;
    color: #000;
	}
  #bank_frame{
    display: table;
    width: 100%;
    border-bottom-width: 41px;
    padding-bottom: 19px;
    padding-left: 101px;
    text-align: left;
  }
  #bank_frame_transfer{
    display: table;
    width: 100%;
    border-bottom-width: 41px;
    padding-bottom: 19px;
    padding-left: 101px;
    text-align: left;
  }
  table#example1 th{
    text-align: center;;
  }

</style>
  <section class="content">
    <div class="row">
    <!-- right column -->
      <div id="utama" class="col-md-12">
      <!-- general form elements disabled -->
        <div class="title_page"><?= $title ?></div>
        <div class="box">
          <div id="angsuran_v_1" class="box-body2 table-responsive">
            <table id="example1" style="width:100%;" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width:5%;text-align:center;">NO. </th>
                  <th style="width:20%;">Pembeli</th>
                  <th style="width:20%;">Total Hutang </th>
                  <th>Alamat </th>
                  <th>Telp. </th>
                  <th>Config </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                while($r_hutang=mysql_fetch_array($query)){ ?>
                  <tr>
                    <td style="width:5%;text-align:center;"><?= $no?></td>
                    <td><?= $r_hutang['member_name']?></td>
                    <td class="text-center">Rp. <?= format_rupiah($r_hutang['total_piutang']) ?></td>
                    <td class="text-center"><?= $r_hutang['member_alamat']?></td>
                    <td class="text-center"><?= $r_hutang['member_phone']?></td>
                    <td class="text-center">
											<a class="btn btn-default" href="angsuran.php?page=list_piutang_member&id=<?= $r_hutang['member_id']?>">
												<i class="fa fa-search"></i>
											</a>
										</td>
                  </tr>
                 <?php $no++; } ?>
              </tbody>
            </table>
          </div>
				</div>
			</div>
		</div>
    <div id="angsuran_v_5" class="box box-body" style="display:none;"></div>
  </section><!-- /.content -->
