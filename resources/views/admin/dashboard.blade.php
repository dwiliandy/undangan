@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
	<div class="container-fluid">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">Dashboard</h1>
		</div>

		<div class="row g-4">
			<!-- Stats Card: Users -->
			<div class="col-xl-3 col-md-6">
				<div class="card bg-primary text-white mb-4 h-100 shadow-sm">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center">
							<div>
								<h6 class="text-uppercase mb-1">Total Users</h6>
								<h2 class="mb-0 fw-bold">{{ \App\Models\User::where('role', 'user')->count() }}</h2>
							</div>
							<i class="bi bi-people fs-1 opacity-50"></i>
						</div>
					</div>
					<div class="card-footer d-flex align-items-center justify-content-between small border-0 bg-primary bg-opacity-75">
						<a class="text-white stretched-link text-decoration-none" href="{{ route('admin.users.index') }}">View Details</a>
						<i class="bi bi-chevron-right"></i>
					</div>
				</div>
			</div>

			<!-- Stats Card: Events -->
			<div class="col-xl-3 col-md-6">
				<div class="card bg-success text-white mb-4 h-100 shadow-sm">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center">
							<div>
								<h6 class="text-uppercase mb-1">Active Events</h6>
								<h2 class="mb-0 fw-bold">{{ \App\Models\Event::count() }}</h2>
							</div>
							<i class="bi bi-calendar-check fs-1 opacity-50"></i>
						</div>
					</div>
					<div class="card-footer d-flex align-items-center justify-content-between small border-0 bg-success bg-opacity-75">
						<a class="text-white stretched-link text-decoration-none" href="{{ route('admin.events.index') }}">View Details</a>
						<i class="bi bi-chevron-right"></i>
					</div>
				</div>
			</div>

			<!-- Stats Card: Templates -->
			<div class="col-xl-3 col-md-6">
				<div class="card bg-warning text-dark mb-4 h-100 shadow-sm">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center">
							<div>
								<h6 class="text-uppercase mb-1">Templates</h6>
								<h2 class="mb-0 fw-bold">{{ \App\Models\EventTemplate::count() }}</h2>
							</div>
							<i class="bi bi-layout-text-window-reverse fs-1 opacity-50"></i>
						</div>
					</div>
					<div class="card-footer d-flex align-items-center justify-content-between small border-0 bg-warning bg-opacity-75">
						<a class="text-dark stretched-link text-decoration-none" href="{{ route('admin.templates.index') }}">View
							Details</a>
						<i class="bi bi-chevron-right"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
