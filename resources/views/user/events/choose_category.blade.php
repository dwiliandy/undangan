@extends('layouts.user')

@section('title', 'Create New Event')

@section('content')
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-md-8 text-center">
				<h2 class="mb-4">What kind of event are you planning?</h2>

				<div class="row g-4 justify-content-center">
					<!-- Wedding Option -->
					<div class="col-md-5">
						<div class="card h-100 shadow-sm hover-shadow transition-all">
							<div class="card-body p-5">
								<div class="mb-4">
									<i class="bi bi-heart-fill text-danger display-1"></i>
								</div>
								<h3 class="card-title">Wedding</h3>
								<p class="text-muted">Plan your special day with elegant templates.</p>
								<a href="{{ route('user.events.create', ['category' => 'wedding']) }}"
									class="btn btn-outline-danger stretched-link w-100">Select Wedding</a>
							</div>
						</div>
					</div>

					<!-- Birthday Option -->
					<div class="col-md-5">
						<div class="card h-100 shadow-sm hover-shadow transition-all">
							<div class="card-body p-5">
								<div class="mb-4">
									<i class="bi bi-gift-fill text-primary display-1"></i>
								</div>
								<h3 class="card-title">Birthday</h3>
								<p class="text-muted">Celebrate life with fun and colorful designs.</p>
								<a href="{{ route('user.events.create', ['category' => 'birthday']) }}"
									class="btn btn-outline-primary stretched-link w-100">Select Birthday</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style>
		.hover-shadow:hover {
			transform: translateY(-5px);
			box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
		}

		.transition-all {
			transition: all 0.3s ease;
		}
	</style>
@endsection
