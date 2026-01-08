@extends('layouts.user')

@section('title', 'Wedding Details')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-9">
				<div class="card shadow-sm">
					<div class="card-header bg-white d-flex justify-content-between align-items-center">
						<h5 class="mb-0">Wedding Details for {{ $event->title }}</h5>
						<a href="{{ route('user.events.index') }}" class="btn btn-outline-secondary btn-sm">Back to Events</a>
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

						@if (session('success'))
							<div class="alert alert-success">
								{{ session('success') }}
							</div>
						@endif

						<form action="{{ route('user.events.wedding-details.update', $event->id) }}" method="POST">
							@csrf

							<!-- Groom Section -->
							<div class="mb-4">
								<h5 class="border-bottom pb-2 mb-3 text-primary">Mempelai Pria (The Groom)</h5>
								<div class="mb-3">
									<label for="groom_name" class="form-label fw-bold">Full Name</label>
									<input type="text" class="form-control" id="groom_name" name="groom_name"
										value="{{ old('groom_name', $weddingEvent->groom_name ?? '') }}" placeholder="Putra" required>
								</div>
								<div class="mb-3">
									<label for="groom_parent" class="form-label fw-bold">Parents' Names</label>
									<input type="text" class="form-control" id="groom_parent" name="groom_parent"
										value="{{ old('groom_parent', $weddingEvent->groom_parent ?? '') }}" placeholder="Bpk. Joko & Ibu Sri">
									<div class="form-text">Optional. E.g., Bpk. Name & Ibu Name</div>
								</div>
							</div>

							<!-- Bride Section -->
							<div class="mb-4">
								<h5 class="border-bottom pb-2 mb-3 text-primary">Mempelai Wanita (The Bride)</h5>
								<div class="mb-3">
									<label for="bride_name" class="form-label fw-bold">Full Name</label>
									<input type="text" class="form-control" id="bride_name" name="bride_name"
										value="{{ old('bride_name', $weddingEvent->bride_name ?? '') }}" placeholder="Putri" required>
								</div>
								<div class="mb-3">
									<label for="bride_parent" class="form-label fw-bold">Parents' Names</label>
									<input type="text" class="form-control" id="bride_parent" name="bride_parent"
										value="{{ old('bride_parent', $weddingEvent->bride_parent ?? '') }}" placeholder="Bpk. Budi & Ibu Tini">
									<div class="form-text">Optional.</div>
								</div>
							</div>

							<div class="d-flex justify-content-end">
								<button type="submit" class="btn btn-primary px-4">Save Details</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
