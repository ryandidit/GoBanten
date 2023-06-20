<?php 
	//ambil id obat pada session yang ingin dihapus
$id_detailBanten = $_GET['id'];
$id_toko = $_GET['toko'];

//unset
unset($_SESSION['beli'][$id_detailBanten]);
$banyakItemPerToko = --$_SESSION['jumlahItem'][$id_toko];
if ($banyakItemPerToko==0) {
	//unset toko karena sudah tidak ada banten lagi
	unset($_SESSION['toko'][$id_toko]);
	unset($_SESSION['jumlahItem'][$id_toko]);
}
echo "<script>
Swal.fire({
	title: 'BARANG DIHAPUS',
	icon:'success',
	text: 'Barang belanjaan dihapus dari keranjang',
	showCancelButton: false,
	confirmButtonColor: '#4BB543',
	cancelButtonColor: '#d33',
	confirmButtonText: 'Beranda'
	}).then((result) => {
		if (result.value) {
			document.location.href = 'index.php?page=Keranjang';
		}
	})</script>";

	?>