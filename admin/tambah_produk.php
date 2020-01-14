<h2>Tambah Produk</h2>
<form method="POST" enctype="multipart/form-data">
	<div class="form-group">
		<label for="nama">Nama Produk</label>
		<input type="text" class="form-control" name="nama">
	</div>
	<div class="form-group">
		<label for="harga">Harga Produk (Rp.)</label>
		<input type="number" class="form-control" name="harga">
	</div>
	<div class="form-group">
		<label for="berat">Berat Produk (Gr)</label>
		<input type="number" class="form-control" name="berat">
	<div class="form-group">
		<label for="stok">Stok Produk</label>
		<input type="number" name="stok" class="form-control">
	</div>
	<div class="form-group">
		<label for="deskripsi">Deskripsi Produk</label>
		<textarea class="form-control" class="form-control" name="deskripsi" rows="10"></textarea>
	</div>
	</div>
	<div class="form-group">
		<label for="foto">Foto Produk</label>
		<input type="file" class="form-control" name="foto">
	</div>
	<button class="btn btn-primary" name="tambah_produk">Tambahkan Produk</button>
</form>
<?php
	include 'config/koneksi.php';
	if(isset($_POST['tambah_produk'])) :
		/*upload file*/
		$foto_produk = $_FILES['foto']['name'];
		$tmp_name = $_FILES['foto']['tmp_name'];
		$path = '../foto_produk/'.$foto_produk;
		$upload = move_uploaded_file($tmp_name, $path);
		if($upload) :
			$nama_produk = $_POST['nama'];
			$harga_produk = $_POST['harga'];
			$berat_produk = $_POST['berat'];
			$stok_produk = $_POST['stok'];
			$deskripsi_produk = $_POST['deskripsi'];
			$tambah_produk = mysqli_query($koneksi, "INSERT INTO produk (nama_produk,harga_produk,berat_produk,foto_produk,deskripsi_produk,stok_produk) 
				VALUES ('$nama_produk', '$harga_produk', '$berat_produk', '$foto_produk', '$deskripsi_produk', '$stok_produk');
			 ");
			echo "<script>alert('Produk ditambahkan');</script>";
			echo "<script>location='index.php?halaman=produk';</script>";
		endif;
	endif;
?>