<aside class="w-64 bg-white border-r border-gray-200 hidden md:block">
	<div class="h-16 flex items-center justify-center border-b border-gray-200">
		<span class="text-xl font-bold text-gray-800">My Undangan</span>
	</div>
	<nav class="mt-6">
		<a href="{{ route('user.dashboard') }}"
			class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('user.dashboard') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }}">
			<span class="mx-3">Dashboard</span>
		</a>
		<a href="{{ route('user.events.index') }}"
			class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('user.events.*') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }}">
			<span class="mx-3">My Events</span>
		</a>
		<a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100">
			<span class="mx-3">Guest List</span>
		</a>
		<a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100">
			<span class="mx-3">Profile</span>
		</a>
	</nav>
</aside>
