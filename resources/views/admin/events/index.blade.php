@extends('admin.layout')

@section('title', 'Manage Events')

@section('content')
	<div class="bg-white rounded-lg shadow-md p-6">
		<div class="flex justify-between items-center mb-6">
			<h2 class="text-2xl font-semibold text-gray-800">All Events</h2>
		</div>

		@if (session('success'))
			<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
				<span class="block sm:inline">{{ session('success') }}</span>
			</div>
		@endif

		<div class="overflow-x-auto">
			<table id="eventsTable" class="min-w-full leading-normal display stripe hover" style="width:100%">
				<thead>
					<tr>
						<th
							class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
							User</th>
						<th
							class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
							Event Title</th>
						<th
							class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
							URL Slug</th>
						<th
							class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
							Template</th>
						<th
							class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
							Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($events as $event)
						<tr>
							<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
								<p class="text-gray-900 whitespace-no-wrap font-semibold">{{ $event->user->name }}</p>
								<p class="text-gray-500 text-xs">{{ $event->user->email }}</p>
							</td>
							<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
								<p class="text-gray-900 whitespace-no-wrap">{{ $event->title }}</p>
							</td>
							<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
								<p class="text-gray-600 whitespace-no-wrap">{{ $event->slug }}</p>
								<a href="{{ route('frontend.event', $event->slug) }}" target="_blank"
									class="text-indigo-500 text-xs hover:underline">View</a>
							</td>
							<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
								<p class="text-gray-900 whitespace-no-wrap">{{ $event->template ? $event->template->name : 'N/A' }}</p>
							</td>
							<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
								<form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
									onsubmit="return confirm('Are you sure you want to delete this event?');">
									@csrf
									@method('DELETE')
									<button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('#eventsTable').DataTable({
				responsive: true,
				order: [
					[1, 'asc']
				]
			});
		});
	</script>
@endsection
