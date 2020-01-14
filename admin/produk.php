<h2>Produk</h2>
<div class="panel panel-default">
 <div class="panel-heading">
   Data produk
 </div>
 <div class="panel-body">
    <table class="table table-bordered table-responsive">
      <thead class="thead-light">
        <tr>
          <th scope="col">NO</th>
          <th scope="col">NAMA PRODUK</th>
          <th scope="col">HARGA PRODUK</th>
          <th scope="col">BERAT PRODUK</th>
          <th scope="col">FOTO PRODUK</th>
          <th scope="col">DESKRIPSI PRODUK</th>
          <th scope="col">STOK PRODUK</th>
          <th scope="col">AKSI</th>
        </tr>
      </thead>
      <?php 
      	$no = 1;
      	$query = mysqli_query($koneksi,"SELECT * FROM produk");
      ?>
      <tbody>
      <p><a href="index.php?halaman=tambah_produk" class="btn btn-primary">Tambah Produk</a></p>
      <?php while($item = mysqli_fetch_assoc($query)) : ?>
          <!-- <br> -->
    	    <tr>
    	      <th scope="row"><?= $no++; ?> .</th>
    	      <td><?= $item['nama_produk']; ?></td>
    	      <td>Rp. <?= number_format($item['harga_produk']); ?> ,-</td>
    	      <td><?= $item['berat_produk']; ?> Gram</td>
    	      <td><img class="img-thumbnail" src="../foto_produk/<?= $item['foto_produk']; ?>" width="100"></td>
    	      <td><?= $item['deskripsi_produk']; ?></td>
            <td><?= $item['stok_produk']; ?></td>
    	      <td>
    	      	<a href="index.php?halaman=ubah_produk&id_produk=<?= $item['id_produk']; ?>" class="btn btn-success">Edit</a>
    	      	<!-- <a href="detail.php" class="btn btn-warning">Detail</a> -->
    	      	<a href="index.php?halaman=hapus_produk&id_produk=<?= $item['id_produk']; ?>" class="btn btn-danger">Delete</a>
    	      </td>
    	    </tr>
       	<?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>