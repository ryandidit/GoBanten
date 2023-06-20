<?php if (!isset($_SESSION['pembeli'])): ?>
	<?php
	//arahkan ke halaman login dulu sebagai pembeli
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
				result.dismiss === Swal.DismissReason.cancel
				) {
					document.location.href = 'index.php?page=Home';
					}else{
						document.location.href = 'index.php?page=Home';
					}

				})</script>";
				exit; 
				?>
				<?php else: ?>
					<!-- Lakukan pengecekan jika ada barang yang dibeli baru buat tabel, jika tidak beri peringatan tidak ada barang yang dibeli -->
					<?php if (!empty($_SESSION['beli'])): ?>
						<!-- Lakukan perulangan untuk setiap toko yang dibeli ditandai dari session $_SESSION['toko'] -->
						<?php foreach ($_SESSION['toko'] as $id_toko => $value):?>
							<!-- Query properties toko dari tabel toko -->
							<?php
							$total_belanja = array();
							$keranjangTiapToko = array(array());
							$id_pengguna = $_SESSION['pembeli']['id_pengguna'];
							$pembeli = $_SESSION['pembeli'];
							$query = "SELECT nama_toko FROM toko WHERE id_toko = '$id_toko'";
							$ambil = $koneksi->query($query);
							$data = $ambil->fetch_assoc();
							?>
							<div class="container mt-4">
								
								<div class="card shadow">
									<div class="card-header">
										<h4 class="display-4">
											<?php echo $data['nama_toko']; ?>
										</h4>
									</div>
									<div class="card-body">
										<h5 class="card-title">Daftar Belanjaan</h5>
										<p class="card-text">
											<!-- Cek $_SESSION['beli'] apakah ada atau tidak, kalau ada, tampilkan tabel, kalau engga tampilkan pesan bahwa session kosong -->
											<?php if (isset($_SESSION['beli'])): ?>
												<?php foreach ($_SESSION['beli'] as $id_detailbanten => $jumlahDibeli) :?>
													<?php
													if ($jumlahDibeli!=0) :
														$query = "SELECT db.*,b.*,t.*,tb.*,kb.nama_kategori FROM detailbanten db INNER JOIN banten b ON db.id_banten = b.id_banten INNER JOIN toko t ON b.id_toko = t.id_toko INNER JOIN tingkatanbanten tb ON tb.id_tingkatan = db.id_tingkatan INNER JOIN kategoribanten kb ON kb.id_kategori = b.id_kategori WHERE db.id_detail = '$id_detailbanten' ";
														$ambil = $koneksi->query($query);
														$data = $ambil->fetch_assoc();
														?>
														<?php if ($id_toko==$data['id_toko']): ?>
															<?php
															$total_belanja = 0;
															$id_detailbanten = $data['id_detail'];
															$subtotal = $data['hargaakhir_detail'] * $jumlahDibeli;
															$total_belanja+=$subtotal; 
															?>
															<!-- Session isi -->
															<table class="table table-hover">
																<thead>
																	<tr>
																		<th scope="col">Nama Barang</th>
																		<th scope="col">Tingkatan</th>
																		<th scope="col">Nama Toko</th>
																		<th scope="col">Harga</th>
																		<th scope="col">Jumlah</th>
																		<th scope="col">Sub Total</th>

																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td><?php echo $data['nama_banten']; ?></td>
																		<td><?php echo $data['nama_tingkatan']; ?></td>
																		<td><?php echo $data['nama_toko']; ?></td>
																		<td>Rp. <?php echo number_format($data['hargaakhir_detail']); ?></td>
																		<td><?php echo $jumlahDibeli; ?></td>
																		<td>Rp. <?php echo number_format($subtotal); ?></td>

																	</tr>
																</tbody>
																<tfoot >
																	<tr >
																		<th colspan="5">Total Belanjaan</th>
																		<th>Rp. <?php echo number_format($total_belanja); ?></th>
																	</tr>
																</tfoot>
																<?php
															//isi array tiap toko dan tiap banten yang dibeli
																$keranjangTiapToko[$id_toko][$id_detailbanten]=$id_detailbanten;
																?>
															</table>
															<div class="container-fluid mt-3 mb-3">
																<form method="post" action="index.php?page=Checkout">
																	<!-- Kirimkan id_toko secara hidden -->
																	<input type="hidden" name="id_toko" id="id_toko" value="<?php echo $id_toko; ?>">
																	<!-- Kirimkan foto banten secara hidden -->
																	<input type="hidden" name="foto_banten" id="foto_banten" value="<?php echo $data['foto_banten']; ?>">
																	<!-- Kirimkan nama kategori banten tersebut secara hidden -->
																	<input type="hidden" name="kategori_banten" id="kategori_banten" value="<?php echo $data['nama_kategori']; ?>"> 
																	<div class="row">
																		<div class="col">
																			<!-- Lokasi Pengiriman -->
																			<div class="form-group">
																				<label for="ongkir">Pilih Lokasi Pengiriman</label>
																				<select class="form-control" name="id_ongkir" required="true" id="id_ongkir">
																					<option value="">Pilih Lokasi</option>
																					<?php
																					$id_toko = $id_toko; 
																					$query = "SELECT o.id_ongkir AS id_ongkir, w.provinsi_wilayah AS provinsi_ongkir, w.kota_wilayah AS kota_ongkir, o.harga_ongkir AS harga_ongkir FROM ongkir o INNER JOIN wilayah w ON o.id_wilayah=w.id_wilayah WHERE o.id_toko = '$id_toko'";
																					$ambil=$koneksi->query($query);
																					while ($ongkir = $ambil->fetch_assoc()):
																						?>
																						<option value="<?php echo $ongkir['id_ongkir']; ?>">
																							<?php echo $ongkir['provinsi_ongkir']." | ".$ongkir['kota_ongkir']." | Rp. ".number_format($ongkir['harga_ongkir']); ?>
																						</option>
																						<?php 
																					endwhile; 
																					?>
																				</select>
																			</div>
																			<!-- Alamat Pengiriman -->
																			<div class="form-group">
																				<label>Alamat Pengiriman</label>
																				<textarea name="alamatPengiriman" class="form-control" rows="3" id="alamatPengiriman" value="" required="true"><?php echo $pembeli['alamat_pengguna']; ?></textarea>
																			</div>

																			<div class="form-group">
																				<div class="row">
																					<div class="col-md-8">
																						<div class="alert alert-info">
																							<?php
																						$id_penjual = $id_toko; //karena 1 pengguna hanya dapat mendirikan 1 toko
																						$queryBank = "SELECT * FROM penjual p INNER JOIN bank b ON p.id_bank = b.id_bank WHERE p.id_penjual ='$id_penjual'";
																						$ambil = $koneksi->query($queryBank);
																						$bankPenjual = $ambil->fetch_assoc();
																						?>
																						<p>
																							Lakukan pembayaran ke bank  <strong><?php echo $bankPenjual['nama_bank']; ?></strong>
																						</p>
																						<p>
																							<strong>A.N</strong> : <?php echo $bankPenjual['namadepan_penjual']." ".$bankPenjual['namabelakang_penjual']; ?>
																							<br>
																							<strong>Nomor Rekening</strong> : <?php echo $bankPenjual['rekening_penjual']; ?>
																							
																						</p>
																						<p>

																							<strong>Nominal</strong> : Rp.<?php echo number_format($total_belanja); ?> + Ongkir
																						</p>
																					</div>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col">
																					<div class="form-check">
																						<input class="form-check-input" type="checkbox" value="<?php echo $total_belanja; ?>" id="checkboxPembayaran" name="checkboxPembayaran" required="true" aria-describedby="penjelasCheckboxPembayaran">
																						<label class="form-check-label" for="checkboxPembayaran">
																							Sudah bayar
																						</label>
																					</div>
																				</div>
																			</div>
																			<div class="row mb-4">
																				<div class="col">
																					<small id="penjelasCheckboxPembayaran" class="form-text text-muted">Centang jika sudah membayar</small>
																				</div>
																			</div>
																			<div class="row">
																				
																				<!-- Button -->
																				<div class="col-md-6">
																					<!-- Memberikan nama tombol yang berbeda untuk setiap nama tokonya -->
																					<button class="btn btn-primary btn-block" name="<?php echo $id_detailbanten; ?>" id="<?php echo $id_detailbanten; ?>" value="" id="<?php echo $id_detailbanten; ?>" onclick="return confirmPembayaran(<?php echo $id_detailbanten; ?>);">Bayar</button>
																				</div>
																			</div>
																			<?php
																			// check name button yang ditekan
																			// Mengecek tombol bayar ditekan atau tidak 
																			// 1. Cek apakah tanggal yang diinputkan user kurang dari tanggal hari ini? 
																			if (isset($_POST[$id_detailbanten])) {
																				if ($_POST[$id_detailbanten]==1) {
																					//cek apakah tanggal sudah ditentukan atau tidak
																					if (isset($_POST['tanggalPengiriman']) && $_POST['tanggalPengiriman']!=null) {
																						if ($_POST['tanggalPengiriman']< date("Y-m-d")) {
																					// Berikan peringatan bahwa tanggal yang anda masukan sudah lewat, silahkan inputkan tanggal yang benar 
																							echo "<script>
																							Swal.fire({
																								title: 'TANGGAL KADALUARSA',
																								icon:'warning',
																								text: 'Silahkan masukkan tanggal yang benar!',
																								showCancelButton: false,
																								confirmButtonColor: '#d33',
																								cancelButtonColor: '#d33',
																								confirmButtonText: 'Ganti Tanggal'
																								}).then((result) => {
																									document.location.href = 'index.php?page=Checkout';
																								})</script>";
																							}elseif ($_POST['tanggalPengiriman']>= date("Y-m-d")) {
																					//tanggal yang dimasukan sudah benar
																								$idpengguna_pembelian = $id_pengguna;
																								$idtoko_pembelian = $_POST['id_toko'];
																								$namabanten_pembelian = $data['nama_banten'];
																								$tingkatanbanten_pembelian = $data['nama_tingkatan'];
																								$namatoko_pembelian = $data['nama_toko'];
																								$kelengkapanbanten_pembelian = $data['kelengkapan_banten'];
																								$deskripsibanten_pembelian = $data['deskripsi_banten'];
																								$kategori_banten = $_POST['kategori_banten'];
																								$quantity_pembelian = $jumlahDibeli;
																								$hargaawal_pembelian = $data['hargaawal_detail'];
																								$diskon_pembelian = $data['diskon_detail'];
																								$id_ongkir = $_POST['id_ongkir'];
																						//query dari tabel ongkir untuk mendapatkan data
																								$queryOngkir = "SELECT w.provinsi_wilayah AS provinsi_ongkir, w.kota_wilayah AS kota_ongkir, o.harga_ongkir AS harga_ongkir FROM ongkir o INNER JOIN wilayah w ON o.id_wilayah=w.id_wilayah WHERE o.id_ongkir = '$id_ongkir'";
																								$dataOngkir = $koneksi->query($queryOngkir);
																								$dataOngkir = $dataOngkir->fetch_assoc();
																								$hargaongkir_pembelian = $dataOngkir['harga_ongkir'];
																								$hargaakhir_pembelian = ($data['hargaakhir_detail'] * $quantity_pembelian) + $hargaongkir_pembelian;
																								$provinsiongkir_pembelian = $dataOngkir['provinsi_ongkir'];
																								$kotaongkir_pembelian = $dataOngkir['kota_ongkir'];
																								$catatanpemesanan_pembelian = $_POST['catatanPengiriman'];
																								$tanggalkirim_pembelian = $_POST['tanggalPengiriman'];
																								$tanggalbeli_pembelian = date("Y-m-d");
																								$alamatpengiriman_pembelian = $_POST['alamatPengiriman'];
																								$fotobanten_pembelian = $_POST['foto_banten'];
																								$status_pembelian = "";
																								$catatanpenolakan_pembelian = "";
																						//==================================
																								$_SESSION['barangDibeli'] = $keranjangTiapToko[$id_toko][$id_detailbanten];
																						//query ke tabel pembelian trigger ke tabel nota
																								$queryInsertPembelian = "INSERT INTO pembelian VALUES('','$idpengguna_pembelian','$idtoko_pembelian','$namabanten_pembelian','$tingkatanbanten_pembelian','$kelengkapanbanten_pembelian','$deskripsibanten_pembelian','$kategori_banten','$quantity_pembelian','$hargaawal_pembelian','$diskon_pembelian','$hargaongkir_pembelian','$hargaakhir_pembelian','$provinsiongkir_pembelian','$kotaongkir_pembelian','$catatanpemesanan_pembelian','$tanggalkirim_pembelian','$tanggalbeli_pembelian','$alamatpengiriman_pembelian','$fotobanten_pembelian','$status_pembelian','$catatanpenolakan_pembelian')";
																								$runSQL = $koneksi->query($queryInsertPembelian);
																								if ($runSQL==true) {
																									$banyakItemPerToko = --$_SESSION['jumlahItem'][$id_toko];
																									if ($banyakItemPerToko==0) {
																										//unset toko karena sudah tidak ada banten lagi
																										unset($_SESSION['toko'][$id_toko]);
																										unset($_SESSION['jumlahItem'][$id_toko]);
																									}
																									// unset SESSION['beli'] yang bersangkutan
																									unset($_SESSION['beli'][$id_detailbanten]);
																									echo "<script>
																									Swal.fire({
																										title: 'PEMBELIAN SUKSES',
																										icon:'success',
																										text: 'Transaksi berhasil, tunggu barang sampai!',
																										showCancelButton: false,
																										confirmButtonColor: '#4BB543',
																										cancelButtonColor: '#d33',
																										confirmButtonText: 'Cek Nota'
																										}).then((result) => {
																											document.location.href = 'index.php?page=Nota Pembelian';
																										})</script>";
																									}else{
																										echo "<script>
																										Swal.fire({
																											title: 'PEMBELIAN GAGAL',
																											icon:'warning',
																											text: 'Tenang saldo tidak berkurang!',
																											showCancelButton: false,
																											confirmButtonColor: '#d33',
																											cancelButtonColor: '#d33',
																											confirmButtonText: 'Cek Nota'
																											}).then((result) => {
																												document.location.href = 'index.php?page=Checkout';
																											})</script>";
																										}

																									}
																								}
																							}
																						}
																						?>
																					</div>
																				</div>
																				<div class="col">
																					<!-- Tanggal Pengiriman -->
																					<div class="form-group">
																						<label>Tanggal Pengiriman</label>
																						<input type="date" name="tanggalPengiriman" class="form-control" value="" required="true" id="tanggalPengiriman">
																					</div>
																					<!-- Catatan Pengiriman -->
																					<div class="form-group">
																						<label>Catatan Pengiriman</label>
																						<textarea name="catatanPengiriman" class="form-control" rows="3" value="" id="catatanPengiriman"></textarea>
																					</div>
																				</div>
																			</div>
																		</form>
																	</div>
																<?php endif ?>
															<?php endif; ?>
														<?php endforeach; ?>
													<?php endif ?>
												</p>
											</div>
										</div>

									</div>
								<?php endforeach; ?>
								<!-- Button Kembali -->
								<div class="container mt-4 mb-4">
									<div class="row">
										<div class="col-md-2">
											<a href="index.php?page=Keranjang" class="btn btn-warning btn-block" >Keranjang</a>
										</div>
									</div>
								</div>
							<?php else: 
								echo "<script>
								Swal.fire({
									title: 'BELANJAAN KOSONG',
									text: 'Yuk! Cek di halaman beranda!',
									showCancelButton: false,
									confirmButtonColor: '#3085d6',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Cek beranda'
									}).then((result) => {
										document.location.href = 'index.php';
									})</script>";
									?>

								<?php endif; ?>
							<?php endif ?>



							<script language="javascript">
								function selectChange(){
									var id_ongkir = document.getElementById("id_ongkir");		// get select id
									var harga_ongkir = parseInt(id_ongkir.options[id_ongkir.selectedIndex].value);
									var total_belanja = parseInt(document.getElementById("total_belanja").value);
									document.getElementById("cetak").innerHTML = total_belanja+harga_ongkir;
								}


								function confirmPembayaran(id_detailbanten){
									var returnValue=0;
									if (confirm("Data yang dimasukkan sudah benar?")) {
										returnValue=1;
									}
									if (returnValue==0) {
										document.getElementById("id_ongkir").required = false;
										document.getElementById("tanggalPengiriman").required = false;
										document.getElementById("alamatPengiriman").required = false;
										document.getElementById("checkboxPembayaran").required = false;
									}
									document.getElementById(id_detailbanten).value = returnValue;
								}
							</script>