<?php
$id_banten = $_GET['id'];
$query = "SELECT * FROM banten INNER JOIN kategoribanten ON banten.id_kategori=kategoribanten.id_kategori WHERE banten.id_toko = '$id_toko' AND banten.id_banten='$id_banten'";
$sqlResult = $koneksi->query($query);
$banten = $sqlResult->fetch_assoc();
$nama_banten = $banten['nama_banten'];
$deskripsi_banten = $banten['deskripsi_banten'];
$kelengkapan_banten = $banten['kelengkapan_banten'];
$nama_kategori = $banten['nama_kategori'];
?>
<div class="container-fluid">
	<div class="container mt-4 mb-4">
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header">
						<h5 class=""><?php echo $nama_banten; ?></h5>
					</div>
					<div class="card-body">
						<div class="jumbotron bg-light">
							<h1 class="display-4 ">Tambah Informasi</h1>
							<!-- Data Informasi Banten -->
							<form method="post" action="index.php?page=Tambah Informasi&id=<?php echo $id_banten; ?>" enctype="multipart/form-data">
								<!-- Passing id_banten hidden to form -->
								<div class="row ">
									<div class="col mt-2">
										<!-- Nama Banten -->
										<div class="form-group">
											<label for="nama_banten">Nama Banten</label>
											<input type="text" class="form-control" id="nama_banten" name="nama_banten" value="<?php echo $nama_banten; ?>"  readonly="true">
										</div>
										<!-- Nama Kategori BAnten -->
										<div class="form-group">
											<label for="nama_kategori">Kategori Banten</label>
											<input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?php echo $nama_kategori; ?>" readonly="true">
										</div>
										<!-- Deskripsi Banten -->
										<div class="form-group">
											<label for="deskripsi_banten">Deskripsi Banten</label>
											<textarea class="form-control" id="deskripsi_banten" rows="3" name="deskripsi_banten" readonly="true"><?php echo $deskripsi_banten; ?></textarea>
										</div>
										<!-- Kelengkapan Banten -->
										<div class="form-group">
											<label for="kelengkapan_banten">Kelengkapan Banten</label>
											<textarea class="form-control" id="kelengkapan_banten" rows="5" name="kelengkapan_banten" readonly="true" ><?php echo $kelengkapan_banten; ?></textarea>
										</div>
										<!-- Tingkatan Banten -->
										<div class="form-group">
											<!-- Query dari tabel kategoriBanten -->
											<?php
											$query = "SELECT * FROM tingkatanbanten";
											$sqlResult = $koneksi->query($query);
											?>
											<label for="tingkatan_banten">Tingkatan Banten</label>
											<select class="form-control" id="tingkatan_banten" name="tingkatan_banten" aria-describedby="tingkatan_banten" required="true">
												<option value="">-tingkatan-</option>
												<?php while ($tingkatanbanten = $sqlResult->fetch_assoc()):?>
													<option value="<?php echo $tingkatanbanten['id_tingkatan']; ?>"><?php echo $tingkatanbanten['nama_tingkatan']; ?></option>
												<?php endwhile ?>
											</select>
										</div>
										<!-- Harga Banten -->
										<div class="form-group">
											<label for="harga_banten">Harga (Rp.)</label>
											<input type="number" class="form-control" id="harga_banten" name="harga_banten" value="" required="true">
										</div>
										<!-- Diskon Banten -->
										<div class="form-group">
											<label for="diskon_banten">Diskon </label>
											<input type="number" class="form-control" id="diskon_banten" name="diskon_banten" value="" aria-describedby="diskon_banten">
											<small id="diskon_banten" class="form-text text-muted">*Abaikan jika tidak ada diskon</small>
										</div>
										<!-- Stok Banten -->
										<div class="form-group">
											<label for="stok_banten">Jumlah Stok</label>
											<input type="number" class="form-control" id="stok_banten" name="stok_banten" value="" required="true">
										</div>	
									</div>
								</div>
								<!-- Button Added -->
								<div class="row">
									<div class="col-md-2">
										<a class="btn btn-warning btn-block" href="index.php?page=Etalase Toko" role="button" name="btnKembaliEtalase" id="btnKembaliEtalase">Etalase</a>
									</div>
									<div class="col-md-2 ml-auto">
										<button type="button" class="btn btn-success btn-block " data-toggle="modal" data-target="#modalTambahInformasiBanten" name="btnTooglerTambahInformasiBanten" id="btnTooglerTambahInformasiBanten" value="">
											Simpan
										</button>
										<!-- Modal Button Toogle Daftar Toko Ditekan -->
										<div class="modal fade" id="modalTambahInformasiBanten" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalTambahInformasiBantenLabel" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="modalTambahInformasiBantenLabel">Konfirmasi Tambah Informasi</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														Data yang dimasukan sudah benar? Tekan 'Simpan' jika sudah!
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
														<button class="btn btn-success btn-user" name="btnSubmitTambahInformasiBanten" type="submit"  value="" id="btnSubmitTambahInformasiBanten" >
															Simpan
														</button>	
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
if (isset($_POST['btnSubmitTambahInformasiBanten'])) {
	$id_banten = $id_banten;
	$id_tingkatan = $_POST['tingkatan_banten'];
 		//query dari tabel detailBanten yang id_banten dan id_tingkatan sama dengan yang akan diinputkan
	$query = "SELECT id_banten,id_tingkatan FROM detailbanten WHERE id_banten='$id_banten' AND id_tingkatan = '$id_tingkatan'";
	$sqlResult = $koneksi->query($query);
 		//Jika ada data yang dikembalikan berarti tidak boleh insert ke tabel detail
	if ($sqlResult->num_rows>0) {
 			//beri peringatan
		echo "<script>
		Swal.fire({
			title: 'GAGAL TAMBAH INFORMASI',
			icon:'warning',
			text: 'Yang kamu tambah, informasinya sudah lengkap ya...',
			showCancelButton: false,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Kembali'
			}).then((result) => {
				if (result.value) {
					document.location.href = 'index.php?page=Etalase Toko';
				}
			})</script>";

		}elseif ($sqlResult->num_rows==0) {
			$nama_banten_baru = $_POST['nama_banten'];
			$deskripsi_banten_baru = $_POST['deskripsi_banten'];
			$kelengkapan_banten_baru = $_POST['kelengkapan_banten'];
			$hargaawal_banten = (int)$_POST['harga_banten'];
			$diskon_banten = (float)$_POST['diskon_banten'];
			$stok_banten = $_POST['stok_banten'];
			if (empty($diskon_banten)) {
				$diskon_banten=0;
			}
			$hargaakhir_banten = $hargaawal_banten-(($hargaawal_banten*$diskon_banten)/100);
 			//boleh insert ke tabel detail
			$query="INSERT INTO detailbanten VALUES('','$id_banten','$id_tingkatan','$stok_banten','$hargaawal_banten','$diskon_banten','$hargaakhir_banten')";
			$sqlResult = $koneksi->query($query);

			if ($sqlResult==true) {
 				//berhaisl insert data ke dalam database
				echo "<script>
				Swal.fire({
					title: 'BERHASIL TAMBAH INFORMASI',
					icon:'success',
					text: 'Yeyy informasi lengkap, tunggu pesanan yaa..',
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ke Etalase'
					}).then((result) => {
						document.location.href = 'index.php?page=Etalase Toko';
					})</script>";
				}else{
 				//gagal insert data ke dlaam database
				}
			}
		} 
		?>
