@extends('layouts.user')

@section('title', 'My Events')

@section('content')
	<div class="card shadow-sm">
		<div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
			<h4 class="mb-0 text-dark">My Events</h4>
			<a href="{{ route('user.events.create') }}" class="btn btn-primary">Create New Event</a>
		</div>
		<div class="card-body p-0">
			@if (session('success'))
				<div class="alert alert-success m-3" role="alert">
					{{ session('success') }}
				</div>
			@endif

			@if ($events->isEmpty())
				<div class="text-center py-5">
					<p class="text-muted fs-5">You haven't created any events yet.</p>
					<a href="{{ route('user.events.create') }}" class="btn btn-link text-decoration-none">Get Started</a>
				</div>
			@else
				<div class="table-responsive">
					<table class="table table-hover align-middle mb-0">
						<thead class="bg-light">
							<tr>
								<th class="ps-4">Title</th>
								<th>Slug</th>
								<th>Date</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($events as $event)
								<tr>
									<td class="ps-4 fw-bold text-dark">{{ $event->title }}</td>
									<td class="text-muted">{{ $event->slug }}</td>
									<td>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
									<td>
										<span class="badge rounded-pill {{ $event->is_active ? 'bg-success' : 'bg-secondary' }}">
											{{ $event->is_active ? 'Active' : 'Inactive' }}
										</span>
									</td>
									<td>
										<div class="btn-group" role="group">
											<a href="{{ route('user.events.invitations.index', $event->id) }}" class="btn btn-sm btn-outline-info"
												title="Guests">Guests</a>
											<a href="{{ route('user.events.wedding-details.edit', $event->id) }}" class="btn btn-sm btn-outline-purple"
												style="color: #6f42c1; border-color: #6f42c1;" title="Details">Details</a>
											<a href="{{ route('user.events.edit', $event->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
											<form action="{{ route('user.events.destroy', $event->id) }}" method="POST" class="d-inline"
												onsubmit="return confirm('Are you sure?');">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-sm btn-outline-danger rounded-0 rounded-end">Delete</button>
											</form>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</div>
	</div>
@endsection
