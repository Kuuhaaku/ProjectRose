<?php
session_start();
include_once 'koneksi.php';


if(isset($_POST["tambah"])){
$nama_barang = $_POST["nama_barang"];
$jumlah = $_POST["jumlah"];
$sql = "INSERT INTO data_barang (nama_barang, jumlah)
VALUES ('".$nama_barang."','".$jumlah."')";

if ($MySQLi_CON->query($sql) == TRUE) {
$kegiatan = "Memabahkan barang baru jumlah ".$jumlah." dengan nama ".$nama_barang;
	header("Location: tab-barang.php");
}
} 

$MySQLi_CON->close();

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
			<h1 class="content">Menambah data barang</</h1>
			<form method="post">
				<input type="text" name="nama_barang" placeholder="Nama Barang" required/>
				<input type="text" name="jumlah" placeholder="Jumlah" required/><br>
				<input type="submit" name="tambah" value="Tambah"/> 
			</form>
		</section>
	</body>
</html>