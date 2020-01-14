<?php
	// logic laporan pembelian
	include 'config/koneksi.php';
	$semua_data = array();
	$tgl_mulai = "-";
	$tgl_selesai = "-";
	if(isset($_POST['pembelian'])) :
		$tgl_mulai = $_POST['tgl_mulai'];
		$tgl_selesai = $_POST['tgl_selesai'];
		$data_laporan_pembelian = mysqli_query($koneksi, "SELECT * FROM pembelian pm LEFT JOIN pelanggan pl ON pm.id_pelanggan = pl.id_pelanggan WHERE tanggal_pembelian BETWEEN '$tgl_mulai' AND '$tgl_selesai' ");
		// 1.perulangan pertama untuk mengisi array semua data dari inputan sql
		// 2.perulangan kedua yang ada di table untuk menampilkan data array associatip yang sudah ada didalam variabel $semua_data dengan foreach
		// catatan = data berupa array associatif wajib memakai foreach atau while sesuai kondisi untuk menampilaknnya
		while($laporan_pembelian = mysqli_fetch_assoc($data_laporan_pembelian)) :
			$semua_data[] = $laporan_pembelian;
		endwhile;

		// echo "<pre>";
		// print_r($semua_data);
		// echo "</pre>";
	endif;
?>	
<h2>Laporan pembelian dari tanggal <?= $tgl_mulai; ?> sampai <?= $tgl_selesai; ?> </h2>
<div class="row">
	<form method="POST">
		<div class="col-md-4">
			<label for="tgl_mulai">Tanggal Mulai</label>
			<input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai; ?>">
		</div>
		<div class="col-md-4">
			<label for="tgl_selesai">Tanggal Selesai</label>
			<input type="date" name="tgl_selesai" class="form-control" value="<?= $tgl_selesai; ?>">
		</div>
		<div class="col-md-4">
			<button type="submit" style="margin-top: 25px;" name="pembelian" class="btn btn-primary">Cari Data Pembelian</button>
		</div>
	</form>
</div>
<br>
<div class="row">
	<div class="col-md-8">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Pelanggan</th>
					<th>Tanggal Pembelian</th>
					<th>Status Pembelian</th>
					<th>Total Pembelian</th>
				</tr>
			</thead>
			<tbody>
				<?php $kalkulasi = 0; ?>
				<?php foreach ($semua_data as $key => $value) : ?>
				<?php $kalkulasi += $value['total_pembelian']; ?>		
				<tr>
					<td><?= $key+=1; ?> .</td>
					<td><?= $value['nama_pelanggan']; ?></td>
					<td><?= $value['tanggal_pembelian']; ?></td>
					<td><?= $value['status_pembelian']; ?></td>
					<td>Rp. <?= number_format($value['total_pembelian']); ?> ,-</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4">Kalkulasi Total Pembelian :</th>
					<th>Rp. <?= number_format($kalkulasi); ?> ,-</th>
				</tr>
			</tfoot>
		</table>

		<?php if(empty($semua_data)) : ?>
			<h3><strong>Pembelian tidak ada</strong></h3>
		<?php endif; ?>
	</div>
</div>
