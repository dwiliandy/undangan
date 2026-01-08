@extends('layouts.user')

@section('title', 'My Events')

@section('content')
	<div class="bg-white rounded-lg shadow-md p-6">
		<div class="flex justify-between items-center mb-6">
			<h2 class="text-2xl font-semibold text-gray-800">My Events</h2>
			<a href="{{ route('user.events.create') }}"
				class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Create New Event</a>
		</div>

		@if (session('success'))
			<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
				<span class="block sm:inline">{{ session('success') }}</span>
			</div>
		@endif

		@if ($events->isEmpty())
			<div class="text-center py-10">
				<p class="text-gray-500 text-lg">You haven't created any events yet.</p>
				<a href="{{ route('user.events.create') }}" class="text-indigo-600 font-semibold mt-2 inline-block">Get Started</a>
			</div>
		@else
			<div class="overflow-x-auto">
				<table class="min-w-full leading-normal">
					<thead>
						<tr>
							<th
								class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
								Title</th>
							<th
								class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
								Slug</th>
							<th
								class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
								Date</th>
							<th
								class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
								Status</th>
							<th
								class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
								Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($events as $event)
							<tr>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap font-semibold">{{ $event->title }}</p>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-600 whitespace-no-wrap">{{ $event->slug }}</p>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</p>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
										<span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
										<span class="relative">{{ $event->is_active ? 'Active' : 'Inactive' }}</span>
									</span>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<div class="flex space-x-2">
										<a href="{{ route('user.events.invitations.index', $event->id) }}"
											class="text-teal-600 hover:text-teal-900">Guests</a>
										<a href="{{ route('user.events.edit', $event->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
										<form action="{{ route('user.events.destroy', $event->id) }}" method="POST"
											onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
										</form>
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@endif
	</div>
@endsection
