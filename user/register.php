<?php
$_GET['page']="Register"; 
require_once 'templates_pembeli/header.php';
?>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
			<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="card-body p-0">
					<!-- Nested Row within Card Body -->
					<div class="row">
						<div class="col">
							<div class="p-5">
								<div class="text-center">
									<h2 class="text-muted">Daftar</h2>
									<hr>
								</div>
								<form class="user" method="post" action="register.php">
									<div class="form-group row">
										<div class="col-sm-6 mb-3 mb-sm-0">
											<input type="text" class="form-control form-control-user" placeholder="Nama Depan" name="namadepan_pengguna" id="namadepan_pengguna" required="true">
										</div>
										<div class="col-sm-6">
											<input type="text" class="form-control form-control-user" placeholder="Nama Belakang" name="namabelakang_pengguna" id="namabelakang_pengguna">
										</div>
									</div>
									<div class="form-group">
										<input type="email" class="form-control form-control-user" placeholder="Email" name="email_pengguna" required="true" id="email_pengguna">
									</div>
									<div class="form-group">
										<input type="number" class="form-control form-control-user" placeholder="Nomor Handphone" name="hp_pengguna" required="true" id="hp_pengguna">
									</div>
									<div class="form-group">
										<input type="text" class="form-control form-control-user" placeholder="Username" name="username_pengguna" required="true" id="username_pengguna">
									</div>
									<div class="form-group row">
										<div class="col-sm-6 mb-3 mb-sm-0">
											<input type="password" class="form-control form-control-user" placeholder="Password" name="password_pengguna" required="true" id="password_pengguna">
										</div>
										<div class="col-sm-6">
											<input type="password" class="form-control form-control-user" placeholder="Ulangi Password" name="repeat_password_pengguna" required="true" id="repeat_password_pengguna">
										</div>
									</div>
									<button type="button" class="btn btn-success btn-block btn-user " data-toggle="modal" data-target="#modalRegisterPengguna" name="btnTooglerTambahInformasiBanten" id="btnTooglerTambahInformasiBanten" value="">
										Buat Akun
									</button>
									<!-- Modal Button Toogle Daftar Toko Ditekan -->
									<div class="modal fade" id="modalRegisterPengguna" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalRegisterPenggunaLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="modalRegisterPenggunaLabel">Konfirmasi Registrasi Pengguna</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													Data yang dimasukan sudah benar? Tekan 'Register' jika sudah!
													<br>
													Anda bisa melakukan konfigurasi kembali di <strong>Profile Akun</strong>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
													<button class="btn btn-success btn-user" name="btnSubmitRegister" type="submit"  value="" id="btnSubmitRegister" >
														Register
													</button>	
												</div>
											</div>
										</div>
									</div>
								</form>
								<?php 
								if (isset($_POST['btnSubmitRegister'])) {
									$password_pengguna = $_POST['password_pengguna'];
									$repeat_password_pengguna = $_POST['repeat_password_pengguna'];
									if ($password_pengguna == $repeat_password_pengguna) {
											// Boleh lanjut menginputkan ke database
										$namadepan_pengguna = $_POST['namadepan_pengguna'];
										$namabelakang_pengguna = $_POST['namabelakang_pengguna'];
										$hp_pengguna = $_POST['hp_pengguna'];
										$email_pengguna = $_POST['email_pengguna'];
										$provinsi_pengguna ="";
										$kota_pengguna = "";
										$kodepos_pengguna =0;
										$alamat_pengguna="";
										$foto_pengguna = "avatar3.png";
										$username_pengguna = $_POST['username_pengguna'];
											//query dari tabel pengguna apakah email yang diinputkan sudah pernah terdaftar atau tidak, karena 1 email hanya boleh digunakan oleh satu pengguna
											//register selector yaitu username dan email pengguna
										$query = "SELECT email_pengguna,username_pengguna FROM pengguna WHERE email_pengguna = '$email_pengguna' OR username_pengguna = '$username_pengguna'";
										$sqlResult = $koneksi->query($query);
											// JIka email yang dimasukan pengguna sudah pernah
										if ($sqlResult->num_rows>0) {
												//email atau username sudah ada terdaftar jadi tidak boleh mendaftar
												//tidak boleh mendaftar dan arahkan untuk login dengan email yang berbeda
											echo "<script>
											Swal.fire({
												icon: 'error',
												title: 'Oops...',
												text: 'Email atau username sudah terdaftar lhoo..'
											})</script>";
										}else{
												//boleh daftar
												//boleh mendaftar dengan data yang diinputkan tersebut
											$query = "INSERT INTO pengguna VALUES ('','$namadepan_pengguna','$namabelakang_pengguna','$hp_pengguna','$email_pengguna','$provinsi_pengguna','$kota_pengguna','$kodepos_pengguna','$alamat_pengguna','$foto_pengguna','$username_pengguna','$password_pengguna')";
											if ($koneksi->query($query)>0) {
												echo "<script>
												Swal.fire({
													title: 'Sukses!!',
													icon:'success',
													text: 'Kamu sudah terdaftar, Yuk Login!',
													showCancelButton: false,
													confirmButtonColor: '#3085d6',
													cancelButtonColor: '#d33',
													confirmButtonText: 'Login'
													}).then((result) => {
														document.location.href = 'login.php';
													})</script>";
												}else{
													echo "<script>
													Swal.fire({
														title: 'GAGAL!',
														icon:'warning',
														text: 'Akun gagal dibuat!',
														showCancelButton: false,
														confirmButtonColor: '#d33',
														cancelButtonColor: '#d33',
														confirmButtonText: 'Register'
														}).then((result) => {
															document.location.href = 'register.php';
														})</script>";
													}
												}
											}else{
										// Password salah, ulangi inputkan yang benar
												echo "<script>
												Swal.fire({
													title: 'Password tidak sama',
													icon:'warning',
													text: 'Masukan password yang sama ya...',
													showCancelButton: false,
													confirmButtonColor: '#d33',
													cancelButtonColor: '#d33',
													confirmButtonText: 'Register'
													}).then((result) => {
														document.location.href = 'register.php';
													})</script>";
												}	
											}
											?>
											<hr>
											<div class="text-center">
												<a class="medium" href="forgotpass.php">Lupa Password?</a>
											</div>
											<div class="text-center">
												<a class="medium" href="login.php">Sudah punya akun? | Login!</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<?php 
			require_once 'templates_pembeli/footer.php';
			?>