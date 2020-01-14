<?php
	session_start();
	$id_produk = $_GET['id_produk'];
	// var_dump($id_produk);die();

	// JIKA DIKLIK BELI MAKA :
	if(isset($_SESSION['keranjang'][$id_produk])) : // jika produk sudah ada di SESSION keranjang maka di tambah 1
		$_SESSION['keranjang'][$id_produk] += 1; 
	elseif(!isset($_SESSION['keranjang'][$id_produk])) : // jika dikerangjang kosong (belum dibeli sama sekali)
		$_SESSION['keranjang'][$id_produk]=1;
	endif;

	echo "<script>alert('Produk berhasil masuk dalam keranjang belanja');</script>";
	echo "<script>location='keranjang.php';</script>";
?>
