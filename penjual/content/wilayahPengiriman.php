<?php
// Query untuk mengetahui kosong atau tidak tabel ongkir tsb
$id_toko = $_SESSION['penjual']['id_toko'];
$query = "SELECT w.kota_wilayah AS kota_ongkir, w.provinsi_wilayah AS provinsi_ongkir , o.harga_ongkir AS harga_ongkir, o.id_ongkir AS id_ongkir FROM ongkir o INNER JOIN wilayah w ON o.id_wilayah = w.id_wilayah WHERE o.id_toko = '$id_toko'";
$sqlResult = $koneksi->query($query);
$returnRows = $sqlResult->num_rows;
if ($returnRows!=0) {
	//query untuk mendapatkan nama kota_ongkir yang digunakan untuk query update ketika button ditekan
	$query = "SELECT id_wilayah FROM ongkir WHERE id_toko = '$id_toko'";
	$sqlResult_ongkir = $koneksi->query($query);
	$ongkir_update = array();
	while ($ongkir_lama = $sqlResult_ongkir->fetch_assoc()) {
		$ongkir_update[] = $ongkir_lama['id_wilayah'];
	}
}
//cek jika returnRows sudah berjumlah 9 (jumlah kota kabupaten di Bali) berarti boleh buka menu bar yang lain di sidebarnya
if ($returnRows==9) {
	//beri alert
	echo "<script>
	Swal.fire({
		icon:'success',
		title: 'ONGKIR LENGKAP',
		text: 'Harga ongkir sudah lengkap, yuk berjualan!!',
		showCancelButton: false,
		confirmButtonColor: '#4BB543',
		cancelButtonColor: '#d33',
		confirmButtonText: 'OK'
		}).then((result) => {
		})</script>";
	}elseif ($returnRows<9 ) {
		//beri peringatan bahwa ongkir harus lengkap dulu untuk bisa menjual barang
		echo "<script>
		Swal.fire({
			icon:'warning',
			title: 'ONGKIR BELUM LENGKAP',
			text: 'Silahkan lengkapi ongkir dulu!!',
			showCancelButton: false,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Lengkapi'
			}).then((result) => {
			})</script>";
	}

	?>
	<div class="container-fluid">
		<div class="container shadow p-2 mb-3">
			<!--  -->
			<div class="row mb-3 mt-3">
				<div class="col">
					<div class="card   bg-red rounded">
						<h5 class="card-header">Wilayah Pengiriman Barang</h5>
						<div class="card-body">
							<form method="post" action="index.php?page=Wilayah Pengiriman">
								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="provinsi_ongkir">Provinsi</label>
										<input type="text" class="form-control" id="provinsi_ongkir" value="Bali" readonly="" name="provinsi_ongkir">
									</div>
									<div class="form-group col-md-4">
										<label for="id_wilayah">Kota</label>
										<select id="id_wilayah" class="form-control" name="id_wilayah" required="true">
											<option selected value="">-Kota-</option>
											<!-- query untuk mengulang nama wilayah -->
											<?php
											$queryGetWilayah = "SELECT * FROM wilayah";
											$getData = $koneksi->query($queryGetWilayah);
											?>
											<?php while($wilayah=$getData->fetch_assoc()): ?>
												<option value="<?php echo $wilayah['id_wilayah'] ?>"><?php echo $wilayah['kota_wilayah']; ?></option>
											<?php endwhile; ?>
										</select>
									</div>
									<div class="form-group col-md-2">
										<label for="harga_ongkir">Harga (Rp.)</label>
										<input type="number" class="form-control" id="harga_ongkir" name="harga_ongkir" required="true" aria-describedby="harga_ongkir">
										<small id="harga_ongkir" class="form-text text-muted">*Beri 0 jika ongkir gratis</small>
									</div>
								</div>
								<button class="btn btn-success" type="submit" name="buttonUpdateWilayahPengiriman" id="buttonUpdateWilayahPengiriman" value="">Perbaharui</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- query dari tabel ongkir berdasarkan id penjualnya dulu -->
			<?php if ($returnRows!=0): ?>
				<!-- Baris untuk labeling -->
				<div class="row">
					<div class="col-md-3">
						<div class="form-group ml-2 mr-2  text-center">
							<label for="provinsi_pengiriman"><h5>Provinsi Pengiriman</h5></label>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group ml-2 mr-2 text-center">
							<label for="kota_pengiriman" ><h5>Kota Pengiriman</h5></label>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group ml-2 mr-2  text-center">
							<label for="hargaperkota_pengiriman"><h5>Harga Pengiriman</h5></label>
						</div>
					</div>
				</div>
				<!-- Baris untuk field -->
				<form method="post" action="index.php?page=Wilayah Pengiriman">
					<!-- Fetch all data from tabel ongkir -->
					<?php while ($ongkir=$sqlResult->fetch_assoc()):?>
						<?php
						$id_ongkir = $ongkir['id_ongkir'];
						?>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group ml-2 mr-2">
									<input type="text" class="form-control" id="provinsi_pengiriman" placeholder="<?php echo $ongkir['provinsi_ongkir'] ?>" readonly="">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group ml-2 mr-2">
									<input type="text" class="form-control" id="kota_pengiriman" placeholder="<?php echo $ongkir['kota_ongkir'] ?>" readonly="">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group ml-2 mr-2">
									<input type="number" class="form-control" id="hargaperkota_pengiriman" placeholder="Rp. <?php echo number_format($ongkir['harga_ongkir']); ?>" name="hargaperkota_pengiriman" readonly="">

								</div>
							</div>
							<!-- Button Added -->
							<div class="col-md-3">
								<div class="container">
									<div class="row">
										<div class="col-sm">
											<button class="btn btn-danger" type="submit" value="" name="<?php echo $id_ongkir; ?>" onclick="confirmHapusOngkir(<?php echo $id_ongkir; ?>)" id="<?php echo $id_ongkir; ?>">Hapus</button>
											<!-- JIka tombol hapus di setiap ongkir ditekan -->
											<?php
											if (isset($_POST[$id_ongkir])) {
												if ($_POST[$id_ongkir]==1) {
													$query = "DELETE FROM ongkir WHERE id_ongkir = '$id_ongkir'";
													$data = $koneksi->query($query);
													if ($data==true) {
														echo "<script>
														Swal.fire({
															icon:'success',
															title: 'BERHASIL',
															text: 'Data pengiriman berhasil dihapus!',
															showCancelButton: false,
															confirmButtonColor: '#4BB543',
															cancelButtonColor: '#d33',
															confirmButtonText: 'OK'
															}).then((result) => {
																document.location.href = 'index.php?page=Wilayah Pengiriman';
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
						<?php endwhile; ?>
					</form>
				<?php endif ?>

			</div>
		</div>


		<?php
//cek jika tombol perbarui ditekan
		if (isset($_POST['buttonUpdateWilayahPengiriman'])) {
	//Jika user kelupaan memilih kota
			$id_wilayah = $_POST['id_wilayah'];
			$harga_ongkir = $_POST['harga_ongkir'];
			if ($id_wilayah==null) {
		//berikan alert harus memilih kotanya
				echo "<script>
				Swal.fire({
					icon:'warning',
					title: 'PILIH KOTA',
					text: 'Kamu belum memilih kota lho...',
					showCancelButton: false,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Edit'
					}).then((result) => {
						if (result.value) {
							document.location.href = 'index.php?page=Wilayah Pengiriman';
						}
						})
						</script>";
						exit;
					}else{
				//cek jumlah baris yang dikembalikan sebelumnya, kalau nol berarti insert data baru ke daftar ongkir
						if ($returnRows==0) {
					//insert data
							$query = "INSERT INTO ongkir VALUES('','$id_wilayah','$id_toko','$harga_ongkir')";
							$sukses = $koneksi->query($query);
							if ($sukses==true) {
						//alert berhasil input data
								echo "<script>
								Swal.fire({
									icon:'success',
									title: 'BERHASIL',
									text: 'Data pengiriman berhasil ditambahkan!',
									showCancelButton: false,
									confirmButtonColor: '#4BB543',
									cancelButtonColor: '#d33',
									confirmButtonText: 'OK'
									}).then((result) => {
										document.location.href = 'index.php?page=Wilayah Pengiriman';
									})</script>";
								}else{
						//alert gagal input data
									echo "<script>
									Swal.fire({
										icon:'warning',
										title: 'GAGAL',
										text: 'Data pengiriman gagal ditambahkan! Cek lagi ya...',
										showCancelButton: false,
										confirmButtonColor: '#d33',
										cancelButtonColor: '#d33',
										confirmButtonText: 'Check'
										}).then((result) => {
											document.location.href = 'index.php?page=Wilayah Pengiriman';
										})</script>";
									}
								}elseif ($returnRows>0) {
									if (in_array($id_wilayah, $ongkir_update)) {
										//update data
										$query = "UPDATE ongkir SET harga_ongkir = '$harga_ongkir' WHERE id_wilayah='$id_wilayah' AND id_toko = '$id_toko'";
										$sukses = $koneksi->query($query);
										if ($sukses) {
											//berhasil update data
											echo "<script>
											Swal.fire({
												icon:'success',
												title: 'BERHASIL',
												text: 'Data pengiriman berhasil diperbaharui!',
												showCancelButton: false,
												confirmButtonColor: '#4BB543',
												cancelButtonColor: '#d33',
												confirmButtonText: 'OK'
												}).then((result) => {
													document.location.href = 'index.php?page=Wilayah Pengiriman';
												})</script>";
											}else{
											//gagal update data
												echo "<script>
												Swal.fire({
													icon:'warning',
													title: 'GAGAL',
													text: 'Data pengiriman gagal diperbaharui! Cek lagi ya...',
													showCancelButton: false,
													confirmButtonColor: '#d33',
													cancelButtonColor: '#d33',
													confirmButtonText: 'Check'
													}).then((result) => {
														document.location.href = 'index.php?page=Wilayah Pengiriman';
													})</script>";
												}
											}else{
										//insert data baru sesuai kota ongkirnya
												$query = "INSERT INTO ongkir VALUES('','$id_wilayah','$id_toko','$harga_ongkir')";
												$sukses = $koneksi->query($query);
												if ($sukses) {
											//berhasil insert data ongkir baru
													echo "<script>
													Swal.fire({
														icon:'success',
														title: 'BERHASIL',
														text: 'Data pengiriman berhasil ditambahkan!',
														showCancelButton: false,
														confirmButtonColor: '#4BB543',
														cancelButtonColor: '#d33',
														confirmButtonText: 'OK'
														}).then((result) => {
															if (result.value) {
																document.location.href = 'index.php?page=Wilayah Pengiriman';
															}
															})
															</script>";
														}else{
											//gagal insert data
															echo "<script>
															Swal.fire({
																icon:'warning',
																title: 'GAGAL',
																text: 'Data pengiriman gagal ditambahkan! Cek lagi ya...',
																showCancelButton: false,
																confirmButtonColor: '#d33',
																cancelButtonColor: '#d33',
																confirmButtonText: 'Check'
																}).then((result) => {
																	document.location.href = 'index.php?page=Wilayah Pengiriman';
																})</script>";
															}
														}

													}
												}
											}
											?>
											<script language="javascript">
												function confirmHapusOngkir(ongkir){
													var returnValue =0;
													if (confirm("Yakin hapus data ongkir ini?")) {
														returnValue=1;
													}
													document.getElementById(ongkir).value = returnValue;

												}
											</script>