<?php
require_once 'templates_dashboard/header.php';
if (!isset($_SESSION['admin'])) {
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
		$id_penjual = $_SESSION['admin']['id_admin'];
	}
	?>
	<div class="d-flex" id="wrapper">
		<!-- Sidebar -->
		<div class="bg-light  " id="sidebar-wrapper" >
			<div class="sidebar-heading bg-dark text-light text-center " style="height: 4rem;">
				<a class="navbar-brand text-light" href="#">
					<img src="../assets/img/logo/gobanten1.png" width="150"  class="d-inline-block align-top" alt="">
				</a>
			</div>
			<div class="list-group list-group-flush">
				<a href="index.php?page=Dashboard" class="list-group-item list-group-item-action bg-light">
					<svg class="bi bi-house-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M8 3.293l6 6V13.5a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 012 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 01.5-.5h1a.5.5 0 01.5.5z" clip-rule="evenodd"/>
						<path fill-rule="evenodd" d="M7.293 1.5a1 1 0 011.414 0l6.647 6.646a.5.5 0 01-.708.708L8 2.207 1.354 8.854a.5.5 0 11-.708-.708L7.293 1.5z" clip-rule="evenodd"/>
					</svg>
					Dashboard
				</a>
				<a href="index.php?page=Informasi Toko&no=0" class="list-group-item list-group-item-action bg-light">
					<svg class="bi bi-info-circle-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M8 16A8 8 0 108 0a8 8 0 000 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
					</svg>
					Informasi Toko
				</a>
				<a href="index.php?page=Informasi Penjual" class="list-group-item list-group-item-action bg-light">
					<svg class="bi bi-info-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
						<path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
						<circle cx="8" cy="4.5" r="1"/>
					</svg>
					Informasi Penjual
				</a>
				<a href="#" class="list-group-item list-group-item-action bg-light">
					Events
				</a>
				<a href="index.php?page=Profile Admin" class="list-group-item list-group-item-action bg-light">
					<svg class="bi bi-person-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path d="M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z"/>
						<path fill-rule="evenodd" d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
						<path fill-rule="evenodd" d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z"/>
					</svg>
					Profile
				</a>
				<a href="#" class="list-group-item list-group-item-action bg-light">
					<svg class="bi bi-question-circle-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.57 6.033H5.25C5.22 4.147 6.68 3.5 8.006 3.5c1.397 0 2.673.73 2.673 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.355H7.117l-.007-.463c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.901 0-1.358.603-1.358 1.384zm1.251 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z"/>
					</svg>
					Status
				</a>
			</div>
		</div>
		<!-- /#sidebar-wrapper -->
		<!-- Page Content -->
		<div id="page-content-wrapper">
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 4rem;">
				<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<form class="form-inline my-2 my-lg-0 " method="get" action="index.php">
					<input class="form-control mr-sm-2 " type="search" placeholder="Search Page" aria-label="Search" name="page" id="page" value="" required="true">
					<button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
				</form>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item dropdown dropleft">
							<a class="nav-link dropdown-toggle" href="#" id="navbarKeluhan" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Keluhan  <span class="badge badge-danger badge-counter">3</span>
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarKeluhan">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
							</div>
						</li>
						<li class="nav-item dropdown dropleft">
							<a class="nav-link dropdown-toggle dropleft" href="" id="navbarProfile" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Profile
							</a>
							<div class="dropdown-menu dropleft" aria-labelledby="navbarProfile">
								<img class="rounded-circle dropdown-item" src="<?php echo BASEURL; ?>assets/img/admin/<?php echo $_SESSION['admin']['foto_admin']; ?>" style="width: 120px; height: 100px; display: block; margin-left: auto;margin-right: auto; ">
								<h5 class="text-center">
									<?php
									echo $_SESSION['admin']['namadepan_admin'];
									?>
								</h5>
								<div class="dropdown-divider mt-3"></div>
								<a class="dropdown-item" href="index.php?page=Profile Admin">Edit Profil</a>
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModalAdmin">Logout</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>
			<div class="container-fluid ">
				<?php
				if (isset($_GET['page'])) {
					if ($_GET['page']=="Dashboard") {
						require_once 'content/dashboard.php';
					}elseif ($_GET['page']=="Informasi Toko") {
						require_once 'content/informasitoko.php';
					}elseif ($_GET['page']=="Profile Admin") {
						require_once 'content/profile.php';
					}elseif ($_GET['page']=="Informasi Penjual") {
						require_once 'content/informasipenjual.php';
					}
				}
				?>
			</div>
			<!-- Logout Modal-->
			<div class="modal fade" id="logoutModalAdmin" tabindex="-1" role="dialog" aria-labelledby="modalLogoutAdmin" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="modalLogoutAdmin">Yakin ingin keluar ?</h5>
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