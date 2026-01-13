@extends('admin.layout')

@section('title', 'Manage Templates')

@section('content')
	<div class="container-fluid">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div>
				<h2 class="h3 text-gray-800 fw-bold">Templates</h2>
				<p class="text-muted small">Manage your invitation templates.</p>
			</div>
			<a href="{{ route('admin.templates.create') }}" class="btn btn-primary shadow-sm">
				<i class="bi bi-plus-lg me-2"></i>Add New Template
			</a>
		</div>

		@if (session('success'))
			<div class="alert alert-success alert-dismissible fade show shadow-sm border-0 border-start border-5 border-success"
				role="alert">
				<div class="d-flex align-items-center">
					<i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
					<div>{{ session('success') }}</div>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		@endif

		<div class="card shadow-sm border-0 rounded-3">
			<div class="card-body p-4">
				<div class="table-responsive">
					<table class="table table-hover align-middle datatable" style="width:100%">
						<thead class="table-light">
							<tr>
								<th class="border-0 rounded-start">Thumbnail</th>
								<th class="border-0">Name</th>
								<th class="border-0">View Path</th>
								<th class="border-0">Status</th>
								<th class="border-0 rounded-end text-end">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($templates as $template)
								<tr>
									<td style="width: 80px;">
										<div class="ratio ratio-1x1 rounded overflow-hidden bg-light border" style="width: 60px; height: 60px;">
											@if ($template->thumbnail)
												<img src="{{ $template->thumbnail }}" alt="{{ $template->name }}" class="object-fit-cover w-100 h-100">
											@else
												<div class="d-flex align-items-center justify-content-center text-muted small h-100">
													<i class="bi bi-image"></i>
												</div>
											@endif
										</div>
									</td>
									<td class="fw-medium text-dark">{{ $template->name }}</td>
									<td class="font-monospace text-secondary small">{{ $template->view_path }}</td>
									<td>
										<span
											class="badge rounded-pill {{ $template->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }} px-3 py-2">
											<i class="bi {{ $template->is_active ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }} me-1"></i>
											{{ $template->is_active ? 'Active' : 'Inactive' }}
										</span>
									</td>
									<td class="text-end">
										<div class="btn-group">
											<a href="{{ route('frontend.preview', $template->slug) }}" target="_blank"
												class="btn btn-sm btn-outline-secondary border-0" title="Preview">
												<i class="bi bi-eye"></i>
											</a>
											<a href="{{ route('admin.templates.edit', $template->id) }}" class="btn btn-sm btn-outline-primary border-0"
												title="Edit">
												<i class="bi bi-pencil-square"></i>
											</a>
											<form action="{{ route('admin.templates.destroy', $template->id) }}" method="POST" class="d-inline-block"
												onsubmit="return confirm('Are you sure you want to delete this template?');">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-end" title="Delete">
													<i class="bi bi-trash"></i>
												</button>
											</form>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
