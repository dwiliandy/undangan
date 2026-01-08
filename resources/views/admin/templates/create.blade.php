@extends('admin.layout')

@section('title', 'Add Template')

@section('content')
	<div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
		<div class="flex justify-between items-center mb-6">
			<h2 class="text-2xl font-semibold text-gray-800">Add New Template</h2>
			<a href="{{ route('admin.templates.index') }}" class="text-gray-600 hover:text-gray-900">Back</a>
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

		<form action="{{ route('admin.templates.store') }}" method="POST">
			@csrf

			<div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="name">Template Name</label>
				<input
					class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
					id="name" type="text" name="name" value="{{ old('name') }}" required>
			</div>

			<div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="view_path">View Path</label>
				<input
					class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
					id="view_path" type="text" name="view_path" value="{{ old('view_path') }}"
					placeholder="frontend.templates.modern" required>
				<p class="text-xs text-gray-500 mt-1">Dot notation path to the blade file.</p>
			</div>

			<div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="thumbnail">Thumbnail URL</label>
				<input
					class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
					id="thumbnail" type="text" name="thumbnail" value="{{ old('thumbnail') }}"
					placeholder="https://example.com/thumb.jpg">
			</div>

			<div class="mb-6">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
				<textarea
				 class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
				 id="description" name="description">{{ old('description') }}</textarea>
			</div>

			<div class="flex items-center justify-end">
				<button
					class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
					type="submit">
					Create Template
				</button>
			</div>
		</form>
	</div>
@endsection
