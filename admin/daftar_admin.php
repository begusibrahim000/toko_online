<!-- konten -->
	<section id="konten" class="konten">
		<div class="container">
			<h2>Daftar Admin</h2>
			<div class="row justify-content-center">
				<div class="col-md-10">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><strong>Daftar Pelanggan</strong></h3>
						</div>
						<div class="panel-body">
							<!-- form daftar admin -->
							<form method="POST" enctype="multipart/form-data">
								<div class="form-group">
									<label for="nama">Nama admin</label>
									<input type="text" name="nama_lengkap_admin" class="form-control" required>
								</div>
								<div class="form-group">
									<label for="email">Email admin</label>
									<input type="email" name="email_admin" class="form-control" required>
								</div>
								<div class="form-group">
									<label for="password">Password admin</label>
									<input type="password" name="password_admin" class="form-control" required>
								</div>
								<div class="form-group">
									<label for="foto_admin">foto admin</label>
									<input type="file" name="foto_admin" class="form-control" required>
								</div>
								<button type="submit" name="daftar_admin" class="btn btn-primary">Daftar Admin</button>
							</form>
							<?php
								// logic daftar , hanya memasukan data inputan ke database pelanggan
								if(isset($_POST['daftar_admin'])) :
									$nama_lengkap_admin = $_POST['nama_lengkap_admin'];
									$email_admin = $_POST['email_admin'];
									$password_admin = $_POST['password_admin'];
									$foto_admin = $_FILES['foto_admin']['name'];
									$tmp_name_foto_admin = $_FILES['foto_admin']['tmp_name'];
									$path = 'foto_admin/'.$foto_admin;
									$upload_foto_admin = move_uploaded_file($tmp_name_foto_admin, $path);

									if($upload_foto_admin) :
										// cek apakah email sudah ada atau belum didatabase
										$data_admin = mysqli_query($koneksi, " SELECT * FROM admin WHERE email_admin = '$email_admin' ");
										$ada_satu = mysqli_num_rows($data_admin);

										if($ada_satu == 1) : // bila cocok data yang diinputkan ada dalam database
											echo "<script>alert('Email sudah digunakan,Mohon gunakan email yang belum pernah didapftarkan');</script>";
											echo "<script>location='daftar_admin.php';</script>";
										else :
											$insert_data_daftar_admin = mysqli_query($koneksi, "INSERT INTO admin (email_admin,password_admin,nama_lengkap_admin,foto_admin) VALUES ('$email_admin', '$password_admin', '$nama_lengkap_admin', '$foto_admin') ");
											if($insert_data_daftar_admin) :
												echo "<script>alert('Daftar berhasil :) ');</script>";
												// echo "<script>location='daftar_admin.php';</script>";
											endif;
										endif;
									endif;		
								endif;	
							?>
						</div>
					</div>
					<!-- akhir form daftar admin -->
					<!-- Data akun admin -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">
								<strong>Data akun admin</strong>
							</div>
						</div>
						<div class="panel-body">
							<?php
								$no = 1;
								$data_akun_admins = mysqli_query($koneksi, "SELECT * FROM admin");
							?>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama Lengkap Admin</th>
										<th>Email Admin</th>
										<th>Password Admin</th>
										<th>Foto Admin</th>
									</tr>
								</thead>
								<tbody>
									<?php while($akun_admins = mysqli_fetch_assoc($data_akun_admins)) : ?>
									<tr>
										<td><?= $no++; ?></td>
										<td><?= $akun_admins['nama_lengkap_admin']; ?></td>
										<td><?= $akun_admins['email_admin']; ?></td>
										<td><?= md5($akun_admins['password_admin']); ?></td>
										<td>
											<img src="foto_admin/<?= $akun_admins['foto_admin'] ?>" class="img-responsive img-thumbnail" width="100" alt="Foto Admin">
										</td>
									</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
						</div>
					</div>
					<!-- Data daftar akun admin -->
				</div>
			</div>
		</div>
	</section>
	<!-- akhir konten -->