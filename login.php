<?php
	session_start();
	// ketika membuat file ini maka data direktory detail yang ada di variabel session di hapus untuk menampilkan lagi fitur searching / pencarian
	include 'layouts/hapus-path-detail.php';
	include 'admin/config/koneksi.php';

	// fitur remember me untuk login pelanggan
	if(isset($_COOKIE['my']) && isset($_COOKIE['jobs'])) :
		$id_pelanggan = $_COOKIE['my'];
		$email_pelanggan_cookie = $_COOKIE['jobs'];

		$data_akun_pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan = '$id_pelanggan' ");
		$akun_pelanggan = mysqli_fetch_assoc($data_akun_pelanggan);
		$email_pelanggan_database = hash('md5', $akun_pelanggan['email_pelanggan']);
		// var_dump($email_pelanggan_cookie);
		// var_dump($email_pelanggan_database);die();

		if($email_pelanggan_cookie === $email_pelanggan_database) :
			$_SESSION['login_pelanggan'] = true;
			if(isset($_SESSION['login_pelanggan']) == true) :
				$_SESSION['pelanggan'] = $akun_pelanggan;
				echo "<script>location='index.php';</script>";
				exit;
			endif;
		endif;
	endif;

	if(isset($_SESSION['login_pelanggan'])) :
		echo "<script>location='index.php';</script>";
		exit;
	endif;
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
				<div class="col-md-4 col-md-offset-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Login Pelanggan</h3>
						</div>
						<div class="panel-body">
							<form method="POST">
								<div class="form-group">
									<label for="email">Email pelanggan</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-user"></i></span>
										<input type="email" name="email_pelanggan" class="form-control" required>
									</div>
								</div>
								<div class="form-group">
									<label for="password">Password pelanggan</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-lock"></i></span>	
										<input type="password" name="password_pelanggan" class="form-control" required>
									</div>
								</div>
								<div class="form-group">
									<label for="remember_pelanggan" class="checkbox-inline">
										<input type="checkbox" id="remember_pelanggan" name="remember_pelanggan"> Ingat Saya
									</label>
									<span class="pull-right">
										<a href="lupa_password_pelanggan.php">Lupa Password ?</a>
									</span>
								</div>
								<button type="submit" name="login_pelanggan" class="btn btn-primary">Login</button>
								<a href="daftar.php">Belum daftar ? Silahkan daftar dulu.</a>
								<hr>
								<span class="pull-right">Begus Ibrahim</span>
							</form>
							<?php
								// logic login pelanggan
								if(isset($_POST['login_pelanggan'])) :
									$email_pelanggan = $_POST['email_pelanggan'];
									$password_pelanggan = $_POST['password_pelanggan'];

									$login_pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE email_pelanggan = '$email_pelanggan' AND password_pelanggan = '$password_pelanggan' ");
									$akun_cocok = mysqli_num_rows($login_pelanggan);
									if($akun_cocok == 1) :
										$_SESSION['login_pelanggan'] = true;
										$_SESSION['pelanggan'] = mysqli_fetch_assoc($login_pelanggan);

										// set cookie
										if(isset($_POST['remember_pelanggan'])) :
											setcookie('my', $_SESSION['pelanggan']['id_pelanggan'], time() + 3600);
											setcookie('jobs', hash('md5', $_SESSION['pelanggan']['email_pelanggan']), time() + 3600);
										endif;

										echo "<script>alert('Anda berhasil login');</script>";
										if(!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) :	
											echo "<script>location='index.php';</script>";
										else :
											echo "<script>location='checkout.php';</script>";
										endif;
									else :
										echo "<script>alert('Anda gagal login, EMAIL & PASSWORD TIDAK SESUAI');</script>";
										echo "<script>location='login.php';</script>";
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