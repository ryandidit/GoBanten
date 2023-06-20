<?php
if (empty($_SESSION['beli'])) {
	unset($_SESSION['toko']);
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
		exit;
	}

	?>
	<div class="container mt-5">
		<div class="card shadow-lg">
			<div class="card-header">
				<h4 class="display-4">
					Keranjang Belanja
				</h4>
			</div>
			<div class="card-body">
				<div class="container mt-4">
					<form method="post" action="checkout.php">
						<!-- Session isi -->
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Nama Barang</th>
									<th scope="col">Tingkatan</th>
									<th scope="col">Nama Toko</th>
									<th scope="col">Harga</th>
									<th scope="col">Jumlah</th>
									<th scope="col">Sub Total</th>
									<th scope="col">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$nomor=1;
								foreach ($_SESSION['beli'] as $id_detail => $jumlahDibeli) :
								//query dari tabel obat berdasarkan $id_detail
									if ($jumlahDibeli!=0):
										$query = "SELECT * FROM detailbanten db INNER JOIN banten b ON db.id_banten = b.id_banten INNER JOIN toko t ON b.id_toko=t.id_toko INNER JOIN tingkatanbanten tb ON tb.id_tingkatan = db.id_tingkatan WHERE db.id_detail = '$id_detail'";
										$ambil = $koneksi->query($query);
										$dataPerBanten = $ambil->fetch_assoc();
										?>

										<tr>
											<th scope="row"><?php echo $nomor; ?></th>
											<td><?php echo $dataPerBanten['nama_banten']; ?></td>
											<td><?php echo $dataPerBanten['nama_tingkatan']; ?></td>
											<td><?php echo $dataPerBanten['nama_toko']; ?></td>
											<td>Rp. <?php echo number_format($dataPerBanten['hargaakhir_detail']); ?></td>
											<td><?php echo $jumlahDibeli; ?></td>
											<td>Rp. <?php echo number_format($dataPerBanten['hargaakhir_detail'] * $jumlahDibeli); ?></td>
											<td>

												<a href="beli.php?page=Beli&type=tambah&id=<?php echo $dataPerBanten['id_detail']; ?>" class="badge badge-primary" style="margin-right: 2px;">+</a>
												<a href="beli.php?page=Beli&type=kurang&id=<?php echo $dataPerBanten['id_detail']; ?>&toko=<?php echo $dataPerBanten['id_toko']; ?>" class="badge badge-warning" style="margin-right: 2px;">-</a>
												<a href="index.php?page=Hapus&id=<?php echo $id_detail; ?>&toko=<?php echo $dataPerBanten['id_toko']; ?>" class="badge badge-danger" style="margin-left: 2px;" >x</a>

												
											</td>
										</tr>
										<?php
										$nomor++; 
									endif;
								endforeach;
								?>
							</tbody>
						</table>
						<a href="index.php" class="btn btn-info" style="margin-right: 3px;">Cari lagi</a>
						<a href="index.php?page=Checkout" class="btn btn-success" style="margin-right: 3px;">Checkout</a>
					</form>
				</div>

			</div>
		</div>
	</div>

