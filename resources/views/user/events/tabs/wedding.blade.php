<div class="card shadow-sm">
	<div class="card-header bg-white">
		<h5 class="mb-0">Wedding Details</h5>
	</div>
	<div class="card-body">
		<form action="{{ route('user.events.wedding-details.update', $event->id) }}" method="POST">
			@csrf

			<!-- Groom Section -->
			<div class="mb-4">
				<h6 class="border-bottom pb-2 mb-3 text-primary fw-bold">Mempelai Pria (The Groom)</h6>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="groom_name" class="form-label">Full Name</label>
						<input type="text" class="form-control" id="groom_name" name="groom_name"
							value="{{ old('groom_name', $event->weddingEvent->groom_name ?? '') }}" placeholder="Putra" required>
					</div>
					<div class="col-md-6 mb-3">
						<label for="groom_parent" class="form-label">Parents' Names</label>
						<input type="text" class="form-control" id="groom_parent" name="groom_parent"
							value="{{ old('groom_parent', $event->weddingEvent->groom_parent ?? '') }}" placeholder="Bpk. Joko & Ibu Sri">
					</div>
				</div>
			</div>

			<!-- Bride Section -->
			<div class="mb-4">
				<h6 class="border-bottom pb-2 mb-3 text-primary fw-bold">Mempelai Wanita (The Bride)</h6>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="bride_name" class="form-label">Full Name</label>
						<input type="text" class="form-control" id="bride_name" name="bride_name"
							value="{{ old('bride_name', $event->weddingEvent->bride_name ?? '') }}" placeholder="Putri" required>
					</div>
					<div class="col-md-6 mb-3">
						<label for="bride_parent" class="form-label">Parents' Names</label>
						<input type="text" class="form-control" id="bride_parent" name="bride_parent"
							value="{{ old('bride_parent', $event->weddingEvent->bride_parent ?? '') }}" placeholder="Bpk. Budi & Ibu Tini">
					</div>
				</div>
			</div>

			<div class="d-flex justify-content-end">
				<button type="submit" class="btn btn-primary">Save Details</button>
			</div>
		</form>
	</div>
</div>
