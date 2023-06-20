<?php
$idpengguna_pembelian = $idpengguna_pembelian;
$status_pembelian = "Selesai";
// query untuk mendapatkan banyak item yang dikirim dengan status pengiriman "Kirim"
$queryGetAmountPesananSelesai = "SELECT COUNT(id_pembelian) AS banyak_item FROM pembelian WHERE idpengguna_pembelian = '$idpengguna_pembelian' AND status_pembelian='$status_pembelian' "; //AND tanggalkirim_pembelian+1 = CURRENT_DATE
$getData = $koneksi->query($queryGetAmountPesananSelesai);
$item = $getData->fetch_assoc();
$banyak_item = $item['banyak_item'];
?>
<!-- Jika belum ada item yang dikirim -->
<?php if ($banyak_item==0): ?>
	<?php echo "<script>
	Swal.fire({
		title: 'PESANAN KOSONG',
		icon:'info',
		text: 'Tidak ada pesanan yang diselesaikan!',
		showCancelButton: false,
		confirmButtonColor: '#22bb33',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Beranda'
		}).then((result) => {
			document.location.href = 'index.php?page=Home';
		})</script>";
		exit;?>
	<?php endif ?>
	<div class="container-fluid mt-3 mb-3">
		<!-- Tidak ada pesanan diterima -->
		<?php if ($banyak_item!=0): ?>
			<div class="card shadow">
				<div class="card-header">
					<nav class="navbar navbar-expand-lg navbar-light bg-light">
						<a class="navbar-brand" href="index.php?page=Pesanan Selesai">
							<h4 class="display-4">
								<?php echo $_GET['page']; ?>
							</h4>		
						</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>

						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="navbar-nav ml-auto">
								<li class="nav-item">
									<!-- Button trigger modal -->
									<button type="button" class="btn btn-transparent" data-toggle="modal" data-target="#exampleModal">
										Read
									</button>
								</li>
							</ul>
						</div>
					</nav>
				</div>
				<div class="card-body">
					<div class="container-fluid mt-2 mb-2">
						<div class="row ">
							<?php
							// query digroup pertoko yang sudah selesai pengiriman bantennya
							$querySetiapToko = "SELECT p.idtoko_pembelian,t.nama_toko FROM pembelian p INNER JOIN toko t ON t.id_toko = p.idtoko_pembelian WHERE p.idpengguna_pembelian = '$idpengguna_pembelian' AND p.status_pembelian='$status_pembelian' GROUP BY p.idtoko_pembelian ";
							$ambil = $koneksi->query($querySetiapToko); 
							?>
							<?php while ( $dataPesananSelesai = $ambil->fetch_assoc()):?>
								<?php
								$idtoko_pembelian = $dataPesananSelesai['idtoko_pembelian'];
								$nama_toko = $dataPesananSelesai['nama_toko'];
								?>
								<div class="col-md-6 mb-2 mt-2">
									<div class="card shadow">
										<div class="card-header">
											<div class="d-flex justify-content-between align-items-center">
												<div class="p-2 bd-highlight ">
													<h5 class="card-title nav-link">
														<?php echo $nama_toko; ?>
													</h5>	
												</div>
												<div class="p-2 bd-highlight">
													<form method="post" action="index.php?page=Pesanan Selesai">
														<!-- passing id_tokonya secara hidden -->
														<input type="hidden" value="<?php echo $idtoko_pembelian; ?>" name="id_toko">
														<button type="submit" class="btn btn-outline-primary" id="" name="btnLihatSedikitPesananDikirim" value="<?php echo $idtoko_pembelian; ?>">
															Perkecil
														</button>
														<button type="submit" class="btn btn-outline-danger" id="" name="btnLihatSemuaPesananDikirim" value="<?php echo $idtoko_pembelian; ?>">
															Lihat Semua
														</button>
													</form>
												</div>
											</div>
										</div>
										<div class="card-body">
											<div class="container-fluid">
												<div class="row">
													<?php
													if (isset($_POST['btnLihatSemuaPesananDikirim']) && $_POST['btnLihatSemuaPesananDikirim']==$idtoko_pembelian) {
															// query setiap banten yang dikirim berdasarkan id_tokonya
														$queryDataPembelianPerItem = "SELECT * FROM pembelian p INNER JOIN toko t ON p.idtoko_pembelian = t.id_toko WHERE p.idtoko_pembelian = '$idtoko_pembelian' AND p.status_pembelian = '$status_pembelian' AND p.idpengguna_pembelian = '$idpengguna_pembelian'";
													}elseif (isset($_POST['btnLihatSedikitPesananDikirim']) && $_POST['btnLihatSedikitPesananDikirim']==$idtoko_pembelian) {
															// query setiap banten yang dikirim berdasarkan id_tokonya
														$queryDataPembelianPerItem = "SELECT * FROM pembelian p INNER JOIN toko t ON p.idtoko_pembelian = t.id_toko WHERE p.idtoko_pembelian = '$idtoko_pembelian' AND p.status_pembelian = '$status_pembelian' AND p.idpengguna_pembelian = '$idpengguna_pembelian' LIMIT 2";
													}else{
															// query setiap banten yang dikirim berdasarkan id_tokonya
														$queryDataPembelianPerItem = "SELECT * FROM pembelian p INNER JOIN toko t ON p.idtoko_pembelian = t.id_toko WHERE p.idtoko_pembelian = '$idtoko_pembelian' AND p.status_pembelian = '$status_pembelian' AND p.idpengguna_pembelian = '$idpengguna_pembelian' LIMIT 2";
													}
													$getDataPembelianPerItem = $koneksi->query($queryDataPembelianPerItem);
													while ( $dataPerItem = $getDataPembelianPerItem->fetch_assoc()):
														?>
														<?php
														$namabanten_pembelian = $dataPerItem['namabanten_pembelian'];
														$tingkatanbanten_pembelian = $dataPerItem['tingkatanbanten_pembelian'];
														$kelengkapanbanten_pembelian = $dataPerItem['kelengkapanbanten_pembelian'];
														$deskripsibanten_pembelian = $dataPerItem['deskripsibanten_pembelian'];
														$kategoribanten_pembelian = $dataPerItem['kategoribanten_pembelian'];
														$quantity_pembelian = $dataPerItem['quantity_pembelian'];
														$hargaawal_pembelian = $dataPerItem['hargaawal_pembelian'];
														$diskon_pembelian = $dataPerItem['diskon_pembelian'];
														$hargaongkir_pembelian = $dataPerItem['hargaongkir_pembelian'];
														$hargaakhir_pembelian = $dataPerItem['hargaakhir_pembelian'];
														$provinsiongkir_pembelian = $dataPerItem['provinsiongkir_pembelian'];
														$kotaongkir_pembelian = $dataPerItem['kotaongkir_pembelian'];
														$catatanpemesanan_pembelian = $dataPerItem['catatanpemesanan_pembelian'];
														$tanggalkirim_pembelian = $dataPerItem['tanggalkirim_pembelian'];
														$tanggalbeli_pembelian = $dataPerItem['tanggalbeli_pembelian'];
														$alamatpengiriman_pembelian = $dataPerItem['alamatpengiriman_pembelian'];
														$fotobanten_pembelian = $dataPerItem['fotobanten_pembelian'];
														?>
														<div class="col-md-6">
															<div class="card mb-3" style="width: auto; height: 55rem;">
																<img src="<?php echo BASEURL ?>assets/img_banten/fullsize/<?php echo $fotobanten_pembelian; ?>" class="card-img-top center" name="foto_banten" style="width: 100px;height: 100px;">
																<div class="card-body">
																	<ul class="list-group list-group-flush" style="height: 2rem;">
																		<li class="list-group-item mb-2">
																			<h6 class="card-subtitle mb-2 text-muted text-center" >
																				<?php echo $namabanten_pembelian; ?> 
																			</h6>
																		</li>
																		<li class="list-group-item mb-2">
																			<h6 class="card-subtitle mb-2 text-muted" >Tingkatan</h6>
																			<p class="card-text" style="height: 1rem;">
																				<?php echo $tingkatanbanten_pembelian;?>
																			</p>
																		</li>
																		<li class="list-group-item mb-2">
																			<h6 class="card-subtitle mb-2 text-muted" >Tanggal Kirim</h6>
																			<p class="card-text" style="height: 1rem;">
																				<?php echo $tanggalkirim_pembelian;?>
																			</p>
																		</li>
																		<li class="list-group-item mb-2" style="height: 13rem;">
																			<h6 class="card-subtitle mb-2 text-muted" >Alamat Pengiriman</h6>
																			<?php echo $alamatpengiriman_pembelian; ?>
																		</li>
																		<li class="list-group-item mb-2" style="height: 13rem;">
																			<h6 class="card-subtitle mb-2 text-muted" >Kelengkapan Barang</h6>
																			<?php echo $kelengkapanbanten_pembelian; ?>
																		</li>
																		<?php if ($catatanpemesanan_pembelian!=""): ?>
																			<li class="list-group-item mb-2" style="height: 15rem;">
																				<h6 class="card-subtitle mb-2 text-muted" >Catatan Pemesanan</h6>
																				<?php echo $catatanpemesanan_pembelian; ?>
																			</li>
																		<?php endif ?>
																		<li class="list-group-item mb-2">
																			<h6 class="card-subtitle mb-2 text-muted" >Detail Ongkir</h6>
																			<p class="card-text" style="height: 3rem;">
																				<?php echo $provinsiongkir_pembelian; ?> ( <?php echo $kotaongkir_pembelian; ?> | Rp.<?php echo number_format($hargaongkir_pembelian); ?> )
																			</p>
																		</li>
																		<li class="list-group-item mb-2">
																			<h6 class="card-subtitle mb-2 text-muted" >
																				Total Harga
																			</h6>
																			<p class="card-text" style="height: 2rem;">
																				Rp.<?php echo number_format($hargaakhir_pembelian); ?>
																			</p>
																		</li>
																	</ul>
																</div>
															</div>
														</div>
													<?php endwhile; ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>

	<!-- Modal Read Navbar-->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Pesanan Selesai</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Berikan penilaian untuk pesanananmu!
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>