<?php
	session_start();
	// ketika membuat halaman detail maka buat direktory penyimpanan file detail untuk menhilangkan fitur pencarian di bagian navbar
	$_SESSION['detail'] = __DIR__ . '/detail.php';
	include 'admin/config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Toko Online | CodeCrypt</title>
	<?php include 'layouts/css.php' ?>
</head>
<body>
	
	<!-- navbar -->
	<?php include 'layouts/navbar.php'; ?>
	<!-- akhir navbar -->

	<!-- konten -->
	<?php
		$id_produk = $_GET['id_produk'];
		$data_produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk' ");
		$produk = mysqli_fetch_assoc($data_produk);
	?>
	<section id="konten" class="konten">
		<div class="container">
			<h1>Detail Produk Terbaru</h1>
			
			<div class="row">
				<div class="col-md-6">
					<img src="foto_produk/<?= $produk['foto_produk']; ?>" alt="Foto Produk" class="img-thumbnail img-responsive">
				</div>
				<div class="col-md-6">
					<h3>Nama produk : <?= $produk['nama_produk']; ?></h3>
					<h4>Harga produk : Rp. <?= number_format($produk['harga_produk']); ?> ,-</h4>
					<span><strong>Stok produk : <?= $produk['stok_produk']; ?></strong></span>
					<form method="POST">
						<label for="jumlah">Masukan jumlah belanja produk <b><?= $produk['nama_produk']; ?></b> :</label>
						<div class="form-group">
							<div class="input-group">
								<input type="number" min="1" max="<?= $produk['stok_produk']; ?>" class="form-control" name="jumlah" required>
								<div class="input-group-btn">
									<button type="submit" class="btn btn-primary" name="beli">Beli</button>
								</div>
							</div>
						</div>
					</form>
					<span>Deskripsi produk : <?= $produk['deskripsi_produk']; ?></span>
					<?php
						if(isset($_POST['beli'])) :
							// mendapatkan jumlah yang diinputkan
							$jumlah = $_POST['jumlah'];
							// masukan ke keranjang belanja
							if(!isset($_SESSION['keranjang'][$id_produk])) :
								$_SESSION['keranjang'][$id_produk] = $jumlah;
							else :
								$_SESSION['keranjang'][$id_produk] += $jumlah;
							endif;
							echo "<script>alert('Barang sudah dibeli');</script>";
							echo "<script>location='keranjang.php';</script>";
						endif;	
					?>
				</div>
			</div>
		

		</div>
	</section>
	<!-- akhir konten -->

	<!-- Footer -->
	<?php include 'layouts/footer.php' ?>
	<!-- JavaScript -->
	<?php include 'layouts/js.php'; ?>
</body>
</html>