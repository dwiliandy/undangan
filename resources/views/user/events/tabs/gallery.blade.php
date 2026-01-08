<div class="card shadow-sm mb-4">
	<div class="card-header bg-white d-flex justify-content-between align-items-center">
		<h5 class="mb-0">Photo Gallery</h5>
		<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
			<i class="bi bi-upload"></i> Upload Photo
		</button>
	</div>
	<div class="card-body">
		@if ($event->eventGalleries->isEmpty())
			<p class="text-muted text-center py-3">No photos uploaded yet.</p>
		@else
			<div class="row g-3">
				@foreach ($event->eventGalleries as $gallery)
					<div class="col-6 col-md-3">
						<div class="card h-100 border position-relative group-hover">
							<img src="{{ Storage::url($gallery->image_path) }}" class="card-img-top object-fit-cover" style="height: 150px;"
								alt="Gallery">
							<div class="position-absolute top-0 end-0 p-1">
								<form action="{{ route('user.events.galleries.destroy', [$event->id, $gallery->id]) }}" method="POST"
									onsubmit="return confirm('Delete this photo?');">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-danger btn-sm rounded-circle p-1 lh-1"
										style="width: 24px; height: 24px; font-size: 12px;">
										<i class="bi bi-trash"></i>
									</button>
								</form>
							</div>
							@if ($gallery->caption)
								<div class="card-footer p-2 text-center small text-truncate">
									{{ $gallery->caption }}
								</div>
							@endif
						</div>
					</div>
				@endforeach
			</div>
		@endif
	</div>
</div>

<!-- Add Gallery Modal -->
<div class="modal fade" id="addGalleryModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Upload Photo</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('user.events.galleries.store', $event->id) }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
						<label class="form-label">Select Image</label>
						<input type="file" name="image" class="form-control" accept="image/*" required>
					</div>
					<div class="mb-3">
						<label class="form-label">Caption (Optional)</label>
						<input type="text" name="caption" class="form-control" placeholder="e.g., Pre-wedding">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Upload</button>
				</div>
			</form>
		</div>
	</div>
</div>
