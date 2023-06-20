<?php
//query informasi toko dari tabel toko berdasarkan id_toko $_SESSION penjual
$id_toko = $_SESSION['penjual']['id_toko'];
if ($id_toko == 0) {
	//tidak ada toko atau sudah dihapus sebelumnya
	//beri peringatan
	echo "<script>
	Swal.fire({
		title: 'Anda Belum Punya Toko!!',
		icon:'warning',
		text: 'Registrasi Dulu yaa..',
		showCancelButton: false,
		confirmButtonColor: 'danger',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Registrasi'
		}).then((result) => {
			document.location.href = 'index.php?page=Dashboard';
		})</script>";
		exit;
	}else{
		$query = "SELECT * FROM toko WHERE id_toko = '$id_toko'";
		$sqlResult = $koneksi->query($query);
		$toko = $sqlResult->fetch_assoc();
		$nama_fotoTokoLama = $toko['foto_toko'];
	}

	?>
	<div class="container-fluid mt-4 mb-4">
		<div class="card shadow mb-3">
			<img src="../assets/img/toko/<?php echo $toko['foto_toko']; ?>" class=" card-img-top mr-auto ml-auto"  width="100%" height="345">
			<div class="card-body">
				<h5 class="card-title">
					<?php echo $toko['nama_toko']; ?> 
				</h5>
				<h6 class="text-muted" aria-described="status_toko_help">
					[<?php echo $toko['status_toko']; ?>]
					<small id="status_toko_help" class="form-text text-muted">
						Status ini terlihat pelanggan
					</small>
				</h6>	
				<p style="height: 1rem;"></p>
				<div class="container">
					<form class="form-group" method="post" action="index.php?page=Informasi Toko" enctype="multipart/form-data">
						<!-- Input ID Wilayah secara hidden -->
						<input type="hidden" name="id_wilayah" id="id_wilayah" value="<?php echo $toko['id_wilayah']; ?>">
						<!-- BARIS 1 -->
						<div class="row">
							<!-- KOLOM 1 -->
							<div class="col">
								<!-- Nama Toko -->
								<div class="form-group">
									<label>Nama Toko</label>
									<input type="text" name="nama_toko_InformasiToko" class="form-control" value="<?php echo $toko['nama_toko']; ?>" required="true" id="nama_toko">
								</div>
								<!-- Deskripsi Toko -->
								<div class="form-group">
									<label>Deskripsi Toko</label>
									<textarea name="deskripsi_toko_InformasiToko" class="form-control" rows="5" id="deskripsi_toko" value="<?php echo $toko['deskripsi_toko']; ?>"><?php echo $toko['deskripsi_toko']; ?></textarea>
								</div>
								<!-- Catatan -->
								<div class="form-group">
									<label>Catatan</label>
									<textarea name="catatan_toko_InformasiToko" class="form-control" rows="5" required="true" id="catatan_toko" value="<?php echo $toko['catatan_toko']; ?>"><?php echo $toko['catatan_toko']; ?></textarea>
								</div>
							</div>
							<!-- KOLOM 2 -->
							<div class="col">
								<!-- Lokasi Toko -->
								<div class="form-group">
									<label>Alamat</label>
									<textarea name="alamat_toko_InformasiToko" required="true" id="alamat_toko" class="form-control" rows="3" required="true" value="<?php echo $toko['alamat_toko']; ?>"><?php echo $toko['alamat_toko']; ?></textarea>
								</div>
								<!-- Provinsi dan Kota Toko -->
								<div class="form-group row">
									<div class="col-sm-4 mb-3 mb-sm-0">
										<label>Provinsi</label>
										<input type="text" name="provinsi_toko_InformasiToko" required="true" id="provinsi_toko_InformasiToko" class="form-control" value="Bali" aria-describedby="provinsi_toko_help">
										<small id="provinsi_toko_help" class="form-text text-muted">Sementara hanya berlaku di Bali</small>
									</div>
									<div class="col-sm-4 mb-3 mb-sm-0">
										<label>Kab/Kota</label>
										<input type="text" name="kota_toko_InformasiToko" id="kota_toko_InformasiToko" class="form-control" value="<?php echo $toko['kota_toko']; ?>" readonly="true" >
									</div>
									<div class="col-sm-4 mb-3 mb-sm-0">
										<label for="kota_toko">Kabupaten/Kota</label>
										<!-- Query dari tabel wilayah -->
										<?php
										$queryWilayah = "SELECT * FROM wilayah";
										$getData = $koneksi->query($queryWilayah);
										?>
										<select class="form-control" id="wilayah_kota_toko_InformasiToko" name="wilayah_kota_toko_InformasiToko" aria-describedby="kota_toko_baru">
											<option value="">-Pilih Kabupaten/Kota</option>
											<?php while ( $wilayah = $getData->fetch_assoc()) :?>
												<option value="<?php echo $wilayah['kota_wilayah']; ?>">
													<?php echo $wilayah['kota_wilayah']; ?>
												</option>
											<?php endwhile; ?>
										</select>
										<small id="kota_toko_baru" class="form-text text-muted">Ubah nama kabupaten/kota</small>
									</div>
								</div>
								<!-- Kodepos Toko -->
								<div class="form-group">
									<label>Kode Pos</label>
									<input type="number" name="kodepos_toko_InformasiToko" required="true" id="kodepos_toko_InformasiToko" class="form-control" value="<?php echo $toko['kodepos_toko']; ?>" >
								</div>
								<!-- Foto Toko -->
								<div class="form-group">
									<div class="custom-file mt-2">
										<input type="file" class="custom-file-input" name="foto_toko_InformasiToko" id="foto_toko_InformasiToko">
										<label for="foto_toko_InformasiToko" class="custom-file-label" >Foto Toko</label>
									</div>
								</div>
								<!-- Status Toko -->
								<div class="form-group row">
									<div class="col-sm-2 mb-3">
										<div class="form-check form-check-inline">
											<input type="hidden" name="status_toko_InformasiToko" value="<?php echo $toko['status_toko']; ?>">
											<input class="form-check-input" type="radio" id="status_tokoBuka" value="Buka" name="status_toko_InformasiToko">
											<label class="form-check-label" for="status_tokoBuka">Buka</label>
										</div>
									</div>
									<div class="col-sm-2 mb-3">
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" id="status_tokoTutup" value="Tutup" name="status_toko_InformasiToko">
											<label class="form-check-label" for="status_tokoTutup">Tutup</label>
										</div>
									</div>
									<div class="col-sm-4 mb-3">
										<button type="button" class="btn btn-secondary btn-sm btn-user btn-block" data-toggle="modal" data-target="#modalSimpanInformasiToko" name="btnTooglerSimpanInformasiToko" id="btnTooglerSimpanInformasiToko" value="">
											Simpan Informasi
										</button>
										<!-- Modal Button Toogle Daftar Toko Ditekan -->
										<div class="modal fade" id="modalSimpanInformasiToko" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalSimpanInformasiTokoLabel" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="modalSimpanInformasiTokoLabel">Konfirmasi Ubah Informasi</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														Data yang dimasukan sudah benar? Tekan 'Simpan' jika sudah!
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
														<button class="btn btn-success btn-user" name="buttonEditInformasiToko" type="submit"  value="" id="buttonEditInformasiToko" >
															Simpan
														</button>	
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>	
							</div>
						</div>
					</form>
				</div>
				<form method="post" action="index.php?page=Informasi Toko">
					<div class="row">
						<div class="col-md-2">
							<button type="button" class="btn btn-danger btn-sm btn-user btn-block" data-toggle="modal" data-target="#modalHapusToko" name="btnTooglerHapusToko" id="btnTooglerHapusToko" value="">
								Hapus Toko
							</button>
							<!-- Modal Button Toogle Daftar Toko Ditekan -->
							<div class="modal fade" id="modalHapusToko" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalHapusTokoLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="modalHapusTokoLabel">Konfirmasi Hapus Toko</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<p class="card-text ">
												Yakin ingin hapus toko ini? 
											</p>
											<p class="card-text">
												Anda <strong>tidak dapat mengembalikan informasi</strong> yang ada!
											</p>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
											<button class="btn btn-danger btn-user" name="buttonHapusToko" type="submit"  value="" id="buttonHapusToko" >
												Hapus
											</button>	
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Cek Jika buttonHapus TOko DItekan -->
	<?php
	if (isset($_POST['buttonHapusToko'])) {
			//confirm answer is YES
		$id_toko = $_SESSION['penjual']['id_toko'];
		$query = "DELETE FROM toko WHERE id_toko = '$id_toko'";
		$runSQL = $koneksi->query($query);
		$_SESSION['penjual']['id_toko']=0;
		if ($runSQL==true) {
			echo "<script>
			Swal.fire({
				title: 'Toko Berhasil Dihapus!!',
				icon:'success',
				text: 'Tokomu berhasil dihapus yaa..',
				showCancelButton: false,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'OK'
				}).then((result) => {
					document.location.href = 'index.php?page=Dashboard';
				})</script>";
			}
		}
		?>
		<?php
