<?php
session_start();
include_once 'koneksi.php';

if(!isset($_SESSION['userSession']))
{
 header("Location: login.php");
}
else{
$sql = "SELECT * FROM data_barang WHERE id_barang=".$_SESSION['userSession'];

}
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
                $('#data_barang').paging({
				limit:10
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
				<a href="tab-barang.php"><li class="side active">Data Barang</li></a>
				<a href="tab-penjualan-barang.php"><li class="side">Data Penjualan Barang</li></a>
				<a href="ses.php"><li class="side">Prediksi SES</li></a>

			</ul>
		</aside>
		<section class="content">
			<h1 class="content">Tabel Barang</h1>
			<a href="tab-barang-tambah.php"><div class="button">Tambah Data</div></a>
				</select>
			</form>
			<?php
			
				$tabledata_barang = "SELECT * FROM data_barang";
			
			if ($result = $MySQLi_CON->query($tabledata_barang))
			{
			if ($result->num_rows > 0)
			{
			echo "<table id='tableData'>";

			echo "<tr>
				<th>Nama Barang</th>
				<th>Jumlah Barang</th>
				<th></th><th></th></tr>";

			while ($row = $result->fetch_object())
			{
			echo "<tr>";
			//echo "<td>" . $row->id_barang . "</td>";
			echo "<td>" . $row->nama_barang . "</td>";
			echo "<td>" . $row->jumlah . "</td>";
			echo "<td><a class='table'href='tab-barang-edit.php?id=" . $row->id_barang . "'>Ubah</a></td>";
			echo "<td><a class='table'onclick='return confirmDelete(this);'href='tab-barang-del.php?id=" . $row->id_barang . "'>Hapus</a></td>";
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
				doAjax(link.href, "POST"); 
			}
			return false;
		}
	</script>
	<?php $MySQLi_CON->close(); ?>
</html>