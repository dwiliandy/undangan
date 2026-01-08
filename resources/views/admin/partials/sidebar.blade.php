<nav class="sidebar d-flex flex-column p-3 text-white">
	<a href="{{ route('admin.dashboard') }}"
		class="d-flex align-items-center mb-4 mb-md-0 me-md-auto text-white text-decoration-none">
		<span class="fs-4 fw-bold ps-2">Admin Panel</span>
	</a>
	<hr>
	<ul class="nav nav-pills flex-column mb-auto">
		<li class="nav-item">
			<a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
				<i class="bi bi-speedometer2"></i>
				Dashboard
			</a>
		</li>
		<li>
			<a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
				<i class="bi bi-people"></i>
				Users
			</a>
		</li>
		<li>
			<a href="{{ route('admin.events.index') }}"
				class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
				<i class="bi bi-calendar-event"></i>
				Events
			</a>
		</li>
		<li>
			<a href="{{ route('admin.templates.index') }}"
				class="nav-link {{ request()->routeIs('admin.templates.*') ? 'active' : '' }}">
				<i class="bi bi-layout-text-window-reverse"></i>
				Templates
			</a>
		</li>
	</ul>
	<hr>
	<div class="dropdown">
		<a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1"
			data-bs-toggle="dropdown" aria-expanded="false">
			<strong>{{ auth()->user()->name }}</strong>
		</a>
		<ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
			<li>
				<form method="POST" action="{{ route('admin.logout') }}">
					@csrf
					<button type="submit" class="dropdown-item">Sign out</button>
				</form>
			</li>
		</ul>
	</div>
</nav>
