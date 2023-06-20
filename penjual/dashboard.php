<?php
$id_toko = $_SESSION['penjual']['id_toko'];

//set alamat url untuk background jumbotron penjualnnya

if ($id_toko!=0) {
	$foto_toko = $_SESSION['penjual']['foto_toko'];
}else{
	$foto_toko = "imagetoko_2.jpg";
}
$url = BASEURL."assets/img/toko/";
$url = $url.$foto_toko;
function greeting(){
	// I'm India so my timezone is Asia/Calcutta
	date_default_timezone_set('Asia/Jakarta'); //GMT + 7
	// 24-hour format of an hour without leading zeros (0 through 23)
	$Hour = date('G');
	$Hour+=1; // we stay in bali so GMT+8
	$greetingMessage="";
	if ( $Hour >= 5 && $Hour <= 11 ) {
		$greetingMessage = "Selamat Pagi";
	} else if ( $Hour >= 12 && $Hour <= 18 ) {
		$greetingMessage = "Selamat Siang";
	} else if ( $Hour >= 19 || $Hour <= 4 ) {
		$greetingMessage = "Selamat Malam";
	}
	return $greetingMessage;
}
?>

<div class="container-fluid">
	<div class="jumbo-dashboard">
		<div class="jumbotron mt-4 " style="background-image: url(<?php echo $url; ?>);">
			<div class="text-highlight">
				<h1 class="display-4">
					<span class="font-weight-bold">
						<?php echo greeting().", ".$_SESSION['penjual']['namadepan_penjual']." ".$_SESSION['penjual']['namabelakang_penjual']; ?>
					</span>
				</h1>
			</div>
			<?php if ($id_toko!=0 && isset($_SESSION['fitur'])): ?>
				<p class="text-jumbotron">
					Semoga harimu menyenangkan! <br>
					Lihat pesananmu dan selesaikan semuanya!
				</p>
				<a class="btn btn-success btn-lg btn-dashboard" href="index.php?page=Pemesanan Baru" role="button">Lihat Pesananmu!</a>
				<?php elseif($id_toko==0): ?>
					<p class="text-jumbotron">
						Semoga harimu menyenangkan! <br>
						Segera registrasi toko untuk dapat menggunakan fitur aplikasinya!

					</p>
					<a class="btn btn-danger btn-lg btn-dashboard" href="index.php?page=Registrasi Toko" role="button">Registrasi Toko</a>
					<?php elseif ($id_toko!=0 && !isset($_SESSION['fitur'])): ?>
						<p class="text-jumbotron">Lengkapi data ongkos pengiriman dahulu yaa!</p>
						<a class="btn btn-success btn-lg btn-dashboard" href="index.php?page=Wilayah Pengiriman" role="button">Lengkapi Ongkos Kirim</a>
					<?php endif ?>
				</div>
			</div>
		</div>