@extends('admin.layout')

@section('title', 'Add User')

@section('content')
	<div class="container-fluid">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">Add New User</h1>
			<div class="btn-toolbar mb-2 mb-md-0">
				<a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
					Back to List
				</a>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-md-8 col-lg-6">
				<div class="card shadow-sm">
					<div class="card-body p-4">
						@if ($errors->any())
							<div class="alert alert-danger" role="alert">
								<ul class="mb-0 ps-3">
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						<form action="{{ route('admin.users.store') }}" method="POST">
							@csrf
							<div class="mb-3">
								<label for="name" class="form-label fw-bold">Full Name</label>
								<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
									placeholder="John Doe" required>
							</div>

							<div class="mb-3">
								<label for="email" class="form-label fw-bold">Email Address</label>
								<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
									placeholder="name@example.com" required>
							</div>

							<div class="mb-3">
								<label for="role" class="form-label fw-bold">Role</label>
								<select class="form-select" id="role" name="role" required>
									<option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
									<option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
								</select>
							</div>

							<div class="mb-3">
								<label for="password" class="form-label fw-bold">Password</label>
								<input type="password" class="form-control" id="password" name="password" required>
							</div>

							<div class="mb-4">
								<label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
								<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
							</div>

							<div class="d-grid">
								<button type="submit" class="btn btn-primary">Create User</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
