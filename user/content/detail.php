<?php
$id_detail = $_GET['id'];
$query = "SELECT * FROM detailbanten db INNER JOIN banten b ON db.id_banten = b.id_banten INNER JOIN toko t ON t.id_toko = b.id_toko INNER JOIN tingkatanbanten tb ON tb.id_tingkatan=db.id_tingkatan INNER JOIN penjual p ON p.id_toko=t.id_toko INNER JOIN wilayah w ON w.id_wilayah=t.id_wilayah WHERE db.id_detail = '$id_detail'";
$ambil = $koneksi->query($query);
$banten = $ambil->fetch_assoc();
$id_toko = $banten['id_toko'];
$id_detail = $banten['id_detail'];
?>
<!-- Content -->
<div class="container-fluid">
	<div class="container mt-3 mb-3">
		<div class="card">
			<h5 class="card-header text-center">
				Detail Barang
			</h5>
			<div class="card-body">
				<div class="row">
					<div class="col-6">
						<!-- Detail barangnya -->
						<div class="row">
							<div class="col">
								<div class="card" style="width: 25rem;">
									<img class="card-img-top center" src="<?php echo BASEURL ?>assets/img_banten/fullsize/<?php echo $banten['foto_banten'] ?>" alt="Card image cap" style="height: 90%; width: 90%; overflow: auto;">
									<div class="card-body" style="height: 30rem;">
										<!-- Nama Banten -->
										<h5 class="card-title  text-center" style="height: 4rem;">
											<?php echo $banten['nama_banten']; ?>
										</h5>
										<h6 class="card-subtitle mb-2 text-muted" >Tingkatan Banten</h6>
										<p class="card-text" style="height: 2rem;">
											<?php echo $banten['nama_tingkatan'];?>
										</p>
										<h6 class="card-subtitle mb-2 text-muted" >Deskripsi Barang</h6>
										<p class="card-text" style="height: 6rem;">
											<?php echo $banten['deskripsi_banten'];?>
										</p>
										<h6 class="card-subtitle mb-2 text-muted" >Kelengkapan Barang</h6>
										<p class="card-text" style="height: 6rem;">
											<?php echo $banten['kelengkapan_banten']; ?>
										</p>
									</div>
								</div>
							</div>
						</div>
						<!-- PEnjelasan Tulisan -->
						<div class="card" style="width: 25rem;">
							<ul class="list-group list-group-flush">
								<li class="list-group-item">
									Harga Awal : Rp.<?php echo number_format($banten['hargaawal_detail']); ?>
								</li>
								<li class="list-group-item">
									Diskon : <?php echo $banten['diskon_detail']; ?>%
								</li>
								<li class="list-group-item">
									Harga Akhir : Rp.<?php echo number_format($banten['hargaakhir_detail']); ?>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-6">
						<!-- Toko dijualnya barang -->
						<div class="row">
							<div class="col">
								<div class="card mb-3">
									<img class="card-img-top" src="<?php echo BASEURL; ?>assets/img/toko/<?php echo $banten['foto_toko']; ?>" alt="Card image cap">
									<div class="card-body">
										<h5 class="card-title" style="height: 3rem;">
											<?php echo $banten['nama_toko']; ?>
										</h5>
										<h6 class="card-subtitle mb-2 text-muted" >Pemilik </h6>
										<p class="card-text" style="height: 2rem;">
											<?php echo $banten['namadepan_penjual']." ".$banten['namabelakang_penjual']; ?>
										</p>
										<h6 class="card-subtitle mb-2 text-muted" >Alamat </h6>
										<p class="card-text" style="height: 3rem;">
											<?php echo $banten['alamat_toko'];?>, <?php echo $banten['kota_wilayah']; ?>, <?php echo $banten['provinsi_wilayah']; ?>
										</p>
										<h6 class="card-subtitle mb-2 text-muted" >Deskripsi Toko</h6>
										<p class="card-text" style="height: 4rem;">
											<?php echo $banten['deskripsi_toko']; ?>
										</p>
										<h6 class="card-subtitle mb-2 text-muted" >Catatan Toko</h6>
										<p class="card-text"style="height: 4rem;">
											<?php echo $banten['catatan_toko']; ?>
										</p>
										<p class="card-text" style="height: 2rem;">
											<small class="text-muted">
												STATUS [<?php echo $banten['status_toko']; ?>]
											</small>
										</p>
									</div>
								</div>
							</div>
						</div>
						<!-- Button added -->
						<div class="row">
							<div class="col-4">
								<a href="index.php?page=Home" class="btn btn-warning btn-block">Kembali</a>
							</div>
							<div class="col-8">
								<a class="btn btn-primary btn-block " href="beli.php?page=Beli&type=null&id=<?php echo $id_detail; ?>&toko=<?php echo $id_toko; ?>" role="button" name="btnDetailBeliBarang" id="btnDetailBeliBarang" >
									Beli
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



