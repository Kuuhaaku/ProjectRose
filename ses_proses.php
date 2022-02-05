<?php
include 'koneksi.php';
include 'function.php';

if(isset($_POST['btn_pross'])) {
	$alpha_value = $_POST['inp_alpha'];
	$id_barang = $_POST['id_barang'];
	
	$del_stmt = $MySQLi_CON->prepare("DELETE FROM `prediksi` WHERE id_barang = ?");
	$del_stmt->bind_param("s", $id_barang); // INI JADIKAN STRING ======================
	$del_stmt->execute();
	
	$ins_stmt = "INSERT INTO `prediksi` (id_barang, bulan, jumlah, prediksi, alpha_value) VALUES ";
	
	//$penjualan_query = $MySQLi_CON->query("SELECT * FROM `data_penjualan` WHERE id_barang = ".$id_barang." ORDER BY id_barang ASC, nama_barang ASC, bln_penjualan ASC");
	$penjualan_query = $MySQLi_CON->query("SELECT * FROM `data_penjualan` WHERE id_barang = ".$id_barang." ORDER BY id_barang ASC");
	$flag_first_record = 0;
	while($penjualan_record = $penjualan_query->fetch_assoc()) {
		// Memunculkan debug pada console =============
		// debug_to_console($penjualan_record['bln_penjualan']);
		if($flag_first_record == 0) {
			$prediksi_ft = $penjualan_record['jumlah'];
			$jumlah_penjualan_sebelum = $penjualan_record['jumlah'];
			$flag_first_record = 1;
		} else {
			$prediksi_ft = round(($alpha_value * $jumlah_penjualan_sebelum) + ((1 - $alpha_value) * $prediksi_ft));
			$jumlah_penjualan_sebelum = $penjualan_record['jumlah'];
		}
		
		$last_record_jlh = $penjualan_record['jumlah'];
		// $last_record_periode = $penjualan_record['bln_penjualan']; ============== OK INI SALAH
		$last_record_tgl = $penjualan_record['bln_penjualan']; // INI yang benar
		// Append Insert Statement ===========
		// $ins_stmt .= "("."$id_barang".", ".$penjualan_record['bln_penjualan'].", ".$penjualan_record['jumlah'].", ".$prediksi_ft.", ".$alpha_value."),";
		// REVISI INSERT DATA ====================
		$insert_query = 	"INSERT INTO `prediksi` (id_barang, bulan, jumlah, prediksi, alpha_value)
							VALUES (?,?,?,?,?)";
		$old_stmt = $MySQLi_CON->prepare($insert_query);
		$old_stmt->bind_param("sssss", $id_barang, $penjualan_record['bln_penjualan'], $penjualan_record['jumlah'], $prediksi_ft, $alpha_value); 
		$old_stmt->execute();
	}
	
	
	$next_record_tgl = date("Y-m-t", strtotime("$last_record_tgl +1 month"));
	// debug_to_console($next_record_tgl);
	$prediksi_bulan_depan = round(($alpha_value * $last_record_jlh) + ((1 - $alpha_value) * $prediksi_ft));

	// Append Insert Stmt
	$ins_stmt .= "(".$id_barang.", '".$next_record_tgl."', 0, ".$prediksi_bulan_depan.", ".$alpha_value.");";
	// Ini INSERT =================
	$MySQLi_CON->query($ins_stmt);

	/* INI BUANG DULU ================================================================
	if($flag_first_record != 0) {
		// Ini kalau .... apaan ya ===============
		$last_record_thn = (int) substr($last_record_tgl, 0, 4);
		$last_record_bln = (int) substr($last_record_tgl, 5, 2);
		if($last_record_bln == 12) {
			$next_record_thn = strval($last_record_thn + 1);
			$next_record_bln = "01";
		} else {
			$next_record_thn = strval($last_record_thn);
			$next_record_bln = strval($last_record_bln + 1);
			if(strlen($next_record_bln) < 2) $next_record_bln = "0".$next_record_bln; // Buat nambahin 0 di bulan satu digit =========
		}
		// $next_record_tgl = $next_record_thn."-".$next_record_bln."-28"; // INI KENAPA 28? ============= date("Y-m-t", strtotime($dt))
		$prediksi_bulan_depan = round(($alpha_value * $last_record_jlh) + ((1 - $alpha_value) * $prediksi_ft));
		$ins_stmt .= "(".$id_barang.", '".$next_record_tgl."', 0, ".$prediksi_bulan_depan.", ".$alpha_value.");";

		// Ini INSERT =================
		$MySQLi_CON->query($ins_stmt);
		
	} else {
		// Ini tidak akan dieksekusi gak sih? ====================
		$ins_stmt .= "(".$id_barang.", ".date('Y-m-d').", 0, 0, ".$alpha_value.");";
		$MySQLi_CON->query($ins_stmt);
	}
	*/
	
	echo "<script>window.location.href = 'ses.php?id_barang=".$id_barang."';</script>";
	}
?>