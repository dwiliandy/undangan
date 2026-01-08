<div class="card shadow-sm mb-4">
	<div class="card-header bg-white d-flex justify-content-between align-items-center">
		<h5 class="mb-0">Event Locations</h5>
		<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLocationModal">
			<i class="bi bi-plus-lg"></i> Add Location
		</button>
	</div>
	<div class="card-body">
		@if ($event->eventLocations->isEmpty())
			<p class="text-muted text-center py-3">No locations added yet.</p>
		@else
			<div class="list-group">
				@foreach ($event->eventLocations as $location)
					<div class="list-group-item d-flex justify-content-between align-items-center">
						<div>
							<div class="d-flex align-items-center gap-2">
								<span class="badge bg-secondary text-capitalize">{{ $location->location_type }}</span>
								<h6 class="mb-0 fw-bold">{{ $location->name }}</h6>
							</div>
							<p class="mb-0 small text-muted mt-1">
								<i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($location->event_time)->format('H:i') }} |
								<i class="bi bi-geo-alt"></i> {{ Str::limit($location->address, 50) }}
							</p>
						</div>
						<form action="{{ route('user.events.locations.destroy', [$event->id, $location->id]) }}" method="POST"
							onsubmit="return confirm('Delete this location?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
						</form>
					</div>
				@endforeach
			</div>
		@endif
	</div>
</div>

<!-- Add Location Modal -->
<div class="modal fade" id="addLocationModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Location</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('user.events.locations.store', $event->id) }}" method="POST">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
						<label class="form-label">Venue Name</label>
						<input type="text" name="name" class="form-control" placeholder="e.g., Grand Hotel Ballroom" required>
					</div>
					<div class="mb-3">
						<label class="form-label">Type</label>
						<select name="location_type" class="form-select" required>
							<option value="akad">Akad Nikah / Holy Matrimony</option>
							<option value="resepsi">Resepsi (Reception)</option>
							<option value="party">After Party</option>
						</select>
					</div>
					<div class="mb-3">
						<label class="form-label">Time</label>
						<input type="time" name="event_time" class="form-control" required>
					</div>
					<div class="mb-3">
						<label class="form-label">Address</label>
						<textarea name="address" class="form-control" rows="2" required></textarea>
					</div>
					<div class="mb-3">
						<label class="form-label">Google Maps URL (Optional)</label>
						<input type="url" name="google_maps_url" class="form-control" placeholder="https://maps.google.com/...">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save Location</button>
				</div>
			</form>
		</div>
	</div>
</div>
