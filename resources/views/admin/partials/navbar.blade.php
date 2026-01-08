<header class="flex justify-between items-center py-4 px-6 bg-white border-b border-gray-200">
	<div class="flex items-center">
		<button class="md:hidden text-gray-500 focus:outline-none">
			<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
			</svg>
		</button>
	</div>

	<div class="flex items-center space-x-4">
		<div class="relative">
			<span class="text-gray-700">Admin</span>
		</div>
		<form action="{{ route('admin.logout') }}" method="POST">
			@csrf
			<button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Logout</button>
		</form>
	</div>
</header>
