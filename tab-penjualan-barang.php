<?php
session_start();
include_once 'koneksi.php';

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="application/javascript" src="jquery-2.1.3.js"></script>
		<script type="application/javascript" src="jquery-ui.js"></script>
		<script type="application/javascript" src="jquery-ui.js"></script>
		<script type="application/javascript" src="paging.js"></script> 
		<script>
			$(document).ready(function() {
                $('#data_penjualan').paging({
				limit:10
				});
				$("#id_barang").change(function() {
					var id_barang_selected = $(this).val();
					window.location.href = "tab-penjualan-barang.php?id_barang=" + id_barang_selected;
				});
            });
		</script>
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
				<a href="tab-penjualan-barang.php"><li class="side active">Data Penjualan Barang</li></a>
				<a href="ses.php"><li class="side">Prediksi SES</li></a>
			</ul>
		</aside>
		<section class="content">
			<h1 class="content">Tabel Data Penjualan</h1>
			<a href="tab-penjualan-tambah.php"><div class="button">Tambah Data</div></a>
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
			<?php
			
			$tabledata_penjualan = "SELECT data_penjualan.id_barang, data_barang.nama_barang,data_penjualan.id_penjualan as id_penjualan,data_penjualan.jumlah,data_penjualan.bln_penjualan 
									FROM (data_barang JOIN data_penjualan ON data_barang.id_barang = data_penjualan.id_barang) WHERE data_barang.id_barang = " . $id_barang_selected;
			
			if ($result = $MySQLi_CON->query($tabledata_penjualan))
			{
			if ($result->num_rows > 0)
			{
			echo "<table id='tabledata_penjualan'>";

			echo "<tr>
					<th>Id Barang</th>
					<th>Nama Barang</th>
					<th>Bulan Penjualan</th>
					<th>Jumlah</th>
					<th></th><th></th></tr>";

			while ($row = $result->fetch_object())
			{
			echo "<tr>";
			//echo "<td>" . $row->id_penjualan . "</td>";
			echo "<td>" . $row->id_barang . "</td>";
			echo "<td>" . $row->nama_barang . "</td>";
			echo "<td>" . $row->bln_penjualan . "</td>";
			echo "<td>" . $row->jumlah . "</td>";
			
			echo "<td><a class='table'href='tab-penjualan-edit.php?id_penjualan=" . $row->id_penjualan . "'>Ubah</a></td>";
			echo "<td><a class='table'onclick='return confirmDelete(this);'href='tab-penjualan-del.php?id_penjualan=" . $row->id_penjualan . "'>Hapus</a></td>";
			echo "</tr>";
			}

			echo "</table>";
			}
			else
			{
			echo "Tidak ada yang dapat ditampilkan !!!";
			}
			}
			else
			{
			echo "Error: " . $MySQLi_CON->error;
			}
			?>
		</section>
	</body>
	<script>
		function confirmDelete(link) {
			if (confirm("Data ini akan dihapus ?")) {
				doAjax(link.href, "POST"); // doAjax needs to send the "confirm" field
			}
			return false;
		}
	</script>
	<?php $MySQLi_CON->close(); ?>
</html>