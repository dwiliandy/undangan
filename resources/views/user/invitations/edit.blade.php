@extends('layouts.user')

@section('title', 'Edit Guest')

@section('content')
	<div class="container-fluid">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div>
				<h2 class="h3 text-gray-800 fw-bold">Edit Guest</h2>
				<p class="text-muted small">Update guest details.</p>
			</div>
			<a href="{{ route('user.events.invitations.index', $event->id) }}" class="btn btn-outline-secondary">
				<i class="bi bi-arrow-left me-2"></i>Back to List
			</a>
		</div>

		@if ($errors->any())
			<div class="alert alert-danger shadow-sm border-0 border-start border-5 border-danger" role="alert">
				<ul class="mb-0 ps-3">
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<div class="card shadow-sm border-0 rounded-3">
			<div class="card-header bg-transparent border-bottom py-3">
				<h5 class="card-title mb-0 fw-semibold text-primary">Guest Information</h5>
			</div>
			<div class="card-body p-4">
				<form action="{{ route('user.events.invitations.update', [$event->id, $invitation->id]) }}" method="POST">
					@csrf
					@method('PUT')

					<div class="mb-4">
						<label for="guest_name" class="form-label fw-semibold">Guest Name</label>
						<input type="text" class="form-control" id="guest_name" name="guest_name"
							value="{{ old('guest_name', $invitation->guest_name) }}" placeholder="Mr. John Doe" required>
					</div>

					<div class="mb-4">
						<label for="phone_number" class="form-label fw-semibold">Phone Number (WhatsApp)</label>
						<input type="text" class="form-control" id="phone_number" name="phone_number"
							value="{{ old('phone_number', $invitation->phone_number) }}" placeholder="08123456789">
						<div class="form-text">Used for sending invitation link via WhatsApp.</div>
					</div>

					<div class="mb-4">
						<label for="guest_address" class="form-label fw-semibold">Guest Address / Note</label>
						<textarea class="form-control" id="guest_address" name="guest_address" rows="3"
						 placeholder="e.g. Family from Jakarta">{{ old('guest_address', $invitation->guest_address) }}</textarea>
					</div>

					<div class="d-flex justify-content-end">
						<button type="submit" class="btn btn-primary px-4 fw-bold">
							<i class="bi bi-check-lg me-2"></i> Update Guest
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
