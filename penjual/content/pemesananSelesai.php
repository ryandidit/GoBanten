<?php
require_once 'templates_dashboard/header.php';
$id_toko = $id_toko;
$status_pembelian = "Selesai";
// query untuk mendapatkan banyak item yang sudah selesai orderannya dan dengan status "Selesai"
// query data pembelian akan melihat untuk pembelian yang "selesai" 1 hari setelah tanggal kirim pembelian saja
$queryGetAmountItemSelesai = "SELECT COUNT(id_pembelian) AS banyak_item FROM pembelian WHERE idtoko_pembelian = '$id_toko' AND status_pembelian='$status_pembelian' AND tanggalkirim_pembelian+1 = CURRENT_DATE";
$getData = $koneksi->query($queryGetAmountItemSelesai);
$item = $getData->fetch_assoc();
$banyak_item = $item['banyak_item'];
?>
<!-- Jika belum ada item yang selesai maka tampilkan alert -->
<?php if ($banyak_item==0): ?>
	<?php echo "<script>
	Swal.fire({
		title: 'PESANAN KOSONG',
		icon:'info',
		text: 'Belum ada pesanan yang diselesaikan!!',
		showCancelButton: false,
		confirmButtonColor: '#22bb33',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Beranda'
		}).then((result) => {
			document.location.href = 'index.php?page=Dashboard';
		})</script>";
		exit;?>
	<?php endif ?>
	<div class="container-fluid mt-4 mb-4">
		<!-- Ada pesanan yang telah selesai -->
		<?php if ($banyak_item!=0): ?>
			<div class="card shadow">
				<div class="card-header">
					<h4 class="display-4">
						<?php echo $_GET['page']; ?> 
					</h4>
				</div>
				<div class="card-body">
					<div class="container-fluid mt-2 mb-2">
						<div class="row ">
							<?php
							$status_pembelian = "Selesai";
							
							// query data pembelian akan melihat untuk pembelian yang "selesai" 1 hari setelah tanggal kirim pembelian saja
							$queryDataPembelianSelesai = "SELECT * FROM (SELECT * FROM pembelian INNER JOIN pengguna ON pembelian.idpengguna_pembelian = pengguna.id_pengguna) AS combine WHERE combine.idtoko_pembelian = '$id_toko' AND combine.status_pembelian = '$status_pembelian' AND combine.tanggalkirim_pembelian+1 = CURRENT_DATE";
							
							$ambil = $koneksi->query($queryDataPembelianSelesai); 
							?>
							<?php while ( $dataPesananSelesai = $ambil->fetch_assoc()):?>
								<?php
								$id_pembelian = $dataPesananSelesai['id_pembelian'];
								$tingkatanbanten_pembelian = $dataPesananSelesai['tingkatanbanten_pembelian'];
								$namabanten_pembelian = $dataPesananSelesai['namabanten_pembelian'];
								$deskripsibanten_pembelian = $dataPesananSelesai['deskripsibanten_pembelian'];
								$kelengkapanbanten_pembelian = $dataPesananSelesai['kelengkapanbanten_pembelian'];
								$alamatpengiriman_pembelian = $dataPesananSelesai['alamatpengiriman_pembelian'];
								$nama_pembeli = $dataPesananSelesai['namadepan_pengguna']." ".$dataPesananSelesai['namabelakang_pengguna'];
								$diskon_pembelian = $dataPesananSelesai['diskon_pembelian'];
								$hargaawal_pembelian = $dataPesananSelesai['hargaawal_pembelian'];
								$provinsiongkir_pembelian = $dataPesananSelesai['provinsiongkir_pembelian'];
								$kotaongkir_pembelian = $dataPesananSelesai['kotaongkir_pembelian'];
								$hargaongkir_pembelian = $dataPesananSelesai['hargaongkir_pembelian'];
								$hargaakhir_pembelian = $dataPesananSelesai['hargaakhir_pembelian'];
								$catatanpemesanan_pembelian = $dataPesananSelesai['catatanpemesanan_pembelian'];
								$fotobanten_pembelian = $dataPesananSelesai['fotobanten_pembelian'];
								$tanggalkirim_pembelian = $dataPesananSelesai['tanggalkirim_pembelian'];
								?>
								<div class="col-md-3 mb-2 mt-2">
									<form method="post" action="index.php?page=Pemesanan Diterima">
										<div class="card" >
											<div class="card-body" style="height: 55rem;">
												<div class="container-fluid">
													<img src="<?php echo BASEURL ?>assets/img_banten/fullsize/<?php echo $fotobanten_pembelian; ?>" style="width: 100px;" name="foto_banten" class="card-img-top center">
													<div class="row">
														<div class="col">
															<ul class="list-group list-group-flush" style="height: 2rem;">
																<li class="list-group-item mb-2">
																	<h6 class="card-subtitle mb-2 text-muted text-center" >
																		<?php echo $namabanten_pembelian; ?> 
																	</h6>
																</li>
																<li class="list-group-item mb-2">
																	<h6 class="card-subtitle mb-2 text-muted" >Nama Pembeli</h6>
																	<p class="card-text" style="height: 1rem;">
																		<?php echo $nama_pembeli;?>
																	</p>
																</li>
																<li class="list-group-item mb-2">
																	<h6 class="card-subtitle mb-2 text-muted" >Tingkatan</h6>
																	<p class="card-text" style="height: 2rem;">
																		<?php echo $tingkatanbanten_pembelian;?>
																	</p>
																</li>
																<li class="list-group-item mb-2">
																	<h6 class="card-subtitle mb-2 text-muted" >Tanggal Kirim</h6>
																	<p class="card-text" style="height: 2rem;">
																		<?php echo $tanggalkirim_pembelian;?>
																	</p>
																</li>
																<li class="list-group-item mb-2" style="height: 9rem;">
																	<h6 class="card-subtitle mb-2 text-muted" >Alamat Pengiriman</h6>
																	<?php echo $alamatpengiriman_pembelian; ?>
																</li>
																<li class="list-group-item mb-2" style="height: 9rem;">
																	<h6 class="card-subtitle mb-2 text-muted" >Kelengkapan Barang</h6>
																	<?php echo $kelengkapanbanten_pembelian; ?>
																</li>
																<?php if ($catatanpemesanan_pembelian!=""): ?>
																	<li class="list-group-item mb-2" style="height: 9rem;">
																		<h6 class="card-subtitle mb-2 text-muted" >Catatan Pemesanan</h6>
																		<?php echo $catatanpemesanan_pembelian; ?>
																	</li>
																<?php endif ?>
																<li class="list-group-item mb-2">
																	<h6 class="card-subtitle mb-2 text-muted" >Detail Ongkir</h6>
																	<p class="card-text" style="height: 4rem;">
																		<?php echo $provinsiongkir_pembelian; ?> | <?php echo $kotaongkir_pembelian; ?>
																		<br>
																		Rp.<?php echo number_format($hargaongkir_pembelian); ?>
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
											</div>
										</div>
									</form>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
	<?php 
	require_once 'templates_dashboard/footer.php';
	?>
