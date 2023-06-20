<?php
require_once 'templates_admin/header.php'
?>
<!-- Main conten login -->
<div class="container">
	<!-- Outer Row -->
	<div class="row justify-content-center">
		<div class="col-md-6 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
			<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="card-body p-0">
					<!-- Nested Row within Card Body -->
					<div class="row">
						<div class="col">
							<div class="p-5">
								<div class="text-center">
									<h2 class="text-muted">Login | Admin</h2>
								</div>
								<br>
								<hr>
								<form class="user" method="post" action="login.php">
									<div class="form-group">
										<input type="text" class="form-control form-control-user" name="username" value=""  placeholder="Username" autofocus="true" required="true">
									</div>
									<div class="form-group">
										<input type="password" class="form-control form-control-user" name="password" value="" placeholder="Password" required="true">
									</div>
									<button class="btn btn-success btn-user btn-block" name="btnLoginAdmin" type="submit" value="">
										Login
									</button>
								</form>
								<hr>
								<div class="text-center">
									<a class="small" href="forgotpass.php">Lupa Password?</a>
								</div>
								<div class="text-center">
									<a class="small" href="register.php">Daftar Admin</a>
								</div>
								<?php 
								if (isset($_POST['btnLoginAdmin'])) {
									$username = $_POST['username'];
									$password = $_POST['password'];
									$queryGetPropertiLoginAdmin = "SELECT * FROM admin WHERE username_admin = '$username' AND password_admin = '$password'";
									$sqlResult = $koneksi->query($queryGetPropertiLoginAdmin);
									if (!$sqlResult) {
										$aksesTrue = 0;
									}elseif (is_object($sqlResult)) {
										$aksesTrue = $sqlResult->num_rows;
									}else{
										$aksesTrue = 0;
									}
									if ($aksesTrue==1) {
										$akun = $sqlResult->fetch_assoc();
										$_SESSION['admin'] = $akun;
										echo "<script>
										Swal.fire({
											title: 'LOGIN SUKSES',
											icon:'success',
											text: 'Login berhasil yey!',
											showCancelButton: false,
											confirmButtonColor: '#4BB543',
											cancelButtonColor: '#d33',
											confirmButtonText: 'Beranda'
											}).then((result) => {
												document.location.href = 'index.php?page=Dashboard';
											})</script>";
										}else{
											echo "<script>
											Swal.fire({
												title: 'LOGIN GAGAL',
												icon:'warning',
												text: 'Cek username atau passwordmu ya!!',
												showCancelButton: false,
												confirmButtonColor: '#d33',
												cancelButtonColor: '#d33',
												confirmButtonText: 'Login'
												}).then((result) => {
													document.location.href = 'login.php';
												})</script>";
											}
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php 
		require_once 'templates_admin/footer.php';
		?>