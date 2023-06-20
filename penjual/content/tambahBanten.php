<div class="container-fluid mt-4 mb-4">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header">
						<h5 class="">Data Informasi Banten</h5>
					</div>
					<div class="card-body">
						<div class="jumbotron">
							<h1 class="display-4">Lengkapi Informasi</h1>
							<!-- Data Informasi Banten -->
							<form method="post" action="index.php?page=Tambah Banten" enctype="multipart/form-data">
								<div class="row ">
									<div class="col mt-2">
										<!-- Nama Banten -->
										<div class="form-group">
											<label for="nama_banten">Nama Banten</label>
											<input type="text" class="form-control" id="nama_banten" autofocus="true" name="nama_banten" value="" required="true">
										</div>
										<!-- Kategori Banten -->
										<div class="form-group">
											<!-- Query dari tabel kategoriBanten -->
											<?php
											$query = "SELECT * FROM kategoriBanten WHERE id_toko = $id_toko";
											$sqlResult = $koneksi->query($query);
											$array_kategoriBanten = array();
											?>
											<label for="kategori_banten">Kategori Banten</label>
											<select class="form-control" id="kategori_banten" name="kategori_banten" aria-describedby="kategori_banten">
												<option value="null">-kategori-</option>
												<?php while ($kategoriBanten = $sqlResult->fetch_assoc()):?>
													<!-- Memasukan nama kategori dari hasil query ke dalam array untuk dicocokkan pada tahap selanjutnya -->
													<?php $array_kategoriBanten[] = $kategoriBanten['nama_kategori']; ?>
													<option value="<?php echo $kategoriBanten['id_kategori']; ?>"><?php echo $kategoriBanten['nama_kategori']; ?></option>
												<?php endwhile ?>
											</select>
											<small id="kategori_banten" class="form-text text-muted">*Tekan tombol di bawah jika kategori tidak ada</small>
										</div>
										<!-- Button kategori_banten added -->
										<div class="row mt-2 mb-2">
											<div class="col">
												<div class="pos-f-t">
													<div class="collapse" id="tooglerTambahKategoriBaru">
														<div class="bg-light p-4">
															<div class="form-group">
																<input type="text" class="form-control" id="tambah_kategoriBanten" placeholder="Kategori Baru" value="" name="tambah_kategoriBanten" >
															</div>
														</div>
													</div>
													<nav class="navbar navbar-light bg-light">
														<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#tooglerTambahKategoriBaru" aria-controls="tooglerTambahKategoriBaru" aria-expanded="false" aria-label="Toggle navigation">
															<span class="navbar-toggler-icon"></span>
														</button>
													</nav>
												</div>
											</div>
										</div>
										<!-- Deskripsi Banten -->
										<div class="form-group">
											<label for="deskripsi_banten">Deskripsi Banten</label>
											<textarea class="form-control" id="deskripsi_banten" rows="3" name="deskripsi_banten" required="true"></textarea>
										</div>
										<!-- Kelengkapan Banten -->
										<div class="form-group">
											<label for="kelengkapan_banten">Kelengkapan Banten</label>
											<textarea class="form-control" id="kelengkapan_banten" rows="5" name="kelengkapan_banten" required="true"></textarea>
										</div>
										<!-- Foto Toko -->
										<div class="form-group">
											<div class="custom-file mt-2">
												<input type="file" class="custom-file-input" name="foto_banten" id="foto_banten" required="true">
												<label for="foto_banten" class="custom-file-label" >Foto Banten</label>
											</div>
										</div>
									</div>
								</div>
								<!-- Button Added -->
								<div class="row">
									<div class="col-md-4">
										<a class="btn btn-warning btn-block" href="#" role="button" name="btnKembali">Dashboard</a>
									</div>
									<div class="col-md-4 ml-auto">
										<button type="button" class="btn btn-success btn-block " data-toggle="modal" data-target="#modalTambahBanten" name="btnTooglerTambahBanten" id="btnTooglerTambahBanten" value="">
											Tambah
										</button>
										<!-- Modal Button Toogle Daftar Toko Ditekan -->
										<div class="modal fade" id="modalTambahBanten" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalTambahBantenLabel" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="modalTambahBantenLabel">Konfirmasi Tambah Banten</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														Data yang dimasukan sudah benar? Tekan 'Simpan' jika sudah!
														<br>
														Anda dapat memperbaharui data pada bagian <strong>Etalase</strong>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
														<button class="btn btn-success btn-user" name="btnSubmitInformasiBanten" type="submit"  value="" id="btnSubmitInformasiBanten" >
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
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
if (isset($_POST['btnSubmitInformasiBanten'])) {
	if (($_POST['kategori_banten']=="null" && empty($_POST['tambah_kategoriBanten'])) || ($_POST['kategori_banten']!="null" && !empty($_POST['tambah_kategoriBanten']))) {
		//beri alert karena keduanya tidak boleh null atau keduanya tidak boleh bersamaan berisi
		echo "<script>
		Swal.fire({
			title: 'OOPS...',
			icon:'warning',
			text: 'Pilih kategori atau isi kategori baru ya.. Tidak boleh bersamaan!',
			showCancelButton: false,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ganti Kategori'
			}).then((result) => {
				if (result.value) {
					document.location.href = 'index.php?page=Tambah Banten';
				}
			})</script>"; 
		}else{
		//jika tambah_kategoriBanten isi berarti insert data baru ke dalam tabel kategoriBanten untuk menentukan id_kategoriBanten
			if (!empty($_POST['tambah_kategoriBanten'])) {
				$kategori_banten = $_POST['tambah_kategoriBanten'];
			//cocokan dengan array_kategoriBanten yang sudah ada siapa tahu user jail menginputkan kategori yang sama
				if (in_array($kategori_banten, $array_kategoriBanten)) {
				//beri peringatan kalau kategori tersebut sudah ada di dalam tabel kategori banten
					echo "<script>
					Swal.fire({
						title: 'OOPS...',
						icon:'warning',
						text: 'Kategori tersebut sudah ada ya!!',
						showCancelButton: false,
						confirmButtonColor: '#d33',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Ganti Kategori'
						}).then((result) => {
							if (result.value) {
								document.location.href = 'index.php?page=Tambah Banten';
							}
						})</script>"; 
					}else{
				//insert data baru ke dalam tabel kategori Banten
				//query data baru ke tabel kategori banten sesuai id_toko
						$query = "INSERT INTO kategoriBanten VALUES('','$kategori_banten','$id_toko')";
						$koneksi->query($query);
				//dapatkan id_kategori dari data yang baru diinputkan barusan
						$query = "SELECT id_kategori FROM kategoriBanten WHERE nama_kategori = '$kategori_banten' AND id_toko='$id_toko'";
						$sqlResult = $koneksi->query($query);
						$kategori_banten = $sqlResult->fetch_assoc();
						$kategori_banten = $kategori_banten['id_kategori'];
					}

				}
				if ($_POST['kategori_banten']!="null") {
					$kategori_banten = $_POST['kategori_banten'];
				}
				$nama_banten = $_POST['nama_banten'];
				$deskripsi_banten = $_POST['deskripsi_banten'];
				$kelengkapan_banten = $_POST['kelengkapan_banten'];
				$foto_banten = $_FILES['foto_banten']['name'];
		//mendapatkan tipe data file yang diinputkan user berupa jpg/jpeg/png
				$tipefoto_banten = explode('.', $foto_banten);
				$tipefoto_banten = end($tipefoto_banten);
				$tipefoto_banten =strtolower($tipefoto_banten);
				$lokasi_foto = $_FILES['foto_banten']['tmp_name'];
					$size_fotoBanten = $_FILES['foto_banten']['size'];//size foto yang diperbolehkan
		// upload foto
					$destination = "../assets/img_banten/fullsize/".$foto_banten;
					$extensions= array("jpeg","jpg","png");
					$errors=array();
		//cek ekstensi apakah sesuai atau tidak
					if (in_array($tipefoto_banten, $extensions)==false) {
						$errors[]="Silahkan masukan format foto (jpg/jpeg/png)";
					}
					if($size_fotoBanten>2097152) {
						$errors[]="Silahkan upload gambar < 2 MB";
					}
					if (empty($errors)==true) {
			//upload foto yang baru ke dalam assets/img
						move_uploaded_file($lokasi_foto, $destination);
			//query ke dalam tabel banten
						$query = "INSERT INTO banten VALUES('','$kategori_banten','$id_toko','$nama_banten','$deskripsi_banten','$kelengkapan_banten','$foto_banten')";
			//cek koneksi query apakah berhasil atau tidak
						if ($koneksi->query($query)>0) {
				//sukses menambahkan banten baru ke dalam tabel banten
							echo "<script>
							Swal.fire({
								title: 'BERHASIL MENAMBAHKAN!',
								icon:'success',
								text: 'Berhasil menambah daftar bantenmu...',
								showCancelButton: false,
								confirmButtonColor: '#4BB543',
								cancelButtonColor: '#d33',
								confirmButtonText: 'OK'
								}).then((result) => {
									document.location.href = 'index.php?page=Tambah Banten';
								})</script>";
							}else{
				//gagal menambahkan banten ke dalam tabel banten, coba cek kesalahan yang ada
				//gagal
								echo "<script>
								Swal.fire({
									title: 'GAGAL MENAMBAHKAN!',
									icon:'warning',
									text: 'Terjadi kesalahan dalam menambahkan...',
									showCancelButton: false,
									confirmButtonColor: '#d33',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Cek'
									}).then((result) => {
										document.location.href = 'index.php?page=Tambah Banten';
									})</script>";
								}
							}else{
			//beri alert pesan kesalahan
			//ada kesalahan baik format atau ukuran
								echo "<script>
								Swal.fire({
									title: 'OOPS...',
									icon:'warning',
									text: 'Cek format atau size gambar ya...',
									showCancelButton: false,
									confirmButtonColor: '#d33',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Perbaiki'
									}).then((result) => {
										document.location.href = 'index.php?page=Tambah Banten';
									})</script>";
								}
							}
						}
						?>
