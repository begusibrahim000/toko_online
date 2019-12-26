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
        <h2> CodeCrypt : Login</h2>
        <h5>( Login yourself to get access )</h5>
        <br />
      </div>
    </div>
    <div class="row ">

      <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Enter Details To Login </strong>  
          </div>
          <div class="panel-body">
            <form action="" role="form" method="POST">
             <br />
             <label for="username">Username / Email / Number</label>
             <div class="form-group input-group">
              <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
              <input type="text" class="form-control" id="username" name="username">
            </div>
            <label for="password">Password</label>
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
              <input type="password" class="form-control" id="password" name="password"/>
            </div>
            <div class="form-group">
              <label class="checkbox-inline">
                <input type="checkbox" /> Remember me
              </label>
              <span class="pull-right">
               <a href="#" >Forget password ? </a> 
             </span>
           </div>

           <button type="submit" name="submit" class="btn btn-primary">LOGIN</button>
           <hr />
           Not register ? <a href="registeration.php" >click here to register </a> 
           <span style="float: right;">Begus Ibrahim</span>
         </form>
         <?php
            // logika login
            include 'config/koneksi.php';
            if(isset($_POST['submit'])) :
              $username = $_POST['username'];
              $passowrd = $_POST['password'];
              $perbadingan = $koneksi->query("SELECT * FROM admin WHERE username = '$username' AND password = '$password' ");
              $data = $perbadingan->num_rows();
        
              if($data == 1) :
                $_SESSION['admin'] = $data->fetch_assoc();
                echo "<script>alert('Anda berhasil login :) ');</script>";
                // echo "<meta http-equiv='refresh' content='1';url='index.php'>";
                header('Location:index.php');
              else :
                echo "<div class='alert alert-danger'>Login Gagal :( Sesuaikan username dan password anda</div>";
                // echo "<meta http-equiv='refresh' content='1';url='login.php'>";               
                header('Location:login.php');
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
