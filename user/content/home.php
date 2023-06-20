<?php
//Query dari tabel toko untuk mendapatkan informasi mengenai semua toko yang sudah terdaftar dan yang sudah punya banten siap jual
$query = "SELECT * FROM banten b INNER JOIN toko t ON b.id_toko = t.id_toko INNER JOIN detailbanten db ON db.id_banten = b.id_banten GROUP BY b.id_toko ";
$sqlResult = $koneksi->query($query);
if (isset($_POST['search'])) {
	$_GET['search'] = $_POST['search'];
	$bantenDicari = $_POST['search'];
}
$startSliderToko=0;
$banyakToko = $sqlResult->num_rows;
?>
<!-- START CONTENT | MAIN -->
<div class="container-fluid mt-3 mb-3 bg-light">
	<div class="row">
		<!-- START SLIDER -->
		<!-- START OUTER SLIDER -->
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active bg-dark"></li>
				<?php for ($i=1; $i <$startSliderToko ; $i++) :?>
					<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" class="bg-dark"></li>
				<?php endfor; ?>
			</ol>
			<div class="carousel-inner">
				<!-- START PERULANGAN TOKO -->
				<?php while($data = $sqlResult->fetch_assoc()): ?>
					<!-- START INNER SLIDER -->
					<?php if ($startSliderToko==0): ?>
						<div class="carousel-item active">
							<?php else: ?>
								<div class="carousel-item ">
								<?php endif ?>
								<div class="col">
									<div class="card shadow-lg mb-3 " id="<?php echo $data['id_toko']; ?>">
										<img src="<?php echo BASEURL; ?>assets/img/toko/<?php echo $data['foto_toko']; ?>" class="card-img-top"  style="max-height: 729px max-width:2186px; ">
										<div class="card-body">
											<div class="d-flex justify-content-between align-items-center">
												<div class="p-2 bd-highlight ">
													<nav class="navbar navbar-expand-lg navbar-light bg-light">
														<a class="navbar-brand" href="#">
															<h4 class="display-4">
																<?php echo $data['nama_toko']; ?>
															</h4>
														</a>
														<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarExpandToko" aria-controls="navbarExpandToko" aria-expanded="false" aria-label="Toggle navigation">
															<span class="navbar-toggler-icon"></span>
														</button>
														<div class="collapse navbar-collapse" id="navbarExpandToko">
															<ul class="navbar-nav ml-auto">
																<?php if (!isset($_GET['search'])): ?>
																	<form method="post" action="index.php?page=Home">
																		<?php else: ?>
																			<form method="post" action="index.php?page=Home&search=<?php echo $bantenDicari; ?>">
																			<?php endif ?>
																			<input type="hidden" value="<?php echo $data['id_toko']; ?>" name="id_toko">
																			
																			<div class="btn-group" role="group" aria-label="Basic example">
																				<button type="submit" class="btn btn-secondary" id="" name="btnLihatSedikitBanten" value="<?php echo $data['id_toko']; ?>">
																					Perkecil
																				</button>
																				<button type="submit" class="btn btn-secondary " id="" name="btnLihatSemua" value="<?php echo $data['id_toko']; ?>">
																					Lihat Semua
																				</button>
																			</div>
																			
																		</form>
																	</ul>
																</div>
															</nav>	
														</div>
													</div>
													<div class="container mt-2">
														<div class="row">
															<?php
															$id_toko = $data['id_toko'];
															if (isset($_GET['search'])) {
									//tampilkan semua banten yang mengandung kata yang dicari user
																$bantenDicari = $_GET['search'];
																$querySpesifikBantenFromSearch = "SELECT * FROM banten b INNER JOIN toko t ON b.id_toko = t.id_toko INNER JOIN kategoribanten kb ON b.id_kategori = kb.id_kategori INNER JOIN detailbanten db ON db.id_banten = b.id_banten INNER JOIN tingkatanbanten tb ON db.id_tingkatan = tb.id_tingkatan WHERE b.id_toko='$id_toko' AND (b.nama_banten LIKE '%$bantenDicari%' OR kb.nama_kategori LIKE '%$bantenDicari%')";
																$querySemuaBantenSetiapToko = $querySpesifikBantenFromSearch;
															}elseif (!isset($_GET['search'])) {
									//Jika button lihat ssemua maka ganti query untuk dapat melihat bantennya
																if (isset($_POST['btnLihatSemua']) && $_POST['btnLihatSemua']==$data['id_toko']) {
								//ganti query untuk dapat melihat semua item banten di toko tersebut
																	$querySemuaBantenSetiapToko = "SELECT * FROM banten b INNER JOIN toko t ON b.id_toko = t.id_toko INNER JOIN detailbanten db ON db.id_banten = b.id_banten INNER JOIN tingkatanbanten tb ON db.id_tingkatan = tb.id_tingkatan WHERE b.id_toko=$id_toko ";
																}elseif (isset($_POST['btnLihatSedikitBanten']) && $_POST['btnLihatSedikitBanten']==$data['id_toko']) {
																	$querySemuaBantenSetiapToko = "SELECT * FROM banten b INNER JOIN toko t ON b.id_toko = t.id_toko INNER JOIN detailbanten db ON db.id_banten = b.id_banten INNER JOIN tingkatanbanten tb ON db.id_tingkatan = tb.id_tingkatan WHERE b.id_toko=$id_toko LIMIT 4";
																}elseif(!isset($_POST['btnLihatSedikitBanten']) || !isset($_POST['btnLihatSemua'])){
																	$querySemuaBantenSetiapToko = "SELECT * FROM banten b INNER JOIN toko t ON b.id_toko = t.id_toko INNER JOIN detailbanten db ON db.id_banten = b.id_banten INNER JOIN tingkatanbanten tb ON db.id_tingkatan = tb.id_tingkatan WHERE b.id_toko=$id_toko LIMIT 4";
																}
															}
															$ambil = $koneksi->query($querySemuaBantenSetiapToko);
															$startIndeksSlider=0;
															?>
															<?php if ($ambil->num_rows!=0): ?>
																<!-- START WHILE -->
																<?php while ($dataPerProduk = $ambil->fetch_assoc()):?>
																	<div class="col-md-3 mb-3">
																		<div class="card" style="height: 70rem;">
																			<img class="card-img-top center" src="<?php echo BASEURL ?>assets/img_banten/fullsize/<?php echo $dataPerProduk['foto_banten'] ?>" alt="Card image cap">
																			<div class="card-body">
																				<h6 class="card-title text-center" style="height: 3rem;">
																					<?php echo $dataPerProduk['nama_banten']; ?>
																				</h6>
																				<h6 class="card-title text-center" style="height: 3rem;">
																					<?php echo $dataPerProduk['nama_tingkatan']; ?>
																				</h6>
																				<ul class="list-group list-group-flush" style="height: 2rem;">
																					<li class="list-group-item mb-2" style="height: 18rem;">
																						<h6 class="card-subtitle mb-2 text-muted" >Deskripsi Barang</h6>
																						<p class="card-text" style="height: 18rem;">
																							<?php echo $dataPerProduk['deskripsi_banten'];?>
																						</p>
																					</li>
																					<li class="list-group-item mb-2" style="height: 20rem;">
																						<h6 class="card-subtitle mb-2 text-muted" >Kelengkapan Barang</h6>
																						<?php echo $dataPerProduk['kelengkapan_banten']; ?>
																					</li>
																					<li class="list-group-item mb-2" style="height: 9rem;">
																						<h6 class="card-subtitle mb-2 text-muted" >Harga (Rp.)</h6>
																						<?php echo number_format($dataPerProduk['hargaakhir_detail']); ?>
																					</li>
																				</ul>
																				<p style="height: 20rem;"></p>
																			</div>
																			<div class="card-footer">
																				<!-- Button Added Detail dan Tambah Keranjang -->
																				<div class="row mt-2">
																					<div class="col-md-4">
																						<a href="index.php?page=Detail&id=<?php echo $dataPerProduk['id_detail']; ?>" class="btn btn-warning ">Detail</a>
																					</div>
																					<div class="col-md-4">
																						<a href="index.php?page=Beli&type=null&id=<?php echo $dataPerProduk['id_detail']; ?>&toko=<?php echo $dataPerProduk['id_toko']; ?>" class="btn btn-primary ">Add</a>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																<?php endwhile; ?>
																<!-- END WHILE -->
																<?php else: ?>
																	<!-- Beri pesan bahwa banten yang dicari tidak ada di toko ini -->
																	<div class="jumbotron jumbotron-fluid">
																		<div class="container">
																			<h1 class="display-4">Banten Tidak Ditemukan</h1>
																			<p class="lead">
																				Banten atau kategori yang kamu masukan tidak ditemukan di toko <?php echo $data['nama_toko']; ?>
																			</p>
																		</div>
																	</div>
																<?php endif ?>
															</div>
														</div>
														<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
													</div>
												</div>
											</div>
											<!-- END INNNER SLIDER -->
										</div>
										<?php $startSliderToko++; ?>
									<?php endwhile; ?>
									<!-- END PERULANGAN TOKO -->
									<!-- END OUTER SLIDER -->
									<!-- END SLIDER -->
								</div>
								<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
									<span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
									<span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
									<span class="sr-only">Next</span>
								</a>
							</div>
						</div>
					</div>
