<?php
$id_banten = $_GET['id'];
//query dari tabel banten dan detail banten
$queryDetailBantenLengkap = "SELECT * FROM detailbanten db INNER JOIN banten b ON db.id_banten=b.id_banten INNER JOIN tingkatanbanten tb ON tb.id_tingkatan=db.id_tingkatan INNER JOIN kategoribanten kb ON kb.id_kategori=b.id_kategori WHERE db.id_banten='$id_banten'";
$jalankanQuery = $koneksi->query($queryDetailBantenLengkap);
$returnRowsDetailBanten = $jalankanQuery->num_rows;
$query = "SELECT * FROM banten WHERE id_banten = '$id_banten'";
$sqlResult=$koneksi->query($query);
$getDataBanten = $sqlResult->fetch_assoc();
?>

<div class="container-fluid">
	<div class="card mt-2 mb-4 shadow-lg">
		<h1 class="display-4 card-header">
			Edit Informasi
		</h1> 
		<div class="card-body">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active">
							<form method="post" action="index.php?page=Edit Informasi&id=<?php echo $id_banten; ?>" name="formKategori">
								<div class="row">
									<!-- Select Kategori -->
									<div class="col">
										<!-- Kategori Banten -->
										<div class="form-group">
											<!-- Query dari tabel tingkatanBanten -->
											<?php
											$query = "SELECT tb.nama_tingkatan,tb.id_tingkatan FROM tingkatanbanten tb INNER JOIN detailbanten db ON tb.id_tingkatan=db.id_tingkatan WHERE db.id_banten='$id_banten'";
											$sqlResult = $koneksi->query($query);
											?>
											<select class="form-control" id="tingkatan_banten" name="tingkatan_banten">
												<option value="null">-tingkatan-</option>
												<?php while ($tingkatanbanten = $sqlResult->fetch_assoc()):?>
													<!-- Memasukan nama kategori dari hasil query ke dalam array untuk dicocokkan pada tahap selanjutnya -->
													<?php $array_tingkatanbanten[] = $tingkatanbanten['nama_tingkatan']; ?>
													<option value="<?php echo $tingkatanbanten['id_tingkatan']; ?>"><?php echo $tingkatanbanten['nama_tingkatan']; ?></option>
												<?php endwhile ?>
												<option value="all">Semua Kategori</option>
											</select>
										</div>
									</div>
									<div class="col">
										<button type="submit" class="btn btn-primary" name="btnTampilkanPerTingkatanBanten" id="btnTampilkanPerTingkatanBanten" for="formKategori">Tampilkan</button>
									</div>
								</div>	
							</form>
						</li>
						<li class="nav-item">
							<!-- Button triggers -->
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalScrollable">
								Edit Properti Banten
							</button>
						</li>
					</ul>
				</div>
			</nav>

			<!-- Row baris pertama ubah nama banten dan peletakan select kategori -->
			<div class="row">
				<!-- Modal -->
				<form method="post" action="index.php?page=Edit Informasi&id=<?php echo $id_banten; ?>" name="formUbahNamaBanten" enctype="multipart/form-data">
					<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="modalUbahKeteranganBanten" aria-hidden="true">
						<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="modalUbahKeteranganBanten">Ubah Keterangan Banten</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<!-- Modal body start -->
									<!-- Ubah Properti Banten -->
									<img class="img-thumbnail-top center shadow" src="<?php echo BASEURL ?>assets/img_banten/fullsize/<?php echo $getDataBanten['foto_banten']; ?>" alt="Card image cap" style="width: 10rem;">
									<div class="card-body text-center">
										<p class="card-text font-weight-bold">
											<h4><?php echo $getDataBanten['nama_banten']; ?></h4>
										</p>
									</div>
									<div class="bg-light p-4">
										<div class="container-fluid">
											<!-- Nama Banten -->
											<div class="row">
												<div class="col">
													<div class="form-group"> 
														<label for="nama_bantenBaru">Nama Barang</label>
														<input type="text" class="form-control" id="nama_bantenBaru" name="nama_bantenBaru" value="<?php echo $getDataBanten['nama_banten']; ?>" aria-describedby="label_nama_bantenBaru" required="true">
														<small id="label_nama_bantenBaru" class="form-text text-muted">*Nama Barang akan diganti untuk semua tingkatan</small>
													</div>
												</div>
											</div>
											<!-- Deskripsi -->
											<div class="row">
												<div class="col">
													<div class="form-group"> 
														<label for="deskripsi_bantenBaru">Deskripsi</label>
														<textarea class="form-control" id="deskripsi_bantenBaru" rows="3" name="deskripsi_bantenBaru" aria-describedby="label_deskripsi_bantenBaru" required="true" value=""><?php echo $getDataBanten['deskripsi_banten']; ?></textarea>
														<small id="label_deskripsi_bantenBaru" class="form-text text-muted">*Deskripsi akan diganti untuk semua tingkatan</small>
													</div>
												</div>
											</div>
											<!-- Kelengkapan Banten -->
											<div class="row">
												<div class="col">
													<div class="form-group"> 
														<label for="kelengkapan_bantenBaru">Kelengkapan</label>
														<textarea class="form-control" id="kelengkapan_bantenBaru" rows="3" name="kelengkapan_bantenBaru" aria-describedby="label_kelengkapan_bantenBaru" required="true" value=""><?php echo $getDataBanten['kelengkapan_banten']; ?></textarea>
														<small id="label_kelengkapan_bantenBaru" class="form-text text-muted">*Kelengkapan akan diganti untuk semua tingkatan</small>
													</div>
												</div>
											</div>
											<!-- Ubah foto banten -->
											<div class="row">
												<div class="col">
													<div class="form-group">
														<div class="custom-file mt-2">
															<!-- Inputkan nama gambar sebelumnya jika user tidak mengupdate gambar -->
															<input type="hidden" name="foto_bantenLama" value="<?php echo $getDataBanten['foto_banten']; ?>">
															<input type="file" class="custom-file-input" name="foto_banten" id="foto_banten" value="" aria-describedby="foto_banten">
															<label for="foto_banten" class="custom-file-label" >Foto Banten</label>
															<small id="foto_banten" class="form-text text-muted">*Abaikan jika tidak ingin mengganti foto</small>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<!-- Modal body end -->
								</div>
								<!-- Modal Footer -->
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
									<button type="submit" class="btn btn-primary" name="buttonUbahInformasiBanten" id="buttonUbahInformasiBanten" value="">Ganti</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<!-- Daftar Banten yang sudah diupload -->
			<div class="row mt-5 mb-2">
				<!-- Start Pagination in Page -->
				<div class="col">
					<section class="konten">
						<div class="container">
							<div class="row">
								<!-- Lakukan perulangan col-md3 dengan php agar kekanan -->
								<?php
								// Tangkap kategori banten yang dipilih
								if (isset($_POST['btnTampilkanPerTingkatanBanten'])) {
									$tingkatan_banten = $_POST['tingkatan_banten'];
									// Tampilkan semua tingkatan banten
									if ($tingkatan_banten=="null" || $tingkatan_banten=="all") {
										//beri peringatan tidak ada yang ditampilkan
										$query = "SELECT * FROM detailbanten db INNER JOIN banten b ON db.id_banten=b.id_banten INNER JOIN tingkatanbanten tb ON tb.id_tingkatan=db.id_tingkatan INNER JOIN kategoribanten kb ON kb.id_kategori=b.id_kategori WHERE db.id_banten='$id_banten'";
										$jalankanQuery = $koneksi->query($query);
									}
									// Tampilkan hanya tingkatna yang dipilh
									else{
										//do query from tabel banten
										$query = "SELECT * FROM detailbanten db INNER JOIN banten b ON db.id_banten=b.id_banten INNER JOIN tingkatanbanten tb ON tb.id_tingkatan=db.id_tingkatan INNER JOIN kategoribanten kb ON kb.id_kategori=b.id_kategori WHERE db.id_banten='$id_banten' AND db.id_tingkatan='$tingkatan_banten'";
										$jalankanQuery = $koneksi->query($query);
									}
								}
								?>
								<?php if (isset($_POST['btnTampilkanPerTingkatanBanten']) || !empty($jalankanQuery)): ?>
								<?php while($data=$jalankanQuery->fetch_assoc()):?>
									<form method="post" action="index.php?page=Edit Informasi&id=<?php echo $id_banten; ?>" enctype="multipart/form-data">
										<div class="col-md-4 mb-3">
											<div class="card bg-light shadow-sm" style="width: 20rem;">
												<!-- Passing id_banten, id_tingkatan dan id_detail -->
												<!-- Id Banten -->
												<input type="hidden" name="id_bantenSelected" value="<?php echo $data['id_banten']; ?>">
												<!-- Tingkatan Banten -->
												<input type="hidden" name="id_tingkatanSelected" value="<?php echo $data['id_tingkatan']; ?>">
												<!-- id_detail banten -->
												<input type="hidden" name="id_detailSelected" value="<?php echo $data['id_detail']; ?>">

												<!-- Foto Banten -->
												<img class="card-img-top" src="<?php echo BASEURL ?>assets/img_banten/fullsize/<?php echo $data['foto_banten'] ?>" alt="Card image cap">
												<div class="card-body" >	
													<!-- Nama Banten dan Nama Tingkatan -->
													<h5 class="card-title">
														<?php echo $data['nama_banten']." "."[".$data['nama_tingkatan']."]"; ?>
													</h5>
													<!-- Stok Barang -->
													<div class="row">
														<div class="col">
															<div class="form-group">
																<label for="stok_banten">Stok</label>
																<input type="number" class="form-control" id="stok_banten" aria-describedby="stok_banten" value="<?php echo $data['stok_detail'] ?>" name="stok_banten">
																<small id="stok_banten" class="form-text text-muted">*Update stok jika sudah laku</small>
															</div>
														</div>
														<div class="col">
															<!-- Diskon Banten -->
															<div class="form-group">
																<label for="diskon_banten">Diskon </label>
																<input type="number" class="form-control" id="diskon_banten" name="diskon_banten" value="<?php echo $data['diskon_detail']; ?>" aria-describedby="diskon_banten">
																<small id="diskon_banten" class="form-text text-muted">*Abaikan jika tidak ada diskon</small>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col">
															<!-- Harga Banten -->
															<div class="form-group">
																<label for="harga_banten">Harga (Rp.)</label>
																<input type="number" class="form-control" id="harga_banten" name="harga_banten" value="<?php echo $data['hargaawal_detail']; ?>" required="true">
															</div>
														</div>
													</div>
													<!-- Button added -->
													<div class="row">
														<div class="col-4">
															<button type="submit" class="btn btn-danger " value="" name="<?php echo $data['id_detail']; ?>" id="<?php echo $data['id_detail']; ?>" onclick="return confirmHapusInformasi(<?php echo $data['id_detail']; ?>)" >
																Hapus
															</button>
															<!-- Memberikan nama unik untuk tombol hapus per id_detail -->
															<?php if (isset($_POST[$data['id_detail']])): ?>
																<?php
																$_POST['btnHapusInformasi']['ditekan'] = true;
																$_POST['btnHapusInformasi']['id_detail'] = $data['id_detail'];
																// Return value confirm user diassign 1 / 0 
																$_POST['btnHapusInformasi']['value'] = $_POST[$data['id_detail']];
																?>
																<!-- input value confirmhapuss -->
															<?php endif ?>
														</div>
														<div class="col-8">
															<button type="submit" class="btn btn-primary btn-block" value="" name="btnSubmitEditInformasi">Ubah</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
								<?php endwhile ?>
							<?php endif ?>
							<!-- endwhile -->
						</div>
					</div>
				</section>
			</div>
			<!-- End Pagination -->
		</div>
		<div class="row mt-2 mb-2">

		</div>

	</div>
	<div class="card-footer text-muted">
		*Edit Informasi Jika ada yang tidak sesuai
	</div>
