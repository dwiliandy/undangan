<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ config('app.name', 'Undangan Digital') }}</title>
	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700|playfair-display:400,600,700" rel="stylesheet" />
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			font-family: 'Outfit', sans-serif;
			background-color: #f8f9fa;
		}

		h1,
		h2,
		h3,
		.serif {
			font-family: 'Playfair Display', serif;
		}

		.text-rose {
			color: #e11d48;
		}

		.bg-rose {
			background-color: #e11d48;
		}

		.btn-rose {
			background-color: #e11d48;
			color: white;
			border: none;
		}

		.btn-rose:hover {
			background-color: #be123c;
			color: white;
		}

		.scroll-smooth {
			scroll-behavior: smooth;
		}

		.nav-link {
			color: #57534e;
			font-weight: 500;
		}

		.nav-link:hover {
			color: #1c1917;
		}

		.hero-section {
			pt-5;
			overflow: hidden;
			position: relative;
		}
	</style>
</head>

<body class="d-flex flex-column h-100 scroll-smooth">

	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
		<div class="container">
			<a class="navbar-brand fs-3 fw-bold serif" href="#">
				<span class="text-rose">Undangan</span><span class="text-dark">Kita</span>
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
				aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto align-items-center">
					<li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
					<li class="nav-item"><a class="nav-link" href="#how-it-works">Cara Buat</a></li>
					<li class="nav-item"><a class="nav-link" href="#templates">Tema</a></li>
					@if (Route::has('login'))
						@auth
							<li class="nav-item"><a class="nav-link text-dark fw-bold" href="{{ url('/dashboard') }}">Dashboard</a></li>
						@else
							<li class="nav-item"><a class="nav-link text-dark fw-bold" href="{{ route('login') }}">Masuk</a></li>
							@if (Route::has('register'))
								<li class="nav-item ms-2">
									<a href="{{ route('register') }}" class="btn btn-rose rounded-pill px-4">Buat Undangan</a>
								</li>
							@endif
						@endauth
					@endif
				</ul>
			</div>
		</div>
	</nav>

	<!-- Hero Section -->
	<section class="hero-section min-vh-100 d-flex align-items-center pt-5 mt-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 text-center text-md-start">
					<span class="badge bg-danger bg-opacity-10 text-danger rounded-pill mb-3 px-3 py-2">✨ Undangan Pernikahan Digital
						#1</span>
					<h1 class="display-3 fw-bold text-dark mb-4 lh-sm">
						Bagikan Momen <br>
						<span class="text-rose fst-italic serif">Bahagiamu</span> Dengan <br>
						Lebih Elegan
					</h1>
					<p class="lead text-secondary mb-5">
						Buat undangan pernikahan digital yang memukau dalam hitungan menit. Tanpa koding, banyak pilihan tema, dan siap
						disebar ke semua tamu.
					</p>
					<div class="d-flex gap-3 justify-content-center justify-content-md-start">
						<a href="{{ route('register') }}"
							class="btn btn-dark rounded-pill px-4 py-3 btn-lg d-flex align-items-center gap-2 shadow-lg">
							Buat Undangan Gratis
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
								class="bi bi-arrow-right" viewBox="0 0 16 16">
								<path fill-rule="evenodd"
									d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
							</svg>
						</a>
						<a href="#how-it-works" class="btn btn-outline-secondary rounded-pill px-4 py-3 btn-lg shadow-sm">
							Cara Kerja
						</a>
					</div>
					<div
						class="mt-5 d-flex align-items-center justify-content-center justify-content-md-start gap-3 text-secondary small">
						<div class="d-flex">
							<img src="https://i.pravatar.cc/100?img=1" class="rounded-circle border border-white" width="32"
								height="32" alt="">
							<img src="https://i.pravatar.cc/100?img=2" class="rounded-circle border border-white ms-n2" width="32"
								height="32" style="margin-left: -10px;" alt="">
							<img src="https://i.pravatar.cc/100?img=3" class="rounded-circle border border-white ms-n2" width="32"
								height="32" style="margin-left: -10px;" alt="">
						</div>
						<span>Bergabung dengan 1,000+ pengantin lainnya</span>
					</div>
				</div>
				<div class="col-md-6 d-none d-md-block position-relative">
					<div
						class="position-absolute top-0 start-0 bg-danger bg-opacity-10 rounded-circle filter blur-3xl w-75 h-75 opacity-50 z-n1"
						style="filter: blur(60px);"></div>
					<img src="https://images.unsplash.com/photo-1606800052052-a08af7148866?q=80&w=2670&auto=format&fit=crop"
						class="img-fluid rounded-4 shadow-lg border border-4 border-white transform rotate-3" alt="App Preview">
				</div>
			</div>
		</div>
	</section>

	<!-- Features Section -->
	<section id="features" class="py-5 bg-white">
		<div class="container py-5">
			<div class="text-center mb-5 mw-100 mx-auto" style="max-width: 700px;">
				<h2 class="display-5 fw-bold text-dark serif mb-3">Fitur Lengkap Untuk Hari Bahagiamu</h2>
				<p class="text-secondary fs-5">Kami menyediakan semua yang kamu butuhkan untuk membuat undangan pernikahan digital
					yang sempurna.</p>
			</div>

			<div class="row g-4">
				<div class="col-md-4">
					<div class="p-4 rounded-4 bg-light h-100 text-center border hover-shadow transition">
						<div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3 d-inline-flex mb-4">
							<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
								class="bi bi-palette" viewBox="0 0 16 16">
								<path
									d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm4 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM5.5 7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm.5 6a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
								<path
									d="M16 8c0 3.15-1.866 2.585-3.567 2.07C11.42 9.763 10.465 9.473 10 10c-.603.683-.475 1.819-.351 2.92C9.826 14.495 9.996 16 8 16a8 8 0 1 1 8-8zm-8 7c.611 0 .654-.171.655-.176.078-.146.124-.464.07-1.119-.014-.168-.037-.37-.061-.591-.052-.464-.112-1.005-.118-1.462-.01-.707.083-1.61.704-2.314.369-.417.845-.578 1.272-.618.404-.038.812.026 1.16.104.343.077.702.186 1.025.284 3.027.924 5.333 1.761 5.333 5.892.001-3.69-2.259-6.738-5.596-7.557C14.078 6.541 12.33 6.035 11.69 6.035c-.658 0-1.229.492-1.229 1.18 0 .155.048.337.202.668a3.693 3.693 0 0 0 .543.834c.264.306.904.995.845 1.77-.074.98-.367 1.954-.667 2.383-.396.566-.69.215-.756.126-.067-.09-.387-.506-.522-1.196-.068-.352-.102-.916.14-1.742.226-.777.294-1.576.294-2.18 0-2.484-1.808-5.323-5.556-5.323C4.192.712 1 3.516 1 8c0 2.219 1.488 4.293 3.57 5.287.41-.05.578-.305.568-.426-.002-.023-.005-.05-.011-.082-.047-.24-.132-.676-.118-1.225.013-.482.049-.966.088-1.423.016-.188.032-.369.049-.537.067-.655.106-1.042.062-1.396-.056-.445-.297-.847-.798-1.124-.486-.268-1.082-.268-1.62-.284-.632-.019-1.275-.038-1.823.167C1.405 8.75 3.58 8 6 8.5c1.868.386 3.166 1.342 3.842 2.378.369.566.69.215.756.126.067-.09.387-.506.522-1.196a5.57 5.57 0 0 1 .14-1.742c.226-.777.294-1.576.294-2.18 0-1.666-.807-3.238-2.228-4.316C12.387 1.492 10.292 1 8 1z" />
							</svg>
						</div>
						<h3 class="h4 fw-bold mb-3">Tema Premium</h3>
						<p class="text-secondary">Pilih dari berbagai template desain eksklusif yang dirancang oleh desainer profesional
							kami.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="p-4 rounded-4 bg-light h-100 text-center border hover-shadow transition">
						<div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 d-inline-flex mb-4">
							<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
								class="bi bi-phone" viewBox="0 0 16 16">
								<path
									d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
								<path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
							</svg>
						</div>
						<h3 class="h4 fw-bold mb-3">Responsif Mobile</h3>
						<p class="text-secondary">Undanganmu akan terlihat sempurna baik dibuka di Smartphone, Tablet, maupun Laptop.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="p-4 rounded-4 bg-light h-100 text-center border hover-shadow transition">
						<div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3 d-inline-flex mb-4">
							<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
								class="bi bi-lightning-charge" viewBox="0 0 16 16">
								<path
									d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09zM4.157 8.5H7a.5.5 0 0 1 .478.647L6.11 13.59l5.732-6.09H9a.5.5 0 0 1-.478-.647L9.89 2.41 4.157 8.5z" />
							</svg>
						</div>
						<h3 class="h4 fw-bold mb-3">Setup Cepat</h3>
						<p class="text-secondary">Cukup 3 menit untuk mengisi data, pilih tema, dan undanganmu siap disebar.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- How It Works -->
	<section id="how-it-works" class="py-5 bg-light">
		<div class="container py-5">
			<div class="text-center mb-5 mw-100 mx-auto" style="max-width: 700px;">
				<span class="text-rose fw-bold text-uppercase small ls-1">Langkah Mudah</span>
				<h2 class="display-5 fw-bold text-dark serif mt-2">Hanya 4 Langkah Sederhana</h2>
			</div>

			<div class="row g-4 text-center">
				<div class="col-md-3">
					<div class="bg-white p-4 rounded-4 shadow-sm h-100">
						<div
							class="d-inline-flex align-items-center justify-content-center bg-dark text-white rounded-circle mb-3 fs-3 fw-bold"
							style="width: 64px; height: 64px;">1</div>
						<h4 class="fw-bold mb-2">Daftar Akun</h4>
						<p class="text-secondary small">Buat akun gratis untuk mulai mengakses dashboard.</p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="bg-white p-4 rounded-4 shadow-sm h-100">
						<div
							class="d-inline-flex align-items-center justify-content-center bg-rose text-white rounded-circle mb-3 fs-3 fw-bold"
							style="width: 64px; height: 64px;">2</div>
						<h4 class="fw-bold mb-2">Isi Data</h4>
						<p class="text-secondary small">Lengkapi informasi mempelai, lokasi, dan waktu acara.</p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="bg-white p-4 rounded-4 shadow-sm h-100">
						<div
							class="d-inline-flex align-items-center justify-content-center bg-white border border-dark text-dark rounded-circle mb-3 fs-3 fw-bold"
							style="width: 64px; height: 64px;">3</div>
						<h4 class="fw-bold mb-2">Pilih Tema</h4>
						<p class="text-secondary small">Pilih template yang sesuai dengan konsep pernikahanmu.</p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="bg-white p-4 rounded-4 shadow-sm h-100">
						<div
							class="d-inline-flex align-items-center justify-content-center bg-white border border-danger text-danger rounded-circle mb-3 fs-3 fw-bold"
							style="width: 64px; height: 64px;">4</div>
						<h4 class="fw-bold mb-2">Sebar</h4>
						<p class="text-secondary small">Dapatkan link unik undanganmu dan bagikan.</p>
					</div>
				</div>
			</div>
			<div class="text-center mt-5">
				<a href="{{ route('register') }}" class="btn btn-rose rounded-pill px-5 py-3 fw-bold shadow-lg">
					Mulai Buat Undanganmu
				</a>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer class="bg-dark text-light py-5 mt-auto">
		<div class="container">
			<div class="row gy-4">
				<div class="col-md-6 text-center text-md-start">
					<h4 class="fw-bold serif">Undangan<span class="text-rose">Kita</span></h4>
					<p class="text-secondary small mt-3" style="max-width: 300px;">Platform pembuatan undangan pernikahan digital
						modern, cepat, dan elegan.</p>
				</div>
				<div class="col-md-3">
					<h5 class="fw-bold mb-3">Navigasi</h5>
					<ul class="list-unstyled">
						<li><a href="#" class="text-secondary text-decoration-none">Beranda</a></li>
						<li><a href="#features" class="text-secondary text-decoration-none">Fitur</a></li>
						<li><a href="#templates" class="text-secondary text-decoration-none">Tema</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h5 class="fw-bold mb-3">Bantuan</h5>
					<ul class="list-unstyled">
						<li><a href="#" class="text-secondary text-decoration-none">FAQ</a></li>
						<li><a href="#" class="text-secondary text-decoration-none">Kontak Kami</a></li>
					</ul>
				</div>
			</div>
			<div class="border-top border-secondary mt-5 pt-4 text-center text-secondary small">
				&copy; {{ date('Y') }} UndanganKita. All rights reserved.
			</div>
		</div>
	</footer>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