//cek jika tombol edit ditekan
		if (isset($_POST['buttonEditInformasiToko'])) {
				//update data
			$nama_toko = $_POST['nama_toko_InformasiToko'];
			$alamat_toko = $_POST['alamat_toko_InformasiToko'];
			$provinsi_toko = $_POST['provinsi_toko_InformasiToko'];
			$kodepos_toko = $_POST['kodepos_toko_InformasiToko'];
			$deskripsi_toko = $_POST['deskripsi_toko_InformasiToko'];
			$catatan_toko = $_POST['catatan_toko_InformasiToko'];
			$status_toko = $_POST['status_toko_InformasiToko'];
			$id_wilayah = $_POST['id_wilayah'];
			$kota_toko = $_POST['kota_toko_InformasiToko'];
				// Jika terjadi perubahan pada daerah kota toko ini
			if ($_POST['wilayah_kota_toko_InformasiToko']!=null) {
					//
				$kota_toko = $_POST['wilayah_kota_toko_InformasiToko'];
				$queryGetIDWilayah = "SELECT id_wilayah FROM wilayah WHERE provinsi_wilayah = '$provinsi_toko' AND kota_wilayah = '$kota_toko'";
				$getData = $koneksi->query($queryGetIDWilayah);
				$id_wilayah = $getData->fetch_assoc();
				$id_wilayah = $id_wilayah['id_wilayah'];
			}

		//nama foto yang diupload
		$nama_fotoToko = $_FILES['foto_toko_InformasiToko']['name']; //yang diinputkan
		if ($nama_fotoToko==null) {
			//ganti dengan yang sebelumnya
			$nama_fotoToko = $nama_fotoTokoLama;
		}
			//mendapatkan tipe data file yang diinputkan user berupa jpg/jpeg/png
		$tipe_fotoToko = explode('.', $nama_fotoToko);
		$tipe_fotoToko = end($tipe_fotoToko);
		$tipe_fotoToko =strtolower($tipe_fotoToko);
			//lokasi foto
		$lokasi_fotoToko = $_FILES['foto_toko_InformasiToko']['tmp_name'];
		$destination = "../assets/img/toko/".$nama_fotoToko;
			//ukuran foto yang diupload
		$size_fotoToko = $_FILES['foto_toko_InformasiToko']['size'];
			//daftar ekstensi file yang diperbolehkan
		$extensions= array("jpeg","jpg","png");
		//cek ekstensi file dan ukuran foto yang diinputkan user
		if ($nama_fotoToko!=null) {
			if (in_array($tipe_fotoToko, $extensions)==false) {
				$errors="Silahkan masukan format foto (jpg/jpeg/png)";
			}
		}
		if ($size_fotoToko>2097152) {
			$errors="Silahkan upload gambar < 2 MB";
		}
			// <!-- Cek pesan error apakah ada error atau tidak -->

			// <!-- Jika ga ada error -->
		if (empty($errors)==true) {
				//Upload foto ke direktori
			move_uploaded_file($lokasi_fotoToko, $destination); 
				// Update query ke dalam tabel penjual
			$queryupdate = "UPDATE toko SET nama_toko = '$nama_toko', alamat_toko = '$alamat_toko', kota_toko = '$kota_toko', provinsi_toko = '$provinsi_toko', kodepos_toko = '$kodepos_toko', deskripsi_toko = '$deskripsi_toko', catatan_toko = '$catatan_toko', status_toko = '$status_toko', foto_toko = '$nama_fotoToko', id_wilayah = '$id_wilayah' WHERE id_toko = '$id_toko'";
			$runQuery = $koneksi->query($queryupdate);
			if ($runQuery==true) {
				if ($runQuery==true) {
					//data berhasil diupdate
					echo "<script>
					Swal.fire({
						title: 'UPDATE BERHASIL',
						icon:'success',
						text: 'Data berhasil diubah yang baru yaa...',
						showCancelButton: false,
						confirmButtonColor: '#5661C5',
						cancelButtonColor: '#d33',
						confirmButtonText: 'OK'
						}).then((result) => {
							document.location.href = 'index.php?page=Informasi Toko';
						})</script>";
					}else{
						echo "<script>
						alert('Data GAGAL diubah!');</script>";
						echo ' <meta http-equiv="refresh" content="1;url=index.php?page=Informasi Toko">';
					}
				}
			}
		}
		?>
