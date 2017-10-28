
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body2 table-responsive">
        <div class="box-header" style="cursor: move;">
          <h3 class="box-title"><strong>Journal</strong></h3>
        </div>
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th style="width:2%;">No</th>
              <th>Tanggal</th>
              <th style="width:5%;">Tipe Jurnal</th>
              <th>Id Transaksi</th>
              <th>Debit</th>
              <th>Kredit</th>
              <th>Piutang</th>
              <th>Hutang</th>
              <th>Bank Kita</th>
              <th>No. Rek</th>
              <th>Bank Client</th>
              <th>No. Rek</th>
              <th>Cabang</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $no_item = 1;
            $total_debit = 0;
            $total_credit = 0;
            // $q_piutang = mysql_query("SELECT SUM(a.total_piutang) from piutang2 a
            //                           WHERE  piutang_date >= '$date1'
            //                           AND piutang_date <= '$date2'");
            $total_piutang = 0;
            $total_hutang = 0;
          while($row_item = mysql_fetch_array($query_item)){ ?>
            <tr>
              <td><?= $no_item ?></td>
              <td><?= format_date($row_item['journal_date']); ?></td>
              <td><?= $row_item['journal_type_name'] ?></td>
              <td><?= $row_item['data_id'] ?></td>
              <td><?= tool_format_number($row_item['journal_debit'])?></td>
              <td><?= tool_format_number($row_item['journal_credit'])?></td>
              <td><?= tool_format_number($row_item['journal_piutang'])?></td>
              <td><?= tool_format_number($row_item['journal_hutang'])?></td>
              <td><?= tool_format_number($row_item['bank_id'])?></td>
              <td><?= tool_format_number($row_item['bank_account'])?></td>
              <td><?= tool_format_number($row_item['bank_id_to'])?></td>
              <td><?= tool_format_number($row_item['bank_account_to'])?></td>
              <?php
              $q_branch=mysql_query("SELECT branch_name from branches WHERE branch_id =".$row_item['branch_id']);
              $r_branch = mysql_fetch_array($q_branch);
              ?>
              <td><?= $r_branch['branch_name']?></td>
            </tr>
          <?php
            $total_debit = $total_debit + $row_item['journal_debit'];
            $total_credit = $total_credit + $row_item['journal_credit'];
            $total_piutang = $total_piutang + $row_item['journal_piutang'];
            $total_hutang = $total_hutang + $row_item['journal_hutang'];
            $no_item++; } ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" align="right" style="font-size:22px; font-weight:bold;">TOTAL</td>
              <td><?= tool_format_number_report($total_debit)?></td>
              <td><?= tool_format_number_report($total_credit)?></td>
              <td><?= tool_format_number_report($total_piutang)?></td>
              <td><?= tool_format_number_report($total_hutang)?></td>
            </tr>
          </tfoot>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>
