<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'Admin Dashboard') - Undangan</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<!-- DataTables CSS -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

	<style>
		body {
			font-family: 'Outfit', sans-serif;
			background-color: #f8f9fa;
		}

		.sidebar {
			min-width: 260px;
			max-width: 260px;
			min-height: 100vh;
			background: #212529;
			transition: all 0.3s;
		}

		.sidebar .nav-link {
			color: rgba(255, 255, 255, .75);
			padding: 10px 20px;
			border-radius: 5px;
			margin-bottom: 5px;
		}

		.sidebar .nav-link:hover,
		.sidebar .nav-link.active {
			color: #fff;
			background: rgba(255, 255, 255, .1);
		}

		.sidebar .nav-link i {
			margin-right: 10px;
		}

		.main-content {
			width: 100%;
			transition: all 0.3s;
		}
	</style>
</head>

<body>
	<div class="d-flex">
		<!-- Sidebar -->
		@include('admin.partials.sidebar')

		<!-- Main Content -->
		<div class="main-content d-flex flex-column min-vh-100">
			@include('admin.partials.navbar')

			<main class="flex-grow-1 p-4">
				@yield('content')
			</main>

			@include('admin.partials.footer')
		</div>
	</div>

	<!-- Bootstrap Bundle -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<!-- jQuery for DataTables -->
	<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
	<!-- DataTables JS -->
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

	<script>
		$(document).ready(function() {
			$('.datatable').DataTable();
		});
	</script>
</body>

</html>
