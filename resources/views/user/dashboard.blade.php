@extends('layouts.user')

@section('title', __('user.dashboard'))

@section('content')
	<div class="card shadow-sm">
		<div class="card-body">
			<h2 class="card-title h4 mb-4">{{ __('user.welcome', ['name' => auth()->user()->name]) }}</h2>
			<p class="card-text text-muted mb-4">{{ __('user.manage_events') }}</p>

			<div class="row g-4">
				<!-- Create Event Card -->
				<div class="col-md-6 col-lg-4">
					<div class="card h-100 border-primary text-center bg-light">
						<div class="card-body d-flex flex-column justify-content-center align-items-center">
							<div class="mb-3 text-primary">
								<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
									class="bi bi-calendar-plus" viewBox="0 0 16 16">
									<path
										d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z" />
									<path
										d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
								</svg>
							</div>
							<h5 class="card-title text-primary">{{ __('user.create_new_event') }}</h5>
							<p class="card-text small text-muted">{{ __('user.start_creating') }}</p>
							<a href="{{ route('user.events.create') }}" class="btn btn-primary mt-auto">{{ __('user.create_now') }}</a>
						</div>
					</div>
				</div>

				<!-- Stats Card -->
				<div class="col-md-6 col-lg-4">
					<div class="card h-100">
						<div class="card-body">
							<h5 class="card-title text-muted">{{ __('user.my_events') }}</h5>
							<p class="display-6 fw-bold text-dark">0</p>
							<p class="card-text small text-muted">{{ __('user.active_events') }}</p>
						</div>
					</div>
				</div>

				<!-- Stats Card -->
				<div class="col-md-6 col-lg-4">
					<div class="card h-100">
						<div class="card-body">
							<h5 class="card-title text-muted">{{ __('user.total_guests') }}</h5>
							<p class="display-6 fw-bold text-dark">0</p>
							<p class="card-text small text-muted">{{ __('user.across_all_events') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
