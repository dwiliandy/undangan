@extends('layouts.user')

@section('title', 'Edit Event')

@section('content')
	<div class="container-fluid">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div>
				<h2 class="h3 text-gray-800 fw-bold">Edit Event</h2>
				<p class="text-muted small">Update your event details.</p>
			</div>
			<a href="{{ route('user.events.index') }}" class="btn btn-outline-secondary">
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

		<form action="{{ route('user.events.update', $event->id) }}" method="POST">
			@csrf
			@method('PUT')

			<div class="row g-4">
				<div class="col-lg-8">
					<div class="card shadow-sm border-0 rounded-3">
						<div class="card-header bg-transparent border-bottom py-3">
							<h5 class="card-title mb-0 fw-semibold text-primary">Event Information</h5>
						</div>
						<div class="card-body p-4">
							<div class="mb-4">
								<label for="title" class="form-label fw-semibold">Event Title</label>
								<input type="text" class="form-control" id="title" name="title"
									value="{{ old('title', $event->title) }}" required>
							</div>

							<div class="mb-4">
								<label for="slug" class="form-label fw-semibold">Event URL Slug</label>
								<div class="input-group">
									<span class="input-group-text bg-light">{{ url('/') }}/</span>
									<input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $event->slug) }}"
										required>
								</div>
								<div class="form-text small">Changing this will break existing invitation links!</div>
							</div>

							<div class="mb-4">
								<label for="event_date" class="form-label fw-semibold">Event Date</label>
								<input type="date" class="form-control" id="event_date" name="event_date"
									value="{{ old('event_date', $event->event_date) }}" required>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="card shadow-sm border-0 rounded-3 sticky-top" style="top: 20px;">
						<div class="card-header bg-transparent border-bottom py-3">
							<h5 class="card-title mb-0 fw-semibold text-primary">Settings</h5>
						</div>
						<div class="card-body p-4">
							<div class="mb-4">
								<label class="form-label fw-semibold">Template Theme</label>
								<div class="row g-3">
									@foreach ($templates as $template)
										<div class="col-6">
											<div
												class="card h-100 {{ old('event_template_id', $event->event_template_id) == $template->id ? 'border-primary ring-2 ring-primary' : '' }}">
												<div class="position-relative">
													<img src="{{ $template->thumbnail_url ?? 'https://via.placeholder.com/300x200' }}" class="card-img-top"
														alt="{{ $template->name }}" style="height: 120px; object-fit: cover;">
													<a href="{{ route('frontend.preview', $template->slug) }}" target="_blank"
														class="btn btn-sm btn-light position-absolute top-0 end-0 m-1 rounded-circle shadow-sm"
														title="Preview Theme">
														<i class="bi bi-eye-fill text-primary"></i>
													</a>
												</div>
												<div class="card-body p-2 text-center">
													<h6 class="card-title small fw-bold mb-1">{{ $template->name }}</h6>
													<div class="form-check d-inline-block">
														<input class="form-check-input" type="radio" name="event_template_id" id="template_{{ $template->id }}"
															value="{{ $template->id }}"
															{{ old('event_template_id', $event->event_template_id) == $template->id ? 'checked' : '' }} required>
														<label class="form-check-label small" for="template_{{ $template->id }}">Select</label>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
						<div class="card-footer bg-transparent border-top p-3">
							<button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
								<i class="bi bi-check-lg me-2"></i> Update Event
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	</div>
	<div class="card-footer bg-transparent border-top p-3">
		<button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
			<i class="bi bi-check-lg me-2"></i> Update Event
		</button>
	</div>
	</div>
	</div>
	</div>
	</form>
	</div>
@endsection
