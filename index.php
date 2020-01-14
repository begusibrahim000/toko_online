<?php
	session_start();
	// ketika membuat file ini maka data direktory detail yang ada di variabel session di hapus untuk menampilkan lagi fitur searching / pencarian
	include 'layouts/hapus-path-detail.php';
	include 'admin/config/koneksi.php';

	// keamanan agar tida ada yang bisa masuk kalau belum login
	// if(!isset($_SESSION['login_pelanggan'])) :
	// 	echo "<script>location='login.php';</script>";
	// 	header('Locatin:login.php');
	// 	exit;
	// endif;
	
	if(isset($_SESSION['pelanggan'])) :
		$_SESSION['pelanggan'];
	endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Toko Online | BEGUS IBRAHIM</title>
	<style>
		.loader {
			width: 100px;
			z-index: -1;
			display : none;
		}
	</style>
	<?php include 'layouts/css.php' ?>
</head>
<body>
	
	<!-- navbar -->
	<?php include 'layouts/navbar.php'; ?>
	<!-- akhir navbar -->

	<!-- konten -->
	
	<section id="konten" class="konten">
		<div class="container">

			<div class="row">
				<div class="col-md-12">
					<h1>
						Produk Terbaru
						<img src="admin/assets/img/loader.gif" class="loader">
					</h1>					
				</div>
			</div>

			<div class="row">
				<div id="live-search">
					<?php $data_produk = mysqli_query($koneksi, "SELECT * FROM produk"); ?>
					<?php while($produk = mysqli_fetch_assoc($data_produk)) : ?>
						<div class="col-md-3">
							<div class="thumbnail">
								<img src="foto_produk/<?= $produk['foto_produk']; ?>" class="img-responsive" alt="Produk">
								<div class="caption">
									<h3><?= $produk['nama_produk']; ?></h3>
									<h5>Rp. <?= number_format($produk['harga_produk']); ?> ,-</h5>
									<span><strong>Stok produk : <?= $produk['stok_produk']; ?></strong></span><br>
									<!-- <i class=" fa fa-refresh "></i> -->
									<a href="beli.php?id_produk=<?= $produk['id_produk']; ?>" class="btn btn-primary">Beli</a>
									<a href="detail.php?id_produk=<?= $produk['id_produk']; ?>" class="btn btn-default">Detail / Custom jumlah</a>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			</div>

		</div>
	</section>
	<!-- akhir konten -->

	<!-- Footer -->
	<?php include 'layouts/footer.php' ?>
	<!-- JavaScript -->
	<?php include 'layouts/js.php'; ?>
	<script src="layouts/js/ajax.js"></script>
</body>
</html>