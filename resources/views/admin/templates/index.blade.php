@extends('admin.layout')

@section('title', 'Manage Templates')

@section('content')
	<div class="bg-white rounded-lg shadow-md p-6">
		<div class="flex justify-between items-center mb-6">
			<h2 class="text-2xl font-semibold text-gray-800">Template List</h2>
			<a href="{{ route('admin.templates.create') }}"
				class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Add New Template</a>
		</div>

		@if (session('success'))
			<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
				<span class="block sm:inline">{{ session('success') }}</span>
			</div>
		@endif

		<div class="overflow-x-auto">
			<table id="templatesTable" class="min-w-full leading-normal display stripe hover" style="width:100%">
				<thead>
					<tr>
						<th
							class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
							Thumbnail</th>
						<th
							class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
							Name</th>
						<th
							class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
							View Path</th>
						<th
							class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
							Status</th>
						<th
							class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
							Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($templates as $template)
						<tr>
							<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
								<div class="w-16 h-16 bg-gray-200 rounded overflow-hidden">
									@if ($template->thumbnail)
										<img src="{{ $template->thumbnail }}" alt="{{ $template->name }}" class="object-cover w-full h-full">
									@else
										<span class="flex items-center justify-center h-full text-xs text-gray-500">No Img</span>
									@endif
								</div>
							</td>
							<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
								<p class="text-gray-900 whitespace-no-wrap font-semibold">{{ $template->name }}</p>
							</td>
							<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
								<p class="text-gray-600 whitespace-no-wrap">{{ $template->view_path }}</p>
							</td>
							<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
								<span
									class="relative inline-block px-3 py-1 font-semibold leading-tight {{ $template->is_active ? 'text-green-900' : 'text-red-900' }}">
									<span aria-hidden
										class="absolute inset-0 {{ $template->is_active ? 'bg-green-200' : 'bg-red-200' }} opacity-50 rounded-full"></span>
									<span class="relative">{{ $template->is_active ? 'Active' : 'Inactive' }}</span>
								</span>
							</td>
							<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
								<div class="flex space-x-2">
									<a href="{{ route('frontend.preview', $template->slug) }}" target="_blank"
										class="text-indigo-600 hover:text-indigo-900">Preview</a>
									<a href="{{ route('admin.templates.edit', $template->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
									<form action="{{ route('admin.templates.destroy', $template->id) }}" method="POST"
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
	</div>

	<script>
		$(document).ready(function() {
			$('#templatesTable').DataTable({
				responsive: true
			});
		});
	</script>
@endsection
