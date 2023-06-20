<?php 
require_once 'templates_dashboard/header.php';
?>
<?php
$id_toko = $_SESSION['penjual']['id_toko'];
$status_pembelian = "Terima";
$dateNow = date("Y-m-d");
//query semua pembelian yang diterima, kemudian lakukan pengujian untuk tanggal hari ini dan tenggat waktu pengiriman yaitu 2 hari, jika  tanggalbeli_pembelian + 2 = CURRENTDATE maka update status untuk item tersebut "BATAL";
$queryCekTanggalKirim = "SELECT tanggalbeli_pembelian, id_pembelian, hargaakhir_pembelian FROM pembelian WHERE idtoko_pembelian='$id_toko' AND status_pembelian='$status_pembelian'";
$getTanggalBeli = $koneksi->query($queryCekTanggalKirim);
while ($PembelianDiterima = $getTanggalBeli->fetch_assoc()) {
	// Jika tanggal sekarang sudah lewat dari tanggal kirim maka otomatis pesanan diselesaikan karena melewati batas tanggal kirim
	if ($dateNow == date('Y-m-d', strtotime($PembelianDiterima['tanggalbeli_pembelian']. ' + 0 days'))) {
		//update tabel pembelian set status pembelian 'selesai'
		$status_pembelian = "Batal";
		$catatanpenolakan_pembelian = "Pesanan telah dibatalkan oleh sistem karena penjual tidak mengerjakan bantenmu. Saldomu telah kami kembalikan ke rekeningmu";
		$id_pembelian = $PembelianDiterima['id_pembelian'];
		$hargaakhir_pembelian = $PembelianDiterima['hargaakhir_pembelian'];
		//update status pembelian menjadi batal
		$queryUpdateStatusPembelian = "UPDATE pembelian SET status_pembelian = '$status_pembelian', catatanpenolakan_pembelian = '$catatanpenolakan_pembelian' WHERE id_pembelian = '$id_pembelian'";
		$runQueryUpdate = $koneksi->query($queryUpdateStatusPembelian);
		//kurangi saldo penjual secara otomatis dengan hargaakhir_pembelian karena pesanan yagn datang batal
		$queryKurangiSaldoPenjualKarenaPesananBatal = "UPDATE penjual SET dompet_penjual = dompet_penjual-'$hargaakhir_pembelian' WHERE id_penjual = '$id_toko'";
		$runQueryKurangiSaldoPenjual = $koneksi->query($queryKurangiSaldoPenjualKarenaPesananBatal);
	}
}

// SUB QUERY
$queryDataPembelianDiterima = "SELECT * FROM (SELECT * FROM pembelian INNER JOIN pengguna ON pembelian.idpengguna_pembelian = pengguna.id_pengguna) AS combine WHERE combine.idtoko_pembelian = '$id_toko' AND combine.status_pembelian = '$status_pembelian'";
//QUERY TUNGGAL
// $queryDataPembelian = "SELECT * FROM pembelian INNER JOIN pengguna ON pembelian.idpengguna_pembelian = pengguna.id_pengguna WHERE pembelian.idtoko_pembelian = '$id_toko' AND pembelian.status_pembelian='' ";

