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
</head>
<body>
	
	<!-- navbar -->
	<?php include 'layouts/navbar.php'; ?>
	<!-- akhir navbar -->

	<!-- konten -->
	<section id="konten" class="konten">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"	>Daftar Pelanggan</h3>
						</div>
						<div class="panel-body">
							<form method="POST" enctype="multipart/form-data">
								<div class="form-group">
									<label for="nama">Nama pelanggan</label>
									<input type="text" name="nama_pelanggan" class="form-control" required>
								</div>
								<div class="form-group">
									<label for="email">Email pelanggan</label>
									<input type="email" name="email_pelanggan" class="form-control" required>
								</div>
								<div class="form-group">
									<label for="password">Password pelanggan</label>
									<input type="password" name="password_pelanggan" class="form-control" required>
								</div>
								<div class="form-group">
									<label for="telepon">Telepon pelanggan</label>
									<input type="number" name="telepon_pelanggan" class="form-control" required>
								<div class="form-group">
									<label for="alamat_pelanggan">Alamat pelanggan</label>
									<textarea name="alamat_pelanggan" class="form-control" id="alamat_pelanggan" rows="10" required></textarea>
								</div>
								</div>
								<div class="form-group">
									<label for="foto_pelanggan">Foto pelanggan</label>
									<input type="file" name="foto_pelanggan" class="form-control" required>
								</div>
								<button type="submit" name="daftar_pelanggan" class="btn btn-primary">Daftar</button>
								<!-- <a href="login.php">Sudah daftar ? Silahkan login.</a> -->
							</form>
							<?php
								// logic daftar , hanya memasukan data inputan ke database pelanggan
								if(isset($_POST['daftar_pelanggan'])) :
									$nama_pelanggan = $_POST['nama_pelanggan'];
									$email_pelanggan = $_POST['email_pelanggan'];
									$password_pelanggan = $_POST['password_pelanggan'];
									$telepon_pelanggan = $_POST['telepon_pelanggan'];
									$alamat_pelanggan = $_POST['alamat_pelanggan'];

									// cek apakah email sudah ada atau belum didatabase
									$data_pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE email_pelanggan = '$email_pelanggan' ");
									$ada_satu = mysqli_num_rows($data_pelanggan);

									if($ada_satu == 1) : // bila cocok data yang diinputkan ada dalam database
										echo "<script>alert('Email sudah digunakan,Mohon gunakan email yang belum pernah didapftarkan');</script>";
										echo "<script>location='daftar.php';</script>";
									else :
										// proese upload foto pelanggan
										$nama_foto_pelanggan = date("Y-m-d-Has").'_'.$_FILES['foto_pelanggan']['name'];
										$tmp_name_foto_pelanggan = $_FILES['foto_pelanggan']['tmp_name'];
										$path_foto_pelanggan = 'foto_pelanggan/'.$nama_foto_pelanggan;
										$upload_foto_pelanggan = move_uploaded_file($tmp_name_foto_pelanggan, $path_foto_pelanggan);
										// tambahkan semua data
										$insert_data_daftar_pelanggan = mysqli_query($koneksi, "INSERT INTO pelanggan (email_pelanggan,password_pelanggan,nama_pelanggan,telepon_pelanggan,alamat_pelanggan,foto_pelanggan) VALUES ('$email_pelanggan', '$password_pelanggan', '$nama_pelanggan', '$telepon_pelanggan', '$alamat_pelanggan','$nama_foto_pelanggan') ");
										if($insert_data_daftar_pelanggan) :
											echo "<script>alert('Daftar berhasil, Silahkan login :) ');</script>";
											echo "<script>location='login.php';</script>";
										endif;
									endif;
								endif;	
							?>
						</div>
					</div>
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