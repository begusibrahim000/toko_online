<?php
	include 'config/koneksi.php';
	$id_produk = $_GET['id_produk'];
	$data = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk' ");
	$pecah = mysqli_fetch_assoc($data);
	// hapus foto
	if(file_exists('../foto_produk/'.$pecah['poto_produk'])) :
		unlink('../foto_produk/'.$pecah['foto_produk']);
	endif;

	$detele_produk = mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk = '$id_produk' ");
	echo "<script>alert('Produk berhsil dihapus');</script>";
	header('Location:index.php?halaman=produk');
?>