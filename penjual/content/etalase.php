<?php
require_once 'templates_dashboard/header.php';
if (isset($_POST['search'])) {
	$_SESSION['search'] = $_POST['search'];
	$bantenDicari = $_SESSION['search'];
	// Query untuk mengetahui apakah pembeli pernah menginputkan banten baru ke dalam etalase atau tidak dan jika ada nama banten yang dicari
	$query = "SELECT * FROM banten INNER JOIN kategoribanten ON banten.id_kategori=kategoribanten.id_kategori WHERE banten.id_toko = '$id_toko' AND  (banten.nama_banten LIKE '%$bantenDicari%' OR kategoribanten.nama_kategori LIKE '%$bantenDicari%')";
	$jalankanQuery = $koneksi->query($query);
}else{
	if (isset($_POST['btnTampilkanPerKategoriBanten'])) {
		if ($_POST['kategori_banten']=="null" || $_POST['kategori_banten'] == "all") {
			unset($_SESSION['search']);
		}
	}
		// Query untuk mengetahui apakah pembeli pernah menginputkan banten baru ke dalam etalase 
	$query = "SELECT * FROM banten INNER JOIN kategoribanten ON banten.id_kategori=kategoribanten.id_kategori WHERE banten.id_toko = '$id_toko'";
	$jalankanQuery = $koneksi->query($query);

}
?>
<?php
if ($jalankanQuery->num_rows==0 && isset($_POST['search'])) {
	echo "<script>
	Swal.fire({
		title: 'TIDAK DITEMUKAN',
		icon:'warning',
		text: 'Banten yang dicari tidak ditemukan',
		showCancelButton: false,
		confirmButtonColor: '#4BB543',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Kembali'
		}).then((result) => {
			document.location.href = 'index.php?page=Etalase Toko';
		})</script>";
		unset($_SESSION['search']);
		exit;
	}elseif ($jalankanQuery->num_rows==0 && !isset($_POST['search'])) {
		echo "<script>
		Swal.fire({
			title: 'Masih Kosong',
			icon:'warning',
			text: 'Yuk tambah barang daganganmu!',
			showCancelButton: false,
			confirmButtonColor: '#4BB543',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Tambah Banten'
			}).then((result) => {
				document.location.href = 'index.php?page=Tambah Banten';
			})</script>";
			exit;
		}

		?>
		<div class="container-fluid">
			<div class="card mt-2 mb-4 shadow-lg">
				<h1 class="display-4 card-header">Etalase Toko</h1>
				<div class="card-body">
					<form method="post" action="index.php?page=Etalase Toko">
						<div class="row">
							<div class="col-md-2">
								<!-- Kategori Banten -->
								<div class="form-group">
									<!-- Query dari tabel kategoriBanten -->
									<?php
									$query = "SELECT id_kategori,nama_kategori FROM kategoriBanten WHERE id_toko = $id_toko";
									$sqlResult = $koneksi->query($query);
									?>
									<select class="form-control" id="kategori_banten" name="kategori_banten" aria-describedby="kategori_banten">
										<option value="null">-kategori-</option>
										<?php while ($kategoriBanten = $sqlResult->fetch_assoc()):?>
											<!-- Memasukan nama kategori dari hasil query ke dalam array untuk dicocokkan pada tahap selanjutnya -->
											<?php $array_kategoriBanten[] = $kategoriBanten['nama_kategori']; ?>
											<option value="<?php echo $kategoriBanten['id_kategori']; ?>"><?php echo $kategoriBanten['nama_kategori']; ?></option>
										<?php endwhile ?>
										<option value="all">Semua Kategori</option>
									</select>
								</div>
							</div>
							<div class="col-ml-3">
								<button type="submit" class="btn btn-outline-success" name="btnTampilkanPerKategoriBanten" id="btnTampilkanPerKategoriBanten">Tampilkan</button>
							</div>
						</div>
					</form>
					<!-- Daftar Banten yang sudah diupload -->
					<div class="row mt-2 mb-2">
						<!-- Start Pagination in Page -->
						<div class="col">
							<section class="konten">
								<div class="container">
									<div class="row">
										<!-- Lakukan perulangan col-md3 dengan php agar kekanan -->
										<?php
									//cek apakah ada $_POST['search'] banten dicari
										if (isset($_SESSION['search'])) {
											$bantenDicari = $_SESSION['search'];
										//jika menekan tampilkan per kategori banten
											if (isset($_POST['btnTampilkanPerKategoriBanten'])) {
												$kategori_banten = $_POST['kategori_banten'];
												if ($kategori_banten=="null" || $kategori_banten=="all") {
													$queryBantenEtalase = "SELECT * FROM banten INNER JOIN kategoribanten ON banten.id_kategori=kategoribanten.id_kategori WHERE banten.id_toko = '$id_toko' AND (banten.nama_banten LIKE '%$bantenDicari%' OR kategoribanten.nama_kategori LIKE '%$bantenDicari%') ";
													$jalankanQuery = $koneksi->query($queryBantenEtalase);
													unset($_SESSION['search']);
												}else{
													$queryBantenEtalase = "SELECT * FROM banten INNER JOIN kategoribanten ON banten.id_kategori=kategoribanten.id_kategori WHERE banten.id_toko = '$id_toko' AND banten.id_kategori='$kategori_banten' AND (banten.nama_banten LIKE '%$bantenDicari%' OR kategoribanten.nama_kategori LIKE '%$bantenDicari%')";
													$jalankanQuery = $koneksi->query($queryBantenEtalase);
												}
											}
										//jika tidak menekan per kategori bantennya
											else{
												$queryBantenEtalase = "SELECT * FROM banten INNER JOIN kategoribanten ON banten.id_kategori=kategoribanten.id_kategori WHERE banten.id_toko = '$id_toko' AND (banten.nama_banten LIKE '%$bantenDicari%' OR kategoribanten.nama_kategori LIKE '%$bantenDicari%')";
												$jalankanQuery = $koneksi->query($queryBantenEtalase);
											}
										}
									// Jika tidak ada banten dicari
										else{
									// Tangkap kategori banten yang dipilih
											if (isset($_POST['btnTampilkanPerKategoriBanten'])) {
												$kategori_banten = $_POST['kategori_banten'];
												if ($kategori_banten=="null" || $kategori_banten=="all") {
										//beri peringatan tidak ada yang ditampilkan
													$queryBantenEtalase = "SELECT * FROM banten INNER JOIN kategoribanten ON banten.id_kategori=kategoribanten.id_kategori WHERE banten.id_toko = '$id_toko'";
													$jalankanQuery = $koneksi->query($queryBantenEtalase);
												}else{
										//do query from tabel banten
													$queryBantenEtalase = "SELECT * FROM banten INNER JOIN kategoribanten ON banten.id_kategori=kategoribanten.id_kategori WHERE banten.id_toko = '$id_toko' AND banten.id_kategori='$kategori_banten'";
													$jalankanQuery = $koneksi->query($queryBantenEtalase);
												}
											}else{
												$queryBantenEtalase = "SELECT * FROM banten INNER JOIN kategoribanten ON banten.id_kategori=kategoribanten.id_kategori WHERE banten.id_toko = '$id_toko' ";
												$jalankanQuery = $koneksi->query($queryBantenEtalase);
											}
										}

										?>
										<?php if (isset($_POST['btnTampilkanPerKategoriBanten']) || !empty($jalankanQuery)): ?>
										<!-- START SLIDER -->
										<!-- START OUTER -->
										<?php 
										$slider=0;
										$banyakSlider = $jalankanQuery->num_rows; 
										?>
										<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
											<ol class="carousel-indicators">
												<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active bg-dark"></li>
												<?php for ($i=1; $i <$banyakSlider ; $i++) : ?>
													<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i ?>" class="bg-dark"></li>
												<?php endfor; ?>
											</ol>
											<div class="carousel-inner">
												<!-- START WHILE -->
												<?php while($data=$jalankanQuery->fetch_assoc()):?>
													<?php $foto_banten = $data['foto_banten']; ?>
													<?php if ($slider==0): ?>
														<div class="carousel-item active">
															<?php else: ?>
																<div class="carousel-item ">
																<?php endif ?>
																<!-- START CONTENT PER ITEM -->
																<div class="col-md-8 mb-3">
																	<div class="card" style="width: 30rem;">
																		<img class="card-img-top" src="<?php echo BASEURL ?>assets/img_banten/fullsize/<?php echo $data['foto_banten'] ?>" alt="Card image cap">
																		<div class="card-body">
																			<h5 class="card-title text-center" style="height: 1rem;">
																				<?php echo $data['nama_banten']; ?>
																			</h5>
																			<p class="card-text">
																				<h5 class="card-title text-center"><?php echo "[".$data['nama_kategori']."]"; ?></h5>
																			</p>
																			<ul class="list-group list-group-flush" style="height: 1rem;">
																				<li class="list-group-item mb-2" style="height: 20rem;">
																					<h6 class="card-subtitle mb-2 text-muted" >Deskripsi Barang</h6>
																					<p class="card-text" style="height: 10rem;">
																						<?php echo $data['deskripsi_banten'];?>
																					</p>
																				</li>
																				<li class="list-group-item mb-2" style="height: 20rem;">
																					<h6 class="card-subtitle mb-2 text-muted" >Kelengkapan Barang</h6>
																					<?php echo $data['kelengkapan_banten']; ?>
																				</li>
																			</ul>
																			<p style="height: 25rem;"></p>
																			<!-- Ubah Kategori Field -->
																			<form method="post" action="index.php?page=Etalase Toko">
																				<!-- Passing id_banten dengan method post -->
																				<input type="hidden" name="id_banten" value="<?php echo $data['id_banten']; ?>">
																				<!-- Tulisan -->
																				<div class="row">
																					<div class="col">
																						<label for="new_kategori_banten">Ubah Kategori</label>
																					</div>
																				</div>
																				<!-- Label Select -->
																				<div class="row ">
																					<div class="col-md-7">
																						<div class="form-group">
																							<!-- Query dari tabel kategoriBanten -->
																							<?php
																							$query = "SELECT id_kategori,nama_kategori FROM kategoriBanten WHERE id_toko = $id_toko";
																							$sqlResult = $koneksi->query($query);
																							?>
																							<select class="form-control" id="new_kategori_banten" name="new_kategori_banten" aria-describedby="new_kategori_banten">
																								<option value="">-kategori baru-</option>
																								<?php while ($kategoriBanten = $sqlResult->fetch_assoc()):?>
																									<!-- Memasukan nama kategori dari hasil query ke dalam array untuk dicocokkan pada tahap selanjutnya -->
																									<?php $array_kategoriBanten[] = $data['nama_kategori']; ?>
																									<option value="<?php echo $kategoriBanten['id_kategori']; ?>"><?php echo $kategoriBanten['nama_kategori']; ?></option>
																								<?php endwhile ?>
																							</select>
																							<small id="new_kategori_banten" class="form-text text-muted">*Abaikan jika tidak diganti</small>
																						</div>
																					</div>
																					<div class="col-md-5">
																						<div class="form-group">
																							<!-- Berikan nama button yang spesifik untuk setiap columnya agar setiap ditekan spesifik mengirimkan id_banten dan id_kategori yang diganti -->
																							<button type="submit" class="btn btn-primary" name="<?php echo $data['id_banten']; ?>" id="btnUbahKategoriBaru" value="">Ganti</button>
																							<!-- Cek jika tombol yang bersangkutan ditekan atau tidak -->
																							<?php
																							if (isset($_POST[$data['id_banten']])) {
																								$_POST['btnUbahKategoriBaru']['diubah'] = true;
																								$_POST['btnUbahKategoriBaru']['id_kategori'] = $_POST['new_kategori_banten'];
																								$_POST['btnUbahKategoriBaru']['id_banten'] = $data['id_banten'];
																							}
																							?>
																						</div>
																					</div>
																				</div>
																			</form>
																			<!-- Button Added Edit and Tambah INformasi -->
																			<form method="post" action="index.php?page=Etalase Toko">
																				<a href="index.php?page=Edit Informasi&id=<?php echo $data['id_banten']; ?>" class="btn btn-warning ">Edit</a>
																				<!-- inget isi konfirmasi hapus banten nya -->
																				<?php $stringButtonHapus = "buttonHapus".$data['id_banten']; ?>
																				<button class="btn btn-danger  mt-2 mb-2" type="submit" name="<?php echo $stringButtonHapus; ?>" id="<?php echo $stringButtonHapus; ?>" value="" onclick="confirmHapusBanten('<?php echo $stringButtonHapus; ?>','<?php echo $data['nama_banten']; ?>','<?php echo $data['id_banten']; ?>');">
																					Hapus 
																				</button>
																				<a href="index.php?page=Tambah Informasi&id=<?php echo $data['id_banten'] ?>" class="btn btn-primary ">Tambah Informasi</a>
																			</form>
																			<?php
																			if (isset($_POST[$stringButtonHapus])) {
																// Value dari button adalah id_banten sehingga jika 0 maka tidak dihapus, jika>0 hapus
																				if ($_POST[$stringButtonHapus]!=0) {
																					$id_banten = $_POST[$stringButtonHapus];
																	//query hapus banten
																					$queryDeleteBanten = "DELETE FROM banten WHERE id_banten='$id_banten'";
																					$runQuery = $koneksi->query($queryDeleteBanten);
																					if ($runQuery>0) {
																		//berhasil dihapus
																						echo "<script>
																						Swal.fire({
																							title: 'BANTEN DIHAPUS',
																							icon:'success',
																							text: 'Banten sudah dihapus ya!!',
																							showCancelButton: false,
																							confirmButtonColor: '#4BB543',
																							cancelButtonColor: '#d33',
																							confirmButtonText: 'Kembali'
																							}).then((result) => {
																								document.location.href = 'index.php?page=Etalase Toko';
																							})</script>";
																						}else{
																		//gagal dihapus
																						}
																					}
																				}
																				?>
																			</div>
																		</div>
																	</div>
																	<!-- END CONTENT PER ITEM -->
																</div>
																<?php  $slider++; ?>
															<?php endwhile ?>
															<!-- ENDWHILE -->
															<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
																<span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
																<span class="sr-only">Previous</span>
															</a>
															<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
																<span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
																<span class="sr-only">Next</span>
															</a>
														</div>
														<!-- END OUTER -->
														<!-- END SLIDER -->
													<?php endif ?>
													<!-- endwhile -->
												</div>
											</div>
										</section>
									</div>
									<!-- End Pagination -->
								</div>
								<div class="row mt-2 mb-2">

								</div>
							</div>
							<div class="card-footer text-muted">
								*Tambah informasi [tingkatan banten, harga, dan diskon] sebelum dijual!
							</div>
						</div>
					</div>
					<?php
					if (isset($_POST['btnUbahKategoriBaru'])) {
						if ($_POST['btnUbahKategoriBaru']['diubah'] == true) {
					$id_kategori = $_POST['btnUbahKategoriBaru']['id_kategori']; //kategori baru yang diubah user
					$id_banten = $_POST['btnUbahKategoriBaru']['id_banten'];
					//cek jika id_kategori tidak diinputkan tapi user jahil menekan tombol ubah kategori
					if ($id_kategori==NULL) {
					//beri peringatan bahwa harus menginputkan kategori baru kalau menekan tombol perubahan
					// BERI ALERT
						echo "<script>
						Swal.fire({
							title: 'INVALID INPUT',
							icon:'warning',
							text: 'Pilih kategori jika ingin mengubahnya!',
							showCancelButton: false,
							confirmButtonColor: '#d33',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Ubah'
							}).then((result) => {
								document.location.href = 'index.php?page=Etalase Toko';
							})</script>";
						}else{
					//query update ke tabel banten
							$query = "UPDATE BANTEN SET id_kategori = '$id_kategori' WHERE id_banten = '$id_banten'";
							if ($koneksi->query($query)==true) {
								echo "<script>
								Swal.fire({
									title: 'KATEGORI DIUBAH',
									icon:'success',
									text: 'Kategori berhasil diubah',
									showCancelButton: false,
									confirmButtonColor: '#4BB543',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Etalase'
									}).then((result) => {
										document.location.href = 'index.php?page=Etalase Toko';
									})</script>";
								}else{
									echo "<script>
									Swal.fire({
										title: 'KATEGORI GAGAL DIUBAH',
										icon:'warning',
										text: 'Kategori gagal diubah karena kendala program!',
										showCancelButton: false,
										confirmButtonColor: '#d33',
										cancelButtonColor: '#d33',
										confirmButtonText: 'Tutup'
										}).then((result) => {
											document.location.href = 'index.php?page=Etalase Toko';
										})</script>";
									}
								}
							}
						}
						?>

						<script language="javascript">
							function confirmHapusBanten(stringButton,namaBanten,idBanten){
								var returnValue=0;
								if (confirm('Yakin hapus '+namaBanten)) {
									document.getElementById(stringButton).value = idBanten;
								}else{
									document.getElementById(stringButton).value = returnValue;
								}
							}
						</script>

						<?php
						require_once 'templates_dashboard/footer.php';
						?>
