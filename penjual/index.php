<?php 
require_once 'templates_dashboard/header.php';
if (!isset($_SESSION['penjual'])) {
  //berikan pesan bahwa anda harus login dulu baru bisa masuk ke halaman login
	echo "<script>
	Swal.fire({
		title: 'LOGIN',
		icon:'warning',
		text: 'Login dulu yaa...!',
		showCancelButton: false,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Login'
		}).then((result) => {
			document.location.href = 'login.php';
		})</script>";
		exit();
	}else{
		$id_penjual = $_SESSION['penjual']['id_penjual'];
		$id_toko = $_SESSION['penjual']['id_toko']; //sebagai tanda apakah pembeli tersebut sudah mendaftarkan toko atau belum ada toko
		$query = "UPDATE penjual SET id_toko = '$id_toko' WHERE id_penjual = $id_penjual";
		$koneksi->query($query);
		//perbarui session[penjual]
		$queryNewDataPenjualAfterRegistrasiNewToko = "SELECT * FROM penjual LEFT JOIN toko ON penjual.id_toko = toko.id_toko WHERE penjual.id_penjual = '$id_penjual'";
		$runQuery = $koneksi ->query($queryNewDataPenjualAfterRegistrasiNewToko);
		$_SESSION['penjual'] = $runQuery->fetch_assoc();
	}
