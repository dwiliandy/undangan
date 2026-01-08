@extends('layouts.user')

@section('title', 'Guest Management')

@section('content')
	<div class="container">
		<div class="card shadow-sm">
			<div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
				<div>
					<h4 class="mb-1 text-dark">Guest List</h4>
					<small class="text-muted">Event: <strong>{{ $event->title }}</strong></small>
				</div>
				<div class="d-flex gap-2">
					<a href="{{ route('user.events.index') }}" class="btn btn-outline-secondary">Back to Events</a>
					<a href="{{ route('user.events.invitations.create', $event->id) }}" class="btn btn-primary">Add Guest</a>
				</div>
			</div>

			<div class="card-body">
				@if (session('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						{{ session('success') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				@endif

				<div class="table-responsive">
					<table id="guestsTable" class="table table-striped table-hover align-middle" style="width:100%">
						<thead class="table-light">
							<tr>
								<th>Guest Name</th>
								<th>Link</th>
								<th>Status</th>
								<th class="text-end">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($invitations as $invitation)
								<tr>
									<td>
										<span class="fw-bold text-dark">{{ $invitation->guest_name }}</span>
										@if ($invitation->guest_address)
											<br><small class="text-muted">{{ $invitation->guest_address }}</small>
										@endif
									</td>
									<td>
										<div class="input-group input-group-sm">
											<input type="text" class="form-control"
												value="{{ route('frontend.invitation', [$event->slug, $invitation->slug]) }}" readonly
												id="link-{{ $invitation->id }}">
											<button class="btn btn-outline-primary" type="button"
												onclick="copyToClipboard('{{ route('frontend.invitation', [$event->slug, $invitation->slug]) }}')">
												Copy
											</button>
										</div>
									</td>
									<td>
										@if ($invitation->is_opened)
											<span class="badge bg-success rounded-pill">Opened</span>
											<br><small class="text-muted"
												style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($invitation->opened_at)->diffForHumans() }}</small>
										@else
											<span class="badge bg-warning text-dark rounded-pill">Not Opened</span>
										@endif
									</td>
									<td class="text-end">
										<div class="btn-group btn-group-sm">
											<a href="{{ route('user.events.invitations.edit', [$event->id, $invitation->id]) }}"
												class="btn btn-outline-secondary">Edit</a>
											<form action="{{ route('user.events.invitations.destroy', [$event->id, $invitation->id]) }}" method="POST"
												class="d-inline" onsubmit="return confirm('Are you sure you want to delete this guest?');">
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

	<!-- DataTables CSS -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
	<!-- DataTables JS -->
	<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

	<script>
		$(document).ready(function() {
			$('#guestsTable').DataTable({
				"order": [
					[0, "asc"]
				], // Sort by name by default
				"pageLength": 10,
				"language": {
					"search": "Cari Tamu:",
					"lengthMenu": "Tampilkan _MENU_ tamu per halaman",
					"info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ tamu",
					"paginate": {
						"first": "Pertama",
						"last": "Terakhir",
						"next": "Selanjutnya",
						"previous": "Sebelumnya"
					}
				}
			});
		});

		function copyToClipboard(text) {
			navigator.clipboard.writeText(text).then(function() {
				// Optional: You could show a toast or change the button text temporarily
				alert('Link berhasil disalin!');
			}, function(err) {
				console.error('Could not copy text: ', err);
			});
		}
	</script>
@endsection
