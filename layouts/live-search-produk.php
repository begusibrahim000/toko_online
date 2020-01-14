<?php

	sleep(1); // 1 detik
	// usleep(500000); // setengah detik
	include '../admin/config/koneksi.php';
	$keyword = $_GET['keyword'];
	$pencarian_data_produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%' OR deskripsi_produk LIKE '%$keyword%' ");
	$semua_data = array();
	// jika data ada yang tertangkap maka pecah menajdi array assosiatif dan varibael semua_data bertipe array diisikan data tersebut berulang sesuai data yang tertangkap
	while($data = mysqli_fetch_assoc($pencarian_data_produk)) :
		$semua_data[] = $data;
	endwhile;
?>
<!-- Mengatasi jika produk tidak ditemukan di beri pesan -->
<?php if(empty($semua_data)) : ?>
	<div class="alert alert-info">
		Pencarian produk <strong><?= $keyword; ?></strong> TIDAK DITEMUKAN.
	</div>
<?php endif; ?>
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