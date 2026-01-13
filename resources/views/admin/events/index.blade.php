@extends('admin.layout')

@section('title', 'Manage Events')

@section('content')
	<div class="container-fluid">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div>
				<h2 class="h3 text-gray-800 fw-bold">All Events</h2>
				<p class="text-muted small">Overview of all user events.</p>
			</div>
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

		<div class="card shadow-sm border-0 rounded-3">
			<div class="card-body p-4">
				<div class="table-responsive">
					<!-- Added .datatable class for auto-init -->
					<table id="eventsTable" class="table table-hover align-middle datatable" style="width:100%">
						<thead class="table-light">
							<tr>
								<th class="border-0 rounded-start">User</th>
								<th class="border-0">Event Title</th>
								<th class="border-0">URL Slug</th>
								<th class="border-0">Template</th>
								<th class="border-0 rounded-end text-end">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($events as $event)
								<tr>
									<td>
										<div class="d-flex flex-column">
											<span class="fw-medium text-dark">{{ $event->user->name }}</span>
											<span class="text-muted small">{{ $event->user->email }}</span>
										</div>
									</td>
									<td class="fw-medium">{{ $event->title }}</td>
									<td>
										<div class="d-flex flex-column">
											<span class="font-monospace text-secondary small">{{ $event->slug }}</span>
											<a href="{{ route('frontend.event', $event->slug) }}" target="_blank"
												class="text-primary small text-decoration-none hover-underline">
												<i class="bi bi-box-arrow-up-right me-1"></i>View
											</a>
										</div>
									</td>
									<td>
										@if ($event->template)
											<span class="badge bg-light text-dark border">{{ $event->template->name }}</span>
										@else
											<span class="badge bg-secondary">N/A</span>
										@endif
									</td>
									<td class="text-end">
										<form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
											onsubmit="return confirm('Are you sure you want to delete this event?');" class="d-inline-block">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Delete">
												<i class="bi bi-trash"></i>
											</button>
										</form>
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
