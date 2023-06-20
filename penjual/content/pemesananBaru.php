<?php 
require_once 'templates_dashboard/header.php';
?>
<?php
$id_toko = $_SESSION['penjual']['id_toko'];
$status_pembelian = "";
$dateNow = date("Y-m-d");

$status_pembelian = "";
//query semua pembelian baru, kemudian lakukan pengujian untuk tanggal hari ini dan tenggat waktu konfirmasi yaitu 1 hari, jika tanggal hari ini > tanggalbeli_pembelian ATAU tanggalbeli_pembelian + 1 = CURRENTDATE maka update status untuk item tersebut "BATAL";
$queryCekTanggalKirim = "SELECT tanggalbeli_pembelian, id_pembelian, hargaakhir_pembelian FROM pembelian WHERE idtoko_pembelian='$id_toko' AND status_pembelian='$status_pembelian'";
$getTanggalBeli = $koneksi->query($queryCekTanggalKirim);
while ($pembelianBaru = $getTanggalBeli->fetch_assoc()) {
	// Jika tanggal sekarang sudah lewat dari tanggal kirim maka otomatis pesanan diselesaikan karena melewati batas tanggal kirim
	if ($dateNow > $pembelianBaru['tanggalbeli_pembelian'] || $dateNow == date('Y-m-d', strtotime($pembelianBaru['tanggalbeli_pembelian']. ' + 1 days'))) {
		//update tabel pembelian set status pembelian 'selesai'
		$status_pembelian = "Batal";
		$catatanpenolakan_pembelian = "Pesanan telah dibatalkan oleh sistem karena penjual tidak merespon. Saldomu telah kami kembalikan ke rekeningmu";
		$id_pembelian = $pembelianBaru['id_pembelian'];
		$hargaakhir_pembelian = $pembelianBaru['hargaakhir_pembelian'];
		//update status pembelian menjadi batal
		$queryUpdateStatusPembelian = "UPDATE pembelian SET status_pembelian = '$status_pembelian', catatanpenolakan_pembelian = '$catatanpenolakan_pembelian' WHERE id_pembelian = '$id_pembelian'";
		$runQueryUpdate = $koneksi->query($queryUpdateStatusPembelian);
		//kurangi saldo penjual secara otomatis dengan hargaakhir_pembelian karena pesanan yagn datang batal
		$queryKurangiSaldoPenjualKarenaPesananBatal = "UPDATE penjual SET dompet_penjual = dompet_penjual-'$hargaakhir_pembelian' WHERE id_penjual = '$id_toko'";
		$runQueryKurangiSaldoPenjual = $koneksi->query($queryKurangiSaldoPenjualKarenaPesananBatal);
	}
}

// SUB QUERY
$queryDataPembelianBaru = "SELECT * FROM (SELECT * FROM pembelian INNER JOIN pengguna ON pembelian.idpengguna_pembelian = pengguna.id_pengguna) AS combine WHERE combine.idtoko_pembelian = '$id_toko' AND combine.status_pembelian = ''";
//QUERY TUNGGAL
// $queryDataPembelian = "SELECT * FROM pembelian INNER JOIN pengguna ON pembelian.idpengguna_pembelian = pengguna.id_pengguna WHERE pembelian.idtoko_pembelian = '$id_toko' AND pembelian.status_pembelian='' ";

