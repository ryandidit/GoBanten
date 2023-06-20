<div class="container-fluid">
	<div class="container">
		<div class="card o-hidden border-0 shadow-lg my-5">
			<div class="card-header">
				<h4 class="display-4">Registrasi Toko</h4>
			</div>
			<div class="card-body bg-light">
				<div class="row">
					<div class="col">
						
						<form class="user" method="post" action="index.php?page=Registrasi Toko"  enctype="multipart/form-data" id="formRegisterToko">
							<div class="col">
								<div class="p-2">
									<div class="form-group">
										<label for="nama_toko">Nama Toko</label>
										<input type="text" class="form-control form-control-user" placeholder="Nama Toko" name="nama_toko" required="true" id="nama_toko" >
									</div>
									<div class="form-group">
										<label for="alamat_toko">Alamat Toko</label>
										<input type="text" class="form-control form-control-user" placeholder="Alamat Toko" name="alamat_toko" required="true" id="alamat_toko">
									</div>
									<div class="form-group">
										<label for="provinsi_toko">Provinsi</label>
										<input type="text" name="provinsi_toko" id="provinsi_toko" class="form-control form-control-user" value="Bali" readonly="true" aria-describedby="provinsi_toko_help">
										<small id="provinsi_toko_help" class="form-text text-muted">Sementara hanya berlaku di Bali</small>
									</div>
									<!--  -->
									<div class="form-group row">
										<div class="col-sm-6 mb-3 mb-sm-0">
											<label for="kota_toko">Kabupaten/Kota</label>
											<!-- Query dari tabel wilayah -->
											<?php
											$queryWilayah = "SELECT * FROM wilayah";
											$getData = $koneksi->query($queryWilayah);
											?>
											<select class="form-control" id="kota_toko" required="true" name="kota_toko">
												<option value="">-Pilih Kabupaten/Kota</option>
												<?php while ( $wilayah = $getData->fetch_assoc()) :?>
													<option value="<?php echo $wilayah['kota_wilayah']; ?>">
														<?php echo $wilayah['kota_wilayah']; ?>
													</option>
												<?php endwhile; ?>
											</select>
										</div>
										<div class="col-sm-6">
											<label for="kodepos_toko">Kode Pos</label>
											<input type="number" class="form-control form-control-user" placeholder="Kode Pos" name="kodepos_toko" required="true" id="kodepos_toko">
										</div>
									</div>
									<!-- Deskripsi -->
									<div class="form-group">
										<label for="deskripsi_toko">Deskripsi Toko</label>
										<textarea class="form-control form-control-user" rows="3" id="deskripsi_toko" name="deskripsi_toko"></textarea>
									</div>
									<!-- Catatan Toko -->
									<div class="form-group">
										<label for="catatan_toko">Catatan Toko</label>
										<textarea class="form-control form-control-user" rows="3" id="catatan_toko" name="catatan_toko"></textarea>
									</div>
									<!-- Foto -->
									<div class="form-group">
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="foto_toko" id="foto_toko" required="true">
											<label for="foto_toko" class="custom-file-label" >Foto Toko</label>
										</div>
									</div>
									<!-- Status Toko -->
									<div class="form-group row">
										<div class="col-sm-6">
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="status_toko" id="statusBuka" value="Buka">
												<label class="form-check-label" for="statusBuka">Buka</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="status_toko" id="statusTutup" value="Tutup">
												<label class="form-check-label" for="statusTutup">Tutup</label>
											</div>
										</div>
									</div>
								</form>
								<button type="button" class="btn btn-success btn-user btn-block" data-toggle="modal" data-target="#modalDaftarToko" name="btnTooglerModal" id="btnTooglerModal" value="">
									Daftar Toko
								</button>
							</div>
						</div>			
					</div>
				</div>
			</div>
		</div>
		<!-- Check for button submit -->
		<?php
		if (isset($_POST['btnSubmitRegister'])) {
			$id_toko = $_SESSION['penjual']['id_penjual'];
			$nama_toko = $_POST['nama_toko'];
			$alamat_toko = $_POST['alamat_toko'];
			$kota_toko = $_POST['kota_toko'];
			$provinsi_toko = $_POST['provinsi_toko'];
			$queryGetIDWilayah = "SELECT id_wilayah FROM wilayah WHERE provinsi_wilayah = '$provinsi_toko' AND kota_wilayah = '$kota_toko'";
			$get = $koneksi->query($queryGetIDWilayah);
			$id_wilayah = $get->fetch_assoc();
			$id_wilayah = $id_wilayah['id_wilayah'];
			$kodepos_toko = $_POST['kodepos_toko'];
			$deskripsi_toko = $_POST['deskripsi_toko'];
			$catatan_toko = $_POST['catatan_toko'];
			$status_toko = $_POST['status_toko'];
			if ($status_toko==NULL) {
				$status_toko = "Buka";
			}
			//1. cek validasi foto
			//Cek jika user menginputkan perubahan terhadap foto profil
			$foto_toko = $_FILES['foto_toko']['name'];
			$lokasi_foto = $_FILES['foto_toko']['tmp_name'];
			//mendapatkan tipe data file yang diinputkan user berupa jpg/jpeg/png
			$tipefoto_toko = explode('.', $foto_toko);
			$tipefoto_toko = end($tipefoto_toko);
			$tipefoto_toko =strtolower($tipefoto_toko);
			//ukuran foto yang diupload
			$size_fotoToko = $_FILES['foto_toko']['size'];
			$destination = "../assets/img/toko/".$foto_toko;
			$extensions= array("jpeg","jpg","png");
			//cek ekstensi file dan ukuran foto yang diinputkan user
			if ($foto_toko!=null) {
				if (in_array($tipefoto_toko, $extensions)==false) {
					$errors="Silahkan masukan format foto (jpg/jpeg/png)";
				}
			}elseif ($size_fotoToko>2097152) {
				$errors="Silahkan upload gambar < 2 MB";
			}
			//Jika pada foto tidak ada error
			if (empty($errors)==true && isset($_POST['btnSubmitRegister'])) {
				// Cek ke tabel toko apakah id_toko yang akan didaftarkan belum ada atau sudah ada berdasarkan id_penjual
				//query dari tabel toko
				$query = "SELECT * FROM toko WHERE id_toko = $id_toko";
				$sqlResult = $koneksi->query($query);
				if ($sqlResult->num_rows>0) {
					//tidak boleh mendaftar karena toko sudah ada sebelumnya
					echo "<script>
					alert('Tokomu sudah ada!');
					</script>";
				}else{
					// BOLEH MENDAFTAR
					//Upload foto ke direktori
					move_uploaded_file($lokasi_foto, $destination);
					$query = "INSERT INTO toko VALUES('$id_toko','$nama_toko', '$alamat_toko','$kota_toko','$provinsi_toko','$kodepos_toko', '$deskripsi_toko','$catatan_toko','$status_toko','$foto_toko','$id_wilayah')";
					if ($koneksi->query($query)>0) {
						$_SESSION['penjual']['id_toko'] = $id_toko;
						echo "<script>
						Swal.fire({
							title: 'BERHASIL REGISTRASI TOKO',
							icon:'success',
							text: 'Tokomu berhasil didaftarkan yaa..',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'OK'
							}).then((result) => {
								document.location.href = 'index.php?page=Dashboard';
							})</script>";
						}else{
							echo "<script>
							Swal.fire({
								title: 'TOKO GAGAL DIDAFTARKAN',
								icon:'warning',
								text: 'Opss Toko Gagal didaftarkan!',
								showCancelButton: false,
								confirmButtonColor: '#d33',
								cancelButtonColor: '#d33',
								confirmButtonText: 'OK'
								}).then((result) => {
									document.location.href = 'index.php?page=Registrasi Toko';
								})</script>";
							}
						}
					}
				}
				?>
				<!-- Modal Button Toogle Daftar Toko Ditekan -->
				<div class="modal fade" id="modalDaftarToko" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalDaftarTokoLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="modalDaftarTokoLabel">Konfirmasi Daftar Toko</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								Data yang dimasukan sudah benar? Tekan 'Daftar' jika sudah!
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
								<form method="post" action="index.php?page=Registrasi Toko">
									<button class="btn btn-success btn-user  btn-block" name="btnSubmitRegister" type="submit"form="formRegisterToko" value="" id="btnSubmitRegister" >
										Daftar
									</button>	
								</form>
							</div>
						</div>
					</div>
				</div>
