@extends('admin.layout')

@section('title', 'Add User')

@section('content')
	<div class="container-fluid">
		<div class="mb-4">
			<a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted small hover-underline">
				<i class="bi bi-arrow-left me-1"></i> Back to Users
			</a>
			<h2 class="h3 text-gray-800 fw-bold mt-2">Add New User</h2>
			<p class="text-muted small">Create a new account with specific roles.</p>
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

						<form action="{{ route('admin.users.store') }}" method="POST">
							@csrf
							<div class="mb-4">
								<label for="name" class="form-label fw-semibold">Full Name</label>
								<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
									placeholder="e.g. John Doe" required>
							</div>

							<div class="mb-4">
								<label for="email" class="form-label fw-semibold">Email Address</label>
								<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
									placeholder="name@example.com" required>
							</div>

							<div class="mb-4">
								<label for="phone_number" class="form-label fw-semibold">Phone/WA Number</label>
								<input type="text" class="form-control" id="phone_number" name="phone_number"
									value="{{ old('phone_number') }}" placeholder="628..." required>
							</div>

							<div class="mb-4">
								<label for="role" class="form-label fw-semibold">Role</label>
								<select class="form-select" id="role" name="role" required>
									<option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
									<option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
								</select>
								<div class="form-text small">Admins have full access to the system.</div>
							</div>

							<div class="row g-3">
								<div class="col-md-6 mb-4">
									<label for="status" class="form-label fw-semibold">Status</label>
									<select class="form-select" id="status" name="status" required>
										<option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
										<option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
										<option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
									</select>
								</div>
								<div class="col-md-6 mb-4">
									<label for="event_quota" class="form-label fw-semibold">Event Quota</label>
									<input type="number" class="form-control" id="event_quota" name="event_quota"
										value="{{ old('event_quota', 1) }}" min="0" required>
								</div>
							</div>

							<hr class="my-4">

							<div class="row g-3">
								<div class="col-md-6 mb-3">
									<label for="password" class="form-label fw-semibold">Password</label>
									<input type="password" class="form-control" id="password" name="password" required>
								</div>

								<div class="col-md-6 mb-3">
									<label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
									<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
								</div>
							</div>

							<div class="d-flex justify-content-end mt-2">
								<button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
									<i class="bi bi-person-plus-fill me-2"></i> Create User
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
