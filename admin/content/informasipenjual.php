<?php
$id_admin = $_SESSION['admin']['id_admin'];
$id_wilayah = $_SESSION['admin']['id_wilayah'];
$id_wilayah=2;
//subquery
//query untuk nampilin penjualnya yang mendirikan toko di wilayahnya tersebut
$sqlQuery = "SELECT * FROM penjual p WHERE id_toko IN (SELECT id_toko FROM toko WHERE id_wilayah = '$id_wilayah')";
$runQuery = $koneksi->query($sqlQuery);
$adaTokoAtauTidak = $runQuery->num_rows;
if ($adaTokoAtauTidak==0) {
	echo "Tidak ada toko";
}else{
	
}
$indeksStartSlider=0;
?>
<div class="container-fluid mb-3 mt-3">
	<div class="card">
		<h5 class="card-header display-4">
			<?php echo $_GET['page']; ?>
		</h5>
		<div class="card-body">
			<div class="container-fluid">
				<div class="row">
					<?php while ($informasiPenjual = $runQuery->fetch_assoc()) :?>
						<div class="col-md-6">
							<div class="card mb-3" style="width: auto;">
								<div class="row no-gutters">
									<div class="col-md-4">
										<img src="../assets/img/penjual/<?php echo $informasiPenjual['foto_penjual'] ?>" class="card-img " alt="..." >
									</div>
									<div class="col-md-8">
										<div class="card-body">
											<h5 class="card-title" style="height: 2rem;">
												<?php echo $informasiPenjual['namadepan_penjual']." ".$informasiPenjual['namabelakang_penjual']; ?>
											</h5>
											<h6 class="card-subtitle mb-2 text-muted">Email</h6>
											<p class="card-text">
												<?php echo $informasiPenjual['email_penjual']; ?>
											</p>
											<h6 class="card-subtitle mb-2 text-muted">Nomor Handphone</h6>
											<p class="card-text">
												<?php echo $informasiPenjual['hp_penjual']; ?>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
</div>
