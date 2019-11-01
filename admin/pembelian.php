<h2>Pembelian</h2>
<table class="table table-bordered table-responsive">
  <thead class="thead-light">
    <tr>
      <th scope="col">NO</th>
      <th scope="col">NAMA PELANGGAN</th>
      <th scope="col">TANGGAL PEMBELIAN</th>
      <th scope="col">TOTAL PEMBELIAN</th>
      <th scope="col">AKSI</th>
    </tr>
  </thead>
  <?php 
  	$no = 1;
  	$query = mysqli_query($koneksi,"SELECT * FROM pembelian INNER JOIN pelanggan ON pembelian.id_pelanggan = pelanggan.id_pelanggan");
  ?>
  <tbody>
	<?php while($item = mysqli_fetch_assoc($query)) : ?>
	    <tr>
	      <th scope="row"><?= $no++; ?> .</th>
	      <td><?= $item['nama_pelanggan']; ?></td>
	      <td><?= $item['tanggal_pembelian']; ?></td>
	      <td><?= $item['total_pembelian']; ?></td>
	      <td>
	      	<a href="edit.php" class="btn btn-primary">Edit</a>
	      	<a href="detail.php?halaman=detail&id_pembelian=<?= $item['id_pembelian']; ?>" class="btn btn-warning">Detail</a>
	      	<a href="delete.php" class="btn btn-danger">Delete</a>
	      </td>
	    </tr>
   	<?php endwhile; ?>
  </tbody>
</table>