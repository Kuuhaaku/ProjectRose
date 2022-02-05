<?php

include('koneksi.php');

if (isset($_GET['id']) && is_numeric($_GET['id']))
{

$id = $_GET['id'];

if ($stmt = $MySQLi_CON->prepare("DELETE FROM data_barang WHERE id_barang = ? LIMIT 1"))
{
$id = $_GET['id'];
$userquery = $MySQLi_CON->query("SELECT * FROM data_barang WHERE id_barang = ".$id);
$row = $userquery->fetch_object();
$kegiatan = "Meghapus nama barang ".$row->nama_barang." dengan jumlah ".$row->jumlah;
$sqlhistory = "INSERT INTO history (jumlah, nama_barang) 
VALUES ('".$row->nama_barang."','".$row->jumlah."')";	
if ($MySQLi_CON->query($sqlhistory) == TRUE) {

}
else 
{
    echo "Error dalam menghapus data: " . $MySQLi_CON->error;
}
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->close();
}
else
{
echo "ERROR: could not prepare SQL statement.";
}

$MySQLi_CON->close();
header("Location: tab-barang.php");
}
else
{
header("Location: tab-barang.php");
}

?>