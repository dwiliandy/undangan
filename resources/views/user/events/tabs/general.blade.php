<div class="card shadow-sm">
	<div class="card-header bg-white">
		<h5 class="mb-0">General Settings</h5>
	</div>
	<div class="card-body">
		<form action="{{ route('user.events.update', $event->id) }}" method="POST">
			@csrf
			@method('PUT')

			<div class="mb-3">
				<label for="title" class="form-label">Event Title</label>
				<input type="text" class="form-control" id="title" name="title" value="{{ old('title', $event->title) }}"
					required>
			</div>

			<div class="mb-3">
				<label for="slug" class="form-label">URL Slug</label>
				<div class="input-group">
					<span class="input-group-text">{{ url('/') }}/</span>
					<input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $event->slug) }}"
						required>
				</div>
			</div>

			<div class="mb-3">
				<label for="event_date" class="form-label">Event Date</label>
				<input type="date" class="form-control" id="event_date" name="event_date"
					value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d')) }}" required>
			</div>

			<div class="d-flex justify-content-end">
				<button type="submit" class="btn btn-primary">Update Settings</button>
			</div>
		</form>
	</div>
</div>
