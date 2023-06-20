<?php 
require_once 'templates_dashboard/header.php';
unset($_SESSION['admin']);
echo "<script>
Swal.fire({
	title: 'LOGOUT',
	icon:'warning',
	text: 'Anda telah logout!!',
	showCancelButton: false,
	confirmButtonColor: '#d33',
	cancelButtonColor: '#d33',
	confirmButtonText: 'Beranda'
	}).then((result) => {
		document.location.href = 'login.php';
	})</script>";?>
	<?php 
	require_once 'templates_dashboard/footer.php';
	?>