<?php
	include 'admin/config/koneksi.php';
	$keyword = $_GET['keyword'];
	// proteksi jika inputan kosong tidak akan diproses script PHP pencarian produknya.
	if(empty($keyword)) :
		echo "<script>alert('Inputan kosong');</script>";
		echo "<script>location='index.php';</script>";
	endif;
	// script PHP pencarian produk berdasarkan nama_produk dan deskripsi_produk
	// ambil data dari database
	$pencarian = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%' OR deskripsi_produk LIKE '%$keyword%' ");
	// buat varibael bertipe array kosong
	$semua_data = array();
	// jika data ada yang tertangkap maka pecah menajdi array assosiatif dan varibael semua_data bertipe array diisikan data tersebut berulang sesuai data yang tertangkap
	while($data = mysqli_fetch_assoc($pencarian)) :
		$semua_data[] = $data;
	endwhile;

	// echo "<pre>";
	// print_r($semua_data);
	// echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pencarian | TOKO ONLINE</title>
	<?php include 'layouts/css.php' ?>
</head>
<body>

	<!-- navbar -->
	<?php include 'layouts/navbar.php' ?>
	<!-- akhir navbar -->

	<section id="pencarian" class="pencarian">
		<div class="container">		
			<h1>Hasil Pencarian produk <strong><?= $keyword; ?></strong></h1>
			<!-- Mengatasi jika produk tidak ditemukan di beri pesan -->
			<?php if(empty($semua_data)) : ?>
				<div class="alert alert-info">
					Pencarian produk <strong><?= $keyword; ?></strong> TIDAK DITEMUKAN.
				</div>
			<?php endif; ?>
			<div class="row">
			<!-- Perulangkan kembali data yang disimpan di $semua_data untuk ditampilkan -->
			<!-- karena $semua_data dibuat menggunakan key maka buat perulangan foreach yang lengkap berserta key -->
			<?php foreach($semua_data as $key => $value) : ?>
				<div class="col-md-3">
					<div class="thumbnail">
						<img src="foto_produk/<?= $value['foto_produk']; ?>" width="img-responsive" alt="Foto Produk Yang Di Cari">
						<div class="caption">
							<h3><?= $value['nama_produk']; ?></h3>
							<h5>Rp. <?= number_format($value['harga_produk']); ?></h5>
							<span><strong>Stok produk : <?= $value['stok_produk']; ?></strong></span> <br>
							<a href="beli.php?id_produk=<?= $value['id_produk']; ?>" class="btn btn-primary">Beli</a>
							<a href="detail.php?id_produk=<?= $value['id_produk']; ?>" class="btn btn-default">Detail / Custom jumlah</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>

			</div>
		</div>
	</section>

	
	<!-- Footer -->
	<?php include 'layouts/footer.php' ?>
	<!-- JavaScript -->
	<?php include 'layouts/js.php'; ?>
</body>
</html>