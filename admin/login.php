<?php 
  session_start();
  include 'config/koneksi.php';
  // Validasi
  if(isset($_COOKIE['toko']) && isset($_COOKIE['online'])) :
    $id_admin = $_COOKIE['toko'];
    $email_admin_cookie = $_COOKIE['online'];

    $data_email_admin = mysqli_query($koneksi, "SELECT email_admin FROM admin WHERE id_admin = '$id_admin' ");
    $pecah_email_admin = mysqli_fetch_assoc($data_email_admin);
    $email_admin_database = hash('md5', $pecah_email_admin['email_admin']);
    // bandingakan kalau admin yang ada dicookie dan database sama maka set session login admin untuk otomatis login meskipun web browser atau pc/laptop nya di matikan atau juga diclone
    if($email_admin_cookie === $email_admin_database) :
      $_SESSION['login_admin'] = true;
      if(isset($_SESSION['login_admin'])) :
        $data_akun_admin_yang_login = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = '$id_admin';  ");
        $akun_admin = mysqli_fetch_assoc($data_akun_admin_yang_login);
        // var_dump($akun_admin);die();
        $_SESSION['admin'] = $akun_admin;
        echo "<script>location='index.php';</script>";
        exit;
      endif;
    else :
      echo "Gagal mendapatkan cookie";
    endif;
  endif;

  if(isset($_SESSION['login_admin'])) :
    echo "<script>alert('Anda harus logout');</script>";
    echo "<script>location='index.php';</script>";
    exit;
  endif;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login : CodeCrypt</title>
  <!-- BOOTSTRAP STYLES-->
  <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <!-- FONTAWESOME STYLES-->
  <link href="assets/css/font-awesome.css" rel="stylesheet" />
  <!-- CUSTOM STYLES-->
  <link href="assets/css/custom.css" rel="stylesheet" />
  <!-- GOOGLE FONTS-->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
  <div class="container">
    <div class="row text-center ">
      <div class="col-md-12">
        <br /><br />
        <h2> TOKO ONLINE : Login Admin</h2>
        <br />
      </div>
    </div>
    <div class="row ">

      <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span>Login Admin </span>  
          </div>
          <div class="panel-body">
            <form role="form" method="POST">
             <br />
             <label for="email_admin">Email Admin</label>
             <div class="form-group input-group">
              <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
              <input type="text" class="form-control" id="email_admin" name="email_admin"/>
            </div>
            <label for="password_admin">Password Admin</label>
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
              <input type="password" class="form-control" id="password_admin" name="password_admin"/>
            </div>
            <div class="form-group">
              <label class="checkbox-inline">
                <input type="checkbox" name="remember" /> Ingat Saya
              </label>
              <span class="pull-right">
               <a href="lupa_password.php" >Lupa Password ? </a> 
             </span>
           </div>

           <button type="submit" name="login" class="btn btn-primary">LOGIN</button>
           <hr />
           <!-- Not register ? <a href="registeration.php" >click here to register </a>  -->
           <span style="float: right;">Begus Ibrahim</span>
         </form>
         <?php
            if(isset($_POST['login'])) :
              $email_admin = $_POST['email_admin'];
              $password_admin = $_POST['password_admin'];
              // 1.ambil data dan bandingkan
              $perbandingan = mysqli_query($koneksi, "SELECT * FROM admin WHERE email_admin = '$email_admin' AND password_admin = '$password_admin'");
              // simpan di fungsi numerik
              $berhasil = mysqli_num_rows($perbandingan);
              // kondisi : jika ada satu yang benar / 1 sesuai dengan perbandingan maka masuk
              if($berhasil == 1) :
                // Cek apakah fitur rembember me nya di CENTANG
                // data disimpan disession admin dari query sql untuk disimpan di halaman index.php
                $_SESSION['login_admin'] = true;
                $_SESSION['admin'] = mysqli_fetch_assoc($perbandingan);

                // Set COOKIE
                if(isset($_POST['remember'])) :
                  setcookie('toko', $_SESSION['admin']['id_admin'], time() + 3600);
                  setcookie('online', hash('md5', $_SESSION['admin']['email_admin']), time() + 3600);
                  // setcookie('ceklis', '$ingat_login_admin', time() + 60);
                endif;

                echo "<script>location='index.php';</script>";               
                header('Location:index.php');
                exit;
              else :
                echo "<script>alert('Login gagal, Sesuaikan EMAIL dan PASSWORD');</script>";
                // echo "<meta http-equiv='refresh' content='1';url='login.php'>";       
                // header('Location:login.php');
              endif;
            endif;
         ?>
       </div>

     </div>
   </div>


 </div>
</div>


<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="assets/js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>

</body>
</html>
