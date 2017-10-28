<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
  <div class="box-body2 table-responsive">
    <table id="tb_angsuran_kredit" class="table table-bordered table-striped" style="width:100%;">
      <thead>
        <tr>
          <th style="text-align:center;">No</th>
          <th style="text-align:center;">Tanggal</th>
          <th style="text-align:center;">Nominal</th>
          <th style="text-align:center;">Total Bayar</th>
          <th style="text-align:center;">Kembalian</th>
          <th style="text-align:center;">Ket.</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($row = mysql_fetch_array($q_angsuran_kredit)) { ?>
          <tr>
            <td style="text-align:center;"><?= $no?></td>
            <td style="text-align:center;"><?= format_date_only($row['angsuran_date'])?></td>
            <td style="text-align:center;"><?= format_rupiah($row['angsuran_nominal'])?></td>
            <td style="text-align:center;"><?= format_rupiah($row['total_payment'])?></td>
            <td style="text-align:center;"><?= format_rupiah($row['payment_change'])?></td>
            <td style="text-align:center;">
              <?php
              if ($row['ket'] == 0){
                echo "Tepat Waktu";
              }else {
                echo "Terlambat Bayar";
              }?></td>
          </tr>
        <? $no++; } ?>
      </tbody>
    </table>
  </div>
</div>
<div class="modal-footer">

</div>
<script type="text/javascript">

    $("#tb_angsuran_kredit").dataTable({
      dom: 'Bfrtip',
      buttons: [

          {
              extend: 'pageLength'
          },
          {
              extend: 'copy'
          },
          {
              extend: 'excel'
          },
          {
              extend: 'pdf'
          }
      ],
      lengthMenu: [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ]
  });
</script>
