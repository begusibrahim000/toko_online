<?php
	session_start();
	// hapus data cookie
	setcookie('my', '', time() + 7200);
	setcookie('jobs', '', time() + 7200);
	// unset($_SESSION['pelanggan']);
	// hanya menghapus akun bukan keranjang yang sudah dibeli 
	session_destroy();
	echo "<script>alert('Anda telah logout');</script>";
	echo "<script>location='login.php';</script>";
?>