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
					<a href="{{ route('user.events.index') }}" class="btn btn-outline-secondary">
						<i class="bi bi-arrow-left me-1"></i> Back
					</a>
					<button type="button" class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#importModal">
						<i class="bi bi-file-earmark-excel me-1"></i> Import Excel
					</button>
					<a href="{{ route('user.events.invitations.create', $event->id) }}" class="btn btn-primary">
						<i class="bi bi-plus-lg me-1"></i> Add Guest
					</a>
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
								<th>Guest Details</th>
								<th>WhatsApp</th>
								<th>Link</th>
								<th>Status</th>
								<th class="text-end">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($invitations as $invitation)
								<tr>
									<td>
										<div class="d-flex flex-column">
											<span class="fw-bold text-dark">{{ $invitation->guest_name }}</span>
											@if ($invitation->phone_number)
												<small class="text-muted"><i class="bi bi-whatsapp text-success me-1"></i>
													{{ $invitation->phone_number }}</small>
											@endif
											@if ($invitation->guest_address)
												<small class="text-muted"><i class="bi bi-geo-alt me-1"></i> {{ $invitation->guest_address }}</small>
											@endif
										</div>
									</td>
									<td>
										@if ($invitation->phone_number)
											@php
												// Simple formatting: remove non-digits
												$phone = preg_replace('/[^0-9]/', '', $invitation->phone_number);
												// If starts with 0, replace with 62
												if (substr($phone, 0, 1) === '0') {
												    $phone = '62' . substr($phone, 1);
												}
												// Message text using event template
												$link = route('frontend.invitation', [$event->slug, $invitation->slug]);
												$messageTemplate = $event->whatsapp_message ?? 'Hello {name}, here is your invitation: {link}';
												$text = urlencode(str_replace(['{name}', '{link}'], [$invitation->guest_name, $link], $messageTemplate));
											@endphp
											<a href="https://wa.me/{{ $phone }}?text={{ $text }}" target="_blank"
												class="btn btn-sm btn-success text-white">
												<i class="bi bi-whatsapp"></i> Send
											</a>
										@else
											<span class="text-muted small">-</span>
										@endif
									</td>
									<td>
										<div class="input-group input-group-sm" style="min-width: 200px;">
											<input type="text" class="form-control"
												value="{{ route('frontend.invitation', [$event->slug, $invitation->slug]) }}" readonly
												id="link-{{ $invitation->id }}">
											<button class="btn btn-outline-primary" type="button"
												onclick="copyToClipboard('{{ route('frontend.invitation', [$event->slug, $invitation->slug]) }}')">
												<i class="bi bi-clipboard"></i>
											</button>
										</div>
									</td>
									<td>
										@if ($invitation->is_opened)
											<span class="badge bg-success rounded-pill">Opened</span>
											<br><small class="text-muted"
												style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($invitation->opened_at)->diffForHumans() }}</small>
										@else
											<span class="badge bg-warning text-dark rounded-pill">Unopened</span>
										@endif
									</td>
									<td class="text-end">
										<div class="btn-group btn-group-sm">
											<a href="{{ route('user.events.invitations.edit', [$event->id, $invitation->id]) }}"
												class="btn btn-outline-secondary" title="Edit">
												<i class="bi bi-pencil"></i> Edit
											</a>
											<form action="{{ route('user.events.invitations.destroy', [$event->id, $invitation->id]) }}" method="POST"
												class="d-inline" onsubmit="return confirm('Are you sure you want to delete this guest?');">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-outline-danger" title="Delete">
													<i class="bi bi-trash"></i> Delete
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

	<!-- Import Modal -->
	<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ route('user.events.invitations.import', $event->id) }}" method="POST"
					enctype="multipart/form-data">
					@csrf
					<div class="modal-header">
						<h5 class="modal-title">Import Guests (Excel/CSV)</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<label for="importFile" class="form-label">Upload Excel/CSV File</label>
							<input class="form-control" type="file" id="importFile" name="file" accept=".xlsx,.xls,.csv,.txt" required>
							<div class="form-text">
								Format: Name, Phone, Address (Header row is skipped if 'Name' or 'Nama').<br>
								Example: <code>John Doe, 08123456789, Jakarta</code>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-success text-white">Import</button>
					</div>
				</form>
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
