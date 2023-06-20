<?php 
require_once 'templates_penjual/header.php';
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
									<h2 class="text-muted">Daftar Penjual</h2>
									<hr>
								</div>
								<form class="user" method="post" action="register.php">
									<!-- input hidden untuk foto acak avatar untuk profile penjual saat firt user -->
									<input type="hidden" name="foto_penjual" id="foto_penjual" value="avatar.png">
									<div class="form-group row">
										<div class="col-sm-6 mb-3 mb-sm-0">
											<label for="namadepan_penjual">Nama Depan</label>
											<input type="text" class="form-control form-control-user"  name="namadepan_penjual" required="true" id="namadepan_penjual">
										</div>
										<div class="col-sm-6">
											<label for="namabelakang_penjual">Nama Belakang</label>
											<input type="text" class="form-control form-control-user" name="namabelakang_penjual" id="namabelakang_penjual">
										</div>
									</div>
									<div class="form-group">
										<label for="email_penjual">Email</label>
										<input type="email" class="form-control form-control-user" name="email_penjual" required="true" id="email_penjual">
									</div>
									<div class="form-group">
										<label for="hp_penjual">Nomor Handphone</label>
										<input type="number" class="form-control form-control-user"  name="hp_penjual" required="true" id="hp_penjual">
									</div>
									<div class="form-group">
										<label for="username_penjual">Username</label>
										<input type="text" class="form-control form-control-user"  name="username_penjual" required="true" id="username_penjual">
									</div>
									<div class="form-group row">
										<div class="col-sm-6 mb-3 mb-sm-0">
											<label for="bank_penjual">Pilih Bank</label>
											<select class="form-control" id="bank_penjual"aria-describedby="bank_penjual" required="true" name="bank_penjual">
												<?php
												$query = "SELECT * FROM bank";
												$sqlResult = $koneksi->query($query);
												?>
												<option value="">-pilih bank-</option>
												<?php while ($data=$sqlResult->fetch_assoc()) :?>
													<option value="<?php echo $data['id_bank'] ?>"><?php echo $data['nama_bank']; ?></option>
												<?php endwhile; ?>
											</select>
											<small id="bank_penjual" class="form-text text-muted">*Pilih bank untuk transaksi pembeli</small>
										</div>
										<div class="col-sm-6">
											<label for="rekening_penjual">Nomor Rekening</label>
											<input type="text" class="form-control form-control-user"  name="rekening_penjual" required="true" id="rekening_penjual" aria-describedby="rekening_penjual" required="true">
											<small id="rekening_penjual" class="form-text text-muted">*Pastikan nomor rekening benar</small>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-6 mb-3 mb-sm-0">
											<label for="password_penjual">Password</label>
											<input type="password" class="form-control form-control-user"  name="password_penjual" required="true" id="password_penjual">
										</div>
										<div class="col-sm-6">
											<label for="repeat_password_penjual">Ulangi Password</label>
											<input type="password" class="form-control form-control-user"  name="repeat_password_penjual" required="true" id="repeat_password_penjual">
										</div>
									</div>
									<!-- Button Trigger -->
									<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modalConfirRegisterPenjual">
										Registrasi
									</button>
									<!-- Modal -->
									<!-- Modal -->
									<div class="modal fade" id="modalConfirRegisterPenjual" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalConfirRegisterPenjualLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="modalConfirRegisterPenjualLabel">Konfirmasi Registrasi</h5>
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
													<button type="submit" class="btn btn-primary" name="btnSubmitRegisterPenjual" id="btnSubmitRegisterPenjual" value="">Registrasi</button>
												</div>
											</div>
										</div>
									</div>
									<!-- EndModal -->
								</form>
								<?php 
								//cek jika button ditekan
								if (isset($_POST['btnSubmitRegisterPenjual'])) {
									$password_penjual = $_POST['password_penjual'];
									$repeat_password_penjual = $_POST['repeat_password_penjual'];
									if ($password_penjual == $repeat_password_penjual) {
										// Boleh lanjut menginputkan ke database
										$namadepan_penjual = $_POST['namadepan_penjual'];
										$namabelakang_penjual = $_POST['namabelakang_penjual'];
										$email_penjual = $_POST['email_penjual'];
										$username_penjual = $_POST['username_penjual'];
										$hp_penjual = $_POST['hp_penjual'];
										$bank_penjual = $_POST['bank_penjual'];
										$rekening_penjual = $_POST['rekening_penjual'];
										$id_toko = "";
										$dompet_penjual = 0;
										$foto_penjual = $_POST['foto_penjual'];
											//query dari tabel penjual apakah email yang diinputkan sudah pernah terdaftar atau tidak, karena 1 email hanya boleh digunakan oleh satu penjual
											//register selector yaitu username dan email penjual
										$query = "SELECT email_penjual,username_penjual FROM penjual WHERE email_penjual = '$email_penjual' OR username_penjual = '$username_penjual'";
										$sqlResult = $koneksi->query($query);
										if ($sqlResult->num_rows>0) {
												//email atau username sudah ada terdaftar jadi tidak boleh mendaftar
												//tidak boleh mendaftar dan arahkan untuk login dengan email yang berbeda
											echo "<script>Swal.fire({
												icon: 'error',
												title: 'Oops...',
												text: 'Email atau username sudah terdaftar lhoo..'
											})</script>";
										}else{
												// query
											$query = "INSERT INTO penjual VALUES('','$namadepan_penjual','$namabelakang_penjual','$email_penjual','$hp_penjual','$dompet_penjual','$foto_penjual','$username_penjual','$password_penjual','','$bank_penjual','$rekening_penjual')";
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
			require_once 'templates_penjual/footer.php';
			?>