<h2><?php echo $_GET['page']; ?></h2>
<hr>
<form class="form-group" method="post">
	<!-- Lakukan perulangan setiap baris setelah query -->
	<?php
	$query = "SELECT * FROM obat";
	$ambil = $koneksi_apotek->query($query);  
	?>
	<?php while ($dataPerProduk = $ambil->fetch_assoc()):?>
		<div class="row border-bottom border-top">
			<!-- KOLOM PERTAMA -->
			<div class="col-md-3 border-right">
				<!-- Foto Barang (example foto obat) -->
				<div class="thumbnail shadow-lg p-3 mb-5 mt-3 bg-white rounded">
					<img src="<?php echo BASEURL2 ?>/img_obat/<?php echo $dataPerProduk['foto_obat'] ?>" style="width: 75%;" name="fotoBarang">
				</div>
			</div>
			<!-- KOLOM KEDUA -->
			<div class="col-md-3 border-right">
				<!-- Detail Pemesanan -->
				<div class="form-group">
					<div class="card mt-2">
						<div class="card-header">
							<strong>Banten Galungan</strong>
						</div>
						<div class="card-body">
							<!-- Text Here -->
							<h5 class="card-title">Special title treatment</h5>
							<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
							<h5 class="card-title">Special title treatment</h5>
							<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						</div>
					</div>
				</div>
			</div>
			<!-- KOLOM KETIGA -->
			<div class="col-md-3 border-right mt-2 mb-2">
				<!-- Alamat Pemesanan-->
				<div class="form-group">
					<label>Alamat</label>
					<textarea name="alamat" class="form-control" rows="5"></textarea>
				</div>
				<!-- Catatan Pemesanan-->
				<div class="form-group">
					<label>Catatan Pemesanan</label>
					<textarea name="catatan_pemesanan" class="form-control" rows="5"></textarea>
				</div>
			</div>
			<!-- KOLOM KEEMPAT -->
			<?php if ($_GET['page']=="Pemesanan Baru"): ?>
				<div class="col-md-3 mt-2 mb-2">
					<!-- Lama Pembuatan -->
					<div class="form-group">
						<label>Lama Pembuatan (Hari)</label>
						<input type="number" class="form-control form-control-user" placeholder="" name="lama_pembuatan">
					</div>
					<!-- Catatan Penolakan-->
					<div class="form-group">
						<label>Catatan Penolakan</label>
						<textarea name="catatan_penolakan" class="form-control" rows="5"></textarea>
					</div>
					<!-- Button Added -->
					<div class="form-group">
						<div class="row">							
							<div class="col">
								<button class="btn btn-block btn-primary" type="submit" name="accept">Terima Pesanan</button>
							</div>
							<div class="col">
								<button class="btn btn-block btn-danger" type="submit" name="decline">Tolak Pesanan</button>
							</div>
						</div>
					</div>
				</div>
				<?php elseif ($_GET['page'] == "Pemesanan Diterima"): ?>
					<div class="form-group">						
						<div class="row rows-2">				
							<div class="col">
								<button class="btn btn-block btn-primary btn-lg" type="submit" name="accept">Terima Pesanan</button>
							</div>	
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endwhile; ?>		
	</form>