<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'Undangan Digital')</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<style>
		.glass {
			background: rgba(255, 255, 255, 0.2);
			backdrop-filter: blur(10px);
			-webkit-backdrop-filter: blur(10px);
			border: 1px solid rgba(255, 255, 255, 0.3);
		}
	</style>
</head>

<body class="bg-gray-50 font-sans text-gray-900 antialiased">

	<!-- Navbar -->
	@unless (isset($hideNav) && $hideNav)
		@include('layouts.frontend.navbar')
	@endunless

	<!-- Main Content -->
	<main>
		@yield('content')
	</main>

	<!-- Footer -->
	@unless (isset($hideNav) && $hideNav)
		@include('layouts.frontend.footer')
	@endunless

</body>

</html>
