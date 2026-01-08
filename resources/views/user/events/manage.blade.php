@extends('layouts.user')

@section('title', 'Manage Event: ' . $event->title)

@section('content')
	<div class="row">
		<!-- Sidebar / Tabs Navigation -->
		<div class="col-md-3 mb-4">
			<div class="card shadow-sm">
				<div class="card-body p-0">
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link active rounded-0 border-bottom p-3" id="v-pills-general-tab" data-bs-toggle="pill"
							href="#v-pills-general" role="tab" aria-controls="v-pills-general" aria-selected="true">
							<i class="bi bi-gear-fill me-2"></i> General Settings
						</a>
						<a class="nav-link rounded-0 border-bottom p-3" id="v-pills-wedding-tab" data-bs-toggle="pill"
							href="#v-pills-wedding" role="tab" aria-controls="v-pills-wedding" aria-selected="false">
							<i class="bi bi-heart-fill me-2"></i> Wedding Info
						</a>
						<a class="nav-link rounded-0 border-bottom p-3" id="v-pills-journey-tab" data-bs-toggle="pill"
							href="#v-pills-journey" role="tab" aria-controls="v-pills-journey" aria-selected="false">
							<i class="bi bi-journal-album me-2"></i> Love Story / Journey
						</a>
						<a class="nav-link rounded-0 border-bottom p-3" id="v-pills-gallery-tab" data-bs-toggle="pill"
							href="#v-pills-gallery" role="tab" aria-controls="v-pills-gallery" aria-selected="false">
							<i class="bi bi-images me-2"></i> Gallery
						</a>
						<a class="nav-link rounded-0 border-bottom p-3" id="v-pills-location-tab" data-bs-toggle="pill"
							href="#v-pills-location" role="tab" aria-controls="v-pills-location" aria-selected="false">
							<i class="bi bi-geo-alt-fill me-2"></i> Locations
						</a>
						<a href="{{ route('user.events.invitations.index', $event->id) }}" class="nav-link rounded-0 p-3 text-dark">
							<i class="bi bi-people-fill me-2"></i> Guest Management <i class="bi bi-box-arrow-up-right small ms-1"></i>
						</a>
						<a href="{{ route('user.events.index') }}" class="nav-link rounded-0 p-3 text-secondary border-top">
							<i class="bi bi-arrow-left me-2"></i> Back to Events
						</a>
					</div>
				</div>
			</div>
		</div>

		<!-- Content Area -->
		<div class="col-md-9">
			@if (session('success'))
				<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
					{{ session('success') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<div class="tab-content" id="v-pills-tabContent">
				<!-- General Settings Tab -->
				<div class="tab-pane fade show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
					@include('user.events.tabs.general')
				</div>

				<!-- Wedding Info Tab -->
				<div class="tab-pane fade" id="v-pills-wedding" role="tabpanel" aria-labelledby="v-pills-wedding-tab">
					@include('user.events.tabs.wedding')
				</div>

				<!-- Journey Tab -->
				<div class="tab-pane fade" id="v-pills-journey" role="tabpanel" aria-labelledby="v-pills-journey-tab">
					@include('user.events.tabs.journey')
				</div>

				<!-- Gallery Tab -->
				<div class="tab-pane fade" id="v-pills-gallery" role="tabpanel" aria-labelledby="v-pills-gallery-tab">
					@include('user.events.tabs.gallery')
				</div>

				<!-- Location Tab -->
				<div class="tab-pane fade" id="v-pills-location" role="tabpanel" aria-labelledby="v-pills-location-tab">
					@include('user.events.tabs.location')
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Storage Key specifically for this event
			const storageKey = 'activeTab_event_{{ $event->id }}';

			// Retrieve saved tab
			const activeTabId = localStorage.getItem(storageKey);

			if (activeTabId) {
				const triggerEl = document.querySelector(`#${activeTabId}`);
				if (triggerEl) {
					const tab = new bootstrap.Tab(triggerEl);
					tab.show();
				}
			}

			// Listen for tab changes
			const tabLinks = document.querySelectorAll('a[data-bs-toggle="pill"]');
			tabLinks.forEach(link => {
				link.addEventListener('shown.bs.tab', function(event) {
					localStorage.setItem(storageKey, event.target.id);
				});
			});
		});
	</script>
@endpush
