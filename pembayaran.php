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
    <?php
      $id_pembelian = $_GET['id_pembelian'];
      $data_pembelian = mysqli_query($koneksi, "SELECT * FROM pembelian WHERE id_pembelian = '$id_pembelian' ");
      $pembelian = mysqli_fetch_assoc($data_pembelian);

      // echo "<pre>";
      // print_r($_SESSION['pelanggan']); 
      // print_r($pembelian);
      // echo "</pre>";

      // PROTEKSI -> KHUSUS ID
      // orang yang akan mengkonfirmasi pembayaran harus lah orang yang login atau beli produk
      // dapatkan id_pelanggan dari pembelian
      $id_pelanggan_beli = $pembelian['id_pelanggan'];
      // dapatkan id_pelanggan dari akun login
      $id_pelanggan_login = $_SESSION['pelanggan']['id_pelanggan'];
      
      if($id_pelanggan_login !== $id_pelanggan_beli) :
        echo "<script>alert('Jangan nakal :D');</script>";
        echo "<script>location='riwayat_belanja.php';</script>";
        exit();
      endif;

      // Untuk memproteksi ketika sudah mengirim pembayaran tidak akan bisa lagi mengirim pembayaran
      $status_pembelian = $pembelian['status_pembelian'];
      $status_pembelian_berhasil = 'sudah kirim pembayaran';
      if($status_pembelian === $status_pembelian_berhasil) :
        echo "<script>alert('Anda sudah mengirimkan bukti pembayaran');</script>";
        echo "<script>location='riwayat_belanja.php';</script>";
        exit();
      endif;
    ?>
    <section id="riwayat" class="riwayat">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <h1>Konfirmasi Pembayarn belanja <?= $_SESSION['pelanggan']['nama_pelanggan']; ?></h2>
                  <div class="alert alert-info">
                    Total tagihan anda adalah <strong>Rp. <?= number_format($pembelian['total_pembelian']); ?> ,-</strong>
                  </div>
                  <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="nama_pengirim">Nama pengirim</label>
                      <input type="text" name="nama_pengirim" id="nama_pengirim" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="nama_bank">Nama bank</label>
                      <input type="text" name="nama_bank" id="nama_bank" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="jumlah_pembayaran">Jumlah pembayaran</label>
                      <input type="number" min="1" name="jumlah_pembayaran" id="jumlah_pembayaran" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="bukti_pembayaran">Bukti pembayaran</label>
                      <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control">
                      <span class="text-danger">Foto bukti pembayaran harug .JPG dan maksimal 2MB</span>
                    </div>
                    <button type="submit" name="pembayaran" class="btn btn-primary">Kirim pembayaran</button>
                    <a href="riwayat_belanja.php" class="btn btn-info">Kembali ke riwayat belanja / cancel</a>
                  </form>
                  <?php
                    // logic fitur konfirmasi pembayaran
                    if(isset($_POST['pembayaran'])) :
                      $nama_pengirim = $_POST['nama_pengirim'];
                      $nama_bank = $_POST['nama_bank'];
                      $jumlah_pembayaran = $_POST['jumlah_pembayaran'];
                      $tanggal_pembayaran = date("Y-m-d");
                      $nama_bukti_pembayaran = $_FILES['bukti_pembayaran']['name'];
                      $nama_bukti_pembayaran_fix = date("YmdHas").$nama_bukti_pembayaran;
                      $tmp_name_bukti_pembayaran = $_FILES['bukti_pembayaran']['tmp_name'];
                      $path_bukti_pembayaran = 'bukti_pembayaran/'.$nama_bukti_pembayaran_fix;
                      $upload_bukti_pembayaran = move_uploaded_file($tmp_name_bukti_pembayaran, $path_bukti_pembayaran);

                      if($upload_bukti_pembayaran) :
                        $insert_pembayaran = mysqli_query($koneksi, "INSERT INTO pembayaran (id_pembelian,nama_pengirim,nama_bank,jumlah_pembayaran,tanggal_pembayaran,bukti_pembayaran) VALUES ('$id_pembelian', '$nama_pengirim', '$nama_bank', '$jumlah_pembayaran', '$tanggal_pembayaran','$nama_bukti_pembayaran_fix') ");
                        if($insert_pembayaran) :
                          $update_status_pembayaran = mysqli_query($koneksi, "UPDATE pembelian SET status_pembelian = 'sudah kirim pembayaran' WHERE id_pembelian = '$id_pembelian' ");
                          if($update_status_pembayaran) :
                            echo "<script>alert('Terimakasih pembayaran sudah diterima,Tunggu proses barang untuk dirim');</script>";
                            echo "<script>location='riwayat_belanja.php';</script>";
                          endif;
                        endif;
                      endif;
                    endif;
                  ?>
                </div>
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
