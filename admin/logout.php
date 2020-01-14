<?php
	session_start();
	include 'config/koneksi.php';
	$id_admin = $_SESSION['admin']['id_admin'];
	$terakhir_login = date("d-M-Y (g:i:s)");
	$update_waktu_terakhir_login = mysqli_query($koneksi, "UPDATE admin SET terakhir_login = '$terakhir_login' WHERE id_admin = '$id_admin' ");
	if($update_waktu_terakhir_login) :
		// hapus cookie
		setcookie('toko', '', time() - 7200);
		setcookie('online', '', time() - 7200);
		// setcookie('ceklis', '', time() - 3600);
		// hapus session
		session_unset();
		session_destroy();
		// redirect halaman ke login
		echo "<script>alert('Anda telah logout');</script>";
		echo "<script>location='login.php';</script>";
	else :
		echo "<script>alert('Anda gagal logout');</script>";
	endif;
?>