<?php 
    session_start(); 
    // ketika membuat file ini maka data direktory detail yang ada di variabel session di hapus untuk menampilkan lagi fitur searching / pencarian
    include 'layouts/hapus-path-detail.php';
    include 'admin/config/koneksi.php';
    // Proteksi -> user yang belum login tidak boleh masuk
    if(!isset($_SESSION['pelanggan']) || empty($_SESSION['pelanggan'])) :
      echo "<script>alert('Anda harus login terlebih dahulu');</script>";
      echo "<script>location='login.php';</script>";
      exit();
    endif;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Riwayat Belanja | CodeCrypt</title>
  <?php include 'layouts/css.php'; ?>
</head>
<body>

    <!-- navbar -->
    <?php include 'layouts/navbar.php'; ?>
    <!-- akhir navbar -->
    
    <!-- konten -->
    <!-- <pre><?php //print_r($_SESSION['pelanggan']); ?></pre> -->
    <?php
      $no = 1;
      $id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];
      $data_pembelian = mysqli_query($koneksi, "SELECT * FROM pembelian WHERE id_pelanggan = '$id_pelanggan' ");
      // Jika tidak ada riwayat pembelian
      $cek_data_pembelian = $data_pembelian->num_rows;
      if($cek_data_pembelian === 0) :
        echo "<script>alert('Data chekcout belum ada,Anda harus beli barang dan checkout dulu');</script>";
        echo "<script>location='index.php';</script>";
        exit();
      endif;
    ?>
    <section id="riwayat" class="riwayat">
        <div class="container">
            <div class="row">
                <h1>Riwayat belanja <?= $_SESSION['pelanggan']['nama_pelanggan']; ?></h2>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>NO</th>
                      <th>Tanggal Pembelian</th>
                      <th>Status Pembelian</th>
                      <th>Total Pembelian</th>
                      <th>Opsi Pembelian</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while($pembelian = mysqli_fetch_assoc($data_pembelian)) : ?>
                    <tr>
                      <td><?= $no++; ?> .</td>
                      <td><?= $pembelian['tanggal_pembelian']; ?></td>
                      <td>
                        <?= $pembelian['status_pembelian']; ?> <br>
                        <?php if(!empty($pembelian['resi_pengiriman'])) : ?>
                          Resi : <?= $pembelian['resi_pengiriman']; ?>
                        <?php endif; ?>   
                      </td>
                      <td>Rp. <?= number_format( $pembelian['total_pembelian']); ?> ,-</td>
                      <td>
                        <a href="nota.php?id_pembelian=<?= $pembelian['id_pembelian']; ?>" class="btn btn-primary">Nota</a>
                        <?php if($pembelian['status_pembelian'] == "pending") : ?>
                          <a href="pembayaran.php?id_pembelian=<?= $pembelian['id_pembelian']; ?>" class="btn btn-success">Kirim Pembayaran</a>
                        <?php else : ?>
                          <a href="lihat_pembayaran.php?id_pembelian=<?= $pembelian['id_pembelian']; ?>" class="btn btn-warning">Lihat Pembayaran</a>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- akhri konten -->

  <!-- Footer -->
  <?php include 'layouts/footer.php' ?>
  <!-- JavaScript -->
  <?php include 'layouts/js.php'; ?>
</body>
</html>
