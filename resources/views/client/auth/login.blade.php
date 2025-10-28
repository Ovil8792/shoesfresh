@extends('client.layout.main')

@section('main')


	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Login/Register</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="category.html">Login/Register</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section id="log" class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="login_box_img">
						<img class="img-fluid" src="{{ asset(url("")) }}/assets/img/login.jpg" alt="">
						<div class="hover">
							<h4>New to our website?</h4>
							<p>There are advances being made in science and technology everyday, and a good example of this is the</p>
							<a id="toreg" class="primary-btn" href="">Đăng kí</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>Đăng nhập</h3>
						<form class="row login_form" action="" method="post" id="contactForm" novalidate="novalidate">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="name" name="name" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="name" name="name" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							<div class="col-md-12 form-group">
								<div class="creat_account">
									<input type="checkbox" id="f-option2" name="selector">
									<label for="f-option2">Keep me logged in</label>
								</div>
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="primary-btn">Log In</button>
								<a href="#">Forgot Password?</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->
<section id="reg" class="login_box_area section_gap" style="display:none;">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
<div class="login_form_inner">
						<h3>Đăng Ký</h3>
						<form class="row login_form" action="" method="post" id="contactForm" novalidate="novalidate">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="name" name="name" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="name" name="name" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							<div class="col-md-12 form-group">
								<div class="creat_account">
									<input type="checkbox" id="f-option2" name="selector">
									<label for="f-option2">Keep me logged in</label>
								</div>
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="primary-btn">Đăng kí</button>
							</div>
						</form>
					</div>
			</div>
			<div class="col-lg-6">
				<div class="login_box_img">
						<img class="img-fluid" src="{{ asset(url("")) }}/assets/img/login.jpg" alt="">
						<div class="hover">
							<h4>New to our website?</h4>
							<p>There are advances being made in science and technology everyday, and a good example of this is the</p>
							<a id="tolog" class="primary-btn" href="">Đăng nhập</a>
						</div>
					</div>
			</div>
		</div>
	</div>
</section>
<script>
	function dangki(){
		document.getElementById("log").style.display="none";
		document.getElementById("reg").style.display="block";
	}
	function dangnhap(){
		document.getElementById("log").style.display="block";
		document.getElementById("reg").style.display="none";
	}
	var toreg=document.getElementById("toreg");
	var tolog=document.getElementById("tolog");
	document.addEventListener("DOMContentLoaded", function(){
		toreg.addEventListener("click", function(event) {
			event.preventDefault();
			dangki();
		});
		tolog.addEventListener("click", function(event){
			event.preventDefault();
			dangnhap();
		});
	});
</script>
@endsection	