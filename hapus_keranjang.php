<?php
	session_start();
	$id_produk = $_GET['id_produk'];
	// hapus session keranjang berdasarkan id dengan syntax "unset" bukan "session_destroy -> ini untuk semua data yang ada disession" 
	unset($_SESSION['keranjang'][$id_produk]);

	echo "<script>alert('Produk berhasil dihapus / dicansel');</script>";
	echo "<script>location='keranjang.php';</script>";

?>