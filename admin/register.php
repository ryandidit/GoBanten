<?php 
require_once 'templates_admin/header.php';
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
									<h2 class="text-muted">Daftar Admin</h2>
									<hr>
								</div>
								<form class="user" method="post" action="register.php">
									<!-- Kirimkan foto random profile -->
									<input type="hidden" name="foto_admin" value="avatar.png" id="foto_admin">
									<div class="form-group row">
										<div class="col-sm-6 mb-3 mb-sm-0">
											<label for="namadepan_admin">Nama Depan</label>
											<input type="text" class="form-control form-control-user"  name="namadepan_admin" required="true" id="namadepan_admin">
										</div>
										<div class="col-sm-6">
											<label for="namabelakang_admin">Nama Belakang</label>
											<input type="text" class="form-control form-control-user" name="namabelakang_admin" id="namabelakang_admin">
										</div>
									</div>
									<div class="form-group">
										<label for="email_admin">Email</label>
										<input type="email" class="form-control form-control-user" name="email_admin" required="true" id="email_admin">
									</div>
									<div class="form-group">
										<label for="hp_admin">Nomor Handphone</label>
										<input type="number" class="form-control form-control-user"  name="hp_admin" required="true" id="hp_admin">
									</div>
									<!-- Wilayah Admin -->
									<div class="form-group row">
										<div class="col-sm-6">
											<label for="provinsi_wilayah_admin">Provinsi</label>
											<input type="text" class="form-control form-control-user"  name="provinsi_wilayah_admin" required="true" id="provinsi_wilayah_admin" aria-describedby="provinsi_wilayah_admin" value="Bali" readonly="true">
											<small id="provinsi_wilayah_admin" class="form-text text-muted">*Sementara hanya untuk Bali</small>
										</div>
										<div class="col-sm-6 mb-3 mb-sm-0">
											<label for="id_wilayah">Pilih Kota/Kabupaten</label>
											<select class="form-control" id="id_wilayah"aria-describedby="id_wilayah" required="true" name="id_wilayah">
												<?php
												$queryGetDataWilayah = "SELECT * FROM wilayah";
												$runQuery = $koneksi->query($queryGetDataWilayah);
												while ($wilayah = $runQuery->fetch_assoc()) :?>
													<option value="<?php echo $wilayah['id_wilayah'] ?>"><?php echo $wilayah['kota_wilayah']; ?></option>
												<?php endwhile; ?>
											</select>
											<small id="id_wilayah" class="form-text text-muted">*Pilih kota/kabupaten penugasan</small>
										</div>
									</div>
									<div class="form-group">
										<label for="username_admin">Username</label>
										<input type="text" class="form-control form-control-user"  name="username_admin" required="true" id="username_admin">
									</div>
									<div class="form-group row">
										<div class="col-sm-6 mb-3 mb-sm-0">
											<label for="password_admin">Password</label>
											<input type="password" class="form-control form-control-user"  name="password_admin" required="true" id="password_admin">
										</div>
										<div class="col-sm-6">
											<label for="repeat_password_admin">Ulangi Password</label>
											<input type="password" class="form-control form-control-user"  name="repeat_password_admin" required="true" id="repeat_password_admin">
										</div>
									</div>
									<!-- Button Trigger -->
									<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modalConfirmRegisterAdmin">
										Registrasi
									</button>
									<!-- Modal -->
									<!-- Modal -->
									<div class="modal fade" id="modalConfirmRegisterAdmin" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalConfirmRegisterAdminLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="modalConfirmRegisterAdminLabel">Konfirmasi Registrasi</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<p class="card-text">
														Informasi yang dimasukkan sudah benar?
													</p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
													<button type="submit" class="btn btn-primary" name="btnSubmitRegisterAdmin" id="btnSubmitRegisterAdmin" value="">Registrasi</button>
												</div>
											</div>
										</div>
									</div>
									<!-- EndModal -->
								</form>
								<?php 
								//cek jika button ditekan
								if (isset($_POST['btnSubmitRegisterAdmin'])) {
									$password_admin = $_POST['password_admin'];
									$repeat_password_admin = $_POST['repeat_password_admin'];
									if ($password_admin == $repeat_password_admin) {
										$namadepan_admin = $_POST['namadepan_admin'];
										$namabelakang_admin = $_POST['namabelakang_admin'];
										$email_admin = $_POST['email_admin'];
										$username_admin = $_POST['username_admin'];
										$hp_admin = $_POST['hp_admin'];
										$id_wilayah = $_POST['id_wilayah'];
										$foto_admin = $_POST['foto_admin'];
										//1. Cek jika untuk kode wilayah yang dimasukkan apakah sudah ada admin yang username atau emailnya sama
										$queryValidationAdminInSameRegion ="SELECT id_wilayah FROM admin WHERE username_admin ='$username_admin' OR email_admin='$email_admin'";
										$sqlResult = $koneksi->query($queryValidationAdminInSameRegion);
										if ($sqlResult->num_rows>0) {
												//email atau username sudah ada terdaftar jadi tidak boleh mendaftar
												//tidak boleh mendaftar dan arahkan untuk login dengan email yang berbeda
											echo "<script>Swal.fire({
												icon: 'error',
												title: 'SUDAH TERDAFTAR',
												text: 'Email atau username sudah terdaftar lhoo..'
											})</script>";
										}else{
												// query
											$queryInsertNewAdmin = "INSERT INTO admin VALUES('','$namadepan_admin','$namabelakang_admin','$username_admin','$password_admin','$email_admin','$hp_admin','$foto_admin','$id_wilayah')";
											if ($koneksi->query($queryInsertNewAdmin)>0) {
												echo "<script>
												Swal.fire({
													title: 'REGISTER BERHASIL',
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
														title: 'REGISTER GAGAL',
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
													title: 'PASSWORD TIDAK SAMA',
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
			require_once 'templates_admin/footer.php';
			?>