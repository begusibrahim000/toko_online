<?php
	$id_pembelian = $_GET['id_pembelian'];
	// Untuk detail pembayaran bagian ADMIN
	$data_pembayaran = mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE id_pembelian = '$id_pembelian' ");
	$pembayaran = mysqli_fetch_assoc($data_pembayaran);
	// Untuk menampilkan resi pengiriman sesuai kondisi ADA atau TIDAK
	$data_resi_pengiriman = mysqli_query($koneksi, "SELECT * FROM pembelian WHERE id_pembelian = '$id_pembelian' ");
	$resi_pengiriman = mysqli_fetch_assoc($data_resi_pengiriman);
	// echo "<pre>";
	// print_r($pembayaran);
	// print_r($resi_pengiriman);
	// echo "</pre>";
?>
<h2>Lihat pembayaran <?= $pembayaran['nama_pengirim']; ?> : ID pembelian <?= $id_pembelian; ?></h2>
<!-- Data pembayaran -->
<div class="row">
	<div class="col-md-6">
		<table class="table table-bordered">
			<tr>
				<th>Nama Pengirim :</th>
				<td><?= $pembayaran['nama_pengirim']; ?></td>
			</tr>
			<tr>
				<th>Nama Bank : </th>
				<td><?= $pembayaran['nama_bank']; ?></td>
			</tr>
			<tr>
				<th>Jumlah Pembayaran : </th>
				<td>Rp. <?= number_format($pembayaran['jumlah_pembayaran']); ?> ,-</td>
			</tr>
			<tr>
				<th>Tanggal Pembayaran :</th>
				<td><?= $pembayaran['tanggal_pembayaran']; ?></td>
			</tr>
		</table>
	</div>
	<div class="col-md-6">
		<img src="../bukti_pembayaran/<?= $pembayaran['bukti_pembayaran']; ?>" class="img-responsive img-thumbnail" width="400" alt="Foto Bukti Pembayaran">
	</div>
</div>
<!-- buat fitur balas / respon trasangki dengan mencantumkan STATUS DAN RESI || update pembayaran stok dan resi -->
<div class="row">
	<div class="col-md-6">
		<form method="POST">
			<div class="form-group">
				<label for="resi_pengiriman">Resi pengiriman</label>
				<?php if(isset($resi_pengiriman['resi_pengiriman'])) : ?>
					<input type="text" name="resi_pengiriman" class="form-control" value="<?= $resi_pengiriman['resi_pengiriman']; ?>">
				<?php else : ?>
					<input type="text" name="resi_pengiriman" class="form-control">
				<?php endif; ?>
			</div>
			<div class="form-group">
				<label for="status">Status Jual Beli</label>
				<select name="status" id="status_pembelian" class="form-control">
					<?php if(isset($resi_pengiriman['status_pembelian'])) : ?>
						<?php if($resi_pengiriman['status_pembelian'] == "sudah dikirim") : ?>
							<option value="<?= $resi_pengiriman['status_pembelian']; ?>"><?= $resi_pengiriman['status_pembelian']; ?></option>
							<option value="lunas">Lunas</option>
							<option value="batal">Batal</option>
						<?php elseif($resi_pengiriman['status_pembelian'] == "lunas") : ?>
							<option value="<?= $resi_pengiriman['status_pembelian']; ?>"><?= $resi_pengiriman['status_pembelian']; ?></option>
							<option value="sudah dikirim">Sudah Dikirim</option>
							<option value="batal">Batal</option>
						<?php elseif($resi_pengiriman['status_pembelian'] == "batal") : ?>
							<option value="<?= $resi_pengiriman['status_pembelian']; ?>"><?= $resi_pengiriman['status_pembelian']; ?></option>
							<option value="sudah dikirim">Sudah Dikirim</option>
							<option value="luas">Lunas</option>
						<?php elseif($resi_pengiriman['status_pembelian'] == "sudah kirim pembayaran") : ?>					
							<option value="">Pilih Status</option>
							<option value="lunas">Lunas</option>
							<option value="sudah dikirim">Sudah Dikirim</option>
							<option value="batal">Batal</option>
						<?php endif; ?>
					<?php endif; ?>
				</select>
			</div>
			<button type="submit" name="proses" class="btn btn-success">Proses</button>
		</form>
		<?php
			// logic respon admin
			if(isset($_POST['proses'])) :
				$resi_pengiriman = $_POST['resi_pengiriman'];
				$status_pembelian = $_POST['status'];
				$respon = mysqli_query($koneksi, "UPDATE pembelian SET status_pembelian = '$status_pembelian', resi_pengiriman = '$resi_pengiriman' WHERE id_pembelian = '$id_pembelian' ");

				if($respon) :
					echo "<script>alert('Proses jual beli ter UPDATE');</script>";
					echo "<script>location='index.php?halaman=pembelian';</script>";
				endif;
			endif;
		?>
	</div>
</div>