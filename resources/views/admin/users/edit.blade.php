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
								<label for="phone_number" class="form-label fw-semibold">Phone/WA Number</label>
								<input type="text" class="form-control" id="phone_number" name="phone_number"
									value="{{ old('phone_number', $user->phone_number) }}" required>
							</div>

							<div class="mb-4">
								<label for="role" class="form-label fw-semibold">Role</label>
								<select class="form-select" id="role" name="role" required>
									<option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
									<option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
								</select>
							</div>

							<div class="row g-3">
								<div class="col-md-6 mb-4">
									<label for="status" class="form-label fw-semibold">Status</label>
									<select class="form-select" id="status" name="status" required>
										<option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>Pending</option>
										<option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
										<option value="rejected" {{ old('status', $user->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
									</select>
								</div>
								<div class="col-md-6 mb-4">
									<label for="event_quota" class="form-label fw-semibold">Event Quota</label>
									<input type="number" class="form-control" id="event_quota" name="event_quota"
										value="{{ old('event_quota', $user->event_quota) }}" min="0" required>
								</div>
							</div>

              {{-- Password change disabled for admin --}}

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
