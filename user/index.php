<?php 
require_once 'templates_dashboard/header.php';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-static-top">
	<!-- Navbar Brand -->
	<a class="navbar-brand text-light" href="#">
		<img src="<?php echo BASEURL; ?>assets/img/logo/gobanten1.png" width="200"  class="d-inline-block align-top" alt="">
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item ">
				<a class="nav-link" href="index.php?page=Home">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="index.php?page=Keranjang">Keranjang</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="index.php?page=Checkout">Checkout</a>
			</li>
			<!-- Cek jika session pembeli masihh kosong jangan ditampilkan -->
			<?php if (isset($_SESSION['pembeli'])): ?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarPesananDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Pesanan
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarPesananDropdown">
						<a class="dropdown-item" href="index.php?page=Pesanan Diproses">Pesanan Diproses</a>
						<a class="dropdown-item" href="index.php?page=Pesanan Dikirim">Pesanan Dikirim</a>
						<a class="dropdown-item" href="index.php?page=Pesanan Selesai">Pesanan Selesai</a>
					</div>
				</li>

			<?php endif ?>
			<li class="nav-item dropdown navbar-right">
				<?php if (!isset($_SESSION['pembeli'])): ?>
					<a href="login.php" class="nav-link">Login</a>
					<?php else: ?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarProfile" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Profile
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarProfile">
								<a class="dropdown-item" href="index.php?page=Profile">Edit Profile</a>
								<a class="dropdown-item" href="index.php?page=Nota Pembelian">Nota Pembelian</a>
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
							</div>
						</li>
					<?php endif ?>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<!-- Pemberitahuan -->
				<!-- Cek session pembeli apakahh kosong atau tidak, kalau kosong jangan tampilkan fitur ini -->
				<?php if (isset($_SESSION['pembeli'])): ?>
					<!-- query dari tabel pembelian dan tampilkan pesan banten yang ditolak berdasarkan id_pengguna -->
					<?php
					$status_pembelian_tolak = "Tolak";
					$status_pembelian_batal = "Batal";
					$idpengguna_pembelian = $_SESSION['pembeli']['id_pengguna'];
					$queryGetNumberPemberitahuanBantenDitolak = "SELECT  * FROM pembelian WHERE idpengguna_pembelian = '$idpengguna_pembelian' AND (status_pembelian = '$status_pembelian_tolak' OR status_pembelian = '$status_pembelian_batal')";
					$runQueryGetAmountBantenDitolak = $koneksi->query($queryGetNumberPemberitahuanBantenDitolak);
					$getAmountBantenDitolak = $runQueryGetAmountBantenDitolak->num_rows;
					?>
					<?php if ($getAmountBantenDitolak!=0): ?>
						<li class="nav-item">
							<a class="nav-link" href="index.php?page=Pemberitahuan" id="navbarPemberitahuan" >
								Pemberitahuan
								<span class="badge badge-warning badge-counter">
									<?php echo $getAmountBantenDitolak; ?>
								</span>
							</a>
						</li>

					<?php endif ?>
				<?php endif ?>
				<li class="nav-item">
					<form method="post" action="index.php?page=Home" class="form-inline my-2 my-lg-0 ml-auto">
						<!-- $_POST['search'] -->
						<input class="form-control mr-sm-2 text-center" type="search" placeholder="Cari Banten" name="search" aria-label="Search" id="search" value="" required="true">
						<button class="btn btn-danger my-2 my-sm-0" type="submit">Search</button>
					</form>
				</li>
			</ul>
		</div>
	</nav>



	<div class="container-fluid">
		<?php 
		if (!isset($_GET['page'])) {
			require_once 'content/home.php';
		}else if(isset($_GET['page'])) {
			if ($_GET['page']=="Detail") {
				require_once 'content/detail.php';
			}else if ($_GET['page']=="Beli") {
				require_once 'beli.php';
			}elseif ($_GET['page']=="Hapus") {
				require_once 'hapus.php';
			}else if ($_GET['page']=="Keranjang") {
				require_once 'keranjang.php';
			}else if ($_GET['page']=="Nota Pembelian") {
				require_once 'content/notapembelian.php';
			}
			else if ($_GET['page']=="Home") {
				require_once 'content/home.php';
			}else if ($_GET['page']=="Checkout") {
				require_once 'checkout.php';
			}else if ($_GET['page']=="Profile") {
				require_once 'content/profile.php';
			}else if ($_GET['page']=="Pemberitahuan") {
				require_once 'content/pemberitahuan.php';
			}elseif ($_GET['page']=="Pesanan Selesai") {
				require_once 'content/pesananSelesai.php';
			}elseif ($_GET['page']=="Pesanan Dikirim") {
				require_once 'content/pesananDikirim.php';
			}elseif ($_GET['page']=="Pesanan Diproses") {
				require_once 'content/pesananDiproses.php';
			}
		} 
		?>
	</div>


	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar ?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Pilih 'Logout' untuk keluar dari akun ini</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
					<a class="btn btn-danger" href="logout.php">Logout</a>
				</div>
			</div>
		</div>
	</div>
	<?php 
	require_once 'templates_dashboard/footer.php';
	?>