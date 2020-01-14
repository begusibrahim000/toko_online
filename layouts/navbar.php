<style>
	li:hover {
		/*background-color : salmon;*/
		/*color : red !important;*/
		border-radius : 5px;
	}
	.user {
		padding-top: 5px;
		padding-left: 100PX;
	}
	.user:hover {
		background-color : #f8f8f8;
	}
	.navbar {
		border-bottom : 5px solid salmon;
		border-radius : 10px;
	}
</style>
<!-- navbar -->
<nav class="navbar navbar-default">
	<div class="container">
		<ul class="nav navbar-nav">
			<a href="index.php" class="navbar-brand">
				<strong>TOKO ONLINE</strong>
			</a>
			<li><a href="index.php">Home</a></li>
			<li><a href="keranjang.php">Keranjang</a></li>
			<!-- jika belum login atau tidak ada session pelanggan maka linknya adalah :  -->
			<?php if(isset($_SESSION['pelanggan'])) : ?>
				<li><a href="checkout.php">Checkout</a></li>
				<li><a href="riwayat_belanja.php">Riwayat Belanja</a></li>
				<li><a href="logout.php" onClick="return confirm('Anda yakin mau LOGOUT ? ,Tidak mau belanja produk lebih banyak lagi GITUH :D ');">Logout</a></li>
				<li class="user">	
					<img src="foto_pelanggan/<?= $_SESSION['pelanggan']['foto_pelanggan']; ?>" width="50" class="img-responsive img-thumbnail img-circle" alt="Foto Plenggan">
					<span class="text-responsive"><?= $_SESSION['pelanggan']['nama_pelanggan']; ?></span>
				</li>
			<?php elseif(!isset($_SESSION['pelanggan'])) : ?>
				<li><a href="checkout.php">Checkout</a></li>
				<li><a href="login.php">Login</a></li>
				<li><a href="daftar.php">daftar</a></li>
			<?php endif; ?>	
		</ul>
		<!-- fitur pencarian -->
		<!-- jika masuk ke file detail maka hilangkan fitur pencarian -->
		<?php if(isset($_SESSION['detail'])) : ?>
			<!-- kosong -->
		<?php else : // jika tidak ada session detail || bukan membukan halaman detail maka tampilkan fitur pencarian ?> 
		<form action="pencarian.php" method="GET" class="navbar-form navbar-right">
			<input type="text" name="keyword" class="form-control" placeholder="Cari Produk" id="keyword">
			<!-- <button type="submit" class="btn btn-primary">Cari</button> -->
		</form>
		<?php endif; ?>
	</div>
</nav>
<!-- akhir navbar -->