<?php
$id_pengguna = $_SESSION['pembeli']['id_pengguna']; 
$query = "SELECT * FROM pengguna WHERE id_pengguna = $id_pengguna"; 
$ambil = $koneksi->query($query);
$pembeli = $ambil->fetch_assoc();
$namadepan_pengguna = $pembeli['namadepan_pengguna'];
$namabelakang_pengguna = $pembeli['namabelakang_pengguna'];
$hp_pengguna = $pembeli['hp_pengguna'];
$email_pengguna = $pembeli['email_pengguna'];
$provinsi_pengguna = $pembeli['provinsi_pengguna'];
$kota_pengguna = $pembeli['kota_pengguna'];
$kodepos_pengguna=$pembeli['kodepos_pengguna'];
$alamat_pengguna=$pembeli['alamat_pengguna'];
$username_pengguna = $pembeli['username_pengguna'];
$password_pengguna = $pembeli['password_pengguna'];
$foto_penggunaLama = $pembeli['foto_pengguna'];
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
										<form action="index.php?page=Profile" method="post" class="form-group" enctype="multipart/form-data">
											<!-- Nama Pengguna -->
											<div class="form-group row">
												<div class="col-sm-6 mb-3 mb-sm-0">
													<label for="namadepan_pengguna"><h6>Nama Depan</h6></label>
													<input type="text" class="form-control form-control-user" value="<?php echo $namadepan_pengguna ?>" name="namadepan_pengguna" required="true" id="namadepan_pengguna">
												</div>
												<div class="col-sm-6">
													<label for="namabelakang_pengguna"><h6>Nama Belakang</h6></label>
													<input type="text" class="form-control form-control-user" value="<?php echo $namabelakang_pengguna ?>" name="namabelakang_pengguna" id="namabelakang_pengguna">
												</div>
											</div>
											<!-- Email pengguna -->
											<div class="form-group">
												<label for="email_pengguna"><h6>Email</h6></label>
												<input type="email" class="form-control form-control-user" value="<?php echo $email_pengguna ?>" name="email_pengguna" required="true" id="email_pengguna">
											</div>
											<div class="form-group">
												<label for="hp_pengguna"><h6>Nomor Handphone</h6></label>
												<input type="number" class="form-control form-control-user" value="<?php echo $hp_pengguna ?>" name="hp_pengguna" required="true" id="hp_pengguna">
											</div>
											<!-- Username -->
											<div class="form-group">
												<label for="username_pengguna"><h6>Username</h6></label>
												<input type="text" class="form-control form-control-user" value="<?php echo $username_pengguna ?>" name="username_pengguna" required="true" id="username_pengguna" readonly='true'>
											</div>
											<!-- Provinsi, kota kodepos -->
											<div class="form-row">
												<div class="form-group col-md-4">
													<label for="provinsi_pengguna"><h6>Provinsi</h6></label>
													<input type="text" class="form-control" id="provinsi_pengguna" name="provinsi_pengguna" value="<?php echo $provinsi_pengguna; ?>">
												</div>
												<div class="form-group col-md-4">
													<label for="kota_pengguna"><h6>Kab/kota</h6></label>
													<input type="text" class="form-control" id="kota_pengguna" name="kota_pengguna" value="<?php echo $kota_pengguna; ?>">
												</div>
												<div class="form-group col-md-4">
													<label for="kodepos_pengguna"><h6>Kodepos</h6></label>
													<input type="number" class="form-control" id="kodepos_pengguna" name="kodepos_pengguna" value="<?php echo $kodepos_pengguna;?>">
												</div>
											</div>
											<!-- Alamat pengguna -->
											<div class="form-group">
												<label for="alamat_pengguna"><h6>Alamat</h6></label>
												<input type="text" class="form-control form-control-user" value="<?php echo $alamat_pengguna; ?>" name="alamat_pengguna" required="true" id="alamat_pengguna">
											</div>
											<div class="form-group row">
												<div class="col-sm-6 mb-3 mb-sm-0">
													<label for="password_pengguna"><h6>Password</h6></label>
													<input type="password" class="form-control form-control-user" value="" name="password_pengguna" required="true" id="password_pengguna">
												</div>
												<div class="col-sm-6">
													<label for="repeat_password_pengguna"><h6>Ulangi Password</h6></label>
													<input type="password" class="form-control form-control-user" value="" name="repeat_password_pengguna" required="true" id="repeat_password_pengguna">
												</div>
											</div>
											<!-- Foto pengguna -->
											<div class="form-group">
												<div class="custom-file mt-2">
													<input type="file" class="custom-file-input" name="foto_pengguna" id="foto_pengguna" value="">
													<label for="foto_pengguna" class="custom-file-label" >Foto Profile</label>
												</div>
											</div>
										</div>
									</div>
									<!-- Button -->
									<div class="row">
										<div class="col">
											<button type="button" class="btn btn-primary btn-block " data-toggle="modal" data-target="#modalEditProfilePengguna" name="btnTooglerEditProfilePengguna" id="btnTooglerEditProfilePengguna" value="">
												Edit Profile
											</button>
											<!-- Modal Button Toogle Daftar Toko Ditekan -->
											<div class="modal fade" id="modalEditProfilePengguna" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEditProfilePenggunaLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="modalEditProfilePenggunaLabel">Konfirmasi Edit Profile</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															Data yang dimasukan sudah benar? Tekan 'Simpan' jika sudah!
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
															<button class="btn btn-success btn-user" name="btnEditProfilePengguna" type="submit"  value="" id="btnEditProfilePengguna" >
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
								<!-- Tampilkan foto pembelinya -->
								<div class="form-group">
									<?php if (empty($foto_penggunaLama)): ?>
										<img src="../assets/img/pengguna/avatar.png" class="rounded  shadow p-3 mb-5 bg-white" style=" display: block; margin-left: auto;margin-right: auto; max-width: 100%; max-height: 100%;">
										<?php else: ?>
											<img src="../assets/img/pengguna/<?php echo $foto_penggunaLama; ?>" class="rounded  shadow p-3 mb-5 bg-white" style=" display: block; margin-left: auto;margin-right: auto; max-width: 100%; max-height: 100%;">
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
	if (isset($_POST['btnEditProfilePengguna'])) {
		//1. Cek kesamaan password dan repeat password
		$password_penggunaInput = $_POST['password_pengguna'];
		$repeat_password_penggunaInput = $_POST['repeat_password_pengguna'];
		if ($password_pengguna == $password_penggunaInput) {
			$pass=true;
		}else{
			$pass=false;
		}
		if ($password_penggunaInput !=$repeat_password_penggunaInput || $pass == false) {
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
						document.location.href = 'index.php?page=Profile';
					}
				})</script>";
				exit;
			}elseif (
				$password_penggunaInput==$repeat_password_penggunaInput && $pass=true) {
				$namadepan_pengguna = $_POST['namadepan_pengguna'];
				$namabelakang_pengguna = $_POST['namabelakang_pengguna'];
				$hp_pengguna = $_POST['hp_pengguna'];
				$email_pengguna = $_POST['email_pengguna'];
				$provinsi_pengguna = $_POST['provinsi_pengguna'];
				$kota_pengguna = $_POST['kota_pengguna'];
				$kodepos_pengguna=$_POST['kodepos_pengguna'];
				$alamat_pengguna=$_POST['alamat_pengguna'];
				$username_pengguna = $_POST['username_pengguna'];
				$password_pengguna = $_POST['password_pengguna'];
				$foto_penggunaBaru = $_FILES['foto_pengguna']['name'];
					//Cek jika user menginputkan perubahan terhadap foto profil
				if ($foto_penggunaBaru==null) {
						//ganti dengan yang sebelumnya
					$foto_penggunaBaru = $foto_penggunaLama;
				}
					//mendapatkan tipe data file yang diinputkan user berupa jpg/jpeg/png
				$tipefoto_pengguna = explode('.', $foto_penggunaBaru);
				$tipefoto_pengguna = end($tipefoto_pengguna);
				$tipefoto_pengguna =strtolower($tipefoto_pengguna);
				$lokasi_foto = $_FILES['foto_pengguna']['tmp_name'];
						$size_fotoToko = $_FILES['foto_pengguna']['size'];//size foto yang diperbolehkan
					// upload foto
						$destination = "../assets/img/pengguna/".$foto_penggunaBaru;
						$extensions= array("jpeg","jpg","png");
			//cek ekstensi file dan ukuran foto yang diinputkan user
						if ($foto_penggunaBaru!=null) {
							if (in_array($tipefoto_pengguna, $extensions)==false) {
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
							$query = "UPDATE pengguna SET namadepan_pengguna = '$namadepan_pengguna', namabelakang_pengguna = '$namabelakang_pengguna', hp_pengguna = '$hp_pengguna', email_pengguna = '$email_pengguna', provinsi_pengguna = '$provinsi_pengguna', kota_pengguna = '$kota_pengguna', kodepos_pengguna = '$kodepos_pengguna', alamat_pengguna = '$alamat_pengguna', foto_pengguna = '$foto_penggunaBaru', username_pengguna = '$username_pengguna', password_pengguna = '$password_penggunaInput' WHERE id_pengguna = $id_pengguna";
							$runQuery = $koneksi->query($query);
							if ($runQuery==true) {
								//berhasil diupdate
								//query data yang baru setelah diupdate
								$query = "SELECT * FROM pengguna WHERE id_pengguna = '$id_pengguna'";
								$sqlResult = $koneksi->query($query);
								$akun = $sqlResult->fetch_assoc();
								$_SESSION['pembeli'] = $akun;
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
										document.location.href = 'index.php?page=Profile';
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
											document.location.href = 'index.php?page=Profile;
										})</script>";
									}
								}
							}
						}
						?>
