@extends('layouts.user')

@section('title', 'Edit Event')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card shadow-sm">
					<div class="card-header bg-white d-flex justify-content-between align-items-center">
						<h4 class="mb-0">Edit Event</h4>
						<a href="{{ route('user.events.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
					</div>
					<div class="card-body">
						@if ($errors->any())
							<div class="alert alert-danger">
								<ul class="mb-0 ps-3">
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						<form action="{{ route('user.events.update', $event->id) }}" method="POST">
							@csrf
							@method('PUT')

							<div class="mb-3">
								<label for="title" class="form-label">Event Title</label>
								<input type="text" class="form-control" id="title" name="title"
									value="{{ old('title', $event->title) }}" required>
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
									value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required>
							</div>

							<div class="mb-4">
								<label for="event_template_id" class="form-label">Template</label>
								<select class="form-select" id="event_template_id" name="event_template_id" required>
									@foreach ($templates as $template)
										<option value="{{ $template->id }}"
											{{ old('event_template_id', $event->event_template_id) == $template->id ? 'selected' : '' }}>
											{{ $template->name }}
										</option>
									@endforeach
								</select>
							</div>

							<div class="d-flex justify-content-end">
								<button type="submit" class="btn btn-primary">Update Event</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
