<?php
	session_start();
	// ketika membuat file ini maka data direktory detail yang ada di variabel session di hapus untuk menampilkan lagi fitur searching / pencarian
	include 'layouts/hapus-path-detail.php';
	include 'admin/config/koneksi.php';
	// echo "<pre>";
	// print_r($_SESSION);
	// echo "</pre>";

	// Untuk mengatasi bila keranjang belanja kosong atau tidak ada yang mengklik beli diarahkan ke halaman beli karan ngapai liat keranjang kosong :D
	// jika keranjang kosong atau tidak ada keranjang maka :
	if(empty($_SESSION['keranjang']) || !$_SESSION['keranjang']) :
		echo "<script>alert('Data keranjang kosong, Mohon untuk beli dulu :) ');</script>";
		echo "<script>location='index.php';</script>";
	endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Keranjang</title>
	<?php include 'layouts/css.php'; ?>
</head>
<body>

	<!-- navbar -->
	<?php include 'layouts/navbar.php'; ?>
	<!-- akhir navbar -->

	<!-- data produk yang masuk keranjang -->
	<section id="konten" class="konten">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama produk</th>
								<th>Foto produk</th>
								<th>Harga produk</th>
								<th>Jumalah</th>
								<th>Subharga</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1; ?>
							<?php foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) : ?>
							<?php
								$perproduk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk' ");
								$produk = mysqli_fetch_assoc($perproduk);
								$subharga = $produk['harga_produk'] * $jumlah;
							?>
							<tr>
								<td><?= $no++; ?> .</td>
								<td><?= $produk['nama_produk']; ?></td>
								<td>
									<img src="foto_produk/<?= $produk['foto_produk']; ?>" alt="FOTO PRODUK" width="100" class="img-thumbnail">
								</td>
								<td>Rp. <?= number_format($produk['harga_produk']); ?> ,-</td>
								<td><?= $jumlah; ?></td>
								<td>Rp. <?= number_format($subharga); ?> ,-</td>
								<td>
									<a href="hapus_keranjang.php?id_produk=<?= $produk['id_produk'];?> " class="btn btn-danger">Hapus</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<a href="index.php" class="btn btn-default">Lanjutkan belanja</a>
					<a href="checkout.php" class="btn btn-primary">Checkout</a>
				</div>
			</div>
		</div>
	</section>
	<!-- akhir data produk yang masuk keranjang -->

	<!-- Footer -->
	<?php include 'layouts/footer.php' ?>
	<!-- JavaScript -->
	<?php include 'layouts/js.php'; ?>
</body>
</html>