$ambil = $koneksi->query($queryDataPembelianDiterima); 
$adaPesananDiterimaAtauTidak = $ambil->num_rows; 
?>
<!-- Jika tidak ada pesanan yang diterima -->
<?php if ($adaPesananDiterimaAtauTidak==0): ?>
	<?php
	echo "<script>
	Swal.fire({
		title: 'PESANAN KOSONG',
		icon:'info',
		text: 'Belum ada pesanan diterima yaa...',
		showCancelButton: false,
		confirmButtonColor: '#22bb33',
		cancelButtonColor: '#d33',
		confirmButtonText: 'OK'
		}).then((result) => {
			document.location.href = 'index.php?page=Dashboard';
		})</script>";
		exit;
		?>
	<?php endif ?>
	<div class="container-fluid mt-4 mb-4">
		<!-- Jika ada esanan yang diterima -->
		<?php if ($adaPesananDiterimaAtauTidak!=0): ?>
			<div class="card shadow">
				<div class="card-header">
					<nav class="navbar navbar-expand-lg navbar-light bg-light">
						<a class="navbar-brand" href="#">
							<h4 class="display-4">
								<?php echo $_GET['page']; ?>
							</h4>
						</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeadPesananDiterima" aria-controls="navbarHeadPesananDiterima" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarHeadPesananDiterima">
							<ul class="navbar-nav ml-auto">
								<li class="nav-item">
									<div class="btn-group dropdown">
										<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<svg class="bi bi-bookmark-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" d="M3 3a2 2 0 012-2h6a2 2 0 012 2v12l-5-3-5 3V3z" clip-rule="evenodd"/>
											</svg>
											Baca Ketentuan
										</button>
										<div class="dropdown-menu">
											<p class="card-text">
												Pesanan yang telah diterima akan dibatalkan dalam <strong>2 Hari</strong> 
												Setelah tanggal pembelian, jika Anda tidak segera mengirimnya!
												Segera <strong>kirim</strong> pesanan Anda!
											</p>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</nav>

				</div>
				<div class="card-body">
					<div class="container-fluid mt-2 mb-2">
						<div class="row ">
							<?php while ( $dataPesananDiterima = $ambil->fetch_assoc()):?>
								<?php
								$id_pembelian = $dataPesananDiterima['id_pembelian'];
								$tingkatanbanten_pembelian = $dataPesananDiterima['tingkatanbanten_pembelian'];
								$namabanten_pembelian = $dataPesananDiterima['namabanten_pembelian'];
								$deskripsibanten_pembelian = $dataPesananDiterima['deskripsibanten_pembelian'];
								$kelengkapanbanten_pembelian = $dataPesananDiterima['kelengkapanbanten_pembelian'];
								$alamatpengiriman_pembelian = $dataPesananDiterima['alamatpengiriman_pembelian'];
								$nama_pembeli = $dataPesananDiterima['namadepan_pengguna']." ".$dataPesananDiterima['namabelakang_pengguna'];
								$diskon_pembelian = $dataPesananDiterima['diskon_pembelian'];
								$hargaawal_pembelian = $dataPesananDiterima['hargaawal_pembelian'];
								$provinsiongkir_pembelian = $dataPesananDiterima['provinsiongkir_pembelian'];
								$kotaongkir_pembelian = $dataPesananDiterima['kotaongkir_pembelian'];
								$hargaongkir_pembelian = $dataPesananDiterima['hargaongkir_pembelian'];
								$hargaakhir_pembelian = $dataPesananDiterima['hargaakhir_pembelian'];
								$catatanpemesanan_pembelian = $dataPesananDiterima['catatanpemesanan_pembelian'];
								$fotobanten_pembelian = $dataPesananDiterima['fotobanten_pembelian'];
								$tanggalkirim_pembelian = $dataPesananDiterima['tanggalkirim_pembelian'];
								$tanggalbeli_pembelian = $dataPesananDiterima['tanggalbeli_pembelian'];
								$remCard; //untuk height card body
								if ($catatanpemesanan_pembelian!="") {
									$remCard="60rem";
									$remCardOuter = "70rem";
								}else{
									$remCard="55rem";
									$remCardOuter = "70rem";
								}
								?>
								<div class="col-md-3 mb-2 mt-2">
									<form method="post" action="index.php?page=Pemesanan Diterima">
										<div class="card" style="height: <?php echo $remCardOuter; ?>;" >
											<div class="card-body" style="height: <?php echo $remCard; ?>;">
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
																<li class="list-group-item mb-2">
																	<h6 class="card-subtitle mb-2 text-muted" >Tanggal Beli</h6>
																	<p class="card-text" style="height: 2rem;">
																		<?php echo $tanggalbeli_pembelian;?>
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
											<div class="card-footer">
												<!-- Input id_pembelian secara hidden -->
												<input type="hidden" name="id_pembelian" value="<?php echo $id_pembelian; ?>">
												<!-- Setiap button kirim sudah diberi nama button yang spesifik untuk 1 ide_pembelian. -->
												<button class="btn btn-primary btn-sm " type="submit" value="" name="<?php echo $id_pembelian; ?>" id="<?php echo $id_pembelian; ?>" onclick="confirmKirimPesanan('<?php echo $id_pembelian; ?>','<?php echo $namabanten_pembelian; ?>');">
													Kirim
												</button>
											</div>
											<?php if (isset($_POST[$id_pembelian])): ?>
												<?php if ($_POST[$id_pembelian]==1): ?>
													<!-- Update tabel pembelian set status pesanan dengan "Kirim" yang id_pembelian = $_POST['id_pembelian'] -->
													<?php
													$status_pembelian = "Kirim";
													$id_pembelian = $_POST['id_pembelian'];
													$queryUpdateStatusPembelianDikirim = "UPDATE pembelian SET status_pembelian = '$status_pembelian' WHERE id_pembelian = '$id_pembelian'";
													$runQuery = $koneksi->query($queryUpdateStatusPembelianDikirim);
													if ($runQuery==true) {
														echo "<script>
														Swal.fire({
															title: 'KIRIM PESANAN',
															icon:'success',
															text: 'Jangan lupa dikirim pesanan ya!!',
															showCancelButton: false,
															confirmButtonColor: '#4BB543',
															cancelButtonColor: '#d33',
															confirmButtonText: 'Kirim'
															}).then((result) => {
																document.location.href = 'index.php?page=Pemesanan Dikirim';
															})</script>";
														}
														?>
													<?php endif ?>
												<?php endif ?>
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
		<script language="javascript">
			function confirmKirimPesanan(nomorButton,namaBanten){
				var returnValue=0;
				if (confirm(namaBanten+" sudah siap dikirim?")) {
					returnValue=1;
				}
				if (returnValue==1) {
					alert("Informasi akan disampaikan ke pelanggan yaa...");
				}
				document.getElementById(nomorButton).value = returnValue;
			}
		</script>
		<?php 
		require_once 'templates_dashboard/footer.php';
		?>
