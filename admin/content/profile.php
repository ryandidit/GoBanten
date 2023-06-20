<?php
$admin = $_SESSION['admin'];
$id_admin = $admin['id_admin'];
$id_wilayah = $admin['id_wilayah'];
$queryGetWilayahAdmin = "SELECT * FROM wilayah WHERE id_wilayah = '$id_wilayah'";
$runQueryGetWilayahAdmin = $koneksi->query($queryGetWilayahAdmin);
$wilayah = $runQueryGetWilayahAdmin->fetch_assoc();
$namadepan_admin = $admin['namadepan_admin'];
$namabelakang_admin = $admin['namabelakang_admin'];
$hp_admin = $admin['hp_admin'];
$email_admin = $admin['email_admin'];
$provinsi_wilayah = $wilayah['provinsi_wilayah'];
$kota_wilayah = $wilayah['kota_wilayah'];
$username_admin = $admin['username_admin'];
$password_admin = $admin['password_admin'];
$foto_adminLama = $admin['foto_admin'];
?>
<div class="container-fluid mt-2 mb-2">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-header">
						<h4 class="display-4 ">Profile</h4>
					</div>
					<div class="card-body bg-light">
						<div class="row ml-auto justify-content-center">
							<h5 class="card-title"></h5>
						</div>
						<div class="row">
							<div class="col">
								<!-- Data Form -->
								<div class="card-body bg-light justify-content-center align-center shadow-sm">
									<div class="row">
										<form action="index.php?page=Profile Admin" method="post" class="form-group" enctype="multipart/form-data">
											<!-- Passing id_admin secara hidden -->
											<input type="hidden" name="id_admin" id="id_admin" value="<?php echo $id_admin;?>">
											<!-- Passing id_wilayah secara hidden -->
											<input type="hidden" name="id_wilayah" id="id_wilayah" value="<?php echo $id_wilayah; ?>">
											<!-- Nama Pengguna -->
											<div class="form-group row">
												<div class="col-sm-6 mb-3 mb-sm-0">
													<label for="namadepan_admin"><h6>Nama Depan</h6></label>
													<input type="text" class="form-control form-control-user" value="<?php echo $namadepan_admin ?>" name="namadepan_admin" required="true" id="namadepan_admin">
												</div>
												<div class="col-sm-6">
													<label for="namabelakang_admin"><h6>Nama Belakang</h6></label>
													<input type="text" class="form-control form-control-user" value="<?php echo $namabelakang_admin ?>" name="namabelakang_admin" id="namabelakang_admin">
												</div>
											</div>
											<!-- Email pengguna -->
											<div class="form-group">
												<label for="email_admin"><h6>Email</h6></label>
												<input type="email" class="form-control form-control-user" value="<?php echo $email_admin ?>" name="email_admin" required="true" id="email_admin">
											</div>
											<div class="form-group">
												<label for="hp_admin"><h6>Nomor Handphone</h6></label>
												<input type="number" class="form-control form-control-user" value="<?php echo $hp_admin ?>" name="hp_admin" required="true" id="hp_admin">
											</div>
											<!-- Username -->
											<div class="form-group">
												<label for="username_admin"><h6>Username</h6></label>
												<input type="text" class="form-control form-control-user" value="<?php echo $username_admin ?>" name="username_admin" required="true" id="username_admin" readonly='true'>
											</div>
											<!-- Provinsi, kota kodepos -->
											<div class="form-row">
												<div class="form-group col-md-4">
													<label for="provinsi_wilayah"><h6>Provinsi</h6></label>
													<input type="text" class="form-control" id="provinsi_wilayah" name="provinsi_wilayah" value="<?php echo $provinsi_wilayah; ?>" readonly="true">
												</div>
												<div class="form-group col-md-4">
													<label for="kota_wilayah"><h6>Kab/kota</h6></label>
													<input type="text" class="form-control" id="kota_wilayah" name="kota_wilayah" value="<?php echo $kota_wilayah; ?>" readonly="true">
												</div>
											</div>
											<div class="form-group row">
												<div class="col-md-4 mb-3 mb-sm-0">
													<label for="password_admin"><h6>Password</h6></label>
													<input type="password" class="form-control form-control-user" value="" name="password_admin" required="true" id="password_admin">
												</div>
												<div class="col-md-4">
													<label for="repeat_password_admin"><h6>Ulangi Password</h6></label>
													<input type="password" class="form-control form-control-user" value="" name="repeat_password_admin" required="true" id="repeat_password_admin">
												</div>
											</div>
											<!-- Foto pengguna -->
											<div class="form-group">
												<div class="custom-file mt-2">
													<input type="file" class="custom-file-input" name="foto_admin" id="foto_admin" value="">
													<label for="foto_admin" class="custom-file-label" >Foto Profile</label>
												</div>
											</div>
										</div>
									</div>
									<!-- Button -->
									<div class="row">
										<div class="col">
											<button type="button" class="btn btn-primary btn-block " data-toggle="modal" data-target="#modalEditProfileAdmin" name="btnTooglerEditProfilePengguna" id="btnTooglerEditProfilePengguna" value="">
												Edit Profile
											</button>
											<!-- Modal Button Toogle Daftar Toko Ditekan -->
											<div class="modal fade" id="modalEditProfileAdmin" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEditProfileAdminLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="modalEditProfileAdminLabel">Konfirmasi Edit Profile</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															Data yang dimasukan sudah benar? Tekan 'Simpan' jika sudah!
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
															<button class="btn btn-success btn-user" name="btnEditProfileAdmin" type="submit"  value="" id="btnEditProfileAdmin" >
																Simpan
															</button>	
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="col">
								<!-- Untuk image profile -->
								<!-- Tampilkan foto adminnya -->
								<div class="form-group">
									<?php if (empty($foto_adminLama)): ?>
										<img src="../assets/img/pengguna/avatar.png" class="rounded  shadow p-3 mb-5 bg-white" style=" display: block; margin-left: auto;margin-right: auto; max-width: 100%; max-height: 100%;">
										<?php else: ?>
											<img src="../assets/img/pengguna/<?php echo $foto_adminLama; ?>" class="rounded  shadow p-3 mb-5 bg-white" style=" display: block; margin-left: auto;margin-right: auto; max-width: 100%; max-height: 100%;">
										<?php endif ?>
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
	//cek jika button edit profile ditekan atau tidak
	if (isset($_POST['btnEditProfileAdmin'])) {
		//1. Cek kesamaan password dan repeat password
		$password_adminInput = $_POST['password_admin'];
		$repeat_password_adminInput = $_POST['repeat_password_admin'];
		if ($password_admin == $password_adminInput) {
			$pass=true;
		}else{
			$pass=false;
		}
		if ($password_adminInput !=$repeat_password_adminInput || $pass == false) {
			// Password salah, ulangi inputkan yang benar
			echo "<script>
			Swal.fire({
				title: 'PASSWORD TIDAK SAMA',
				icon:'warning',
				text: 'Masukan password yang sama ya...',
				showCancelButton: false,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Edit'
				}).then((result) => {
					if (result.value) {
						document.location.href = 'index.php?page=Profile Admin';
					}
				})</script>";
				exit;
			}elseif ($password_adminInput==$repeat_password_adminInput && $pass=true) {
				//boleh update data
				$namadepan_admin = $_POST['namadepan_admin'];
				$namabelakang_admin = $_POST['namabelakang_admin'];
				$hp_admin = $_POST['hp_admin'];
				$email_admin = $_POST['email_admin'];
				$username_admin = $_POST['username_admin'];
				$password_admin = $_POST['password_admin'];
				$foto_adminBaru = $_FILES['foto_admin']['name'];
					//Cek jika user menginputkan perubahan terhadap foto profil
				if ($foto_adminBaru==null) {
						//ganti dengan yang sebelumnya
					$foto_adminBaru = $foto_adminLama;
				}
					//mendapatkan tipe data file yang diinputkan user berupa jpg/jpeg/png
				$tipefoto_admin = explode('.', $foto_adminBaru);
				$tipefoto_admin = end($tipefoto_admin);
				$tipefoto_admin =strtolower($tipefoto_admin);
				$lokasi_foto = $_FILES['foto_admin']['tmp_name'];
						$size_fotoToko = $_FILES['foto_admin']['size'];//size foto yang diperbolehkan
					// upload foto
						$destination = "../assets/img/admin/".$foto_adminBaru;
						$extensions= array("jpeg","jpg","png");
			//cek ekstensi file dan ukuran foto yang diinputkan user
						if ($foto_adminBaru!=null) {
							if (in_array($tipefoto_admin, $extensions)==false) {
								$errors="Silahkan masukan format foto (jpg/jpeg/png)";
							}
						}
						if($size_fotoToko>2097152) {
							$errors="Silahkan upload gambar < 2 MB";
						}
						if (empty($errors)==true) {
							//upload foto yang baru ke dalam assets/img
							move_uploaded_file($lokasi_foto, $destination);
							//query data ke dalam database
							//maka lakukan query data2nya kedalam database
							$query = "UPDATE admin SET namadepan_admin = '$namadepan_admin', namabelakang_admin = '$namabelakang_admin', hp_admin = '$hp_admin', email_admin = '$email_admin',foto_admin = '$foto_adminBaru', username_admin = '$username_admin', password_admin = '$password_adminInput' WHERE id_admin = $id_admin";
							$runQuery = $koneksi->query($query);
							if ($runQuery==true) {
								//berhasil diupdate
								//query data yang baru setelah diupdate
								$query = "SELECT * FROM admin WHERE id_admin = '$id_admin'";
								$sqlResult = $koneksi->query($query);
								$akun = $sqlResult->fetch_assoc();
								$_SESSION['admin'] = $akun;
								echo "<script>
								Swal.fire({
									title: 'BERHASIL UPDATE PROFILE',
									icon:'success',
									text: 'Profilemu berhasil diupdate!',
									showCancelButton: false,
									confirmButtonColor: '#22bb33',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Lihat Profile'
									}).then((result) => {
										document.location.href = 'index.php?page=Profile Admin';
									})</script>";
								}else{
									echo "<script>
									Swal.fire({
										title: 'GAGAL MENGUBAH PROFILE',
										icon:'warning',
										text: 'Profilemu gagal diubah!',
										showCancelButton: false,
										confirmButtonColor: '#d33',
										cancelButtonColor: '#d33',
										confirmButtonText: 'Lihat Profile'
										}).then((result) => {
											document.location.href = 'index.php?page=Profile Admin';
										})</script>";
									}
								}
							}
						}
						?>
