<?php
	session_start();
	// ketika membuat file ini maka data direktory detail yang ada di variabel session di hapus untuk menampilkan lagi fitur searching / pencarian
	include 'layouts/hapus-path-detail.php';
	include 'admin/config/koneksi.php';
	// data pembayaran
	$id_pembelian = $_GET['id_pembelian'];
	// Untuk mendapatkan data kompleks dengan pembelian untuk VALIDASI url ID dengan field "id_pelanggan"
	$data_pembayaran = mysqli_query($koneksi, "SELECT * FROM pembayaran LEFT JOIN pembelian ON pembayaran.id_pembelian = pembelian.id_pembelian WHERE pembelian.id_pembelian = '$id_pembelian' ");
	$hasil_akhir_pembayaran = mysqli_fetch_assoc($data_pembayaran);

	// echo "<pre>";
	// print_r($hasil_akhir_pembayaran);
	// print_r($_SESSION);
	// echo "</pre>";

	// VALIDASI / PROTEKSI / SECURITY / KEAMANAN

	// Mengamankan user yang masuk pembelian yang belum di bayar (belum ada data pembayaran)
	if(empty($hasil_akhir_pembayaran)) :
		echo "<script>alert('Belum ada data pembayaran');</script>";
		echo "<script>location='riwayat_belanja.php';</script>";
		exit();
	endif;

	// Mengamankan user lain tidak bisa melihat data pembayaran orang lain atau orang yang login dan sudah membayar
	if($hasil_akhir_pembayaran['id_pelanggan'] !== $_SESSION['pelanggan']['id_pelanggan']) :
		echo "<script>alert('Anda tidak berhak dan Jangan nakal');</script>";
		echo "<script>location='riwayat_belanja.php';</script>";
		exit();
	endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Lihat Pembayaran | MyJobs</title>
	<?php include 'layouts/css.php'; ?>
</head>
<body>

	<!-- menu -->
	<?php include 'layouts/navbar.php' ?>
	<!-- akhir menu -->
	
	<!-- Lihat pembayaran -->
	<section id="lihat_pembayaran" class="lihat_pembayaran">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<table class="table table-bordered">
						<p><a href="riwayat_belanja.php" class="btn btn-info">Kembali ke riwayat belanja</a></p>
						<tr>
							<th>ID Pembelian :</th>
							<td><?= $hasil_akhir_pembayaran['id_pembelian']; ?></td>
						</tr>
						<tr>
							<th>Nama Pengirim :</th>
							<td><?= $hasil_akhir_pembayaran['nama_pengirim']; ?></td>
						</tr>
						<tr>
							<th>Nama Bank :</th>
							<td><?= $hasil_akhir_pembayaran['nama_bank']; ?></td>
						</tr>
						<tr>
							<th>Jumlah Pembayaran : </th>
							<td>Rp. <?= $hasil_akhir_pembayaran['jumlah_pembayaran']; ?></td>
						</tr>
						<tr>
							<th>Tanggal Pembayaran :</th>
							<td><?= $hasil_akhir_pembayaran['tanggal_pembayaran']; ?></td>
						</tr>
					</table>
				</div>
				<div class="col-md-6">
					<img src="bukti_pembayaran/<?= $hasil_akhir_pembayaran['bukti_pembayaran']; ?>" class="img-responsive img-thumbnail" alt="Bukti Pembayaran">
				</div>
			</div>
		</div>
	</section>
	<!-- Akrhi Lihat pembayaran -->
	
	<!-- Footer -->
	<?php include 'layouts/footer.php' ?>
	<!-- JavaScript -->
	<?php include 'layouts/js.php'; ?>
</body>
</html>