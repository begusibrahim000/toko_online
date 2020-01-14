<?php
	include 'config/koneksi.php';
	$id_pembelian = $_GET['id_pembelian'];
	$data_pembelian = mysqli_query($koneksi, "SELECT * FROM pembelian INNER JOIN pelanggan ON pembelian.id_pelanggan = pelanggan.id_pelanggan WHERE pembelian.id_pembelian = '$id_pembelian' ");
		// echo "<pre>";
		// print_r($data_pembelian->fetch_assoc());
		// echo "</pre>";
	$pecah_data_pembelian = mysqli_fetch_assoc($data_pembelian);
	// data ongkir sesuai id pembelian
	$id_ongkir = $pecah_data_pembelian['id_ongkir'];
	$data_ongkir = mysqli_query($koneksi, "SELECT * FROM ongkir WHERE id_ongkir = $id_ongkir ");
	$tarif_ongkir = mysqli_fetch_assoc($data_ongkir);
	// echo "<pre>";
	// print_r($pecah_data_pembelian);
	// print_r($tarif_ongkir);
	// echo "</pre>";
?>
<h2>Detail Pembelian / NOTA</h2>
<div class="row">
	<div class="col-md-12">
		<!-- Detail pembelian dan pelanggan -->
		<div class="panel panel-default">
			<div class="panel-heading">
				DETAIL PEMBELIAN dan PELANGGAN
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#pelanggan" data-toggle="tab">Detail Pelanggan</a>
					</li>
					<li class="">
						<a href="#pembelian" data-toggle="tab">Detail Pembelian</a>
					</li>
					<li class="">
						<a href="#pengiriman" data-toggle="tab">Detail Pengiriman</a>
					</li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane fade active in" id="pelanggan">
						<h4>Detail Pelanggan</h4>
						<ul>
							<li>Nama pelanggan : <?= $pecah_data_pembelian['nama_pelanggan']; ?></li>
							<li>Email pelanggan : <?= $pecah_data_pembelian['email_pelanggan']; ?></li>
							<li>Password pelanggan : <?= md5($pecah_data_pembelian['password_pelanggan']); ?></li>
							<li>Telepon pelanggan : <?= $pecah_data_pembelian['telepon_pelanggan']; ?></li>
						</ul>
					</div>
					<div class="tab-pane fade" id="pembelian">
						<h4>Detail Pembelian</h4>
						<ul>
							<li>ID pembelian : <?= $pecah_data_pembelian['id_pembelian']; ?></li>
							<li>ID pelanggan : <?= $pecah_data_pembelian['id_pelanggan']; ?></li>
							<li>ID ongkir : <?= $pecah_data_pembelian['id_ongkir']; ?></li>
							<li>Tanggal pembelian : <?= $pecah_data_pembelian['tanggal_pembelian']; ?></li>
				 			<li>Total pembelian : <?= number_format($pecah_data_pembelian['total_pembelian']); ?></li>
							<li>Status pembelian : <strong><?= $pecah_data_pembelian['status_pembelian']; ?></strong></li>
							<li>Resi pembelian : <strong><?= $pecah_data_pembelian['resi_pengiriman']; ?></strong></li>
						</ul>
					</div>
					<div class="tab-pane fade" id="pengiriman">
						<h4>Detail Pengiriman</h4>
						<ul>
							<li>Nama kota : <?= $tarif_ongkir['nama_kota']; ?></li>
							<li>Tarif ongkir : Rp. <?= number_format($tarif_ongkir['tarif']); ?> ,-</li>
							<li>Alamat pengiriman : <strong><?= $pecah_data_pembelian['alamat_pengiriman']; ?></strong></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Akhir Detail pembelian dan pelanggan -->

		<!-- Advanced Tables -->
		<div class="panel panel-default">
			<div class="panel-heading">
				Data produk yang di beli oleh <b><?= $pecah_data_pembelian['nama_pelanggan']; ?></b> pada tanggal <b><?= $pecah_data_pembelian['tanggal_pembelian']; ?></b>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Nama produk</th>
								<th class="text-center">Foto produk</th>
								<th class="text-center">Harga produk</th>
								<th class="text-center">Jumlah produk</th>
								<th class="text-center">Subtotal</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no = 1;
								$ambil_data_produk_pembelian = mysqli_query($koneksi, "SELECT * FROM pembelian_produk INNER JOIN produk ON pembelian_produk.id_produk = produk.id_produk WHERE pembelian_produk.id_pembelian = '$id_pembelian' ");
								while($item = mysqli_fetch_assoc($ambil_data_produk_pembelian)) :
							?>
							
								<tr class="odd gradeX">
									<td class="text-center"><?= $no++; ?> .</td>
									<td class="text-center"><?= $item['nama_produk']; ?></td>
									<td class="text-center"><img src="../foto_produk/<?= $item['foto_produk']; ?>" class="img-thumbnail" width="150"></td>
									<td class="text-center">Rp. <?= number_format($item['harga_produk']); ?></td>
									<td class="text-center"><?= $item['jumlah']; ?></td>
									<td class="text-center">Rp. <?= number_format($item['harga_produk'] * $item['jumlah']); ?></td>
								</tr>
								<?php endwhile; ?>								
								<!-- tarif ongkir -->
						</tbody>
						<tfoot>
							<tr>
								<th colspan="5">Tarif Ongkir :</th>
								<th class="text-center">Rp. <?= number_format($tarif_ongkir['tarif']); ?></th>	
							</tr>
							<!-- <tr>
								<th colspan="6">-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</th>
							</tr> -->
							<tr>
								<th colspan="5">Kalkulasi :</th>	
								<th class="text-center">=</th>	
							</tr>
							<tr>
								<th colspan="5">Total Pembelian :</th>
								<th class="text-center">Rp. <?= number_format($pecah_data_pembelian['total_pembelian']); ?></th>	
							</tr>
						</tfoot>
					</table>
				</div>

			</div>
		</div>
		<!--End Advanced Tables -->  
	</div>
</div>
<a href="index.php?halaman=pembelian" class="btn btn-primary">Kembali ke halaman pembelian</a>

