<script type="text/javascript">
		  function grand_total()
			{

				var harga = parseFloat(document.getElementById("i_harga").value);
				var qty = parseFloat(document.getElementById("i_qty").value);


				var	total = harga * qty;



				document.getElementById("i_total").value = total;

			}

		   </script>
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


                                        <div class="col-md-12">

                                        <div class="form-group">
                                            <label>Kode Transaksi</label>
                                            <input readonly required type="text" name="i_name" class="form-control" placeholder="Masukkan nama supplier..." value="<?=$row->transaction_code ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input readonly required type="text" name="i_telp" id="i_telp" class="form-control" placeholder="Masukkan nomor telepon..." value="<?= $row->transaction_date ?>"/>
                                        </div>
                                         <div class="form-group">
                                            <label>Grand Total</label>
                                            <input readonly required type="email" name="i_email" id="i_email" class="form-control" placeholder="Masukkan email..." value="<?= $row->transaction_grand_total ?>"/>
                                        </div>

                                        </div>
                                        <section class="content">
                    <div class="row">
                        <div class="col-xs-12">



                            <div class="box">

                                <div class="box-body2 table-responsive">
                                 <div class="box-header" style="cursor: move;">
<h3 class="box-title"><strong>List Detail Transaksi</strong></h3>
</div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>Menu</th>
                                                   <th>Jumlah</th>
                                                   <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                           $no_tr = 1;
                                           while($row_tr = mysql_fetch_array($query_detail)){
                                            ?>
                                            <tr>
                                            <td><?= $no_tr?></td>
                                               <td><?= $row_tr['menu_name']?></td>
                                               <td><?= $row_tr['transaction_detail_qty']?></td>
                                               <td><?= tool_format_number($row_tr['transaction_detail_grand_price'])?></td>

                                            </tr>
                                            <?php
                                            $no_tr++;
                                            }
                                            ?>



                                        </tbody>

                                    </table>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section>

                                        <div style="clear:both;"></div>

                                </div><!-- /.box-body -->

                                  <div class="box-footer">
                                <a href="<?= $close_button?>" class="btn btn-danger" >Close</a>

                             </div>

                            </div><!-- /.box -->
                       </form>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
