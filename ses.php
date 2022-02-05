<?php
include 'koneksi.php';
include 'function.php'
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="application/javascript" src="jquery-2.1.3.js"></script>
		<script type="application/javascript" src="jquery-ui.js"></script>
		<script type="application/javascript" src="jquery-ui.js"></script>
		<script type="application/javascript" src="paging.js"></script>
	</head>
	
	<body>
		<header>
			<div class="left">
				PT. SATRIA JAYA PRIMA
			</div>
			<div class="right">
				<a href="logout.php">Logout</a>
			</div>
		</header>
		<aside>
			<ul class="side">
				<a href="tab-barang.php"><li class="side">Data Barang</li></a>
				<a href="tab-penjualan-barang.php"><li class="side">Data Penjualan Barang</li></a>
				<a href="ses.php"><li class="side active">Prediksi SES</li></a>

			</ul>
		</aside>
		<section class="content">
			<h1 class="content">Prediksi Stok Barang</h1>
			<table>
				<!-- Pemanggilan ses_proses -->
				<form id="form_prediksi" action="ses_proses.php" method="POST"> 
					<tr>
						<td colspan="3">
							<select id="id_barang" name="id_barang" style="width: 100%; margin: 0;" required>
								<?php
									$id_barang_selected = $_GET['id_barang'];
									$barang_query = $MySQLi_CON->query("SELECT * FROM `data_barang`");
									$flag_first_item = false;
									while($barang_row = $barang_query->fetch_assoc()) {
										echo "<option value='".$barang_row['id_barang']."' ";
										if($id_barang_selected == $barang_row['id_barang']) echo "selected";
										echo ">".$barang_row['id_barang']." - ".$barang_row['nama_barang']."</option>";
										if($id_barang_selected == false AND $flag_first_item == false) {
											$id_barang_selected = $barang_row['id_barang'];
											$flag_first_item = true;
										}
									}
								?>
							</select>
							<script>
								<?php
								$alphaquery = $MySQLi_CON->query("SELECT * FROM prediksi WHERE id_barang = ".$id_barang_selected." ORDER BY id_prediksi DESC LIMIT 1");
								$alphavalue = $alphaquery->fetch_object();
								if($alphavalue != false) {
									echo "var alpha_value = ".$alphavalue->alpha_value.";";
								} else {
									echo "var alpha_value = 0.9;";
								}
								?>
								$(document).ready(function() {
									$('#prediksi').paging({
										limit:10
									});
									$('#inp_alpha').val(alpha_value);
									$('#p_alpha').text("Alpha: " + alpha_value);
									$('#btn_alpha').click(function() {
										alpha_value = prompt("Masukkan nilai alpha (0.1 - 0.9):", alpha_value);
										$('#inp_alpha').val(alpha_value);
										$('#p_alpha').text("*Alpha: " + alpha_value + "* - [Klik tombol \"Proses\" untuk melihat hasil prediksi.]");
									});
									$('#id_barang').change(function() {
										var id_barang_selected = $(this).val();
										window.location.href = "ses.php?id_barang=" + id_barang_selected;
									});
								});
							</script>
						</td>
					</tr>
					<tr>
						<td width="15%">
							<button id="btn_alpha" type="button" role="button" class="button" style="min-width: 100px; padding: 5px 10px; margin: 0;">Alpha</button>
						</td>
						<td width="15%">
							<input type="hidden" id="inp_alpha" name="inp_alpha" value="0"/>
							<input type="submit" id="btn_pross" name="btn_pross" class="button" style="min-width: 100px; padding: 5px 10px; margin: 0;" value="Proses"/>
						</td>
						<td>
							<p id="p_alpha">Alpha: 0</p>
							<p id="p_mad">MAD: </p>
							<p id="p_mape">MAPE: </p>
						</td>
					</tr>
				</form>
			</table>
			
			
			<?php

			
			//$tableprediksi = "SELECT * FROM prediksi WHERE id_barang = " . $id_barang_selected;
			$tableprediksi = "SELECT data_barang.id_barang, data_barang.nama_barang, prediksi.id_prediksi, prediksi.bulan, prediksi.jumlah, prediksi.prediksi
							FROM prediksi JOIN data_barang
							WHERE prediksi.id_barang = data_barang.id_barang && prediksi.id_barang = $id_barang_selected
							ORDER BY prediksi.id_prediksi ASC"; // Pengurutan Tabel Prediksi 
			
			if($result = $MySQLi_CON->query($tableprediksi)) {
				if($result->num_rows > 0) {
					$num_of_records = 0;
					$sum_mad = 0;
					$sum_mape = 0;
					echo "<table id='tableprediksi'>";
					echo "<tr><th>Id Barang</th><th>Nama Barang</th><th>Bulan Penjualan</th><th>Jumlah</th><th>Prediksi</th><th></th><th></th></tr>";
					while($row = $result->fetch_object()) {
							echo "<tr>";
							echo "<td>" . $row->id_barang . "</td>";
							echo "<td>" . $row->nama_barang . "</td>";
							echo "<td>" . $row->bulan . "</td>";
							echo "<td>" . $row->jumlah . "</td>";
							echo "<td>" . $row->prediksi . "</td>";
							echo "</tr>";
							if($row->jumlah != 0) {
								$val_error = abs($row->jumlah - $row->prediksi);
								$val_error_sqrt = pow($val_error, 2);
								$val_error_perc = $val_error / $row->jumlah * 100;
								$num_of_records++;
								$sum_mad += $val_error;
								$sum_mape += $val_error_perc;
							}
							}
					if($num_of_records == 0) $num_of_records = 1;
					$val_mad = round($sum_mad / $num_of_records);
					$val_mape = round($sum_mape / $num_of_records);
					echo "</table>";
					echo "
						<script>
						$(document).ready(function() {
							$('#p_mad').text('MAD: ".$val_mad."');
							$('#p_mape').text('MAPE: ".$val_mape."%');
						});
						</script>";
				}
				else {
					echo "Tidak ada yang dapat ditampilkan !!!";
				}
			}
			else {
				echo "Error: " . $MySQLi_CON->error;
			}
			
			?>
			
		</section>
	</body>
</html>