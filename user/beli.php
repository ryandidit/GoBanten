<?php 
require_once 'templates_dashboard/header.php';
$id_detailBanten = $_GET['id'];
$id_toko = $_GET['toko'];
if ($_GET['page']=="Beli") {
	if ($_GET['type']=="tambah") {
			//cek jika produk dengan id tersebut sudah pernah diklik beli sebelumnya, maka session produk yang bersangkutan bertambah 1
		if (isset($_SESSION['beli'][$id_detailBanten])) {
			$_SESSION['beli'][$id_detailBanten]++;
		}
			//jika belum sama sekali, maka buat session dengan id banten tersebut
		else{
			//null
			$_SESSION['beli'][$id_detailBanten] = 1;
			$_SESSION['jumlahItem'][$id_toko]++; // karena item di toko tersebut berbeda, artinya untuk toko tersebut ada x+1 item yang dibeli
		}
		header('Location:index.php?page=Keranjang');
		exit;
	}elseif ($_GET['type']=="kurang") {
			//cek jika produk dengan id tersebut sudah pernah diklik beli sebelumnya, maka session produk yang bersangkutan berkurang 1
		if (isset($_SESSION['beli'][$id_detailBanten])) {
			if ($_SESSION['beli'][$id_detailBanten]>0) {
				$_SESSION['beli'][$id_detailBanten]--;
			}
			if($_SESSION['beli'][$id_detailBanten]==0){
				unset($_SESSION['beli'][$id_detailBanten]);
				if ($_SESSION['jumlahItem'][$id_toko]>0) {
					$_SESSION['jumlahItem'][$id_toko]--;
				}elseif ($_SESSION['jumlahItem'][$id_toko]==0) {
					unset($_SESSION['jumlahItem'][$id_toko]);
					unset($_SESSION['toko'][$id_toko]);
				}
			}
		}
			//jika belum sama sekali, maka buat session dengan id obat tersebut
		else{
			$_SESSION['beli'][$id_detailBanten] = 1;
			$_SESSION['jumlahItem'][$id_toko]++; // karena item di toko tersebut berbeda, artinya untuk toko tersebut ada x+1 item yang dibeli
		}
		header('Location:index.php?page=Keranjang');
		exit;
	}elseif($_GET['type']=="null"){
			//cek jika produk dengan id tersebut sudah pernah diklik beli sebelumnya, maka session produk yang bersangkutan bertambah 1
		if (isset($_SESSION['toko'][$id_toko])) {
			if (isset($_SESSION['beli'][$id_detailBanten])) {
				$_SESSION['beli'][$id_detailBanten]++;
			}else{
				$_SESSION['beli'][$id_detailBanten] = 1;
				$_SESSION['jumlahItem'][$id_toko]++; // karena jenis item di toko tersebut berbeda, artinya untuk toko tersebut ada x+1 item yang dibeli
			}
		}
			//jika belum sama sekali, maka buat session untuk setiap toko
		else{
			$_SESSION['toko'][$id_toko] = $id_toko;
			$_SESSION['jumlahItem'][$id_toko]=1; //sebagai penanda banyak banten yang masih ada di setiap toko 
			$_SESSION['beli'][$id_detailBanten] = 1;
		}


		//animasi untuk hitung mundur
		echo "<script>
		let timerInterval
		Swal.fire({
			title: 'Lihat Keranjangmu!',
	 	// html: 'Lihat <b></b> keranjangmu.',
			timer: 1000,
			timerProgressBar: false,
			onBeforeOpen: () => {
				timerInterval = setInterval(() => {
					const content = Swal.getContent()
					if (content) {
						const b = content.querySelector('b')
						if (b) {
							b.textContent = Swal.getTimerLeft()
						}
					}
					}, 100)
					},
					onClose: () => {
						clearInterval(timerInterval)
					}
					}).then((result) => {
						document.location.href = 'index.php?page=Keranjang';
					})</script>";
				}
			}
			?>
			<?php 
			require_once 'templates_dashboard/footer.php';
			?>