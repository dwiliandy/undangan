<aside
	class="w-64 glass-sidebar border-r border-gray-800 hidden md:flex flex-col text-white transition-all duration-300">
	<div class="h-16 flex items-center justify-center border-b border-gray-800 bg-gray-900/50">
		<span
			class="text-xl font-bold tracking-wide bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-400">Undangan
			Admin</span>
	</div>
	<nav class="flex-1 py-6 space-y-2 px-3">

		<p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Main</p>

		<a href="{{ route('admin.dashboard') }}"
			class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 shadow-lg shadow-indigo-500/30 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
			<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
					d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
				</path>
			</svg>
			<span class="font-medium">Dashboard</span>
		</a>

		<p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Management</p>

		<a href="{{ route('admin.events.index') }}"
			class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.events.*') ? 'bg-indigo-600 shadow-lg shadow-indigo-500/30 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
			<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
					d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
			</svg>
			<span class="font-medium">Events</span>
		</a>

		<a href="{{ route('admin.templates.index') }}"
			class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.templates.*') ? 'bg-indigo-600 shadow-lg shadow-indigo-500/30 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
			<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
					d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
				</path>
			</svg>
			<span class="font-medium">Templates</span>
		</a>

		<a href="#"
			class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group text-gray-400 hover:bg-gray-800 hover:text-white">
			<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
					d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
				</path>
			</svg>
			<span class="font-medium">Users</span>
		</a>

		<div class="mt-auto px-4 pb-6">
			<div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg p-4 mt-6">
				<p class="text-xs text-white/80 mb-1">Total Active Events</p>
				<p class="text-2xl font-bold text-white">0</p>
			</div>
		</div>
	</nav>
</aside>
