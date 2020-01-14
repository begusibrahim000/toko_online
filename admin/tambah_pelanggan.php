<h2>Tambah akun pelanggan</h2>
<form method="POST">
	<div class="form-group">
		<label for="nama">Nama pelanggan</label>
		<input type="text" name="nama_pelanggan" id="nama" class="form-control">
	</div>
	<div class="form-group">
		<label for="telepon">Telepon pelanggan</label>
		<input type="number" name="telepon_pelanggan" id="telepon" class="form-control">
	</div>
	<div class="form-group">
		<label for="email">Email pelanggan</label>
		<input type="email" name="email_pelanggan" id="email" class="form-control">
	</div>
	<div class="form-group">
		<label for="password">Password pelanggan</label>
		<input type="password" name="password_pelanggan" id="password" class="form-control">
	</div>
	<div class="form-group">
		<label for="konfirmasi_password">Konfirmasi password pelanggan</label>
		<input type="password" name="konfirmasi_password_pelanggan" id="konfirmasi_password" class="form-control">
	</div>
	<button type="submit" name="tambah_pelanggan" class="btn btn-primary">Tambakan</button>
	<?php include 'layouts/kembali_pada_pelanggan.php'; ?>
</form>
<?php
	
	if(isset($_POST['tambah_pelanggan'])) :
		$nama_pelanggan = $_POST['nama_pelanggan'];
		$telepon_pelanggan = $_POST['telepon_pelanggan'];
		$email_pelanggan = $_POST['email_pelanggan'];
		$password_pelanggan = $_POST['password_pelanggan'];
		$konfirmasi_password_pelanggan = $_POST['konfirmasi_password_pelanggan'];
		if($password_pelanggan == $konfirmasi_password_pelanggan) :
			$tambah_pelanggan = mysqli_query($koneksi, "INSERT INTO pelanggan (email_pelanggan,password_pelanggan,nama_pelanggan,telepon_pelanggan) VALUES ('$email_pelanggan', '$password_pelanggan', '$nama_pelanggan', '$telepon_pelanggan');
				");
			echo "<script>alert('Data berhasil ditambahkan :) ');</script>";
			echo "<script>location='index.php?halaman=pelanggan';</script>";
		else :
			echo "<script>alert('Password tidak sama,ULANG KEMBALI');</script>";
		endif;
	endif;

?>