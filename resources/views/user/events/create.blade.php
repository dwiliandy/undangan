@extends('layouts.user')

@section('title', __('user.event.create_title'))

@section('content')
	<div class="container-fluid">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div>
				<h2 class="h3 text-gray-800 fw-bold">{{ __('user.event.create_title') }}</h2>
				<p class="text-muted small">{{ __('user.event.create_subtitle') }}</p>
			</div>
			<a href="{{ route('user.events.index') }}" class="btn btn-outline-secondary">
				<i class="bi bi-arrow-left me-2"></i>{{ __('user.event.back_to_list') }}
			</a>
		</div>

		@if ($errors->any())
			<div class="alert alert-danger shadow-sm border-0 border-start border-5 border-danger fade show" role="alert">
				<div class="d-flex align-items-center">
					<i class="bi bi-exclamation-circle-fill fs-4 me-3 text-danger"></i>
					<div>
						<h6 class="alert-heading fw-bold mb-1">Validation Error</h6>
						<ul class="mb-0 small ps-3">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		@endif

		<form action="{{ route('user.events.store') }}" method="POST">
			@csrf
			<input type="hidden" name="category" value="{{ $category ?? 'wedding' }}">

			<div class="row g-4">
				<div class="col-lg-8">
					<div class="card shadow-sm border-0 rounded-3">
						<div class="card-header bg-transparent border-bottom py-3">
							<h5 class="card-title mb-0 fw-semibold text-primary">{{ ucfirst($category ?? 'Event') }}
								{{ __('user.event.details_title') }}</h5>
						</div>
						<div class="card-body p-4">
							<div class="mb-4">
								<label for="title" class="form-label fw-semibold">{{ __('user.event.input_title') }}</label>
								<input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
									placeholder="e.g. Romeo & Juliet Wedding" required>
							</div>

							<div class="mb-4">
								<label for="slug" class="form-label fw-semibold">{{ __('user.event.input_slug') }}</label>
								<div class="input-group">
									<span class="input-group-text bg-light">{{ url('/') }}/</span>
									<input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}"
										placeholder="romeo-juliet" required>
								</div>
								<div class="form-text small">{{ __('user.event.slug_help') }}</div>
							</div>

							<div class="mb-4">
								<label for="event_date" class="form-label fw-semibold">{{ __('user.event.input_date') }}</label>
								<input type="date" class="form-control" id="event_date" name="event_date" value="{{ old('event_date') }}"
									required>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="card shadow-sm border-0 rounded-3 sticky-top" style="top: 20px;">
						<div class="card-header bg-transparent border-bottom py-3">
							<h5 class="card-title mb-0 fw-semibold text-primary">{{ __('user.event.config_title') }}</h5>
						</div>
						<div class="card-body p-4">
							<div class="mb-4">
								<label class="form-label fw-semibold">{{ __('user.event.select_template') }}</label>
								<div class="row g-3">
									@foreach ($templates as $template)
										<div class="col-6">
											<div
												class="card h-100 {{ old('event_template_id') == $template->id ? 'border-primary ring-2 ring-primary' : '' }}">
												<div class="position-relative">
													<img src="{{ $template->thumbnail_url ?? 'https://via.placeholder.com/300x200' }}" class="card-img-top"
														alt="{{ $template->name }}" style="height: 120px; object-fit: cover;">
													<a href="{{ route('frontend.preview', $template->slug) }}" target="_blank"
														class="btn btn-sm btn-light position-absolute top-0 end-0 m-1 rounded-circle shadow-sm"
														title="Preview Theme">
														<i class="bi bi-eye-fill text-primary"></i>
													</a>
												</div>
												<div class="card-body p-2 text-center">
													<h6 class="card-title small fw-bold mb-1">{{ $template->name }}</h6>
													<div class="form-check d-inline-block">
														<input class="form-check-input" type="radio" name="event_template_id" id="template_{{ $template->id }}"
															value="{{ $template->id }}" {{ old('event_template_id') == $template->id ? 'checked' : '' }} required>
														<label class="form-check-label small"
															for="template_{{ $template->id }}">{{ __('user.event.template_help') }}</label>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
								@if ($templates->isEmpty())
									<div class="form-text text-danger mt-2">
										<i class="bi bi-exclamation-triangle"></i> No templates available. Please contact admin.
									</div>
								@endif
							</div>

							<div class="mb-4">
								<label for="whatsapp_message" class="form-label fw-semibold">{{ __('user.event.wa_template') }}</label>
								<div class="mb-2">
									<button type="button" class="btn btn-sm btn-outline-primary me-1" onclick="insertVar('{name}')">
										<i class="bi bi-plus"></i> {name}
									</button>
									<button type="button" class="btn btn-sm btn-outline-primary" onclick="insertVar('{link}')">
										<i class="bi bi-plus"></i> {link}
									</button>
								</div>
								<textarea class="form-control" id="whatsapp_message" name="whatsapp_message" rows="4"
								 placeholder="Halo {name}, saksikan pernikahan kami...">{{ old('whatsapp_message', "Kepada Yth. Bapak/Ibu/Saudara/i \n{name}\n\nTanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara pernikahan kami:\n\nLink Undangan: \n{link}\n\nMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\nMohon maaf perihal undangan hanya di bagikan melalui pesan ini.\n\nTerima kasih banyak atas perhatiannya.") }}</textarea>
								<div class="form-text small">{{ __('user.event.wa_help') }}</div>
							</div>
						</div>
						<div class="card-footer bg-transparent border-top p-3">
							<button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
								<i class="bi bi-plus-lg me-2"></i> {{ __('user.event.create_btn') }}
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>

	<script>
		function insertVar(text) {
			const textarea = document.getElementById('whatsapp_message');
			const start = textarea.selectionStart;
			const end = textarea.selectionEnd;
			const before = textarea.value.substring(0, start);
			const after = textarea.value.substring(end, textarea.value.length);
			textarea.value = before + text + after;
			textarea.selectionStart = textarea.selectionEnd = start + text.length;
			textarea.focus();
		}
	</script>
@endsection
