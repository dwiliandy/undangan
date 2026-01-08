<div class="card shadow-sm mb-4">
	<div class="card-header bg-white d-flex justify-content-between align-items-center">
		<h5 class="mb-0">Love Story / Journey</h5>
		<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addJourneyModal">
			<i class="bi bi-plus-lg"></i> Add Story
		</button>
	</div>
	<div class="card-body">
		@if ($event->eventJourneys->isEmpty())
			<p class="text-muted text-center py-3">No stories added yet.</p>
		@else
			<div class="list-group">
				@foreach ($event->eventJourneys as $journey)
					<div class="list-group-item d-flex justify-content-between align-items-center">
						<div>
							<h6 class="mb-1 fw-bold">{{ $journey->title }} <small
									class="text-muted ms-2">({{ $journey->journey_date ? $journey->journey_date->format('Y') : '' }})</small></h6>
							<p class="mb-1 text-muted small">{{ Str::limit($journey->description, 100) }}</p>
						</div>
						<form action="{{ route('user.events.journeys.destroy', [$event->id, $journey->id]) }}" method="POST"
							onsubmit="return confirm('Delete this story?');">
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

<!-- Add Journey Modal -->
<div class="modal fade" id="addJourneyModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add New Story</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('user.events.journeys.store', $event->id) }}" method="POST">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
						<label class="form-label">Title</label>
						<input type="text" name="title" class="form-control" placeholder="e.g., First Met" required>
					</div>
					<div class="mb-3">
						<label class="form-label">Date</label>
						<input type="date" name="journey_date" class="form-control" required>
					</div>
					<div class="mb-3">
						<label class="form-label">Story Description</label>
						<textarea name="description" class="form-control" rows="3" required></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save Story</button>
				</div>
			</form>
		</div>
	</div>
</div>
