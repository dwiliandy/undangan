@extends('admin.layout')

@section('title', 'Edit User')

@section('content')
	<div class="container-fluid">
		<div class="mb-4">
			<a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted small hover-underline">
				<i class="bi bi-arrow-left me-1"></i> Back to Users
			</a>
			<h2 class="h3 text-gray-800 fw-bold mt-2">Edit User</h2>
			<p class="text-muted small">Update account details for <strong>{{ $user->name }}</strong>.</p>
		</div>

		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="card shadow-sm border-0 rounded-3">
					<div class="card-header bg-transparent border-bottom py-3">
						<h5 class="card-title mb-0 fw-semibold text-primary">Account Details</h5>
					</div>
					<div class="card-body p-4">
						@if ($errors->any())
							<div class="alert alert-danger shadow-sm border-0 border-start border-5 border-danger fade show mb-4"
								role="alert">
								<div class="d-flex align-items-center">
									<i class="bi bi-exclamation-circle-fill fs-4 me-3 text-danger"></i>
									<div>
										<h6 class="alert-heading fw-bold mb-1">Validation Error</h6>
										<ul class="mb-0 small ps-3">
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								</div>
							</div>
						@endif

						<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
							@csrf
							@method('PUT')

							<div class="mb-4">
								<label for="name" class="form-label fw-semibold">Full Name</label>
								<input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}"
									required>
							</div>

							<div class="mb-4">
								<label for="email" class="form-label fw-semibold">Email Address</label>
								<input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}"
									required>
							</div>

							<div class="mb-4">
								<label for="role" class="form-label fw-semibold">Role</label>
								<select class="form-select" id="role" name="role" required>
									<option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
									<option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
								</select>
							</div>

							<hr class="my-4">
							<h6 class="fw-bold mb-3 text-muted">Change Password <span class="fw-normal small">(Optional)</span></h6>

							<div class="row g-3">
								<div class="col-md-6 mb-3">
									<label for="password" class="form-label fw-semibold">New Password</label>
									<input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep">
								</div>

								<div class="col-md-6 mb-3">
									<label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
									<input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
								</div>
							</div>
							<div class="form-text mt-0 mb-3">Only fill these fields if you want to change the user's password.</div>

							<div class="d-flex justify-content-end mt-2">
								<button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
									<i class="bi bi-save me-2"></i> Update User
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
