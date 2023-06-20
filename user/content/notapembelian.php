<?php

//get data pembeli dari $_SESSION['pembeli']
$id_pengguna = $_SESSION['pembeli']['id_pengguna'];

//Cari id_toko yang pernah dibeli oleh id_pengguna dan kelompokkan untuk setiap id_toko yang sama
$queryPembelian = "SELECT * FROM nota WHERE idpengguna_nota = '$id_pengguna' GROUP BY idtoko_nota";
$runSQLGetIdToko = $koneksi->query($queryPembelian);
// cek jumlah baris yang dikembalikan dari runSQLGetIdToko jika 0 berarti nota pemblian sudah dihapus semuanya dan beri alert
if ($runSQLGetIdToko->num_rows==0) {
	echo "<script>
	Swal.fire({
		title: 'NOTA KOSONG',
		icon:'info',
		text: 'Tidak ada nota pembelian',
		showCancelButton: false,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Beranda'
		}).then((result) => {
			document.location.href = 'index.php?page=Home';
		})</script>";
		exit;
	}
	?>
	<div class="container mt-3">
		<?php while ($dataTokoPernahDibeli=$runSQLGetIdToko->fetch_assoc()):?>
			<div class="card mb-4">
				<div class="card-header">
					<h4 class="display-4">
						<?php
						$id_toko = $dataTokoPernahDibeli['idtoko_nota'];
						$barangBelanjaanTiapToko[$id_toko]=0;
						$queryToko = "SELECT nama_toko FROM toko WHERE id_toko = '$id_toko'";
						$runSQLGetNamaToko = $koneksi->query($queryToko);
						$toko = $runSQLGetNamaToko->fetch_assoc();
						echo $toko['nama_toko'];
						?>
					</h4>
				</div>
				<div class="card-body">
					<?php
					$queryCollectAllDataPembelian = "SELECT * FROM nota WHERE idtoko_nota = '$id_toko'";
					$runSQLCollectAllDataPembelian = $koneksi->query($queryCollectAllDataPembelian);
					while ($dataPembelian = $runSQLCollectAllDataPembelian->fetch_assoc()):?>
						<?php $barangBelanjaanTiapToko[$id_toko]++;//menambahkan barang yg pernah dibeli dengan ++ untuk setiap toko ?> 
						<!-- Session isi -->
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">Nama Barang</th>
									<th scope="col">Harga</th>
									<th scope="col">Diskon</th>
									<th scope="col">Harga Didiskon</th>
									<th scope="col">Jumlah</th>
									<th scope="col">Ongkir</th>
									<th scope="col">Sub Total</th>
									<th scope="col">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php $totalBelanjaan=0; ?>
									<td><?php echo $dataPembelian['namabanten_nota']; ?></td>
									<td><?php echo "Rp. ".number_format($dataPembelian['hargaawal_nota']); ?></td>
									<td><?php echo $dataPembelian['diskon_nota']; ?>%</td>
									<td><?php echo "Rp. ".number_format($dataPembelian['hargaawal_nota']-($dataPembelian['hargaawal_nota']*$dataPembelian['diskon_nota']/100)); ?></td>
									<td><?php echo $dataPembelian['quantity_nota']; ?></td>
									<td><?php echo "Rp. ".number_format($dataPembelian['hargaongkir_nota']); ?></td>
									<td><?php echo "Rp. ".number_format($dataPembelian['hargaakhir_nota']); ?></td>
									<td>
										<form method="post" action="index.php?page=Nota Pembelian">
											<input type="hidden" name="id_nota" id="id_nota" value="<?php echo $dataPembelian['id_nota']; ?>">
											<div class="form-group">
												<button class="btn btn-danger btn-sm" type="submit" id="<?php echo $dataPembelian['id_nota']; ?>" name="<?php echo $dataPembelian['id_nota']; ?>" value="" onclick="return confirmHapus(<?php echo $dataPembelian['id_nota']; ?>);">Hapus</button>
											</div>
										</form>
									</td>
									<?php
									$totalBelanjaan +=$dataPembelian['hargaakhir_nota'];
									?>
									<?php
									if (isset($_POST[$dataPembelian['id_nota']])) {
										if ($_POST[$dataPembelian['id_nota']]==1) {
											$id_nota = $_POST['id_nota'];
											$queryHapusPerNota = "DELETE FROM nota WHERE id_nota = '$id_nota'";
											$runSQLHapusPerNota = $koneksi->query($queryHapusPerNota);
											if ($runSQLHapusPerNota==true) {
												$barangBelanjaanTiapToko[$id_toko]--;
												if ($barangBelanjaanTiapToko[$id_toko]==0) {
												//beri alert kalo nota kosong dan alihkan ke beranda
													echo "<script>
													Swal.fire({
														title: 'NOTA TOKO DIBERSIHKAN',
														icon:'success',
														text: 'Nota sudah dihapus untuk toko ini',
														showCancelButton: false,
														confirmButtonColor: '#4BB543',
														cancelButtonColor: '#d33',
														confirmButtonText: 'OK'
														}).then((result) => {
															document.location.href = 'index.php?page=Nota Pembelian';
														})</script>";
													}else{
												//arahkan ke nota pembelian
														echo "<script>document.location.href = 'index.php?page=Nota Pembelian';</script>";
													}
												}

											}
										}
										?>
									</tr>
								</tbody>
								<tfoot >
									<tr >
										<th colspan="6">Total Belanjaan</th>
										<th>Rp. <?php echo number_format($totalBelanjaan); ?></th>
									</tr>
								</tfoot>
							</table>
						<?php endwhile; ?>
					</div>
					<div class="container mb-4">
						<div class="row">
							<div class="col-md-2">
								<form method="post" action="">
									<div class="form-group">
										<button class="btn btn-danger btn-block btn-sm" name="<?php echo $id_toko; ?>" id="<?php echo $id_toko; ?>">Bersihkan Semua</button>
									</div>
								</form>
								<!-- cekjika button bersihkan semua ditekan -->
								<?php
								if (isset($_POST[$id_toko])) {
									$queryBersihkanSemua = "DELETE FROM nota WHERE idtoko_nota = '$id_toko'";
									$runSQLBersihkanSemua = $koneksi->query($queryBersihkanSemua);
									if ($runSQLBersihkanSemua==true) {
										unset($_SESSION['toko'][$id_toko]);
										echo "<script>
										Swal.fire({
											title: 'NOTA DIBERSIHKAN',
											icon:'success',
											text: 'Data Nota sudah terhapus semuanya',
											showCancelButton: false,
											confirmButtonColor: '#4BB543',
											cancelButtonColor: '#d33',
											confirmButtonText: 'OK'
											}).then((result) => {
												document.location.href = 'index.php?page=Nota Pembelian';
											})</script>";
										}
									}?>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>

			<script language="javascript">
				function confirmHapus(id_nota){
					var returnValue=0;
					if (confirm("Yakin hapus data nota ini?")) {
						returnValue=1;
					}
					document.getElementById(id_nota).value=returnValue;
				}
			</script>