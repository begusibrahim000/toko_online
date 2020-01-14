<?php
session_start();
// ketika membuat file ini maka data direktory detail yang ada di variabel session di hapus untuk menampilkan lagi fitur searching / pencarian
include 'layouts/hapus-path-detail.php';
include 'admin/config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Toko Online | CodeCrypt</title>
	<?php include 'layouts/css.php' ?>
	<style>
		.panel ul li:hover {
			background-color : #f5f5f5;
			border-radius: 5px;
		}
	</style>
</head>
<body>

	<!-- navbar -->
	<?php include 'layouts/navbar.php'; ?>
	<!-- akhir navbar -->

	<!-- konten -->
	<section id="konten" class="konten">
		<div class="container">
			<?php
				include 'admin/config/koneksi.php';
				$id_pembelian = $_GET['id_pembelian'];
				$data_pembelian = mysqli_query($koneksi, "SELECT * FROM pembelian INNER JOIN pelanggan ON pembelian.id_pelanggan = pelanggan.id_pelanggan WHERE pembelian.id_pembelian = '$id_pembelian' ");
				$pecah_data_pembelian = mysqli_fetch_assoc($data_pembelian);
				$id_ongkir = $pecah_data_pembelian['id_ongkir'];
				$data_ongkir = mysqli_query($koneksi, "SELECT * FROM ongkir WHERE id_ongkir = $id_ongkir ");
				$tarif_ongkir = mysqli_fetch_assoc($data_ongkir);
				// echo "<pre>";
				// print_r($pecah_data_pembelian);
				// print_r($_SESSION['pelanggan']);
				// print_r($tarif_ongkir);
				// echo "</pre>";
				// PROTEKSI
				// jika pelanggan yang beli atau yang melihat nota tidak sama dengan yang login maka di larikan ke riwayat.php karena dia tidak berhak melihat nota orang lain
				if($pecah_data_pembelian['id_pelanggan'] !== $_SESSION['pelanggan']['id_pelanggan']) :
					echo "<script>alert('Anda jangan nakal :D, Lihat nota sendiri OCKEY');</script>";
					echo "<script>location='riwayat_belanja.php';</script>";
					exit();
				endif;
			?>
			<h2>NOTA</h2>
			<div class="row">
				<div class="col-md-12">
							
					<!-- identias pembelian -->
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="col-md-4">
								<h3>Pembelian</h3>
								<strong>ID pembelian : <?= $pecah_data_pembelian['id_pembelian']; ?></strong> <br>
								<span>Tanggal : <?= $pecah_data_pembelian['tanggal_pembelian']; ?></span> <br>
								<span>Total : <?= $pecah_data_pembelian['total_pembelian']; ?></span> <br>
								<span>Total : <?= $pecah_data_pembelian['status_pembelian']; ?></span>
							</div>
							<div class="col-md-4">
								<h3>Pelanggan</h3>
								<strong>Nama : <?= $pecah_data_pembelian['nama_pelanggan']; ?></strong> <br>
								<span>No : <?= $pecah_data_pembelian['telepon_pelanggan']; ?></span>
								<span>Email : <?= $pecah_data_pembelian['email_pelanggan']; ?></span>
							</div>
							<div class="col-md-4">
								<h3>Pengiriman</h3>
								<strong>Kota : <?= $tarif_ongkir['nama_kota']; ?></strong> <br>
								<span>Tarif ongkir : <?= $tarif_ongkir['tarif']; ?></span> <br>
								<span>Alamat : <?= $pecah_data_pembelian['alamat_pengiriman']; ?></span>
							</div>
						</div>
					</div>
					<!-- akhir identias pembelian -->

					<!-- Advanced Tables -->
					<div class="panel panel-default">
						<div class="panel-heading">
							Data produk yang di beli oleh <b><?= $pecah_data_pembelian['nama_pelanggan']; ?></b> pada tanggal <b><?= $pecah_data_pembelian['tanggal_pembelian']; ?></b>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr>
											<th class="text-center">No</th>
											<th class="text-center">Nama produk</th>
											<th class="text-center">Foto produk</th>
											<th class="text-center">berat produk</th>
											<th class="text-center">Subberat produk</th>
											<th class="text-center">Harga produk</th>
											<th class="text-center">Jumlah produk</th>
											<th class="text-center">Subtotal</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
											// sql coding awal :
											// $ambil_data_produk_pembelian = mysqli_query($koneksi, "SELECT * FROM pembelian_produk INNER JOIN produk ON pembelian_produk.id_produk = produk.id_produk WHERE pembelian_produk.id_pembelian = '$id_pembelian' ");
											// sql coding kedua untuk mengatasi nota tidak berbah dikala produk di DB di rubah
											$ambil_data_produk_pembelian = mysqli_query($koneksi, "SELECT * FROM pembelian_produk WHERE pembelian_produk.id_pembelian = '$id_pembelian' ");
											while($item = mysqli_fetch_assoc($ambil_data_produk_pembelian)) :
										?>
											<tr class="odd gradeX">
												<td class="text-center"><?= $no++; ?> .</td>
												<td class="text-center"><?= $item['nama_produk']; ?></td>
												<td class="text-center"><img src="foto_produk/<?= $item['foto_produk']; ?>" class="img-thumbnail" width="150"></td>
												<td class="text-center"><?= $item['berat_produk']; ?> Gr.</td>
												<td class="text-center"><?= $item['subberat_produk']; ?> Gr.</td>
												<td class="text-center">Rp. <?= number_format($item['harga_produk']); ?> ,-</td>
												<td class="text-center"><?= $item['jumlah']; ?></td>
												<td class="text-center">Rp. <?= number_format($item['harga_produk'] * $item['jumlah']); ?> ,-</td>
											</tr>
										<?php endwhile; ?>								
										<!-- tarif ongkir -->
									</tbody>
									<tfoot>
										<tr>
											<th colspan="7">Tarif Ongkir</th>
											<th class="text-center">Rp. <?= number_format($tarif_ongkir['tarif']); ?> ,-</th>	
										</tr>
										<tr>
										<th colspan="7">Kalkulasi :</th>	
											<th class="text-center">=</th>	
										</tr>
										<tr>
											<th colspan="7">Total Pembelian</th>
											<th class="text-center">Rp. <?= number_format($pecah_data_pembelian['total_pembelian']); ?> ,-</th>	
										</tr>
									</tfoot>
								</table>
							</div>

						</div>
					</div>
					<!--End Advanced Tables -->  
					<div class="alert alert-info text-center">
						<span>Silahkan melakukan pembayaran sebesar Rp.<?= number_format($pecah_data_pembelian['total_pembelian']); ?> ,-  ke :</span>
						<!-- <br> -->
						<strong>BANK BRI 110-000789-2340 AN. Begus Ibrahim</strong>
						<?php if($pecah_data_pembelian['status_pembelian'] == "pending") : ?>
							<a href="pembayaran.php?id_pembelian=<?= $id_pembelian; ?>" class="btn btn-success">Kirim pembayaran</a>
						<?php else : ?>
							<a href="lihat_pembayaran.php?id_pembelian=<?= $id_pembelian; ?>" class="btn btn-warning">Lihat pembayaran</a>
						<?php endif; ?>
					</div>
					<br>

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