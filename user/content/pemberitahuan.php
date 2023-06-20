<?php
// Cek jika session pembeli belum login maka arahkan untuk login terlebih dahulu
if (!isset($_SESSION['pembeli'])) {
	echo "<script>
	Swal.fire({
		title: 'Anda belum login',
		text: 'Silahkan login untuk dapat melanjutkan!',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Login',
		cancelButtonText:'Beranda'
		}).then((result) => {
			if (result.value) {
				document.location.href = 'login.php';
				}else if (
				/* Read more about handling dismissals below */
				result.dismiss === Swal.DismissReason.cancel) {
					document.location.href = 'index.php?page=Home';
					}else{
						document.location.href = 'index.php?page=Home';
					}
				})</script>";
				exit; 
			}?>
			<!-- cek apakah button hapus pemberitahuan banten ditolak ditekan atau tidak -->
			<?php
			if (isset($_POST['btnHapusPemberitahuanBantenDitolak'])) {
				if ($_POST['btnHapusPemberitahuanBantenDitolak']==1) {
					//query untuk delete banten berdasarkan id_pembelian
					$id_pembelian = $_POST['id_pembelian'];
					// $queryDeleteBantenDitolak = "DELETE FROM pembelian WHERE id_pembelian='$id_pembelian'";
					$queryDeleteBantenDitolak = "CALL deleteBantenDitolakFromPembelian('$id_pembelian')";
					$runQueryDeleteBantenDitolak = $koneksi->query($queryDeleteBantenDitolak);
					if ($runQueryDeleteBantenDitolak>0) {
					//alert berhasil
						echo "<script>
						Swal.fire({
							title: 'PEMBERITAHUAN DIHAPUS',
							icon:'success',
							text: 'Pemberitahuan berhasil dihapus!',
							showCancelButton: false,
							confirmButtonColor: '#4BB543',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Home'
							}).then((result) => {
								document.location.href = 'index.php?page=Home';
							})</script>";
							exit;
						}else{
					//alert gagal
							echo "<script>
							Swal.fire({
								title: 'PEMBERITAHUAN GAGAL DIHAPUS',
								icon:'warning',
								text: 'Pemberitahuan berhasil dihapus!',
								showCancelButton: false,
								confirmButtonColor: '#d33',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Home'
								}).then((result) => {
									document.location.href = 'index.php?page=Home';
								})</script>";
							}
						}
					}
					?>
					<?php
			//query dari tabel pembelian yang statusnya ditolak sesuai id_pembeli
					$idpengguna_pembelian = $_SESSION['pembeli']['id_pengguna'];
					$status_pembelian_tolak = "Tolak";
					$status_pembelian_batal = "Batal";
					//query manually
					// $queryGetSpesificData = "SELECT pemb.*,t.*,pen.namadepan_penjual,pen.namabelakang_penjual,pen.hp_penjual FROM pembelian pemb INNER JOIN toko t ON pemb.idtoko_pembelian=t.id_toko INNER JOIN penjual pen ON t.id_toko=pen.id_toko WHERE pemb.idpengguna_pembelian = '$idpengguna_pembelian' AND pemb.status_pembelian = '$status_pembelian'";
					//query with stored procedure
					$queryGetSpesificData = "CALL getPembelianDitolak('$idpengguna_pembelian','$status_pembelian_tolak','$status_pembelian_batal')";
					$runQuery = $koneksi->query($queryGetSpesificData);
					$jumlahBantenDitolak = $runQuery->num_rows;
					$indeksAwalSlider=0;
					?>
					<div class="container mt-5">
						<div class="card shadow-lg">
							<h4 class="display-4 card-header">
								Pemberitahuan
							</h4>
							<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
								<ol class="carousel-indicators">
									<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active bg-dark"></li>
									<?php for ($i=0; $i <$jumlahBantenDitolak ; $i++): ?>
										<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i ?>" class="bg-dark"></li>
									<?php endfor; ?>
								</ol>
								<!-- START INNER SLIDER -->
								<div class="carousel-inner">
									<?php while ($bantenTolak = $runQuery->fetch_assoc()): ?>
										<?php if ($indeksAwalSlider==0): ?>
											<div class="carousel-item active">
												<?php else: ?>
													<div class="carousel-item">
													<?php endif ?>
													<!-- Start Card-Body -->
													<div class="card-body">
														<div class="card mb-3 shadow" >
															<div class="row no-gutters">
																<div class="col-md-4">
																	<img src="<?php echo BASEURL; ?>assets/img_banten/fullsize/<?php echo $bantenTolak['fotobanten_pembelian']; ?>" class="card-img" alt="...">
																</div>
																<div class="col-md-8">
																	<div class="card-body">
																		<h5 class="card-title">
																			<?php echo $bantenTolak['namabanten_pembelian']; ?> 
																		</h5>
																		<p class="card-text">
																			<?php
																			if ($bantenTolak['status_pembelian']==$status_pembelian_tolak) {
																				$string = "Catatan Penolakan";
																			}elseif ($bantenTolak['status_pembelian']==$status_pembelian_batal) {
																				$string = "Catatan Pembatalan";
																			}
																			?>
																			<h6 class="card-subtitle mb-2 text-muted" ><?php echo $string; ?></h6>
																			<p style="height: 4rem;">
																				<?php echo $bantenTolak['catatanpenolakan_pembelian']; ?>
																			</p>
																		</p>
																		<hr>
																		<p class="card-text">
																			<h6 class="card-subtitle mb-2 text-muted" >Nama Toko</h6>
																			<?php echo $bantenTolak['nama_toko']; ?>
																		</p>
																		<hr>
																		<p class="card-text">
																			<h6 class="card-subtitle mb-2 text-muted" >Nama Penjual</h6>
																			<?php echo $bantenTolak['namadepan_penjual']." ".$bantenTolak['namabelakang_penjual']; ?> [<?php echo $bantenTolak['hp_penjual']; ?>]
																		</p>
																		<hr>
																	</div>
																	<div class="card-footer ml-auto">
																		<form method="post" action="index.php?page=Pemberitahuan">
																			<input type="hidden" name="id_pembelian" value="<?php echo $bantenTolak['id_pembelian']; ?>">
																			<button type="submit" class="btn btn-danger" name="btnHapusPemberitahuanBantenDitolak" id="btnHapusPemberitahuanBantenDitolak" value="" onclick="return confirmHapusPemberitahuanBantenDitolak();">
																				Hapus
																			</button>
																			<button class="btn btn-success" type="submit" role="button" name="btnHubungiPenjual" id="btnHubungiPenjual">Hubungi Penjual</button>
																		</form>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!-- End Card Body -->
												</div>
												<?php $indeksAwalSlider++; ?>
											<?php endwhile; ?>
										</div>
										<!-- END INNER SLIDER -->
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
							<script language="javascript">
								function confirmHapusPemberitahuanBantenDitolak(){
									var returnValue=0;
									if (confirm("Yakin hapus pemberitahuan ini?")) {
										returnValue=1;
									}
									document.getElementById("btnHapusPemberitahuanBantenDitolak").value=returnValue;
								}
							</script>