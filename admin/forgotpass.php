<?php 
require_once 'templates_admin/header.php';
?>
<div class="container">
	<!-- Outer Row -->
	<div class="row justify-content-center">
		<div class="col-xl-10 col-lg-12 col-md-9">
			<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="card-body p-0">
					<!-- Nested Row within Card Body -->
					<div class="row">
						<div class="col-lg-6 d-none d-lg-block bg-password-image">
							<!-- Image -->
							<img src="<?php echo BASEURL; ?>assets/img/img_regtoko/image5.jpg" class="img-thumbnail center-responsive">
						</div>
						<div class="col-lg-6">
							<div class="p-5">
								<div class="text-center">
									<h4 class="display-4 mb-4">Lupa Password?</h4>
									<p class="mb-4 form-text text-muted">Masukan alamat email yang sudah terdaftar. Kami akan kirimkan link untuk mereset passwordmu!</p>
								</div>
								<form class="user form-group" action="forgotpass.php" method="post">
									<div class="form-group">
										<input type="email" class="form-control form-control-user" id="email_recovery" name="email_recovery" aria-describedby="email_recovery" placeholder="Enter Email Address" value=""required="true">
									</div>
									<button class="btn btn-danger btn-user btn-block" type="submit" name="btnResetPassword" id="btnResetPassword" value="">
										Reset Password
									</button>
									<?php
									if (isset($_POST['btnResetPassword'])) {
										echo "<script>
										Swal.fire({
											title: 'LINK TERKIRIM',
											icon:'success',
											text: 'Lakukan reset password di alamat emailmu ya!!',
											showCancelButton: false,
											confirmButtonColor: '#4BB543',
											cancelButtonColor: '#d33',
											confirmButtonText: 'Login'
											}).then((result) => {
												document.location.href = 'login.php';
											})</script>";
										}
										?>
									</form>
									<hr>
									<div class="text-center">
										<a class="small" href="register.php">Registrasi Akun</a>
									</div>
									<div class="text-center">
										<a class="small" href="login.php">Sudah punya akun? Login!</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<?php 
	require_once 'templates_admin/footer.php';
	?>