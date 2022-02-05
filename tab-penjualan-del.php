<?php

include('koneksi.php');


if ($stmt = $MySQLi_CON->prepare("DELETE FROM data_penjualan WHERE id_penjualan = ? LIMIT 1"))
{
$id_penjualan = $_GET['id_penjualan'];
$userquery = $MySQLi_CON->query("SELECT * FROM data_penjualan WHERE id_penjualan = ".$id_penjualan);
$row = $userquery->fetch_object();
$kegiatan = "Menghapus bulan penjualan ".$row->bln_penjualan." jumlah ".$row->jumlah." dengan id barang ".$row->id_barang ;
$sqlhistory = "INSERT INTO history (bln_penjualan, jumlah, id_barang) 
VALUES ('".$row->bln_penjualan."','".$row->jumlah."','".$row->id_barang."')";	
if ($MySQLi_CON->query($sqlhistory) == TRUE) {

}
else 
{
    echo "Error dalam menghapus data: " . $MySQLi_CON->error;
}
$stmt->bind_param("i",$id_penjualan);
$stmt->execute();
$stmt->close();
}
else
{
echo "ERROR: could not prepare SQL statement.";
}

$MySQLi_CON->close();
header("Location: tab-penjualan-barang.php");

?>