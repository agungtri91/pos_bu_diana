<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/print/print.css" rel="stylesheet">
<style media="screen">
@media print {
  thead { display: table-header-group; }
}
@media screen {
  thead { display: block; }
}
</style>
<body onload="print()">
  <center>
    <div id="" class="Section1">
      <table id="tb_utama">
          <thead>
            <tr>
                <td>
                  <center>
                    <div class="header-perjanjian"></div>
                  </center>
                </td>
            </tr>
          </thead>
        <tbody>
          <tr>
            <td style="text-align:right;">NOMOR : 2in1 / <?= $transaction_code?></td>
          </tr>
          <tr>
            <td>
              <div id="body-perjanjian">
                <p>
                  Pada hari ini, <b><?= $hari_ini ?></b> Tanggal <b><?= format_date_only($transaction_date) ?></b> Bulan <b><?= $bulan_ini?></b>
                   Tahun <b><?= $tahun_ini?></b>
                  kami yang bertandatangan dibawah ini
                </p>
                <table class="member-perjanjian">
                  <tr>
                    <td class="title-tb-member-perjanjian" >Nama</td>
                    <td class="titik-dua center">:</td>
                    <td valign="top"><?= $r_office['office_owner']?></td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian">Jabatan</td>
                    <td class="titik-dua center">:</td>
                    <td valign="top">Pemilik </td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian" valign="top">Alamat</td>
                    <td class="titik-dua center">:</td>
                    <td valign="top"><?= $r_office['office_owner_address']?></td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian" valign="top">Telepon</td>
                    <td class=": center">:</td>
                    <td  valign="top"><?= $r_office['office_owner_phone']?></td>
                  </tr>
                </table>
                <p>Dalam hal ini bertindak untuk dan atas nama Two in One Corporate yang selanjutnya disebut PIHAK PERTAMA.</p>
                <table class="member-perjanjian">
                  <tr>
                    <td class="title-tb-member-perjanjian" >Nama</td>
                    <td class="titik-dua center">:</td>
                    <td valign="top"><?= $r_member['member_name']?></td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian">Tempat, Tanggal Lahir</td>
                    <td class="titik-dua center">:</td>
                    <?php
                    $ttl = $r_member['tempat_lahir'].', '. format_date_only($r_member['tanggal_lahir']);
                     ?>
                    <td valign="top"><?= $ttl?></td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian" valign="top">Pekerjaan</td>
                    <td class="titik-dua center" valign="top">:</td>
                    <td><?= $r_member['jenis_pekerjaan']?></td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian" valign="top">Nik</td>
                    <td class=": center" valign="top">:</td>
                    <td><?= $r_member['member_nik']?></td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian" valign="top">Telepon</td>
                    <td class=": center" valign="top">:</td>
                    <td><?= $r_member['member_phone']?></td>
                  </tr>
                </table>
                  <p>Bahwa PIHAK PERTAMA dengan ini menjual dan menyerahkan kepada PIHAK KEDUA,
                  dan PIHAK KEDUA sepakat membeli dan menerima penyerahan dari PIHAK PERTAMA berupa:</p>
                <table class="member-perjanjian">
                  <tr>
                    <td class="title-tb-member-perjanjian" >Jenis Barang</td>
                    <td class="titik-dua center">:</td>
                    <td valign="top"><?= $r_item['kategori_name']?></td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian">Merk</td>
                    <td class="titik-dua center">:</td>
                    <td valign="top"><?= $r_item['item_merk']?></td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian" valign="top">Tipe</td>
                    <td class="titik-dua center" valign="top">:</td>
                    <td valign="top"><?= $r_item['item_tipe']?></td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian" valign="top">No. Seri</td>
                    <td class=": center" valign="top">:</td>
                    <td valign="top"></td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian" valign="top">Harga Barang</td>
                    <td class=": center" valign="top">:</td>
                    <td valign="top">Rp. <?= format_rupiah($r_item['harga_item'])?>,00</td>
                  </tr>
                  <!-- <tr>
                    <td class="title-tb-member-perjanjian" valign="top">Biaya Administrasi</td>
                    <td class=": center" valign="top">:</td>
                    <td valign="top">Rp. <?= format_rupiah($r_kredit['administrasi'])?>,00</td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian" valign="top">Uang Muka</td>
                    <td class=": center" valign="top">:</td>
                    <td valign="top">Rp. <?= format_rupiah($r_kredit['uang_muka_barang'])?>,00</td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian" valign="top">Lama Angsuran</td>
                    <td class=": center" valign="top">:</td>
                    <td valign="top"><?= $r_kredit['lama_angsuran']?> <?= $periode_name?></td>
                  </tr>
                  <tr>
                    <td class="title-tb-member-perjanjian" valign="top">Nominal Angsuran</td>
                    <td class=": center" valign="top">:</td>
                    <td valign="top">Rp. <?= format_rupiah($r_kredit['angsuran_per_bulan'])?>,00</td>
                  </tr> -->
                </table>
                  <p>
                    Dalam hal ini bertindak untuk dan atas namanya sendiri, yang selanjutnya disebut sebagai PIHAK KEDUA.
                    Para Pihak menerangkan terlebih dahulu hal-hal sebagai berikut:
                  </p>
                  <p style="text-align:center; font-size: 14px;"><b>Pasal 1</b></p>
                  <p>
                    Harga Barang tersebut disepakati oleh kedua belah pihak sebesar <strong>Rp. <?= format_rupiah($r_item['harga_item'])?>,00
                    (<?= terbilang($r_item['harga_item'])?></strong>)
                  </p>
                  <p style="text-align:center; font-size: 14px;"><b>Pasal 2</b></p>
                  <p>
                    PIHAK PERTAMA menyerahkan barang tersebut kepada PIHAK KEDUA pada saat serah terima dan telah terjadi kesepakatan kedua belah pihak.
                  </p>
                  <p style="text-align:center; font-size: 14px;"><b>Pasal 3</b></p>
                  <p>Jangka Waktu pembayaran disepakati oleh kedua belah pihak selama bulan terhitung sejak di tandatanganinya Perjanjian ini.</p>
                  <p style="text-align:center; font-size: 14px;"><b>Pasal 4</b></p>
                  <p>HAK KEDUA sepakat melakukan pembayaran dengan cara-cara berikut ini:</p>
                    <table class="member-perjanjian">
                      <tr>
                        <td valign="top">a.</td>
                        <td>PIHAK KEDUA membayar uang muka sebesar <strong>Rp. <?= format_rupiah($r_item['uang_muka_barang'])?></strong></td>
                      </tr>
                      <tr>
                        <td valign="top">b.</td>
                        <td>Pembayaran harus diangsur oleh PIHAK KEDUA selama <strong><?= $r_item['lama_angsuran']?> <?= $periode_name?></strong> sejak
                          penyerahan Barang yang besarnya <strong>Rp <?= format_rupiah($r_item['angsuran_per_bulan'])?> <?= $periode_name?></strong></td>
                      </tr>
                      <tr>
                        <td valign="top">c.</td>
                        <td>Pembayaran angsuran ditetapkan setiap tanggal <strong><?= $r_item['pembayaran_per_tanggal_1'].'-'.$r_item['pembayaran_per_tanggal_2']?><strong>
                          Setiap bulannya.</td>
                      </tr>
                    </table>
                  <p style="text-align:center; font-size: 14px;"><b>Pasal 5</b></p>
                  <p>
                    PIHAK PERTAMA akan memberikan kuitansi untuk setiap angsuran, dan pembayaran angsuran hanya
                    dianggap sah apabila PIHAK PERTAMA telah menerima bukti kwitansi resmi.
                    Contoh dan bukti kwitansi resmi adalah sama dengan kuitansi uang muka yang dicap resmi.
                  </p>
                  <p style="text-align:center; font-size: 14px;"><b>Pasal 6</b></p>
                  <p>PIHAK KEDUA tidak diperbolehkan memindahtangankan, mengoperkan, menjual, menggadaikan atau melakukan
                     perbuatan-perbuatan lain yang bertujuan untuk memindah tangankan kepemilikan barang milik PIHAK
                     PERTAMA sebelum angsuran dibayar lunas.</p>
                  <p style="text-align:center; font-size: 14px;"><b>Pasal 7</b></p>
                  <table class="member-perjanjian">
                    <tr>
                      <td valign="top">a.</td>
                      <td>Selama Barang tersebut belum dibayar lunas, maka Barang tersebut masih milik PIHAK PERTAMA. Dan, PIHAK PERTAMA sewaktu-waktu dapat
                        mengecek keadaan barang tersebut, karena status barang tersebut masih merupakan titipan PIHAK PERTAMA di alamat PIHAK KEDUA.</td>
                    </tr>
                    <tr>
                      <td valign="top">b.</td>
                      <td>Apabila PIHAK KEDUA telah melunasi semua pembayaran angsuran Barang tersebut, maka PIHAK PERTAMA akan
                        menyerahkan hak kepemilikan barang tersebut kepada PIHAKKEDUA dalam bentuk Surat Tanda Bukti Lunas (STBL).</td>
                    </tr>
                    <tr>
                      <td valign="top">c.</td>
                      <td>Jika barang tersebut dibeli secara diangsur maka keterlambatan angsuran akan di kenakan biaya sebesar <?= $denda?> dari biaya angsuran
                        tersebut sesuai dengan jumlah angsuran yang harus di bayar oleh PIHAK KEDUA dan denda keterlambatan ini dihitung per-hari
                        sejak jatuh tempo pembayaran berlangsung.</td>
                    </tr>
                  </table>
                  <p style="text-align:center; font-size: 14px;"><b>Pasal 8</b></p>
                  <p>Apabila PIHAK KEDUA mengingkari perjanjian ini di kemudian hari, maka PIHAK KEDUA bersedia untuk menjaminkan harta bendanya untuk
                    diperhitungkan dengan pinjamannya dan PIHAK PERTAMA mengeksekusi harta benda tersebut.</p>
                  <p style="text-align:center; font-size: 14px;"><b>Pasal 9</b></p>
                  <p>Apabila terjadi perselisihan dari Perjanjian ini akan diselesaikan dengan jalan musyawarah, dan apabila tidak terjadi
                    kesepakatan antara kedua belah pihak dalam musyawarah, maka kedua belah pihak sepakat untuk menyelesaikan dengan jalur hokum
                    dengan mengambil tempat tinggal (domisili) yang umum dan tetap di Kantor Pengadilan Negeri. Demikianlah Perjanjian ini dibuat dan
                    ditandatangani padahari, tanggal, bulan, tahun seperti yang disebutkan dalam awal
                    Perjanjian ini, dibuat rangkap 2 dan bermeterai cukup yang berkekuatan hukum yang sama untuk masing masing pihak.</p>
                    <table style="width:100%;">
                      <tr>
                        <td style="text-align:center;width:50%;"></td>
                				<td style="text-align:center;">Gresik, <?= format_date_only($transaction_date) ?></td>
                      </tr>
                			<tr>
                				<td style="text-align:center;width:50%;">Pihak Kedua</td>
                				<td style="text-align:center;">Pihak Pertama</td>
                			</tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                			<tr>
                				<td style="text-align:center;width:50%;">
                					<?= $r_member['member_name'] ? $r_member['member_name'] : "................."?>
                        </td>
                				<td style="text-align:center;"><?= $user_name?></td>
                			</tr>
                		</table>
                    <table style="width:100%;">
                      <center>
                        <tr>
                          <td style="text-align:center;">Penjamin Pihak Kedua</td>
                        </tr>
                        <tr>
                          <td style="text-align:center;">&nbsp;</td>
                          <td style="text-align:center;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="text-align:center;">&nbsp;</td>
                          <td style="text-align:center;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="text-align:center;">&nbsp;</td>
                          <td style="text-align:center;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                              <?= $partner_name ? $partner_name : "................."?>
                            </td>
                            <td></td>
                        </tr>
                      </center>
                    </table>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <center>
        <div class="row" style="width:100%">
          <a href="transaction_new.php" class="hidden-print">
            <button class="btn btn-danger"><label>Kembali</label></button>
          </a>
        </div>
      </center>
    </div>
  </center>
</body>
