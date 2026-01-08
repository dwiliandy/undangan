<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'User Dashboard') - Undangan</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex">

	<!-- Sidebar -->
	@include('layouts.user.sidebar')

	<div class="flex-1 flex flex-col h-screen">
		<!-- Navbar -->
		@include('layouts.user.navbar')

		<!-- Main Content -->
		<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
			@yield('content')
		</main>

		<!-- Footer -->
		@include('layouts.user.footer')
	</div>

</body>

</html>
