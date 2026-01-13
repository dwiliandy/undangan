<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - Undangan</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-indigo-50 flex items-center justify-center h-screen">
	<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
		<h2 class="text-3xl font-extrabold mb-6 text-center text-indigo-700">Welcome Back</h2>

		@if (session('success'))
			<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
				<p class="font-bold">Info</p>
				<p>{{ session('success') }}</p>
			</div>
		@endif

		@if ($errors->any())
			<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
				<p class="font-bold">Error</p>
				<p>{{ $errors->first() }}</p>
			</div>
		@endif

		<form action="{{ route('login.submit') }}" method="POST">
			@csrf
			<div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email Address</label>
				<input
					class="shadow-sm appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
					id="email" type="email" name="email" placeholder="you@example.com" required>
			</div>
			<div class="mb-6">
				<div class="flex justify-between mb-2">
					<label class="block text-gray-700 text-sm font-bold" for="password">Password</label>
					<a href="#" class="text-sm text-indigo-600 hover:text-indigo-800">Forgot Password?</a>
				</div>
				<input
					class="shadow-sm appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
					id="password" type="password" name="password" placeholder="********" required>
			</div>
			<div class="flex items-center justify-between">
				<button
					class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out"
					type="submit">
					Sign In
				</button>
			</div>
			<div class="mt-4 text-center">
				<p class="text-gray-600 text-sm">Don't have an account? <a href="{{ route('register') }}"
						class="text-indigo-600 hover:text-indigo-800 font-bold">Sign Up</a></p>
			</div>
		</form>
	</div>
</body>

</html>
