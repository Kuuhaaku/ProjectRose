<?php
session_start();
include_once 'koneksi.php';

$id_penjualan = $_GET['id_penjualan'];
$userquery = $MySQLi_CON->query("SELECT * FROM data_penjualan WHERE id_penjualan = ".$id_penjualan);
$row = $userquery->fetch_object();
if(isset($_POST["ubah"])){
$bln_penjualan = $_POST["bln_penjualan"];
$jumlah = $_POST["jumlah"];
$id_barang = $_POST["id_barang"];
$sql = "UPDATE data_penjualan SET bln_penjualan = '".$bln_penjualan."', jumlah = '".$jumlah."', id_barang = '".$id_barang."' WHERE id_penjualan = ".$id_penjualan;
if ($MySQLi_CON->query($sql) == TRUE) {
	$kegiatan = "Mengubah bulan penjualan ".$row->bln_penjualan." menjadi ".$bln_penjualan." mengubah jumlah ".$row->jumlah." menjadi ".$jumlah." dan mengubah id barang ".$row->id_barang." menjadi ".$id_barang;
	 {
	header("Location: tab-penjualan-barang.php");
	} 
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
			<h1 class="content">Mengubah data barang</h1>
			<form method="post">
				<p>ID: <?php echo $id_penjualan; ?></p>
				<input type="date" name="bln_penjualan" value="<?php echo $row->bln_penjualan; ?>" required/>
				<input type="text" name="jumlah" value="<?php echo $row->jumlah; ?>" placeholder="Jumlah" required/>
				<select name="id_barang" required>
					<option value=''>---Pilih ID Barang---</option>
					<?php
					$barang_query = $MySQLi_CON->query("SELECT * FROM `data_barang`");
					while ($barang_row = $barang_query->fetch_assoc()) {
						echo "<option value='".$barang_row['id_barang']."' ";
						if($row->id_barang == $barang_row['id_barang']) echo "selected";
						echo ">".$barang_row['id_barang']." - ".$barang_row['nama_barang']."</option>";
					}
					?>
				</select><br>
				<input type="submit" name="ubah" value="Ubah"/> 
			</form>
		</section>
	</body>
</html>