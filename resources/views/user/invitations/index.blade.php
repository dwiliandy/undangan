@extends('layouts.user')

@section('title', 'Guest Management')

@section('content')
	<div class="bg-white rounded-lg shadow-md p-6">
		<div class="flex justify-between items-center mb-6">
			<div>
				<h2 class="text-2xl font-semibold text-gray-800">Guest List</h2>
				<p class="text-gray-600 text-sm">Event: {{ $event->title }}</p>
			</div>
			<div class="flex space-x-2">
				<a href="{{ route('user.events.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Back
					to Events</a>
				<a href="{{ route('user.events.invitations.create', $event->id) }}"
					class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Add Guest</a>
			</div>
		</div>

		@if (session('success'))
			<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
				<span class="block sm:inline">{{ session('success') }}</span>
			</div>
		@endif

		@if ($invitations->isEmpty())
			<div class="text-center py-10">
				<p class="text-gray-500 text-lg">No guests added yet.</p>
				<a href="{{ route('user.events.invitations.create', $event->id) }}"
					class="text-indigo-600 font-semibold mt-2 inline-block">Add your first guest</a>
			</div>
		@else
			<div class="overflow-x-auto">
				<table class="min-w-full leading-normal">
					<thead>
						<tr>
							<th
								class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
								Guest Name</th>
							<th
								class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
								Slug/URL</th>
							<th
								class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
								Status</th>
							<th
								class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
								Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($invitations as $invitation)
							<tr>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap font-semibold">{{ $invitation->guest_name }}</p>
									@if ($invitation->guest_address)
										<p class="text-gray-500 text-xs">{{ $invitation->guest_address }}</p>
									@endif
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-600 whitespace-no-wrap text-xs">{{ $invitation->slug }}</p>
									<button class="text-indigo-600 text-xs hover:text-indigo-900"
										onclick="copyToClipboard('{{ url('/invitation/' . $invitation->slug) }}')">Copy Link</button>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<span
										class="relative inline-block px-3 py-1 font-semibold leading-tight {{ $invitation->is_opened ? 'text-green-900' : 'text-yellow-900' }}">
										<span aria-hidden
											class="absolute inset-0 {{ $invitation->is_opened ? 'bg-green-200' : 'bg-yellow-200' }} opacity-50 rounded-full"></span>
										<span class="relative">{{ $invitation->is_opened ? 'Opened' : 'Not Opened' }}</span>
									</span>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<div class="flex space-x-2">
										<a href="{{ route('user.events.invitations.edit', [$event->id, $invitation->id]) }}"
											class="text-blue-600 hover:text-blue-900">Edit</a>
										<form action="{{ route('user.events.invitations.destroy', [$event->id, $invitation->id]) }}" method="POST"
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

	<script>
		function copyToClipboard(text) {
			navigator.clipboard.writeText(text).then(function() {
				alert('Link copied to clipboard!');
			}, function(err) {
				console.error('Could not copy text: ', err);
			});
		}
	</script>
@endsection
