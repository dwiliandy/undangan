@extends('admin.layout')

@section('title', 'Edit Template')

@section('content')
	<div class="container-fluid">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div>
				<h2 class="h3 text-gray-800 fw-bold">Edit Template</h2>
				<p class="text-muted small">Manage your invitation design details and visuals.</p>
			</div>
			<a href="{{ route('admin.templates.index') }}" class="btn btn-light border shadow-sm">
				<i class="bi bi-arrow-left me-2"></i>Back to List
			</a>
		</div>

		@if ($errors->any())
			<div class="alert alert-danger shadow-sm border-0 border-start border-5 border-danger fade show" role="alert">
				<div class="d-flex align-items-center">
					<i class="bi bi-exclamation-circle-fill fs-4 me-3 text-danger"></i>
					<div>
						<h6 class="alert-heading fw-bold mb-1">Validation Error</h6>
						<ul class="mb-0 small ps-3">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		@endif

		<form action="{{ route('admin.templates.update', $template->id) }}" method="POST">
			@csrf
			@method('PUT')

			<div class="row g-4">
				<!-- Form Section -->
				<div class="col-lg-8">
					<div class="card shadow-sm border-0 rounded-3">
						<div class="card-header bg-transparent border-bottom py-3">
							<h5 class="card-title mb-0 fw-semibold text-primary">General Information</h5>
						</div>
						<div class="card-body p-4">
							<div class="mb-4">
								<label for="name" class="form-label fw-semibold">Template Name</label>
								<input type="text" class="form-control" id="name" name="name"
									value="{{ old('name', $template->name) }}" required placeholder="e.g. Modern Floral">
							</div>

							<div class="row g-4 mb-4">
								<div class="col-md-6">
									<label for="view_path" class="form-label fw-semibold">View Path</label>
									<div class="input-group">
										<span class="input-group-text bg-light"><i class="bi bi-code-slash"></i></span>
										<input type="text" class="form-control font-monospace" id="view_path" name="view_path"
											value="{{ old('view_path', $template->view_path) }}" required placeholder="frontend.templates.v1">
									</div>
									<div class="form-text small">Blade file location (dot notation).</div>
								</div>

								<div class="col-md-6">
									<label class="form-label fw-semibold">Status</label>
									<div class="form-check form-switch p-0 m-0 border rounded px-3 py-2 d-flex align-items-center">
										<input class="form-check-input ms-0 me-3 fs-4" type="checkbox" role="switch" id="is_active" name="is_active"
											value="1" {{ $template->is_active ? 'checked' : '' }}>
										<label class="form-check-label fw-medium stretched-link cursor-pointer" for="is_active">Active /
											Published</label>
									</div>
								</div>
							</div>

							<div>
								<label for="description" class="form-label fw-semibold">Description</label>
								<textarea class="form-control" id="description" name="description" rows="4"
								 placeholder="Brief description of the template style...">{{ old('description', $template->description) }}</textarea>
							</div>
						</div>
					</div>
				</div>

				<!-- Visuals Section -->
				<div class="col-lg-4">
					<div class="card shadow-sm border-0 rounded-3 sticky-top" style="top: 20px;">
						<div class="card-header bg-transparent border-bottom py-3">
							<h5 class="card-title mb-0 fw-semibold text-primary">Visuals</h5>
						</div>
						<div class="card-body p-4 space-y-4">
							<div class="mb-4">
								<label for="thumbnail" class="form-label fw-semibold">Thumbnail URL</label>
								<div class="input-group">
									<span class="input-group-text bg-light"><i class="bi bi-image"></i></span>
									<input type="text" class="form-control" id="thumbnail" name="thumbnail"
										value="{{ old('thumbnail', $template->thumbnail) }}" placeholder="https://...">
								</div>
							</div>

							<!-- Preview Box -->
							<div class="border rounded-3 p-3 bg-light text-center min-vh-25 position-relative" id="preview-container"
								style="min-height: 200px;">
								<img id="image-preview" src="{{ old('thumbnail', $template->thumbnail) }}" alt="Preview"
									class="img-fluid rounded shadow-sm {{ $template->thumbnail ? '' : 'd-none' }}"
									style="max-height: 250px; object-fit: cover;">
								<div id="no-image-placeholder"
									class="position-absolute top-50 start-50 translate-middle {{ $template->thumbnail ? 'd-none' : '' }}">
									<i class="bi bi-image text-secondary display-4 d-block mb-2"></i>
									<span class="text-secondary small">No thumbnail preview</span>
								</div>
							</div>
						</div>
						<div class="card-footer bg-transparent border-top p-3">
							<button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
								<i class="bi bi-save me-2"></i> Save Changes
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const thumbnailInput = document.getElementById('thumbnail');
			const previewImage = document.getElementById('image-preview');
			const placeholder = document.getElementById('no-image-placeholder');

			function updatePreview() {
				const url = thumbnailInput.value.trim();
				if (url) {
					previewImage.src = url;
					previewImage.classList.remove('d-none');
					placeholder.classList.add('d-none');

					// Handle error
					previewImage.onerror = function() {
						previewImage.classList.add('d-none');
						placeholder.classList.remove('d-none');
					};
				} else {
					previewImage.src = '';
					previewImage.classList.add('d-none');
					placeholder.classList.remove('d-none');
				}
			}

			thumbnailInput.addEventListener('input', updatePreview);
			// Trigger on load for preset values
			updatePreview();
		});
	</script>
@endsection
