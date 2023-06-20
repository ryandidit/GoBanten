<?php 
require_once 'templates_dashboard/header.php';
unset($_SESSION['penjual']);
echo "<script>
Swal.fire({
	title: 'LOGOUT',
	icon:'warning',
	text: 'Anda telah logout!!',
	showCancelButton: false,
	confirmButtonColor: '#d33',
	cancelButtonColor: '#d33',
	confirmButtonText: 'Login'
	}).then((result) => {
		document.location.href = 'login.php';
	})</script>";?>


	<?php 
	require_once 'templates_dashboard/footer.php';
	?>