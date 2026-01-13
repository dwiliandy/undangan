@extends('admin.layout')

@section('title', 'Manage Users')

@section('content')
	<div class="container-fluid">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div>
				<h2 class="h3 text-gray-800 fw-bold">Users</h2>
				<p class="text-muted small">Manage user accounts and roles.</p>
			</div>
			<a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-sm">
				<i class="bi bi-plus-lg me-2"></i>Add New User
			</a>
		</div>

		@if (session('success'))
			<div class="alert alert-success alert-dismissible fade show shadow-sm border-0 border-start border-5 border-success"
				role="alert">
				<div class="d-flex align-items-center">
					<i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
					<div>{{ session('success') }}</div>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		@endif

		@if (session('error'))
			<div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 border-start border-5 border-danger"
				role="alert">
				<div class="d-flex align-items-center">
					<i class="bi bi-exclamation-circle-fill fs-4 me-3 text-danger"></i>
					<div>{{ session('error') }}</div>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		@endif

		<div class="card shadow-sm border-0 rounded-3">
			<div class="card-body p-4">
				<div class="table-responsive">
					<table id="usersTable" class="table table-hover align-middle datatable" style="width:100%">
						<thead class="table-light">
							<tr>
								<th class="border-0 rounded-start">Name</th>
								<th class="border-0">Email</th>
								<th class="border-0">Role</th>
								<th class="border-0">Created At</th>
								<th class="border-0 rounded-end text-end">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $user)
								<tr>
									<td class="fw-medium text-dark">{{ $user->name }}</td>
									<td class="text-muted">{{ $user->email }}</td>
									<td>
										@if ($user->role === 'admin')
											<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
												<i class="bi bi-shield-lock-fill me-1"></i> Admin
											</span>
										@else
											<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
												<i class="bi bi-person-fill me-1"></i> User
											</span>
										@endif
									</td>
									<td class="text-secondary small">{{ $user->created_at->format('d M Y') }}</td>
									<td class="text-end">
										<div class="btn-group">
											<a href="{{ route('admin.users.edit', $user->id) }}"
												class="btn btn-sm btn-outline-primary border-0 rounded-start" title="Edit">
												<i class="bi bi-pencil-square"></i>
											</a>
											<form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline"
												onsubmit="return confirm('Are you sure you want to delete this user?');">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-end" title="Delete">
													<i class="bi bi-trash"></i>
												</button>
											</form>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
