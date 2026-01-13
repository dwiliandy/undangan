@extends('layouts.user')

@section('title', 'My Events')

@section('content')
	<div class="card shadow-sm border-0">
		<div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom-0">
			<div>
				<h4 class="mb-0 text-dark fw-bold">My Events</h4>
				<p class="text-muted mb-0 small">Manage your wedding invitations.</p>
			</div>
			<a href="{{ route('user.events.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
				<i class="bi bi-plus-lg"></i> Create New Event
			</a>
		</div>
		<div class="card-body">
			@if (session('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<i class="bi bi-check-circle me-2"></i> {{ session('success') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<div class="table-responsive">
				<table id="eventsTable" class="table table-hover align-middle" style="width:100%">
					<thead class="table-light">
						<tr>
							<th class="ps-3">Title & Slug</th>
							<th>Date</th>
							<th>Status</th>
							<th class="text-end pe-3">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($events as $event)
							<tr>
								<td class="ps-3">
									<div class="d-flex flex-column">
										<span class="fw-bold text-dark">{{ $event->title }}</span>
										<small class="text-muted text-truncate" style="max-width: 200px;">
											<a href="{{ route('frontend.event', $event->slug) }}" target="_blank" class="text-decoration-none">
												<i class="bi bi-box-arrow-up-right"></i> {{ $event->slug }}
											</a>
										</small>
									</div>
								</td>
								<td>
									<div class="d-flex flex-column">
										<span>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
										<small class="text-muted">{{ \Carbon\Carbon::parse($event->event_date)->diffForHumans() }}</small>
									</div>
								</td>
								<td>
									@if ($event->is_active)
										<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
											<i class="bi bi-check-circle-fill me-1"></i> Active
										</span>
									@else
										<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill">
											<i class="bi bi-pause-circle-fill me-1"></i> Inactive
										</span>
									@endif
								</td>
								<td class="text-end pe-3">
									<div class="d-flex justify-content-end gap-2">
										{{-- Manage Guests Button --}}
										<a href="{{ route('user.events.invitations.index', $event->id) }}"
											class="btn btn-sm btn-info text-white d-flex align-items-center gap-2 px-3">
											<i class="bi bi-people-fill"></i> Guests
										</a>

										{{-- Main Manage Button --}}
										<a href="{{ route('user.events.manage', $event->id) }}"
											class="btn btn-sm btn-primary d-flex align-items-center gap-2 px-3">
											<i class="bi bi-gear-fill"></i> Manage Event
										</a>

										{{-- Delete Button --}}
										<form action="{{ route('user.events.destroy', $event->id) }}" method="POST" class="d-inline"
											onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1"
												data-bs-toggle="tooltip" title="Delete Event">
												<i class="bi bi-trash-fill"></i> Delete
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

	{{-- DataTables CSS/JS --}}
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
	<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

	<script>
		$(document).ready(function() {
			$('#eventsTable').DataTable({
				"order": [
					[1, "desc"]
				], // Sort by Date desc
				"language": {
					"search": "Search:",
					"lengthMenu": "Show _MENU_ events",
					"paginate": {
						"first": "«",
						"last": "»",
						"next": "›",
						"previous": "‹"
					}
				},
				"dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rtip'
			});

			// Initialize tooltips
			var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
			var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
				return new bootstrap.Tooltip(tooltipTriggerEl)
			})
		});
	</script>
@endsection
