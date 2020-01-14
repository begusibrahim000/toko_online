<?php
	include_once 'config/koneksi.php';
	$id_pelanggan = $_GET['id_pelanggan'];
	$hapus_pelanggan = mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'");
	if($hapus_pelanggan) :
		echo "<script>alert('Data pelanggan berhasil dihapus');</script>";
		echo "<script>location='index.php?halaman=pelanggan';</script>";
	endif;
?>