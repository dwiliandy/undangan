<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Login</title>
	<style>
		body {
			font-family: sans-serif;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			background: #f0f2f5;
		}

		.login-box {
			background: white;
			padding: 40px;
			border-radius: 8px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
			width: 300px;
		}

		input {
			width: 100%;
			padding: 10px;
			margin: 10px 0;
			border: 1px solid #ddd;
			border-radius: 4px;
			box-sizing: border-box;
		}

		button {
			width: 100%;
			padding: 10px;
			background: #007bff;
			color: white;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}

		button:hover {
			background: #0056b3;
		}

		.error {
			color: red;
			font-size: 0.9em;
			margin-bottom: 10px;
		}
	</style>
</head>

<body>
	<div class="login-box">
		<h2 style="text-align:center; margin-top:0;">Admin Login</h2>
		@if ($errors->any())
			<div class="error">{{ $errors->first() }}</div>
		@endif
		<form action="{{ route('admin.login.submit') }}" method="POST">
			@csrf
			<input type="email" name="email" placeholder="Email" required>
			<input type="password" name="password" placeholder="Password" required>
			<button type="submit">Login</button>
		</form>
	</div>
</body>

</html>
