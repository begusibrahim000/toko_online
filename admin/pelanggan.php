<h2>Pelanggan</h2>
<div class="panel panel-default">
 <div class="panel-heading">
   Data akun pelanggan
 </div>
 <div class="panel-body">
    <?php 
      // LOGIKA PAGINATION && AMBIL DATA
      $no = 1;
      // Algoritma PAGINATION 
      // LIMIT -> indexnya dari 0
      $jumlahDataPerhalaman = 2;
      $totalData = mysqli_query($koneksi, "SELECT * FROM pelanggan");
      $hitungTotalData = mysqli_num_rows($totalData);
      // total data perhalaman 2,data 6, total halaman 3
      // total data perhalaman 3, data 6, total halaman 2
      $jumlahHalaman = ceil($hitungTotalData / $jumlahDataPerhalaman);
      // ini untuk menentukan nilai pertama dari KEYWORD LIMIT mau mulai dari mana index data yang akan dimunculkan
      // buat rumus halaman aktif
      if(isset($_GET['aktif'])) :
        $halamanAktif = $_GET['aktif'];
      else :
        $halamanAktif = 1;
      endif;
      // 2
      // halaman aktif 1, awal data 0
      // halaman aktif 2, awal data 2
      // halaman aktif 3, awal data 4 
      $awalData = ( $jumlahDataPerhalaman * $halamanAktif ) - $jumlahDataPerhalaman;
      // var_dump($awalData);
      // var_dump($jumlahHalaman);

      $query = mysqli_query($koneksi,"SELECT * FROM pelanggan LIMIT $awalData,$jumlahDataPerhalaman");
    ?>
    <p><a href="index.php?halaman=tambah_pelanggan" class="btn btn-primary">Tambah akun pelanggan</a></p>

    <!-- pagination -->
    <?php if($halamanAktif >= 2) : ?>
      <a href="?halaman=pelanggan&aktif=<?= $halamanAktif - 1; ?>" style="border:1px solid;border-radius:3px;background-color:salmon;color:black;text-decoration:none;padding-right:10px;padding-left:10px;">Mundur</a>
    <?php endif; ?>

    <div class="pagination" style="border:1px solid;">
      <?php for($i = 1; $i <= $jumlahHalaman; $i++) : ?>
        <?php if($i == $halamanAktif) : ?>
          <a href="?halaman=pelanggan&aktif=<?= $i; ?>" style="font-weight:bold;color:red;"><?= $i ?></a>
        <?php else : ?>
          <a href="?halaman=pelanggan&aktif=<?= $i; ?>"><?= $i ?></a>
        <?php endif; ?>
      <?php endfor; ?>
    </div>

    <?php if($halamanAktif < $jumlahHalaman) : ?>
      <a href="?halaman=pelanggan&aktif=<?= $halamanAktif + 1; ?>" style="border:1px solid;border-radius:3px;background-color:salmon;color:black;text-decoration:none;padding-right:10px;padding-left:10px;">Maju</a>
    <?php endif; ?>
    <!-- akhir pagination -->

    <table class="table table-bordered table-responsive">
      <thead class="thead-light">
        <tr>
          <th scope="col">NO</th>
          <th scope="col">EMAIL PELANGGAN</th>
          <th scope="col">PASSWORD PELANGGAN</th>
          <th scope="col">NAMA PELANGGAN</th>
          <th scope="col">TELEPON PELANGGAN</th>
          <th scope="col">FOTO PELANGGAN</th>
          <th scope="col">AKSI</th>
        </tr>
      </thead>
      <tbody>
    	<?php while($item = mysqli_fetch_assoc($query)) : ?>
    	    <tr>
    	      <th scope="row"><?= $no++; ?> .</th>
    	      <td><?= $item['email_pelanggan']; ?></td>
            <td><?= hash('md5', $item['password_pelanggan']); ?></td>
    	      <td><?= $item['nama_pelanggan']; ?></td>
    	      <td><?= $item['telepon_pelanggan']; ?></td>
            <td><img src="../foto_pelanggan/<?= $item['foto_pelanggan']; ?>" class="img-responsive img-thumbnail" width="100" alt="Foto Pelanggan <?= $item['foto_pelanggan']; ?>"></td>
    	      <td>
    	      	<a href="index.php?halaman=ubah_pelanggan&id_pelanggan=<?= $item['id_pelanggan']; ?>" class="btn btn-success">Edit</a>
    	      	  <a href="detail.php" class="btn btn-warning">Detail</a>
    	      	<a href="index.php?halaman=hapus_pelanggan&id_pelanggan=<?= $item['id_pelanggan']; ?>" onClick="return confirm('Yakin mau dihapus?');" class="btn btn-danger">Delete</a>
    	      </td>
    	    </tr>
       	<?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>