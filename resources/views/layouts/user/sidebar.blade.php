<nav id="sidebar" class="bg-dark text-white" style="min-width: 250px; max-width: 250px; min-height: 100vh;">
	<div class="p-4">
		<h3 class="text-center py-2 border-bottom border-secondary">UndanganKita</h3>
		<ul class="list-unstyled components mt-4">
			<li class="mb-2">
				<a href="{{ route('user.dashboard') }}"
					class="text-white text-decoration-none d-block p-2 rounded {{ request()->routeIs('user.dashboard') ? 'bg-primary' : 'hover-bg-secondary' }}">
					Dashboard
				</a>
			</li>
			<li class="mb-2">
				<a href="{{ route('user.events.index') }}"
					class="text-white text-decoration-none d-block p-2 rounded {{ request()->routeIs('user.events.*') ? 'bg-primary' : 'hover-bg-secondary' }}">
					My Events
				</a>
			</li>
		</ul>
	</div>
</nav>

<style>
	.hover-bg-secondary:hover {
		background-color: #6c757d;
	}
</style>
