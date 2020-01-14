<?php
	include 'config/koneksi.php';
	$id_produk = $_GET['id_produk'];
	$data_produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
	$item = mysqli_fetch_assoc($data_produk);
	// var_dump($item['foto_produk']);die();
	// echo "<pre>";
	// print_r ($item);
	// echo "</pre>";
?>
<h2>Ubah Produk <b><?= $item['nama_produk']; ?></b></h2>
<form method="POST" enctype="multipart/form-data">
	<div class="form-group">
		<label for="nama">Nama Produk</label>
		<input type="text" class="form-control" name="nama" value="<?= $item['nama_produk']; ?>">
	</div>
	<div class="form-group">
		<label for="harga">Harga Produk (Rp.)</label>
		<input type="number" class="form-control" name="harga" value="<?= $item['harga_produk']; ?>">
	</div>
	<div class="form-group">
		<label for="berat">Berat Produk (Gr)</label>
		<input type="number" class="form-control" name="berat" value="<?= $item['berat_produk']; ?>">
	</div>
	<div class="form-group">
		<label for="stok">stok Produk</label>
		<input type="number" class="form-control" name="stok" value="<?= $item['stok_produk']; ?>">
	</div>
	<div class="form-group">
		<label for="deskripsi">Deskripsi Produk</label>
		<textarea class="form-control" class="form-control" name="deskripsi" rows="10"><?= $item['deskripsi_produk']; ?></textarea>
	</div>
	<img src="../foto_produk/<?= $item['foto_produk']; ?>" class="img-thumbnail" width="300">
	<div class="form-group">
		<label for="foto">Foto Produk</label>
		<input type="file" class="form-control" name="foto">
	</div>
	<input type="hidden" name="id_produk" value="<?= $item['id_produk']; ?>">
	<button class="btn btn-success" name="ubah_produk">Ubah Produk</button>
	<?php include 'layouts/kembali_pada_produk.php'; ?>
</form>
<?php
	// ubah produk
	if(isset($_POST['ubah_produk'])) :
		$nama_produk = $_POST['nama'];
		$harga_produk = $_POST['harga'];
		$berat_produk = $_POST['berat'];
		$stok_produk = $_POST['stok'];
		$deskripsi_produk = $_POST['deskripsi'];
		$foto_produk_lama = $_POST['foto_produk_lama'];
		$foto_produk_baru = $_FILES['foto']['name'];
		$tmp_name = $_FILES['foto']['tmp_name'];
		// jika tidak kosong lokasi input file foto / jika input dimasukan / foto dirubah
		if(!empty($tmp_name)) :
			// hapus foto yang ada di folder
			if(file_exists('../foto_produk/'.$item['foto_produk'])) :
				unlink('../foto_produk/'.$item['foto_produk']);
			endif;
			// upload foto
			$path_baru = '../foto_produk/'.$foto_produk_baru;
			$upload_foto_baru = move_uploaded_file($tmp_name, $path_baru);

			if($upload_foto_baru) :
				$update_produk = mysqli_query($koneksi, "UPDATE produk SET nama_produk = '$nama_produk', harga_produk = '$harga_produk', berat_produk = '$berat_produk', foto_produk = '$foto_produk_baru', deskripsi_produk = '$deskripsi_produk', stok_produk = '$stok_produk' WHERE id_produk = '$id_produk'");
				echo "<script>alert('produk berhasil di ubah TERMASUK FOTO PRODUK');</script>";
				include 'layouts/kembali_pada_produk.php';
			endif;
		else :
			$update_produk = mysqli_query($koneksi, "UPDATE produk SET nama_produk = '$nama_produk', harga_produk = '$harga_produk', berat_produk = '$berat_produk', deskripsi_produk = '$deskripsi_produk', stok_produk = '$stok_produk' WHERE id_produk = '$id_produk'");
				echo "<script>alert('produk berhasil di ubah KECUALI FOTO PRODUK');</script>";
				include 'layouts/kembali_pada_produk.php';
		endif;
		echo "<script>location='index.php?halaman=produk';</script>";
	endif;
?>