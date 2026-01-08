<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register - Undangan</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			background-color: #f8f9fa;
		}

		.card-registration {
			border: none;
			border-radius: 1rem;
			box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
		}
	</style>
</head>

<body class="d-flex align-items-center min-vh-100 py-3 py-md-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-md-8 col-lg-6 col-xl-5">
				<div class="card card-registration">
					<div class="card-body p-5">
						<h2 class="text-center mb-4 fw-bold text-primary">Create Account</h2>

						@if ($errors->any())
							<div class="alert alert-danger" role="alert">
								<ul class="mb-0 ps-3">
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						<form action="{{ route('register.submit') }}" method="POST">
							@csrf
							<div class="mb-3">
								<label for="name" class="form-label fw-bold">Full Name</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
							</div>
							<div class="mb-3">
								<label for="email" class="form-label fw-bold">Email Address</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
							</div>
							<div class="mb-3">
								<label for="password" class="form-label fw-bold">Password</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="********" required>
							</div>
							<div class="mb-4">
								<label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
								<input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
									placeholder="********" required>
							</div>
							<div class="d-grid">
								<button class="btn btn-primary btn-lg" type="submit">Register</button>
							</div>
							<div class="text-center mt-3">
								<p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="{{ route('login') }}"
										class="link-danger">Sign In</a></p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
