@extends('layouts.user')

@section('title', 'Edit Guest')

@section('content')
	<div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
		<div class="flex justify-between items-center mb-6">
			<h2 class="text-2xl font-semibold text-gray-800">Edit Guest</h2>
			<a href="{{ route('user.events.invitations.index', $event->id) }}" class="text-gray-600 hover:text-gray-900">Back</a>
		</div>

		@if ($errors->any())
			<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
				<ul class="list-disc ml-4">
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form action="{{ route('user.events.invitations.update', [$event->id, $invitation->id]) }}" method="POST">
			@csrf
			@method('PUT')

			<div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="guest_name">Guest Name</label>
				<input
					class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
					id="guest_name" type="text" name="guest_name" value="{{ old('guest_name', $invitation->guest_name) }}" required>
			</div>

			<div class="mb-6">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="guest_address">Guest Address/Note (Optional)</label>
				<textarea
				 class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
				 id="guest_address" name="guest_address">{{ old('guest_address', $invitation->guest_address) }}</textarea>
			</div>

			<div class="flex items-center justify-end">
				<button
					class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
					type="submit">
					Update Guest
				</button>
			</div>
		</form>
	</div>
@endsection
