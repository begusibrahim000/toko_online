<?php 
	include 'config/koneksi.php';
	// var_dump($_SESSION['admin']['username']); 
	$data = $_SESSION['admin'];
?>
<h2>Selamat Datang <?= $data['nama_lengkap_admin']; ?></h2>
<!-- <pre><?php print_r($_SESSION); ?></pre> -->
<div class="row">
	<div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
               Data akun administrator yang LOGIN
           </div>
           <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th class="text-center">Nama lengkap</th>
                            <th class="text-center">Email_admin</th>
                            <th class="text-center">Password_admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd gradeX">
                            <td class="text-center"><?= $data['nama_lengkap_admin']; ?></td>
                            <td class="text-center"><?= $data['email_admin']; ?></td>
                            <td class="text-center"><?= md5($data['password_admin']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--End Advanced Tables -->  
	</div>
    <div class="col-md-12">
        <div class="alert alert-success">
            <strong class="text-primary">Aplikasi toko online hardware hp perusahaan MyJOBS</strong>
        </div>
    </div>
</div>