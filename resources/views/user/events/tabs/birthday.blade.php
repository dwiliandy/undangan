<div class="card shadow-sm">
	<div class="card-header bg-white">
		<h5 class="mb-0">Birthday Details</h5>
	</div>
	<div class="card-body">
		<form action="{{ route('user.events.birthday-details.update', $event->id) }}" method="POST"
			enctype="multipart/form-data">
			@csrf

			<div class="mb-4">
				<h6 class="border-bottom pb-2 mb-3 text-primary fw-bold">Birthday Person</h6>
				<div class="row">
					<div class="col-md-8 mb-3">
						<label for="person_name" class="form-label">Full Name / Nickname</label>
						<input type="text" class="form-control" id="person_name" name="person_name"
							value="{{ old('person_name', $event->birthdayEvent->person_name ?? '') }}" placeholder="e.g. Budi Santoso"
							required>
					</div>
					<div class="col-md-4 mb-3">
						<label for="age" class="form-label">Turning Age (Optional)</label>
						<input type="number" class="form-control" id="age" name="age"
							value="{{ old('age', $event->birthdayEvent->age ?? '') }}" placeholder="e.g. 17">
					</div>
				</div>
				<div class="mb-3">
					<label for="photo" class="form-label">Photo (Optional)</label>
					<input type="file" class="form-control" id="photo" name="photo" accept="image/*">
					@if (isset($event->birthdayEvent->photo))
						<div class="mt-2">
							<img src="{{ Storage::url($event->birthdayEvent->photo) }}" alt="Current Photo" class="img-thumbnail"
								style="max-height: 150px;">
						</div>
					@endif
				</div>
			</div>

			<div class="d-flex justify-content-end">
				<button type="submit" class="btn btn-primary">Save Details</button>
			</div>
		</form>
	</div>
</div>
