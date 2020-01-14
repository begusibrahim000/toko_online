<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Lupa Password | TOKO ONLINE</title>
	<?php include 'layouts/css.php'; ?>
</head>
<body>

	<div class="container">
		<div class="row text-center">
			<div class="col-md-8 col-md-offset-2">
				<h1><strong>Lupa password</strong></h1>
			</div>
		</div>

		<!-- form lupa password -->
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-md-sm-8-col-sm-offset-2 col-xs-10 col-xs-offset-1">
				<div class="panel-default">
					<div class="panel-heading">
						<div class="panel-title">
							Lupa Password Pelanggan
						</div>
					</div>
					<div class="panel-body">
						<form action="" method="POST">
							<div class="form-group">
								<label for="email_pelanggan">Email Pelanggan</label>
								<input type="email" name="email_pelanggan" class="form-control">
							</div>
							<div class="form-group">
								<label for="password_baru">Password Baru</label>
								<input type="password" name="password_baru" class="form-control">
							</div>
							<div class="form-group">
								<label for="konfirmasi_password_baru">Konfirmasi Password Baru</label>
								<input type="password" name="konfirmasi_password_baru" class="form-control">
							</div>
							<button type="submit" name="ganti_password_pelanggan" class="btn btn-primary">Ganti Password</button>
							<a href="login.php" class="btn btn-warning">Kembali ke login / Cancel</a>
						</form>
						<?php
							include 'admin/config/koneksi.php';

							if(isset($_POST['ganti_password_pelanggan'])) :
								$email_pelanggan_form = $_POST['email_pelanggan'];
								$password_baru = $_POST['password_baru'];
								$konfirmasi_password_baru = $_POST['konfirmasi_password_baru'];

								$email_pelanggan = mysqli_query($koneksi, "SELECT email_pelanggan FROM pelanggan WHERE email_pelanggan = '$email_pelanggan_form' ");
								$email_pelanggan_database = mysqli_fetch_assoc($email_pelanggan);

								if($email_pelanggan_form === $email_pelanggan_database['email_pelanggan']) :
									if($password_baru === $konfirmasi_password_baru) :
										$ganti_password = mysqli_query($koneksi, "UPDATE pelanggan SET password_pelanggan = '$password_baru' WHERE email_pelanggan = '$email_pelanggan_form' ");
										echo "<script>
												alert('Password berhasil di UBAH');
												location='login.php';
											</script>";
									endif;	
								else :
									echo "<script>
											alert('Email Tidak Ada,Masukan email yang BENAR');
										</script>";
								endif;
							endif;
						?>
					</div>
				</div>
			</div>
		</div>

	</div>
	
	<?php include 'layouts/footer.php'; ?>
	<?php include 'layouts/js.php'; ?>
</body>
</html>