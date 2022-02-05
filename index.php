<?php
session_start();
include_once 'koneksi.php';

if(!isset($_SESSION['userSession']))
{
 header("Location: login.php");
}
else{
$sql = "SELECT * FROM user WHERE id_user=".$_SESSION['userSession'];
$userquery = $MySQLi_CON->query($sql);
$userRow = $userquery->fetch_object();
$username = $userRow->username;
}

$tabledata_barang = "SELECT * FROM data_barang";
$tabledata_barangquery = $MySQLi_CON->query($tabledata_barang);
$tabledata_barangrow = $tabledata_barangquery->num_rows;

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
				<a href="tab-penjualan-barang.php"><li class="side">Data Penjualan Barang</li></a>
				<a href="ses.php"><li class="side">Prediksi SES</li></a>
			</ul>
		</aside>
		<section class="content">
			<h1 class="content"> Aplikasi prediksi stok barang ini dibuat untuk membantu bagian admin logistik 
			di PT. Satria Jaya Prima dalam memprediksikan stok barang yang ada di gudang, 
			agar pemesanan barang ke pusat dapat lebih efektif.</h1>
		</section>
	<?php $MySQLi_CON->close(); ?>
	</body>
</html>









