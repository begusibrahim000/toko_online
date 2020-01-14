<?php
	session_start();
	// ketika membuat file ini maka data direktory detail yang ada di variabel session di hapus untuk menampilkan lagi fitur searching / pencarian
	include 'layouts/hapus-path-detail.php';
	include 'admin/config/koneksi.php';

	if(!isset($_SESSION['pelanggan'])) :
		echo "<script>alert('MAAF,anda harus login dulu :) ');</script>";
		echo "<script>location='login.php';</script>";
		exit();
	endif;

	if(empty($_SESSION['keranjang'])) :
		// echo "<pre>";
		// print_r ("Belum ada produk yang dibeli");
		// echo "</pre>";
		echo "<script>alert('Anda harus belanja dulu kalau mau CHECKOUT :) ');</script>";
		echo "<script>location='index.php';</script>";
	endif;

	// echo "<pre>";
	// print_r($_SESSION['pelanggan']);
	// echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Toko Online | CodeCrypt</title>
	 <?php include 'layouts/css.php'; ?>
</head>
<body>
	
	<!-- navbar -->
	<?php include 'layouts/navbar.php'; ?>
	<!-- akhir navbar -->

	<!-- konten -->
	<!-- data produk yang masuk keranjang -->
	<section id="konten" class="konten">
		<div class="container">
			<h1>Checkout</h1>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama produk</th>
								<th>Foto produk</th>
								<th>Harga produk</th>
								<th>Jumlah</th>
								<th>Subharga</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$no = 1; 
								$totalharga = 0;
							?>
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
							</tr>
							<?php $akhir_harga = $totalharga += $subharga; ?>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="5">Total akhir belanja</th>
								<th>Rp. <?= number_format($akhir_harga); ?> ,-</th>
							</tr>
						</tfoot>
					</table>
				</div>
				<!-- Checkout -->
				<form method="POST">
					<div class="row">
						<div class="col-md-4">
							<label for="nama_pelanggan">Nama Pelanggan</label>
							<input type="text" readonly id="nama_pelanggan" value="<?= $_SESSION['pelanggan']['nama_pelanggan']; ?>" class="form-control">
						</div>
						<div class="col-md-4">
							<label for="telepon_pelanggan">No Telepon Pelanggan</label>
							<input type="text" readonly id="telepon_pelanggan" value="<?= $_SESSION['pelanggan']['telepon_pelanggan']; ?>" class="form-control">
						</div>
						<div class="col-md-4">
							<label for="id_ongkir">Metode Ongkos Kirim</label>
							<select name="id_ongkir" id="id_ongkir" class="form-control" required>
								<option value="">Pilih Ongkir</option>
								<?php 
									$data_ongkir = mysqli_query($koneksi, "SELECT * FROM ongkir");
									while($ongkir = mysqli_fetch_assoc($data_ongkir)) :
								?>
									<option value="<?= $ongkir['id_ongkir'] ?>">
										<?= $ongkir['nama_kota'] ?> - Rp. <?= number_format($ongkir['tarif']); ?> ,-
									</option>
								<?php endwhile; ?>
							</select>
						</div>
						<div class="col-md-12">
							<label for="alamat_pengiriman">Alamat Pengiriman</label>
							<textarea name="alamat_pengiriman" id="alamat_pengiriman" class="form-control" rows="5" placeholder="Contoh : Jl jatipamor no 100, rumah no 100 ATAU alamat lengkap"></textarea>
						</div>
					</div>
					<br>
					<button type="submit" class="btn btn-primary" name="checkout" onclick="return confirm('Anda yakin mau CHECKOUT sekarang ? :) ');">Checkout</button>
				</form>
				<!-- logic checkout -->
				<?php
					if(isset($_POST['checkout'])) :				
						// mendapatkan data untuk table pembelian
						$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];
						$id_ongkir = $_POST['id_ongkir'];
						$tanggal_pembelian = date("Y-m-d");
						$alamat_pengiriman = $_POST['alamat_pengiriman'];

						$pertarif = mysqli_query($koneksi, "SELECT * FROM ongkir WHERE id_ongkir = '$id_ongkir' ");
						$data_tarif = mysqli_fetch_assoc($pertarif);
						$tarif = $data_tarif['tarif'];
						
						$total_pembelian = $akhir_harga + $tarif;

						// Menambahkan data ke table pelanggan
						$tambah_data_pembelian_baru = mysqli_query($koneksi, "INSERT INTO pembelian (id_pelanggan, id_ongkir, tanggal_pembelian, total_pembelian,alamat_pengiriman) VALUES ('$id_pelanggan', '$id_ongkir', '$tanggal_pembelian', '$total_pembelian', '$alamat_pengiriman') ");

						$id_pembelian_barusan = $koneksi->insert_id; // mendapatkan id_pembelian yang barusan terjadi
						
						// Menambhkan data ke table pembelian produk
						foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) :
							// mendapatkan data produk sesuai id_produk / copy data produk agar ketika checout nota tidak akan berubah meskipun data produk seperti harga_produk berubah naik tinggi atau turun
							$data_produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk' ");
							$pecah_data_produk = mysqli_fetch_assoc($data_produk);
							$nama_produk = $pecah_data_produk['nama_produk'];
							$harga_produk = $pecah_data_produk['harga_produk'];
							$berat_produk = $pecah_data_produk['berat_produk'];
							$foto_produk = $pecah_data_produk['foto_produk'];
							$subharga_produk = $pecah_data_produk['harga_produk'] * $jumlah;
							$subberat_produk = $pecah_data_produk['berat_produk'] * $jumlah;

							$tambah_data_pembelian_produk_baru = mysqli_query($koneksi, "INSERT INTO pembelian_produk (id_pembelian, id_produk, jumlah, nama_produk, harga_produk, berat_produk, foto_produk, subharga_produk, subberat_produk) VALUES ('$id_pembelian_barusan', '$id_produk', '$jumlah', '$nama_produk', '$harga_produk', '$berat_produk', '$foto_produk', '$subharga_produk', '$subberat_produk') ");

							// update stok produk menjadi berkurang
							mysqli_query($koneksi, "UPDATE produk SET stok_produk=stok_produk - $jumlah WHERE id_produk = '$id_produk' ");

						endforeach;

						// Mengkosongkan keranjang setelah update database
						unset($_SESSION['keranjang']);

						echo "<script>alert('Proses belanja berhasil');</script>";
						echo "<script>location='nota.php?id_pembelian=$id_pembelian_barusan';</script>";
					endif;	
				?>
			</div>
		</div>
	</section>
	<!-- akhir data produk yang masuk keranjang -->
	<!-- akhir konten -->

	<!-- Footer -->
	<?php include 'layouts/footer.php' ?>
	<!-- JavaScript -->
	<?php include 'layouts/js.php'; ?>
</body>
</html>