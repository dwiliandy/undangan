<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'User Dashboard') - Undangan</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			background-color: #f8f9fa;
		}

		.wrapper {
			display: flex;
			width: 100%;
			align-items: stretch;
		}

		#content {
			width: 100%;
			padding: 20px;
			min-height: 100vh;
			transition: all 0.3s;
		}
	</style>
</head>

<body>

	<div class="wrapper">
		<!-- Sidebar -->
		@include('layouts.user.sidebar')

		<div id="content" class="d-flex flex-column">
			<!-- Navbar -->
			@include('layouts.user.navbar')

			<!-- Main Content -->
			<div class="container-fluid flex-grow-1">
				@yield('content')
			</div>

			<!-- Footer -->
			@include('layouts.user.footer')
		</div>
	</div>

	<!-- Bootstrap JS Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	@stack('scripts')
</body>

</html>
