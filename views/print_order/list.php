<style type="text/css">
	body{
		font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
	}
	.frame{
		border:1px solid #000;
		width:10%;
		margin-left:auto;
		margin-right:auto;
		padding:10px;
	}
	table{
		font-size:14px;
	}
	.header{
		text-align:center;
		font-weight:bold;
		font-size:11px;
	}
	.header_img{
		width:164px;
		height:79px;
		margin-left:auto;
		margin-right:auto;
		margin-bottom:10px;
	}

	.back_to_order{
		width:10%;
		margin-left:auto;
		margin-right:auto;
		color:#fff;
		font-weight:bold;
		background:#09F;
		text-align:center;
		border-radius:10px;
		margin-top:10px;
		padding:5px;height:30px;
	}
		.back_to_order:hover{
		background:#069;
	}
</style>
<body  onload=print()>
<?php
$tbl = $row['table_name'];
$stt = $row['tot_name'];?>
	<div class="header">
		<span style="font-size:14px;">Hong Li Huo Guo Cheng Resto
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" >
		<tr>
			<td><?= "Meja : ". $row['table_name']?></td>

			<td align="right" ><?= $row['transaction_date'] ?></td>
		</tr>
		<tr>
			<td colspan="2"><strong><?= $row['tot_name'] ?></strong></td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top: -10;" >
		<?php
			$no_item = 1;
			$total_price = 0;
			$addwhere = "";
			if(isset($_GET["type"])){
				if($_GET["type"] == 4){
					$addwhere = " AND c.menu_type_id = 6";
				}else{
					$addwhere = " AND c.menu_type_id != 6";
				}
			}
		// query type menu
			$query_type = mysql_query("select DISTINCT C.menu_type_id , C.menu_type_name from widget_tmp a
						join menus b on b.menu_id = a.menu_id
						left join menu_types c on c.menu_type_id = b.menu_type_id
						where table_id = '$table_id' $addwhere
						order by c.menu_type_id ");
						$ind = 0;
			while ($row_type = mysql_fetch_array($query_type)) {
				if($ind!=0){
					echo "<tr>
							<td colspan = '2'>
								<hr>
							</td>
							<tr>
								<td colspan='2'>Meja : ". $tbl."</td>
							</tr>
							<tr>
								<td colspan='2'><strong>". $stt ."</strong></td>
							</tr>
					</tr>";
				}
		?>
				<tr>&nbsp;
					<td align="center"><strong><?= $row_type['menu_type_name'] ?></strong></td>
					<td align="right"></td>
				</tr>
			<?
				//query menu yang tampil
				$query = mysql_query("select a.*, b.menu_name,c.* from widget_tmp a
								join menus b on b.menu_id = a.menu_id
								join menu_types c on c.menu_type_id = b.menu_type_id
								where table_id = '$table_id' and c.menu_type_id = '".$row_type['menu_type_id']."' and a.printed !=1 and a.menu_id != 299
								order by c.menu_type_id, b.menu_name ASC");
				$lalu = "";
				$kini = "";
				while($row = mysql_fetch_array($query)){
					$kini = substr($row['menu_name'], 0, 1);
					if($_GET["type"] != 4){
							if($kini !='A' && $lalu == 'A'){
								echo "<tr>";
								echo "<td>&nbsp;</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td><hr></td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td>Meja: ".$tbl."</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td><strong>".$stt."</strong></td>";
								echo "</tr>";
							}else if($kini !='B' && $lalu =='B'){
								echo "<tr>";
								echo "<td>&nbsp;</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td><hr></td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td>Meja: ".$tbl."</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td><strong>".$stt."</strong></td>";
								echo "</tr>";
							}
							$lalu=$kini;
						}
			?>
					<tr>&nbsp;
						<td><?= $no_item. '. '.$row['menu_name']//.' - '.$row['menu_type_name'] ?></td>
						<td align="right"><?=  $row['jumlah'] ?></td>
					</tr>
						<?php
						//query keterangan menu
						$query_widget_detail = mysql_query("select a.*, b.note_name
										from widget_tmp_details a
										join notes b on b.note_id = a.note_id
										where wt_id = '".$row['wt_id']."'
										order by wt_id

										");
						while($row_widget_detail = mysql_fetch_array($query_widget_detail)){

						?>
							<tr>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;- <?= $row_widget_detail['note_name']?></td>
							</tr>
						<?php
						}
						if($row['wt_desc'] != ""){
						?>
						<tr>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;- <?= $row['wt_desc']?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
				<?php
					}
					$no_item++;
					}
					$ind++;
				}

				?>
		</table>
	<br />
	<br>
	<br>
	<hr>
	<br />

	<a href="order.php" style="text-decoration:none"><div class="back_to_order"></div></a>
</body>