//query dari tabel ongkir apakah toko yang bersangkutan sudah pernah mengeset ongkir pengirimannya untuk 9 wilayah di Bali
	$queryGetRowOngkirPengirimanWilayah =  "SELECT COUNT(id_wilayah) AS banyakWilayahOngkir FROM ongkir WHERE id_toko = '$id_toko'";
	$getRow = $koneksi->query($queryGetRowOngkirPengirimanWilayah);
	$data = $getRow->fetch_assoc();
	$banyakWilayahOngkir = $data['banyakWilayahOngkir'];
	$banyakWilayahOngkir = (int) $banyakWilayahOngkir;
	if ($banyakWilayahOngkir==9) {
	//jika jumlah ongkir yang sudah di set ==9 (jumlah kota di Bali)
	//boleh buka fitur lainnya
		$_SESSION['fitur'] = 1;
	}else{
	//beri peringatan bahwa jumlah kota yang diset ongkirnya belum lengkap
		unset($_SESSION['fitur']);
	}
	?>
	<!-- Navbar TOP -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="<?php echo BASEURL; ?>penjual/index.php?page=Dashboard">
			<a class="navbar-brand text-light" href="#">
				<img src="../assets/img/logo/gobanten1.png" width="200"  class="d-inline-block align-top" alt="">
			</a>
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<?php if ($id_toko!=0): ?>
					<li class="nav-item">
						<!-- query jumlah pesanan baru dari tabel pembelian -->
						<?php
						$id_toko = $id_toko;
						$status_pembelian = "";
				//SUB QUERY
						$queryDataPembelian = "SELECT * FROM (SELECT * FROM pembelian INNER JOIN pengguna ON pembelian.idpengguna_pembelian = pengguna.id_pengguna) AS combine WHERE combine.idtoko_pembelian = '$id_toko' AND combine.status_pembelian = ''";
						$ambil = $koneksi->query($queryDataPembelian); 
						$amountJumlahPesananBaru = $ambil->num_rows; 
						?>
						<a class="nav-link" href="index.php?page=Pemesanan Baru">
							Pesanan 
							<?php if ($amountJumlahPesananBaru!=0): ?>
								<span class="badge badge-warning badge-counter">
									<?php echo $amountJumlahPesananBaru; ?>
								</span>
							<?php endif ?>
						</a>
					</li>
					<form class="form-inline my-2 my-lg-0" method="post" action="index.php?page=Etalase Toko">
						<!-- POST['search'] -->
						<input class="form-control mr-sm-2 text-center" type="search" placeholder="Cari Banten" aria-label="Search" name="search" id="search">
						<button class="btn btn-secondary my-2 my-sm-0" type="submit" name="btnSearchBantenPenjual" id="btnSearchBantenPenjual" value="">Cari</button>
					</form>
				<?php endif ?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo $_SESSION['penjual']['namadepan_penjual']." ".$_SESSION['penjual']['namabelakang_penjual']; ?>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="index.php?page=Profile">Profile</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>
	<!-- Side Bar -->
	<div class="d-flex" id="wrapper">
		<!-- Sidebar -->
		<div class="bg-light border-right border-top" id="sidebar-wrapper">
			<!-- Foto Penjual -->
			<div class="sidebar-heading">
				<div class="rounded bg-light" style="height: 100px;">
					<img class="rounded-circle" src="../assets/img/penjual/<?php echo $_SESSION['penjual']['foto_penjual']; ?>" style="width: 120px; height: 100px; display: block; margin-left: auto;margin-right: auto; ">
				</div>
				<hr>
				<div class="card bg-primary">
					<div class="card-head">
						<h6 class="font-weight-normal text-light mt-1 text-center"><?php echo $_SESSION['penjual']['namadepan_penjual']." ".$_SESSION['penjual']['namabelakang_penjual']; ?></h6>
					</div>
				</div>
				<div class="rounded border container bg-primary">
					<div class="row ">
						<div class="col" >

						</div>
					</div>
				</div>
				<div class="container">
					<div class="row align-items-left">
						<div class="col-4 mt-2">
							<small class="text-muted">Saldo</small>
						</div>
						<div class="col-8 mt-2">
							<small>
								Rp.
								<?php echo number_format($_SESSION['penjual']['dompet_penjual']);  ?>
							</small>
						</div>
					</div>
				</div>
				<hr>
			</div>
			<div class="list-group list-group-flush">
				<a href="index.php?page=Dashboard" class="list-group-item list-group-item-action bg-light">
					<svg class="bi bi-house-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M8 3.293l6 6V13.5a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 012 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 01.5-.5h1a.5.5 0 01.5.5z" clip-rule="evenodd"/>
						<path fill-rule="evenodd" d="M7.293 1.5a1 1 0 011.414 0l6.647 6.646a.5.5 0 01-.708.708L8 2.207 1.354 8.854a.5.5 0 11-.708-.708L7.293 1.5z" clip-rule="evenodd"/>
					</svg>
					Dashboard
				</a>
				<!-- JIka dia sudah punya toko tapi belum melakukan setting wilayah -->
				<?php if ($id_toko!=0): ?>
					<a href="index.php?page=Informasi Toko" class="list-group-item list-group-item-action bg-light">
						<svg class="bi bi-info-circle-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M8 16A8 8 0 108 0a8 8 0 000 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
						</svg>
						Informasi Toko
					</a>
					<a href="index.php?page=Wilayah Pengiriman" class="list-group-item list-group-item-action bg-light">
						<svg class="bi bi-arrow-left-right" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M10.146 7.646a.5.5 0 01.708 0l3 3a.5.5 0 010 .708l-3 3a.5.5 0 01-.708-.708L12.793 11l-2.647-2.646a.5.5 0 010-.708z" clip-rule="evenodd"/>
							<path fill-rule="evenodd" d="M2 11a.5.5 0 01.5-.5H13a.5.5 0 010 1H2.5A.5.5 0 012 11zm3.854-9.354a.5.5 0 010 .708L3.207 5l2.647 2.646a.5.5 0 11-.708.708l-3-3a.5.5 0 010-.708l3-3a.5.5 0 01.708 0z" clip-rule="evenodd"/>
							<path fill-rule="evenodd" d="M2.5 5a.5.5 0 01.5-.5h10.5a.5.5 0 010 1H3a.5.5 0 01-.5-.5z" clip-rule="evenodd"/>
						</svg>
						Wilayah Pengiriman
					</a>
				<?php endif ?>
				<!-- JIka dia sudah mempunyai toko dan sudah melakukan setting ongkir wilayah -->
				<?php if ($id_toko!=0 && isset($_SESSION['fitur'])): ?>
					<a class="nav-link dropdown-toggle text-dark" href="#" id="pemesananDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<svg class="bi bi-bag-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M1 4h14v10a2 2 0 01-2 2H3a2 2 0 01-2-2V4zm7-2.5A2.5 2.5 0 005.5 4h-1a3.5 3.5 0 117 0h-1A2.5 2.5 0 008 1.5z"/>
						</svg>
						Pesanan
					</a>
					<div class="dropdown-menu" aria-labelledby="pemesananDropdown">
						<a class="dropdown-item" href="index.php?page=Pemesanan Diterima">Pesanan Diterima</a>
						<a class="dropdown-item" href="index.php?page=Pemesanan Dikirim">Pesanan Dikirim</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="index.php?page=Pemesanan Selesai">Pesanan Selesai</a>
					</div>
					<a href="index.php?page=Tambah Banten" class="list-group-item list-group-item-action bg-light">
						<svg class="bi bi-plus-square-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M2 0a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2H2zm6.5 4a.5.5 0 00-1 0v3.5H4a.5.5 0 000 1h3.5V12a.5.5 0 001 0V8.5H12a.5.5 0 000-1H8.5V4z" clip-rule="evenodd"/>
						</svg>
						Tambah Banten
					</a>
					<a href="index.php?page=Etalase Toko" class="list-group-item list-group-item-action bg-light">
						<svg class="bi bi-folder-symlink-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M13.81 3H9.828a2 2 0 01-1.414-.586l-.828-.828A2 2 0 006.172 1H2.5a2 2 0 00-2 2l.04.87a1.99 1.99 0 00-.342 1.311l.637 7A2 2 0 002.826 14h10.348a2 2 0 001.991-1.819l.637-7A2 2 0 0013.81 3zM2.19 3c-.24 0-.47.042-.684.12L1.5 2.98a1 1 0 011-.98h3.672a1 1 0 01.707.293L7.586 3H2.19zm9.608 5.271l-3.182 1.97c-.27.166-.616-.036-.616-.372V9.1s-2.571-.3-4 2.4c.571-4.8 3.143-4.8 4-4.8v-.769c0-.336.346-.538.616-.371l3.182 1.969c.27.166.27.576 0 .742z" clip-rule="evenodd"/>
						</svg>
						Etalase
					</a>
				<?php endif ?>
			</div>
		</div>
		<!-- /#sidebar-wrapper -->

		<!-- Page Content -->
		<!-- Navbar title -->
		<div class="border-right border-top" id="page-content-wrapper" >
			<!-- BODY di dalam page wrapper -->
			<!-- Cek Method GET / POST-->
			<?php
			if (isset($_GET['page'])) {
				if ($_GET['page']=="Informasi Toko") {
					require_once 'content/informasiToko.php';
				}elseif ($_GET['page']=="Etalase Toko") {
					require_once 'content/etalase.php';
				}elseif ($_GET['page']=="Tambah Banten") {
					require_once 'content/tambahBanten.php';
				}
				elseif ($_GET['page']=="Edit Informasi") {
					require_once 'content/editInformasi.php';
				}
				elseif ($_GET['page']=="Tambah Informasi") {
					require_once 'content/tambahInformasi.php';
				}
				elseif ($_GET['page']=="Pemesanan Baru") {
					require_once 'content/pemesananBaru.php';
				}
				elseif ($_GET['page']=="Pemesanan Diterima") {
					require_once 'content/pemesananDiterima.php';
				}
				elseif ($_GET['page']=="Pemesanan Dikirim") {
					if (isset($_POST['sendId'])) {
						$_GET['idBarang'] = $_POST['sendId'];
					}
					require_once 'content/pemesananDikirim.php';
				}
				elseif ($_GET['page']=="Pemesanan Selesai") {
					require_once 'content/pemesananSelesai.php';
				}
				elseif($_GET['page']=="Registrasi Toko"){
					require_once 'content/registrasiToko.php';
				}
				elseif ($_GET['page']=="Wilayah Pengiriman") {
					require_once 'content/wilayahPengiriman.php';
				}
				elseif ($_GET['page']=="Dashboard") {
					require_once 'dashboard.php';
				}
				elseif ($_GET['page']=="Profile") {
					require_once 'profile.php';
				}
				elseif ($_GET['page']=="logout") {
					require_once 'logout.php';
				}
			}else{
				require_once 'index.php';
			}
			?>
			<!-- Akhir dari page wrapper -->
		</div>
		<!-- /#page-content-wrapper -->
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
	<script language="javascript">
		function confirmHapusToko(id_toko){
			var  returnValue=0;
			if (confirm('Yakin hapus toko ini? Anda tidak dapat mengembalikannya!')) {
				returnValue=1;
			}
			document.getElementById("nilaiconfirmhapustoko").value=returnValue;

		}
	</script>
	<?php 
	require_once 'templates_dashboard/footer.php';
	?>
