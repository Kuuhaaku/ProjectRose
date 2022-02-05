<?php
session_start();
include_once 'koneksi.php';


if(isset($_POST["tambah"])){
$bln_penjualan = $_POST["bln_penjualan"];
$jumlah = $_POST["jumlah"];
$id_barang = $_POST["id_barang"];
$sql = "INSERT INTO data_penjualan (bln_penjualan, jumlah, id_barang)
VALUES ('".$bln_penjualan."','".$jumlah."', '".$id_barang."')";

if ($MySQLi_CON->query($sql) == TRUE) {
$kegiatan = "Mengubah bulan penjualan ".$row->bln_penjualan." menjadi ".$bln_penjualan." mengubah jumlah ".$row->jumlah." menjadi ".$jumlah." dan mengubah id barang ".$row->id_barang." menjadi ".$id_barang;
	header("Location: tab-penjualan-barang.php");
}

$MySQLi_CON->close();
}

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
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
			<h1 class="content">Menambah data penjualan barang</</h1>
			<form method="post">
				<input type="date" name="bln_penjualan" />
				<input type="text" name="jumlah" placeholder="Jumlah" required/><br>
				<select name="id_barang" required>
					<option value=''>---Pilih ID Barang---</option>
					<?php
					$barang_query = $MySQLi_CON->query("SELECT * FROM `data_barang`");
					while($barang_row = $barang_query->fetch_assoc()) {
						echo "<option value='".$barang_row['id_barang']."'>".$barang_row['id_barang']." - ".$barang_row['nama_barang']."</option>";
					}
					?>
				</select><br>
				<input type="submit" name="tambah" value="Tambah"/> 
			</form>
		</section>
	</body>
</html>