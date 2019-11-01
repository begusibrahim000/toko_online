<?php 
	
	$hostname = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'toko_online';

	$koneksi = new mysqli($hostname,$username,$password,$database);

	if(!$koneksi){
		echo "<script>alert('Koneksi Gagal');</script>";
	}