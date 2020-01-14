<?php
	include_once 'config/koneksi.php';
	$id_pelanggan = $_GET['id_pelanggan'];
	$data_pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'");
	$item = mysqli_fetch_assoc($data_pelanggan);
	// echo "<pre>";
	// print_r($item);
	// echo "</pre>";
?>
<h2>Ubah data pelanggan</h2>
<form method="POST">
	<div class="form-group">
		<label for="nama">Nama pelanggan</label>
		<input type="text" name="nama_pelanggan" id="nama" class="form-control" value="<?= $item['nama_pelanggan']; ?>">
	</div>
	<div class="form-group">
		<label for="telepon">Telepon pelanggan</label>
		<input type="number" name="telepon_pelanggan" id="telepon" class="form-control" value="<?= $item['telepon_pelanggan']; ?>">
	</div>
	<div class="form-group">
		<label for="email">Email pelanggan</label>
		<input type="email" name="email_pelanggan" id="email" class="form-control" value="<?= $item['email_pelanggan']; ?>">
	</div>
	<div class="form-group">
		<label for="password">Password pelanggan</label>
		<input type="password" name="password_pelanggan" id="password" class="form-control" value="<?= $item['password_pelanggan']; ?>">
	</div>
	<div class="form-group">
		<label for="konfirmasi_password">Konfirmasi password pelanggan</label>
		<input type="password" name="konfirmasi_password_pelanggan" id="konfirmasi_password" class="form-control" value="<?= $item['password_pelanggan']; ?>">
	</div>
	<button type="submit" name="ubah_pelanggan" class="btn btn-success">Ubah data</button>
	<?php include 'layouts/kembali_pada_pelanggan.php'; ?>
</form>
<?php
	// logic edit data pelanggan
	if(isset($_POST['ubah_pelanggan'])) :
		$nama_pelanggan = $_POST['nama_pelanggan'];
		$telepon_pelanggan = $_POST['telepon_pelanggan'];
		$email_pelanggan = $_POST['email_pelanggan'];
		$password_pelanggan = $_POST['password_pelanggan'];
		$konfirmasi_password_pelanggan = $_POST['konfirmasi_password_pelanggan'];
		// CARA KESATU -> bila input konfirmasi_password_pelanggan diisikan valuenya
		if($password_pelanggan == $konfirmasi_password_pelanggan) :
			$ubah_pelanggan = mysqli_query($koneksi, "UPDATE pelanggan SET email_pelanggan = '$email_pelanggan', password_pelanggan = '$password_pelanggan', nama_pelanggan = '$nama_pelanggan', telepon_pelanggan = '$telepon_pelanggan' ");
				echo "<script>alert('Data pelanggan berhasil di ubah TERMASUK PASSWORD');</script>";
				echo "<script>location='index.php?halaman=pelanggan';</script>";
		else :
				echo "<script>alert('Password tidak sama,ULANGI KEMBALI');</script>";
		endif;

		// CARA KEDUA -> bila input konfirmasi_password_pelanggan dikosongkan valuenya
		// jika password yang diinputkan dengan password di database tidak sama / inputan di rubah
		// if($password_pelanggan != $item['password_pelanggan']) :
		// 	if($password_pelanggan == $konfirmasi_password_pelanggan) :
		// 		$ubah_pelanggan = mysqli_query($koneksi, "UPDATE pelanggan SET email_pelanggan = '$email_pelanggan', password_pelanggan = '$password_pelanggan', nama_pelanggan = '$nama_pelanggan', telepon_pelanggan = '$telepon_pelanggan' ");
		// 			echo "<script>alert('Data pelanggan berhasil di ubah TERMASUK PASSWORD');</script>";
		// 			echo "<script>location='index.php?halaman=pelanggan';</script>";
		// 	else :
		// 			echo "<script>alert('Password tidak sama,ULANGI KEMBALI');</script>";
		// 	endif;
		// else :
		// 	$ubah_pelanggan = mysqli_query($koneksi, "UPDATE pelanggan SET email_pelanggan = '$email_pelanggan', nama_pelanggan = '$nama_pelanggan', telepon_pelanggan = '$telepon_pelanggan' ");
		// 			echo "<script>alert('Data pelanggan berhasil di ubah KECUALI PASSWORD');</script>";
		// 			echo "<script>location='index.php?halaman=pelanggan';</script>";
		// endif;

	endif;
?>