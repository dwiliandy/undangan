<!DOCTYPE html>
<html lang="en">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin Dashboard') - Undangan</title>

<!-- Google Fonts: Outfit -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
	tailwind.config = {
		theme: {
			extend: {
				fontFamily: {
					sans: ['Outfit', 'sans-serif'],
				},
			}
		}
	}
</script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.tailwindcss.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.tailwindcss.js"></script>

<style>
	.dt-container .dt-length select,
	.dt-container .dt-search input {
		border-radius: 0.375rem;
		border-color: #e5e7eb;
		background-color: #fff;
		padding: 0.25rem 0.5rem;
	}

	/* Glassmorphism sidebar helper */
	.glass-sidebar {
		background: rgba(17, 24, 39, 0.95);
		backdrop-filter: blur(10px);
	}
</style>
</head>

<body class="bg-gray-100 flex">

	<!-- Sidebar -->
	@include('admin.partials.sidebar')

	<div class="flex-1 flex flex-col h-screen">
		<!-- Navbar -->
		@include('admin.partials.navbar')

		<!-- Main Content -->
		<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 p-6">
			@yield('content')
		</main>

		<!-- Footer -->
		@include('admin.partials.footer')
	</div>

</body>

</html>
