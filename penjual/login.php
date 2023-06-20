<?php
require_once 'templates_penjual/header.php'
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
									<h2 class="text-muted">Login | Penjual</h2>
								</div>
								<br>
								<hr>
								<form class="user" method="post">
									<div class="form-group">
										<input type="text" class="form-control form-control-user" name="username"   placeholder="Username" autofocus="true" required="true">
									</div>
									<div class="form-group">
										<input type="password" class="form-control form-control-user" name="password" placeholder="Password" required="true">
									</div>
									<button class="btn btn-success btn-user btn-block" name="btnLoginPenjual" type="submit" value="">
										Login
									</button>
								</form>
								<hr>
								<div class="text-center">
									<a class="small" href="forgotpass.php">Lupa Password?</a>
								</div>
								<div class="text-center">
									<a class="small" href="register.php">Daftar Penjual</a>
								</div>
								<?php 
								if (isset($_POST['btnLoginPenjual'])) {
									$username = $_POST['username'];
									$password = $_POST['password'];
									$query = "SELECT p.*, t.foto_toko FROM penjual p LEFT JOIN toko t ON p.id_toko = t.id_toko WHERE p.username_penjual = '$username' AND p.password_penjual = '$password'";
									$sqlResult = $koneksi->query($query);
									if (!$sqlResult) {
										$aksesTrue = 0;
									}elseif (is_object($sqlResult)) {
										$aksesTrue = $sqlResult->num_rows;
									}else{
										$aksesTrue = 0;
									}
									if ($aksesTrue==1) {
										$akun = $sqlResult->fetch_assoc();
										$_SESSION['penjual'] = $akun;
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
		require_once 'templates_penjual/footer.php';
		?>