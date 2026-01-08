@extends('layouts.user')

@section('title', 'Edit Event')

@section('content')
	<div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
		<div class="flex justify-between items-center mb-6">
			<h2 class="text-2xl font-semibold text-gray-800">Edit Event</h2>
			<a href="{{ route('user.events.index') }}" class="text-gray-600 hover:text-gray-900">Back</a>
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

		<form action="{{ route('user.events.update', $event->id) }}" method="POST">
			@csrf
			@method('PUT')

			<div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="title">Event Title</label>
				<input
					class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
					id="title" type="text" name="title" value="{{ old('title', $event->title) }}" required>
			</div>

			<div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="slug">URL Slug</label>
				<div class="flex items-center">
					<span class="text-gray-500 mr-2">{{ url('/') }}/</span>
					<input
						class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
						id="slug" type="text" name="slug" value="{{ old('slug', $event->slug) }}" required>
				</div>
			</div>

			<div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="event_date">Event Date</label>
				<input
					class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
					id="event_date" type="date" name="event_date"
					value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required>
			</div>

			<div class="mb-6">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="event_template_id">Template</label>
				<select
					class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
					id="event_template_id" name="event_template_id" required>
					@foreach ($templates as $template)
						<option value="{{ $template->id }}"
							{{ old('event_template_id', $event->event_template_id) == $template->id ? 'selected' : '' }}>{{ $template->name }}
						</option>
					@endforeach
				</select>
			</div>

			<div class="flex items-center justify-end">
				<button
					class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
					type="submit">
					Update Event
				</button>
			</div>
		</form>
	</div>
@endsection
