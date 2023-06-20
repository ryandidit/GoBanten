<?php
$id_admin = $_SESSION['admin']['id_admin'];
$id_wilayah = $_SESSION['admin']['id_wilayah'];
$id_wilayah = 2;
$jumlahTokoTampilTiapHalaman = 2;
if (isset($_GET['no'])) {
	$offset = $_GET['no']*2;
	$row_count = $jumlahTokoTampilTiapHalaman;
		//jika pagination ditekan
	$sqlQuery = "SELECT * FROM (SELECT * FROM toko WHERE id_wilayah='$id_wilayah') AS t INNER JOIN penjual p ON t.id_toko = p.id_toko LIMIT $offset, $row_count";
	$runQuery = $koneksi->query($sqlQuery);
	$adaTokoAtauTidak = $runQuery->num_rows;
	if ($adaTokoAtauTidak==0) {
		echo "<script>
		Swal.fire({
			title: 'TIDAK ADA TOKO',
			icon:'warning',
			text: 'Belum ada toko yang terdaftar!',
			showCancelButton: false,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#d33',
			confirmButtonText: 'OK'
			}).then((result) => {
				document.location.href = 'index.php';
			})</script>";
			exit();
		}else{
			// Jika dia di halaman pertama
			if ($_GET['no'] == 0) {
				$indexUrlAfter = $_GET['no'] + 1;
				$urlBefore = "index.php?page=Informasi Toko&no=0";
				$urlAfter ="index.php?page=Informasi Toko&no=".$indexUrlAfter;
			}
			if ($_GET['no'] ==$_SESSION['jumlahPerulangan']-1) {
				$indexUrlBefore = $_GET['no'] - 1;
				$urlBefore = "index.php?page=Informasi Toko&no=".$indexUrlBefore;
				$urlAfter ="index.php?page=Informasi Toko&no=".$_GET['no'];
			}
			if ($_GET['no']==0 && $_GET['no']==$_SESSION['jumlahPerulangan']-1) {
				$urlBefore = "index.php?page=Informasi Toko&no=".$_GET['no'];
				$urlAfter ="index.php?page=Informasi Toko&no=".$_GET['no'];
			}
			if ($_GET['no']>0 && $_GET['no']<$_SESSION['jumlahPerulangan']-1) {
				$indexUrlBefore = $_GET['no']-1;
				$indexUrlAfter = $_GET['no']+1;
				$urlBefore = "index.php?page=Informasi Toko&no=".$indexUrlBefore;
				$urlAfter ="index.php?page=Informasi Toko&no=".$indexUrlAfter;
			}
			$jumlahPerulangan = 0;
			//query untuk mendapatkan total banyak toko
			$sqlQueryToGetNumberOfTokoExist = "SELECT * FROM (SELECT * FROM toko WHERE id_wilayah='$id_wilayah') AS t INNER JOIN penjual p ON t.id_toko = p.id_toko ";
			$runQueryToGetNumberOfTokoExist = $koneksi->query($sqlQueryToGetNumberOfTokoExist);
			$banyakTokoTotal = $runQueryToGetNumberOfTokoExist->num_rows;
			if ($banyakTokoTotal % 2 == 0) {
				$_SESSION['jumlahPerulangan'] = $banyakTokoTotal/$jumlahTokoTampilTiapHalaman;
			}else{
				$_SESSION['jumlahPerulangan'] = (int) ($banyakTokoTotal/$jumlahTokoTampilTiapHalaman) + 1;
			}
		}

	}
	$indeksStartSlider=0;
	?>
	<div class="container-fluid mb-3 mt-3">
		<div class="card">
			<h5 class="card-header display-4">
				<?php echo $_GET['page']; ?>
			</h5>
			<div class="card-body">
				<div class="container-fluid">
					<div class="row">
						<?php while ($informasiToko = $runQuery->fetch_assoc()) :?>
							<div class="col-md-6">
								<div class="card mb-3">
									<img src="../assets/img/toko/<?php echo $informasiToko['foto_toko']; ?>" class="card-img-top" alt="...">
									<div class="card-body">
										<div class="container-fluid">
											<div class="row">
												<div class="col">
													<div class="card-body">
														<h5 class="card-title" style="height: 2rem;">
															<?php echo $informasiToko['nama_toko']; ?>
														</h5>
														<h6 class="card-subtitle mb-2 text-muted">Alamat Toko</h6>
														<p class="card-text" style="height: 3rem;">
															<?php echo $informasiToko['alamat_toko']; ?>
														</p>
														<div class="form-row">
															<div class="col">
																<h6 class="card-subtitle mb-2 text-muted">Provinsi</h6>
																<p class="card-text" style="height: 3rem;">
																	<?php echo $informasiToko['provinsi_toko']; ?>
																</p>
															</div>
															<div class="col">
																<h6 class="card-subtitle mb-2 text-muted">Kota</h6>
																<p class="card-text" style="height: 3rem;">
																	<?php echo $informasiToko['kota_toko']; ?>
																</p>
															</div>
															<div class="col">
																<h6 class="card-subtitle mb-2 text-muted">Kode Pos</h6>
																<p class="card-text" style="height: 3rem;">
																	<?php echo $informasiToko['kodepos_toko']; ?>
																</p>
															</div>
														</div>
														<h6 class="card-subtitle mb-2 text-muted">Deskripsi Toko</h6>
														<p class="card-text" style="height: 7rem;">
															<?php echo $informasiToko['deskripsi_toko']; ?>
														</p>
														<h6 class="card-subtitle mb-2 text-muted">Catatan Toko</h6>
														<p class="card-text" style="height: 5rem;">
															<?php echo $informasiToko['catatan_toko']; ?>
														</p>
														<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>

													</div>
												</div>
												<div class="col">
													<div class="card mb-3" style="width: auto;">
														<div class="row no-gutters">
															<div class="col-md-4">
																<img src="../assets/img/penjual/<?php echo $informasiToko['foto_penjual']; ?>" class="card-img" alt="...">
															</div>
															<div class="col-md-8">
																<div class="card-body">
																	<h5 class="card-title" style="height: 2rem;">
																		Penjual
																	</h5>
																	<h6 class="card-subtitle mb-2 text-muted">Nama Penjual</h6>
																	<p class="card-text">
																		<?php echo $informasiToko['namadepan_penjual']." ".$informasiToko['namabelakang_penjual']; ?>
																	</p>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
			<div>
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">
						<!-- Symbol before -->
						<li class="page-item">
							<a class="page-link" href="<?php echo $urlBefore; ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<!-- End Symbol Before -->
						<!-- Perulangan sebanyak jumlah toko -->
						<?php for ($i=0; $i < $_SESSION['jumlahPerulangan']; $i++): ?>
							<li class="page-item"><a class="page-link" href="index.php?page=Informasi Toko&no=<?php echo $i; ?>"><?php echo $i+1; ?></a></li>
						<?php endfor; ?>
						<!-- Symbol after -->
						<li class="page-item">
							<a class="page-link" href="<?php echo $urlAfter; ?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
						<!-- End Symbol after -->
					</ul>
				</nav>
			</div>
		</div>

	</div>
