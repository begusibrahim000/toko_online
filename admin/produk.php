<h2>Produk</h2>
<table class="table table-bordered table-responsive">
  <thead class="thead-light">
    <tr>
      <th scope="col">NO</th>
      <th scope="col">NAMA PRODUK</th>
      <th scope="col">HARGA PRODUK</th>
      <th scope="col">BERAT PRODUK</th>
      <th scope="col">FOTO PRODUK</th>
      <th scope="col">DESKRIPSI PRODUK</th>
      <th scope="col">AKSI</th>
    </tr>
  </thead>
  <?php 
  	$no = 1;
  	$query = mysqli_query($koneksi,"SELECT * FROM produk");
  ?>
  <tbody>
	<?php while($item = mysqli_fetch_assoc($query)) : ?>
	    <tr>
	      <th scope="row"><?= $no++; ?> .</th>
	      <td><?= $item['nama_produk']; ?></td>
	      <td><?= $item['harga_produk']; ?></td>
	      <td><?= $item['berat_produk']; ?></td>
	      <td><?= $item['foto_produk']; ?></td>
	      <td><?= $item['deskripsi_produk']; ?></td>
	      <td>
	      	<a href="edit.php" class="btn btn-primary">Edit</a>
	      	<a href="detail.php" class="btn btn-warning">Detail</a>
	      	<a href="delete.php" class="btn btn-danger">Delete</a>
	      </td>
	    </tr>
   	<?php endwhile; ?>
  </tbody>
</table>