$ambil = $koneksi->query($queryDataPembelianBaru); 
$amountJumlahPesananBaru = $ambil->num_rows; 
?>
<!-- Jika belum ada pesanan tampilkan pesan -->
<?php if ($amountJumlahPesananBaru==0): ?>
	<?php
	echo "<script>
	Swal.fire({
		title: 'PESANAN KOSONG',
		icon:'info',
		text: 'Belum ada pesanan baru yaa...',
		showCancelButton: false,
		confirmButtonColor: '#22bb33',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Beranda'
		}).then((result) => {
			document.location.href = 'index.php?page=Dashboard';
		})</script>";
		exit;
		?>
	<?php endif ?>
	<!-- Start Container -->
	<div class="container-fluid mt-4" >
		<!-- Start Card -->
		<div class="card shadow">
			<!-- Start Card Header -->
			<div class="card-header">
				<nav class="navbar navbar-expand-lg navbar-light bg-light">
					<a class="navbar-brand" href="#">
						<h4 class="display-4">
							<?php echo $_GET['page']; ?>
						</h4>
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeadPesananBaru" aria-controls="navbarHeadPesananBaru" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarHeadPesananBaru">
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
										<div class="card shadow">
											<p class="card-text">
												Pesanan yang datang akan dibatalkan dalam <strong>1 Hari</strong> 
												Jika Anda tidak memprosesnya!
												Segera <strong>proses</strong> pesanan Anda!
											</p>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</nav>
			</div>
			<!-- End Card Headr -->
			<!-- Start Card Body -->
			<div class="card-body">
				<table class="table table-sm" >
					<thead class="text-center">
						<tr>
							<th scope="col">Nomor</th>
							<th scope="col">Foto </th>
							<th scope="col">Nama </th>
							<th scope="col">Quantity</th>
							<th scope="col">Tanggal Beli</th>
							<th scope="col">Tanggal Kirim</th>
							<th scope="col">Alamat</th>
							<th scope="col">Aksi</th>
						</tr>
					</thead>
					<tbody class="text-center " style="word-break: break-all;">
						<?php while ($dataPerProduk = $ambil->fetch_assoc()):?>
							<form method="post" action="index.php?page=Pemesanan Baru" name="formTerimaPesanan">
								<tr>
									<td>
										<?php echo $dataPerProduk['id_pembelian']; ?>
									</td>
									<td scope="col">
										<img src="<?php echo BASEURL ?>assets/img_banten/fullsize/<?php echo $dataPerProduk['fotobanten_pembelian'] ?>" style="width: 100px;" name="foto_banten">
									</td>
									<td scope="col">
										<?php echo $dataPerProduk['namabanten_pembelian']; ?> <br> [<?php echo $dataPerProduk['tingkatanbanten_pembelian']; ?>]
									</td>
									<td scope="col">
										<?php echo $dataPerProduk['quantity_pembelian']; ?>
									</td>
									<td scope="col">
										<?php echo $dataPerProduk['tanggalbeli_pembelian']; ?>
									</td>
									<td scope="col">
										<?php echo $dataPerProduk['tanggalkirim_pembelian']; ?>
									</td>
									<td scope="col">
										<?php echo $dataPerProduk['alamatpengiriman_pembelian']; ?>
									</td>
									<td scope="col">
										<div class="container mt-3">
											<div class="row ">
												<div class="col">
													<?php 
													$buttonDetailPesanan = $dataPerProduk['id_pembelian'];
													?>
													<!-- Button Trigger For Detail Pesanan -->
													<button type="submit" class="btn btn-warning mr-2" name="<?php echo $buttonDetailPesanan; ?>" id="<?php echo $buttonDetailPesanan; ?>" value="" onclick="setValueButtonDetail('<?php echo $buttonDetailPesanan; ?>');">
														Detail
													</button>
													<?php
													if (isset($_POST[$buttonDetailPesanan])) {
														$_POST['detailPesanan'] = $dataPerProduk;
													}
													?>
													<!-- Memberikan nama button terima yang spesisifk untuk setiap banten -->
													<?php 
													$buttonTerimaPesanan = "ButtonTerima".$dataPerProduk['id_pembelian'];
													?>
													<button class="btn btn-primary" name="<?php echo $buttonTerimaPesanan; ?>" id="<?php echo $buttonTerimaPesanan; ?>" value="" onclick="confirmTerimaPesananPembelian('<?php echo $buttonTerimaPesanan; ?>','<?php echo $dataPerProduk['namabanten_pembelian'] ?>','<?php echo $dataPerProduk['tanggalkirim_pembelian']; ?>');" type="submit">
														Terima 
													</button>
													<?php if (isset($_POST[$buttonTerimaPesanan])): ?>
														<?php
														if ($_POST[$buttonTerimaPesanan]==1) {
														//confirm is yes
														//update tabel pembelian set status pembelian = terima
															$status_pembelian = "Terima";
															$id_pembelian = $dataPerProduk['id_pembelian'];
															$queryUpdateTerimaPesanan = "UPDATE pembelian SET status_pembelian = '$status_pembelian' WHERE id_pembelian = '$id_pembelian' ";
															$runSQL=$koneksi->query($queryUpdateTerimaPesanan);
															if ($runSQL==true) {
															//berhasil update tabel
																echo "<script>
																Swal.fire({
																	title: 'PESANAN DITERIMA',
																	icon:'success',
																	text: 'Pesanan diterima. Ingat kirim pesanannya ya...',
																	showCancelButton: false,
																	confirmButtonColor: '#4BB543',
																	cancelButtonColor: '#d33',
																	confirmButtonText: 'OK'
																	}).then((result) => {
																		if (result.value) {
																			document.location.href = 'index.php?page=Pemesanan Diterima';
																		}
																	})</script>";
																}else{
															//gagal update
																	echo "<script>
																	Swal.fire({
																		title: 'PESANAN GAGAL DITERIMA',
																		icon:'alert',
																		text: 'Ada kesalahan dalam sistem, pesanan gagal diterima',
																		showCancelButton: false,
																		confirmButtonColor: '#d33',
																		cancelButtonColor: '#d33',
																		confirmButtonText: 'Kembali'
																		}).then((result) => {
																			if (result.value) {
																				document.location.href = 'index.php?page=Pemesanan Diterima';
																			}
																		})</script>";
																	}
																}

																?>
															<?php endif ?>
														</div>
													</div>
												</div>
											</td>
										</tr>
									</form>
								<?php endwhile; ?>
							</tbody>
						</table>
						<form method="post" action="index.php?page=Pemesanan Baru" name="formTolakPesanan">
							<div class="container-fluid mt-4">
								<div class="row">
									<!-- Modal -->
									<div class="modal fade" id="modalTolakPesanan" tabindex="-1" role="dialog" aria-labelledby="modalTolakPesananTitle" aria-hidden="true">
										<div class="modal-dialog modal-dialog-scrollable" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="modalTolakPesananTitle">Tolak Pesanan</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<!-- Pilih Nomor Banten yang ditolak -->
													<div class="row">
														<div class="col">
															<div class="form-group">
																<label for="id_pembelian">Nomor Banten Ditolak</label>
																<input type="hidden" name="id_pembelian_tolak" value="" id="id_pembelian_tolak">
																<select class="form-control" id="select_idPembelian" required="true" onchange="ddlSelect();">
																	<option value="">-Pilih Nomor-</option>
																	<!-- Query id_pembelian dan nama_banten nya -->
																	<?php
																	$query = "SELECT id_pembelian, namabanten_pembelian,hargaakhir_pembelian FROM pembelian WHERE idtoko_pembelian = '$id_toko' AND status_pembelian =''";
																	$getData = $koneksi->query($query);?>
																	<?php while ($dataPembelian = $getData->fetch_assoc()) :?>
																		<option value="<?php echo $dataPembelian['id_pembelian'] ?>" id="<?php echo $dataPembelian['namabanten_pembelian']; ?>"><?php echo $dataPembelian['id_pembelian']; ?></option>
																	<?php endwhile; ?>	
																</select>
															</div>
														</div>
													</div>
													<!-- Nama Banten yang dipilih -->
													<div class="row">
														<div class="col">
															<div class="form-group"> 
																<label for="inputNamaBanten">Nama Banten</label>
																<input type="text" name="inputNamaBanten" value="" id="inputNamaBanten" aria-describedby="label_namabanten_pembelian" class="form-control" readonly="true">
																<small id="label_namabanten_pembelian" class="form-text text-muted">*Nama banten yang ditolak pesanannya</small>
															</div>
														</div>
													</div>
													<!-- Catatan Penolakan -->
													<div class="row">
														<div class="col">
															<div class="form-group"> 
																<label for="catatan_penolakan">Catatan Penolakan</label>
																<textarea class="form-control" id="catatan_penolakan" rows="3" name="catatan_penolakan" aria-describedby="label_catatan_penolakan" required="true"></textarea>
																<small id="label_deskripsi_bantenBaru" class="form-text text-muted">*Berikan alasan jelas banten ditolak</small>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
													<button type="submit" class="btn btn-danger" name="btnTolakPesanan" id="btnTolakPesanan" value="" onclick="return confirmTolakPesanan('<?php echo $dataPerProduk?>')">Tolak</button>
													<?php
													if (isset($_POST['btnTolakPesanan'])) {
														if ($_POST['btnTolakPesanan']==1) {
															//confirm is YES
															$status_pembelian = "Tolak";
															$id_pembelian = $_POST['id_pembelian_tolak'];
															$catatanpenolakan_pembelian = $_POST['catatan_penolakan'];
														//ambil hargaakhir_pembelian dari tabel pembelian yang id nya id_pembelian
															$queryAmbilHargaAkhirPembelian = "SELECT hargaakhir_pembelian FROM pembelian WHERE id_pembelian = '$id_pembelian' ";
															$runQueryAmbilHargaAkhirPembelian = $koneksi->query($queryAmbilHargaAkhirPembelian);
															$hargaakhir_pembelian = $runQueryAmbilHargaAkhirPembelian->fetch_assoc();
															$hargaakhir_pembelian = $hargaakhir_pembelian['hargaakhir_pembelian'];
															$queryUpdatePenolakanPembelian = "UPDATE pembelian SET status_pembelian ='$status_pembelian', catatanpenolakan_pembelian = '$catatanpenolakan_pembelian' WHERE id_pembelian = '$id_pembelian'";
															$runSQL = $koneksi->query($queryUpdatePenolakanPembelian);
															if ($runSQL==true) {
															//potong saldo penjual sejumlah hargaakhir_pembelian dan kembalikan saldo ke rekening customer oleh sistem
																$queryPotongSaldoPenjualKarenaMenolakPesanan = "UPDATE penjual SET dompet_penjual = dompet_penjual - '$hargaakhir_pembelian' WHERE id_penjual = '$id_toko'";
																$runQueryPotongSaldoPenjual = $koneksi->query($queryPotongSaldoPenjualKarenaMenolakPesanan);
																if ($runQueryPotongSaldoPenjual>0) {
																	//update success
																echo "<script>
																Swal.fire({
																	title: 'PESANAN DITOLAK',
																	icon:'success',
																	text: 'Banten tersebut sudah ditolak pesanannya ya...',
																	showCancelButton: false,
																	confirmButtonColor: '#4BB543',
																	cancelButtonColor: '#d33',
																	confirmButtonText: 'OK'
																	}).then((result) => {
																		if (result.value) {
																			document.location.href = 'index.php?page=Pemesanan Baru';
																		}
																	})</script>";
																}else{
																	//potong saldo error
																	echo "<script>
																	Swal.fire({
																		title: 'KESALAHAN',
																		icon:'warning',
																		text: 'Ada kesalahan dalam pemotongan saldo penjual',
																		showCancelButton: false,
																		confirmButtonColor: '#d33',
																		cancelButtonColor: '#d33',
																		confirmButtonText: 'OK'
																		}).then((result) => {
																			if (result.value) {
																				document.location.href = 'index.php?page=Pemesanan Baru';
																			}
																		})</script>";
																}
																
																}else{
																//update error
																	echo "<script>
																	Swal.fire({
																		title: 'KESALAHAN',
																		icon:'warning',
																		text: 'Ada kesalahan dalam penolakan banten tersebut!',
																		showCancelButton: false,
																		confirmButtonColor: '#d33',
																		cancelButtonColor: '#d33',
																		confirmButtonText: 'OK'
																		}).then((result) => {
																			if (result.value) {
																				document.location.href = 'index.php?page=Pemesanan Baru';
																			}
																		})</script>";
																	}

																}
															}
															?>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-2">
												<!-- Button trigger modal -->
												<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalTolakPesanan" for="formTolakPesanan" id="<?php echo $dataPerProduk['id_pembelian']; ?>" >
													Tolak Pesanan
												</button>
											</div>
										</div>
									</div>
								</form>
							</div>
							<!-- End Card Body -->

						</div>
						<!-- End Card -->
					</div>
					<!-- End Container -->
					<!-- Ketika tombol banten setiap pembelian ditekan -->
					<?php if (isset($_POST['detailPesanan'])): ?>
						<?php
						$id_pembelian = $_POST['detailPesanan']['id_pembelian'];
						$tingkatanbanten_pembelian = $_POST['detailPesanan']['tingkatanbanten_pembelian'];
						$namabanten_pembelian = $_POST['detailPesanan']['namabanten_pembelian'];
						$deskripsibanten_pembelian = $_POST['detailPesanan']['deskripsibanten_pembelian'];
						$kelengkapanbanten_pembelian = $_POST['detailPesanan']['kelengkapanbanten_pembelian'];
						$nama_pembeli = $_POST['detailPesanan']['namadepan_pengguna'].' '.$_POST['detailPesanan']['namabelakang_pengguna'];
						$diskon_pembelian = $_POST['detailPesanan']['diskon_pembelian'];
						$hargaawal_pembelian = $_POST['detailPesanan']['hargaawal_pembelian'];
						$provinsiongkir_pembelian = $_POST['detailPesanan']['provinsiongkir_pembelian'];
						$kotaongkir_pembelian = $_POST['detailPesanan']['kotaongkir_pembelian'];
						$hargaongkir_pembelian = $_POST['detailPesanan']['hargaongkir_pembelian'];
						$hargaakhir_pembelian = $_POST['detailPesanan']['hargaakhir_pembelian'];
						$catatanpemesanan_pembelian = $_POST['detailPesanan']['catatanpemesanan_pembelian'];
						?>
						<div class="container-fluid mt-5 mb-5">

							<div class="card" style="width: 30rem; height: 40rem;">
								<div class="card-body">
									<div class="container">
										<!-- Nama Banten dan tingkatan banten -->
										<div class="row">
											<div class="col">
												<h5 class="card-title text-center" >
													[<?php echo $id_pembelian; ?>] <?php echo $namabanten_pembelian; ?>
												</h5>
												<h6 class="card-subtitle text-center" style="height: 2rem;">
													[<?php echo $tingkatanbanten_pembelian; ?>]
												</h6>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<ul class="list-group list-group-flush" style="height: 2rem;">
													<li class="list-group-item mb-2">
														<h6 class="card-subtitle mb-2 text-muted" >Nama Pembeli</h6>
														<p class="card-text" style="height: 4rem;">
															<?php echo $nama_pembeli;?>
														</p>
													</li>
													<li class="list-group-item mb-2" style="height: 9rem;">
														<h6 class="card-subtitle mb-2 text-muted" >Deskripsi Barang</h6>
														<p class="card-text" style="height: 8rem;">
															<?php echo $deskripsibanten_pembelian;?>
														</p>
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
												</ul>
											</div>
											<div class="col">
												<ul class="list-group list-group-flush" style="height: 2rem;">
													<li class="list-group-item mb-2">
														<h6 class="card-subtitle mb-2 text-muted" >Harga Barang</h6>
														<p class="card-text" style="height: 2rem;">
															Rp.<?php echo number_format($hargaawal_pembelian);?>
														</p>
													</li>
													<li class="list-group-item mb-2">
														<h6 class="card-subtitle mb-2 text-muted" >Diskon</h6>
														<p class="card-text" style="height: 2rem;">
															<?php echo $diskon_pembelian;?>%
														</p>
													</li>
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
															Harga Dibayar
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

						</div>

					<?php endif ?>
					<script language="javascript">
						function setValueButtonDetail(buttonDetailPesanan){
							document.getElementById(buttonDetailPesanan).value = buttonDetailPesanan;

						}
						function ddlSelect(){
							var select = document.getElementById("select_idPembelian");
							var optionValue = select.options[select.selectedIndex];
							document.getElementById("inputNamaBanten").value = optionValue.id;
							document.getElementById("id_pembelian_tolak").value = optionValue.value;

						}
						function confirmTolakPesanan(){
							var returnValue=0;
							if (confirm("Yakin tolak pesanan ini?")) {
								returnValue=1;
							}
							if (returnValue==0) {
								document.getElementById("select_idPembelian").required=false;
								document.getElementById("catatan_penolakan").required=false;
							}
							document.getElementById("btnTolakPesanan").value = returnValue;

						}
						function confirmTerimaPesananPembelian(nomorButton,namaBanten,tanggalKirimBanten){
							var returnValue=0;
							if (confirm("Terima pesanan " + namaBanten +" ?")) {
								returnValue=1;
							}
							if (returnValue==1) {
								alert("Pesanan harus dikirim tanggal "+tanggalKirimBanten);
							}
							document.getElementById(nomorButton).value = returnValue;

						}
					</script>
					<?php 
					require_once 'templates_dashboard/footer.php';
					?>
