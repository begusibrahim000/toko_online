<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Lupa Password | TOKO ONLINE</title>
	<?php include 'layouts/css.php' ?>
</head>
<body>

	
	<!-- Lupa password -->
	<div class="container">
		<!-- Title -->
		<div class="row text-center">
			<div class="col-md-12">
				<h2>Lupa Password</h2>
			</div>
		</div>

		<!-- Form lupa password  -->
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1">
				<div class="panel-default">
					<div class="panel-heading">
						<div class="panel-title">Lupa Password</div>
					</div>
					<div class="panel-body">
						<form method="POST">
							<div class="form-group">
								<label for="email_admin">Email Admin</label>
								<input type="email" name="email_admin" id="email_admin" class="form-control">
							</div>
							<div class="form-group">
								<label for="password_baru">Password Baru</label>
								<input type="password" name="password_baru" id="password_baru" class="form-control">
							</div>
							<div class="form-group">
								<label for="konfirmasi_password_baru">Konfirmasi Password Baru</label>
								<input type="password" name="konfirmasi_password_baru" id="konfirmasi_password_baru" class="form-control">
							</div>
							<button type="submit" name="ganti_password" class="btn btn-success">Ganti Password</button>
							<a href="login.php" class="btn btn-warning">Kembali ke login / Cansel</a>
						</form>
						<?php
							include 'config/koneksi.php';
							// logic lupa password
							if(isset($_POST['ganti_password'])) :
								// ambil email dan cek apakah ada didalam database
								$email_admin = $_POST['email_admin'];
								$email_admin_database = mysqli_query($koneksi, "SELECT * FROM admin WHERE email_admin = '$email_admin' ");
								$cek_email_admin = mysqli_num_rows($email_admin_database);
								if($cek_email_admin == 1) :
									$password_baru = $_POST['password_baru'];
									$konfirmasi_password_baru = $_POST['konfirmasi_password_baru'];
									if($password_baru !== $konfirmasi_password_baru) :
										echo "<script>
												alert('Password Tidak Sama');
												windows.location.href = 'lupa_password.php';
											</script>";
									else :
										$update_password = mysqli_query($koneksi, "UPDATE admin SET password_admin = '$password_baru' WHERE email_admin = '$email_admin' ");
										echo "<script>
											alert('Password berhasil di UBAH');
											location = 'login.php';
											</script>";
									endif;
								else :
									echo "<script>	
										alert('Email TIDAK ADA');
										location = 'lupa_password.php';
										</script>";
								endif;
							endif;

						?>	
					</div>
				</div>
			</div>
		</div>


	</div>
	<!-- Akhir lupa password -->

	<?php include '../layouts/footer.php' ?>
	<?php include 'layouts/js.php' ?>
</body>
</html>
