<?php
$id_penjual = $_SESSION['penjual']['id_penjual']; 
$query = "SELECT * FROM penjual WHERE id_penjual = $id_penjual"; 
$sqlResult = $koneksi->query($query);
$penjual = $sqlResult->fetch_assoc();
$namadepan_penjual = $penjual['namadepan_penjual'];
$namabelakang_penjual = $penjual['namabelakang_penjual'];
$email_penjual = $penjual['email_penjual'];
$hp_penjual = $penjual['hp_penjual'];
$dompet_penjual = $penjual['dompet_penjual'];
$foto_penjual = $penjual['foto_penjual'];
$bank_penjual = $penjual['id_bank'];
$rekening_penjual = $penjual['rekening_penjual'];
$username_penjual = $penjual['username_penjual'];
$password_penjual = $penjual['password_penjual'];
?>
<div class="container-fluid mt-5">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-header">
						<h4 class="display-4">Profile</h4>
					</div>
					<div class="card-body bg-light">
						<div class="row ml-auto justify-content-center">
							<h5 class="card-title"></h5>
						</div>
						<div class="row">
							<div class="col">
								<!-- Untuk image profile -->
								<!-- Tampilkan foto pembelinya -->
								<div class="form-group">
									<img src="../assets/img/penjual/<?php echo $foto_penjual; ?>" class="rounded  shadow p-3 mb-5 bg-white" style=" display: block; margin-left: auto;margin-right: auto; max-width: 100%; max-height: 100%; height: 50rem;">
								</div>
							</div>
							<div class="col">
								<!-- Data Form -->
								<div class="card-body bg-light justify-content-center align-center shadow-sm">
									<div class="row">
										<form action="index.php?page=Profile" method="post" class="form-group" enctype="multipart/form-data">
											<!-- Nama Pengguna -->
											<div class="form-group row">
												<div class="col-sm-6 mb-3 mb-sm-0">
													<label for="namadepan_penjual"><h6>Nama Depan</h6></label>
													<input type="text" class="form-control form-control-user" value="<?php echo $namadepan_penjual ?>" name="namadepan_penjual" required="true" id="namadepan_penjual">
												</div>
												<div class="col-sm-6">
													<label for="namabelakang_penjual"><h6>Nama Belakang</h6></label>
													<input type="text" class="form-control form-control-user" value="<?php echo $namabelakang_penjual ?>" name="namabelakang_penjual" id="namabelakang_penjual">
												</div>
											</div>
											<!-- Email pengguna -->
											<div class="form-group">
												<label for="email_penjual"><h6>Email</h6></label>
												<input type="email" class="form-control form-control-user" value="<?php echo $email_penjual ?>" name="email_penjual" required="true" id="email_penjual">
											</div>
											<!-- Nomor handphone penjual -->
											<div class="form-group">
												<label for="hp_penjual"><h6>Nomor Handphone</h6></label>
												<input type="number" class="form-control form-control-user" value="<?php echo $hp_penjual ?>" name="hp_penjual" required="true" id="hp_penjual">
											</div>
											<!-- Wallet Penjual -->
											<div class="form-group">
												<label><h6>Saldo Dompet (Rp.)</h6></label>
												<input type="number" class="form-control form-control-user" value="<?php echo $dompet_penjual;?>" name="dompet_penjual" readonly="true" id="dompet_penjual">
											</div>
											<!-- BANK & REKENING BANK -->
											<div class="form-group row">
												<div class="col-sm-6 mb-3 mb-sm-0">
													<label for="bank_penjual"><h6>Pilih Bank</h6></label>
													<select class="form-control" id="bank_penjual"aria-describedby="bank_penjual" required="true" name="bank_penjual">
														<?php
														$query = "SELECT * FROM bank WHERE id_bank <> '$bank_penjual'";
														$sqlResult = $koneksi->query($query);
														$query2 = "SELECT id_bank,nama_bank FROM bank WHERE id_bank='$bank_penjual'";
														$sqlResult2 = $koneksi->query($query2);
														$data2=$sqlResult2->fetch_assoc();
														?>
														<option value="<?php echo $data2['id_bank']; ?>"><?php echo $data2['nama_bank']; ?></option>
														<?php while ($data=$sqlResult->fetch_assoc()) :?>
															<option value="<?php echo $data['id_bank'] ?>"><?php echo $data['nama_bank']; ?></option>
														<?php endwhile; ?>
													</select>
													<small id="bank_penjual" class="form-text text-muted">*Pilih bank untuk transaksi pembeli</small>
												</div>
												<div class="col-sm-6">
													<label for="rekening_penjual"><h6>Nomor Rekening</h6></label>
													<input type="text" class="form-control form-control-user"  name="rekening_penjual" required="true" id="rekening_penjual" aria-describedby="rekening_penjual" required="true" value="<?php echo $rekening_penjual; ?>">
													<small id="rekening_penjual" class="form-text text-muted">*Pastikan nomor rekening benar</small>
												</div>
											</div>
											<!-- Username -->
											<div class="form-group">
												<label><h6>Username</h6></label>
												<input type="text" class="form-control form-control-user" value="<?php echo $username_penjual ?>" name="username_penjual" id="username_penjual" readonly="true">
											</div>
											<!-- Password -->
											<div class="form-group row">
												<div class="col-sm-6 mb-3 mb-sm-0">
													<label><h6>Password</h6></label>
													<input type="password" class="form-control form-control-user" value="" name="password_penjual_baru" required="true" id="password_penjual_baru">
												</div>
												<div class="col-sm-6">
													<label><h6>Re-Password</h6></label>
													<input type="password" class="form-control form-control-user" value="" name="repeat_password_penjual_baru" required="true" id="repeat_password_penjual_baru">
												</div>
											</div>
											<!-- Upload foto -->
											<div class="form-group">
												<div class="custom-file mt-2">
													<input type="file" class="custom-file-input" name="foto_penjual" id="foto_penjual">
													<label for="foto_penjual" class="custom-file-label" >Foto Penjual</label>
												</div>
											</div>
										</div>
									</div>
									<!-- Button -->
									<div class="row">
										<div class="col">
											<button class="btn btn-primary btn-user btn-block" name="btnEditProfilePenjual" type="submit" id="btnEditProfilePenjual" value="">
												Edit Profile
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
if (isset($_POST['btnEditProfilePenjual'])) {
	$password_penjual_baru = $_POST['password_penjual_baru'];
	$repeat_password_penjual_baru = $_POST['repeat_password_penjual_baru'];
		//Cek kesamaan password
	if ($password_penjual_baru != $repeat_password_penjual_baru) {
		// Password salah, ulangi inputkan yang benar
		echo "<script>
		Swal.fire({
			title: 'Password tidak sama',
			icon:'warning',
			text: 'Masukan password yang sama ya...',
			showCancelButton: false,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Check'
			}).then((result) => {
				if (result.value) {
					document.location.href = 'index.php?page=Profile';
				}
				})
				</script>";
				exit;
			}elseif ($password_penjual_baru == $repeat_password_penjual_baru) {
				if ($password_penjual_baru==$password_penjual) {
					$namadepan_penjual = $_POST['namadepan_penjual'];
					$namabelakang_penjual = $_POST['namabelakang_penjual'];
					$email_penjual = $_POST['email_penjual'];
					$hp_penjual = $_POST['hp_penjual'];
					$dompet_penjual = $_POST['dompet_penjual'];
					$username_penjual = $_POST['username_penjual'];
					$id_bank = $_POST['bank_penjual'];
					$rekening_penjual = $_POST['rekening_penjual'];
		//Cek jika user menginputkan perubahan terhadap foto profil
					$foto_penjualBaru = $_FILES['foto_penjual']['name'];
					if ($foto_penjualBaru==null) {
			//ganti dengan yang sebelumnya
						$foto_penjualBaru = $foto_penjual;
					}
					$lokasi_foto = $_FILES['foto_penjual']['tmp_name'];
			//mendapatkan tipe data file yang diinputkan user berupa jpg/jpeg/png
					$tipefoto_penjual = explode('.', $foto_penjualBaru);
					$tipefoto_penjual = end($tipefoto_penjual);
					$tipefoto_penjual =strtolower($tipefoto_penjual);
			//ukuran foto yang diupload
					$size_fotoToko = $_FILES['foto_penjual']['size'];
			// upload foto
					$destination = "../assets/img/penjual/".$foto_penjualBaru;
					$extensions= array("jpeg","jpg","png");
			//cek ekstensi file dan ukuran foto yang diinputkan user
					if ($foto_penjualBaru!=null) {
						if (in_array($tipefoto_penjual, $extensions)==false) {
							$errors="Silahkan masukan format foto (jpg/jpeg/png)";
						}
					}
					if($size_fotoToko>2097152) {
						$errors="Silahkan upload gambar < 2 MB";
					}
					if (empty($errors)==true) {
				//Upload foto ke direktori
						move_uploaded_file($lokasi_foto, $destination);
						$query = "UPDATE penjual SET namadepan_penjual = '$namadepan_penjual', namabelakang_penjual = '$namabelakang_penjual', email_penjual = '$email_penjual', hp_penjual = '$hp_penjual', dompet_penjual = '$dompet_penjual', foto_penjual = '$foto_penjualBaru', username_penjual = '$username_penjual', password_penjual = '$password_penjual' , id_bank='$id_bank' , rekening_penjual='$rekening_penjual' WHERE id_penjual = $id_penjual";
						$runQuery=$koneksi->query($query);
						if ($runQuery>0) {
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
					//query data yang baru setelah diupdate
								$query = "SELECT p.*,t.foto_toko FROM penjual p LEFT JOIN toko t USING(id_toko) WHERE id_penjual = $id_penjual";
								$sqlResult = $koneksi->query($query);
								$akun = $sqlResult->fetch_assoc();
								$_SESSION['penjual'] = $akun;
								echo ' <meta http-equiv="refresh" content="1;url=index.php?page=Dashboard">';
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
										document.location.href = 'index.php?page=Profile';
									})</script>";
								}
							}
						}else{
						//beri pesan kalau password tidak sama dengan yang terdaftar
							echo "<script>
							Swal.fire({
								title: 'Password tidak sama dengan yang terdaftar!',
								icon:'warning',
								text: 'Masukan password yang sama ya...',
								showCancelButton: false,
								confirmButtonColor: '#d33',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Check'
								}).then((result) => {
									if (result.value) {
										document.location.href = 'index.php?page=Profile';
									}
									})
									</script>";
									exit;
								}
							}




						}
						?>