</div>
</div>
<!-- PHP untuk button ubah nama banten baru -->
<?php
if (isset($_POST['buttonUbahInformasiBanten'])) {
	//boleh update ke tabel banten
	$nama_banten = $_POST['nama_bantenBaru'];
	$deskripsi_banten = $_POST['deskripsi_bantenBaru'];
	$kelengkapan_banten = $_POST['kelengkapan_bantenBaru'];
	$foto_banten = $_FILES['foto_banten']['name'];
	if ($foto_banten==null) {
		$foto_banten = $_POST['foto_bantenLama'];
	}
	$query = "UPDATE banten SET nama_banten = '$nama_banten', kelengkapan_banten = '$kelengkapan_banten', deskripsi_banten = '$deskripsi_banten', foto_banten = '$foto_banten' WHERE id_banten = '$id_banten'";
	$sqlResult = $koneksi->query($query);
	if ($sqlResult==true) {
				//beri alert berhaisl update data ke dalam database
		echo "<script>
		Swal.fire({
			title: 'BERHASIL UPDATE INFORMASI',
			icon:'success',
			text: 'Informasi sudah diperbarui yaa..',
			showCancelButton: false,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'OK'
			}).then((result) => {
				if (result.value) {
								// passing id_banten
					document.location.href = 'index.php?page=Edit Informasi&id=$id_banten';
				}
				})
				</script>";

			}else{
				//beri alert gagal update data ke dalam database
				echo "Gagal update ke dalam database";
			}
		} 
		?>
		<!-- PHP untuk button SubmitEditInformasi jika ditekan -->
		<?php
		if (isset($_POST['btnSubmitEditInformasi'])) {
			$id_banten = $_POST['id_bantenSelected'];
			$id_tingkatan = $_POST['id_tingkatanSelected'];
			$id_detail = $_POST['id_detailSelected'];
			$stok_banten = $_POST['stok_banten'];
			$diskon_banten = (float)$_POST['diskon_banten'];
			$hargaawal_detail = (int)$_POST['harga_banten'];
			$hargaakhir_detail = $hargaawal_detail-(($hargaawal_detail*$diskon_banten)/100);
			//update tabel detail banten sesuai id_detail 
			$query = "UPDATE detailbanten set stok_detail = $stok_banten, hargaawal_detail = $hargaawal_detail,hargaakhir_detail=$hargaakhir_detail, diskon_detail=$diskon_banten WHERE id_detail = $id_detail";
			$sqlResult = $koneksi->query($query);
			if ($sqlResult==true) {
				//berhasil update detailbante
				echo "<script>
				Swal.fire({
					title: 'BERHASIL UPDATE INFORMASI',
					icon:'info',
					text: 'Data kamu sudah diperbaharui yaa..!',
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'OK'
					}).then((result) => {
						if (result.value) {
								// passing id_banten
							document.location.href = 'index.php?page=Etalase Toko';
						}
						})
						</script>";
					}else{
					//gagal update detail banten

					}


				}
				?>
				<!-- PHP untuk mengecek button hapus barang-->
				<?php
				if (isset($_POST['btnHapusInformasi'])) {
					if ($_POST['btnHapusInformasi']['ditekan']==true) {
				// $_POST['btnHapusInformasi']['value'] sebagai tanda dia confirm hapus atau tidak
						if ($_POST['btnHapusInformasi']['value']==1) {
							$id_detail = $_POST['btnHapusInformasi']['id_detail'];
							$query = "DELETE FROM detailbanten WHERE id_detail = '$id_detail'";
							$sqlResult = $koneksi->query($query);
							if ($sqlResult==true) {
						//beri pesan bahwa data dengan id_detail sudah berhasil dihapus
								echo "<script>
								Swal.fire({
									title: 'BERHASIL HAPUS INFORMASI',
									icon:'info',
									text: 'Barang tersebut sudah dihapus yaa..',
									showCancelButton: false,
									confirmButtonColor: '#d33',
									cancelButtonColor: '#d33',
									confirmButtonText: 'OK'
									}).then((result) => {
										if (result.value) {
								// passing id_banten
											document.location.href = 'index.php?page=Etalase Toko';
										}
										})
										</script>";
									}else{
									//gagal menhapus data
									}
								}else{
					//do nothing karena user tidak jadi menghapus
								}
							}
						}

						?>
						<script language="javascript">
							function confirmHapusInformasi(id_detail_barang_dihapus){
								var returnValue=0;
								if (confirm('Yakin ingin hapus barang ini?\nAnda tidak bisa mengembalikannya!')) {
									returnValue=1;
								}
								document.getElementById(id_detail_barang_dihapus).value=returnValue;

							}
						</script>