<h2>Pelanggan</h2>
<table class="table table-bordered table-responsive">
  <thead class="thead-light">
    <tr>
      <th scope="col">NO</th>
      <th scope="col">EMAIL PELANGGAN</th>
      <th scope="col">NAMA PELANGGAN</th>
      <th scope="col">TELEPON PELANGGAN	</th>
      <th scope="col">AKSI</th>
    </tr>
  </thead>
  <?php 
  	$no = 1;
  	$query = mysqli_query($koneksi,"SELECT * FROM pelanggan");
  ?>
  <tbody>
	<?php while($item = mysqli_fetch_assoc($query)) : ?>
	    <tr>
	      <th scope="row"><?= $no++; ?> .</th>
	      <td><?= $item['email_pelanggan']; ?></td>
	      <td><?= $item['nama_pelanggan']; ?></td>
	      <td><?= $item['telepon_pelanggan']; ?></td>
	      <td>
	      	<a href="edit.php" class="btn btn-primary">Edit</a>
	      	<a href="detail.php" class="btn btn-warning">Detail</a>
	      	<a href="delete.php" class="btn btn-danger">Delete</a>
	      </td>
	    </tr>
   	<?php endwhile; ?>
  </tbody>
</table>