@extends('admin.layout')

@section('title', 'Manage Users')

@section('content')
	<div class="container-fluid">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">Users</h1>
			<div class="btn-toolbar mb-2 mb-md-0">
				<a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
					<i class="bi bi-plus-lg"></i> Add New User
				</a>
			</div>
		</div>

		@if (session('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				{{ session('success') }}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		@endif

		@if (session('error'))
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				{{ session('error') }}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		@endif

		<div class="card shadow-sm">
			<div class="card-body">
				<div class="table-responsive">
					<table id="usersTable" class="table table-striped table-hover align-middle" style="width:100%">
						<thead class="table-light">
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Created At</th>
								<th class="text-end">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $user)
								<tr>
									<td class="fw-bold">{{ $user->name }}</td>
									<td>{{ $user->email }}</td>
									<td>
										@if ($user->role === 'admin')
											<span class="badge bg-danger rounded-pill">Admin</span>
										@else
											<span class="badge bg-primary rounded-pill">User</span>
										@endif
									</td>
									<td>{{ $user->created_at->format('d M Y') }}</td>
									<td class="text-end">
										<div class="btn-group btn-group-sm">
											<a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-secondary">Edit</a>
											<form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline"
												onsubmit="return confirm('Are you sure?');">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-outline-danger">Delete</button>
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

	<!-- DataTables CSS/JS included in layout, initialize here -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

	<script>
		$(document).ready(function() {
			$('#usersTable').DataTable({
				"order": [
					[3, "desc"]
				] // Sort by created_at (index 3) desc
			});
		});
	</script>
@endsection
