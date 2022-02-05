<?php
session_start();
include_once 'koneksi.php';


$id = $_GET['id'];
$userquery = $MySQLi_CON->query("SELECT * FROM data_barang WHERE id_barang = ".$id);
$row = $userquery->fetch_object();
if(isset($_POST["ubah"])){
$nama_barang = $_POST["nama_barang"];
$jumlah = $_POST["jumlah"];
$sql = "UPDATE data_barang SET nama_barang = '".$nama_barang."', jumlah = '".$jumlah."' WHERE id_barang = ".$id;
if ($MySQLi_CON->query($sql) == TRUE) {
	$kegiatan = "Mengubah nama barang ".$row->nama_barang." menjadi ".$nama_barang." dan mengubah jumlah ".$row->jumlah." menjadi ".$jumlah;
	 {
	header("Location: tab-barang.php");
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
				<a href="tab-barang.php"><li class="side active">Data Barang</li></a>
				<a href="tab-penjualan-barang.php"><li class="side">Data Penjualan Barang</li></a>
				<a href="ses.php"><li class="side">Prediksi SES</li></a>
			</ul>
		</aside>
		<section class="content">
			<h1 class="content">Mengubah nama dan jumlah barang</h1>
			<form method="post">
				<p>ID: <?php echo $id; ?></p>
				<input type="text" name="nama_barang" value="<?php echo $row->nama_barang; ?>" placeholder="Nama Barang" required/>
				<input type="text" name="jumlah" value="<?php echo $row->jumlah; ?>" placeholder="Jumlah" required/>
				<input type="submit" name="ubah" value="Ubah"/> 
			</form>
		</section>
	</body>
</html>