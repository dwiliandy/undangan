@extends('layouts.user')

@section('title', 'My Dashboard')

@section('content')
	<div class="bg-white rounded-lg shadow-md p-6">
		<h2 class="text-2xl font-semibold text-gray-800 mb-4">Welcome, {{ auth()->user()->name }}!</h2>
		<p class="text-gray-600 mb-6">Manage your events and invitations here.</p>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
			<!-- Create Event Card -->
			<div
				class="bg-indigo-50 p-6 rounded-lg border border-indigo-100 flex flex-col items-center justify-center text-center hover:bg-indigo-100 transition">
				<div class="p-3 bg-indigo-200 rounded-full mb-4">
					<svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
					</svg>
				</div>
				<h3 class="font-bold text-indigo-700 text-lg mb-2">Create New Event</h3>
				<p class="text-indigo-600 text-sm mb-4">Start creating your wedding or birthday invitation.</p>
				<a href="{{ route('user.events.create') }}"
					class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Create Now</a>
			</div>

			<!-- Stats Card -->
			<div class="bg-white p-6 rounded-lg border border-gray-200">
				<h3 class="font-bold text-gray-700 mb-2">My Events</h3>
				<p class="text-3xl font-bold text-gray-800">0</p>
				<p class="text-gray-500 text-sm mt-1">Active Events</p>
			</div>

			<!-- Stats Card -->
			<div class="bg-white p-6 rounded-lg border border-gray-200">
				<h3 class="font-bold text-gray-700 mb-2">Total Guests</h3>
				<p class="text-3xl font-bold text-gray-800">0</p>
				<p class="text-gray-500 text-sm mt-1">Across all events</p>
			</div>
		</div>
	</div>
@endsection
