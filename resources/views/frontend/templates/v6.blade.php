@extends('layouts.frontend', ['hideNav' => true])

@section('title', $event->title)

@section('content')
	<!-- Fonts -->
	<link
		href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Courier+Prime:wght@400;700&display=swap"
		rel="stylesheet">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

	<style>
		.font-sans {
			font-family: 'Montserrat', sans-serif;
		}

		.font-mono {
			font-family: 'Courier Prime', monospace;
		}

		.bg-navy {
			background-color: #1a2238;
		}

		.text-navy {
			color: #1a2238;
		}

		.bg-gold {
			background-color: #d4af37;
		}

		.text-gold {
			color: #d4af37;
		}

		.passport-pattern {
			background-image: radial-gradient(#d4af37 1px, transparent 1px);
			background-size: 20px 20px;
			opacity: 0.1;
		}

		.stamp {
			transform: rotate(-15deg);
			border: 3px double #dcae1d;
			color: #dcae1d;
			display: inline-block;
			padding: 0.5rem 1rem;
			text-transform: uppercase;
			font-weight: bold;
			font-family: 'Courier Prime', monospace;
			opacity: 0.8;
		}

		.border-dashed-vertical {
			background-image: linear-gradient(to bottom, #ccc 50%, rgba(255, 255, 255, 0) 0%);
			background-position: left;
			background-size: 2px 10px;
			background-repeat: repeat-y;
		}

		#main-content {
			display: none;
		}

		.hide-scroll::-webkit-scrollbar {
			display: none;
		}

		.hide-scroll {
			-ms-overflow-style: none;
			scrollbar-width: none;
		}

		.spin {
			animation: spin 8s linear infinite;
		}

		@keyframes spin {
			100% {
				transform: rotate(360deg);
			}
		}
	</style>

	<!-- Audio Control -->
	<audio id="bg-music" loop>
		<source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
	</audio>
	<button id="music-control"
		class="fixed bottom-6 right-6 z-50 bg-navy text-white p-3 rounded-full shadow-lg hidden hover:bg-black transition border-2 border-gold"
		onclick="toggleMusic()">
		<i class="fas fa-compact-disc spin text-xl" id="music-icon"></i>
	</button>

	<!-- Cover (Passport) -->
	<div id="cover"
		class="fixed inset-0 z-50 bg-navy flex flex-col justify-center items-center text-center p-6 bg-cover">
		<div class="absolute inset-0 passport-pattern pointer-events-none"></div>

		<div class="z-10 bg-navy border-4 border-gold p-8 md:p-12 mb-8 shadow-2xl max-w-sm w-full relative rounded-lg">
			<div class="absolute top-4 left-1/2 -ml-6 text-gold text-4xl"><i class="fas fa-plane"></i></div>

			<h1 class="text-gold font-sans text-xs uppercase tracking-[0.4em] mt-8 mb-4">Passport to Love</h1>
			<h2 class="text-white font-sans text-3xl md:text-5xl font-bold mb-4">
				{{ $event->weddingEvent->groom_name }} <br> & <br> {{ $event->weddingEvent->bride_name }}
			</h2>

			<div class="w-full h-px bg-gold opacity-50 my-6"></div>

			@if (isset($invitation))
				<p class="text-gray-400 text-[10px] uppercase tracking-widest mb-2">Passioner Name</p>
				<h3 class="text-2xl text-white font-mono">{{ $invitation->guest_name }}</h3>
				@if ($invitation->guest_address)
					<p class="text-gold text-xs mt-1"><i class="fas fa-map-marker-alt mr-1"></i> {{ $invitation->guest_address }}</p>
				@endif
			@endif

			<div class="mt-8 flex justify-center gap-4 text-gold text-xs font-mono">
				<div class="border border-gold p-2 rounded">
					<span class="block text-gray-400 text-[8px] uppercase">Class</span>
					VIP
				</div>
				<div class="border border-gold p-2 rounded">
					<span class="block text-gray-400 text-[8px] uppercase">Date</span>
					{{ \Carbon\Carbon::parse($event->event_date)->format('d M') }}
				</div>
				<div class="border border-gold p-2 rounded">
					<span class="block text-gray-400 text-[8px] uppercase">Gate</span>
					01
				</div>
			</div>
		</div>

		<button id="open-invitation"
			class="bg-gold text-navy px-10 py-3 rounded-full font-bold uppercase tracking-widest hover:bg-white transition shadow-lg transform hover:-translate-y-1">
			Check In
		</button>
	</div>

	<!-- Main Content -->
	<div id="main-content" class="min-h-screen bg-gray-100 font-sans text-navy pb-20 overflow-x-hidden">

		<!-- Boarding Pass Header -->
		<header class="bg-navy text-white pt-20 pb-32 px-4 relative overflow-hidden rounded-b-[50px]">
			<div class="absolute inset-0 passport-pattern opacity-5"></div>
			<div class="max-w-4xl mx-auto text-center relative z-10" data-aos="fade-down">
				<div class="inline-block border-2 border-white/30 px-4 py-1 rounded-full text-xs uppercase tracking-widest mb-6">
					<i class="fas fa-plane-departure mr-2"></i> Boarding Pass
				</div>
				<h1 class="text-4xl md:text-6xl font-bold mb-4">The Adventure Begins</h1>
				<p class="text-gold text-xl italic font-serif">"Come fly with us"</p>

				<div class="mt-8 flex justify-center items-center gap-8">
					<div class="text-center">
						<div class="text-3xl font-bold">JKT</div>
						<div class="text-xs text-gray-400 uppercase">Origin</div>
					</div>
					<div class="text-gold text-2xl"><i class="fas fa-plane"></i></div>
					<div class="text-center">
						<div class="text-3xl font-bold">BAL</div>
						<div class="text-xs text-gray-400 uppercase">Destination</div>
					</div>
				</div>
			</div>
		</header>

		<!-- Couple (Passport Photos) -->
		<section class="max-w-4xl mx-auto px-4 -mt-20">
			<div class="bg-white rounded-lg shadow-xl p-8 grid md:grid-cols-2 gap-12 relative overflow-hidden">
				<!-- Watermark -->
				<div
					class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-5 text-9xl text-navy pointer-events-none">
					<i class="fas fa-globe-americas"></i>
				</div>

				<!-- Groom -->
				<div class="text-center md:text-left flex flex-col md:flex-row gap-6 items-center" data-aos="fade-right">
					<div class="w-32 h-40 bg-gray-200 border-4 border-white shadow-md rotate-[-3deg] overflow-hidden">
						<img
							src="{{ isset($event->weddingEvent->groom_photo) ? (Str::startsWith($event->weddingEvent->groom_photo, 'http') ? $event->weddingEvent->groom_photo : Storage::url($event->weddingEvent->groom_photo)) : 'https://via.placeholder.com/150' }}"
							class="w-full h-full object-cover">
					</div>
					<div>
						<h3 class="font-bold text-xl uppercase mb-1">{{ $event->weddingEvent->groom_name }}</h3>
						<p class="text-xs text-gray-500 uppercase tracking-widest mb-3">Captain</p>
						<p class="font-mono text-sm text-gray-600 mb-2">Son of {{ $event->weddingEvent->groom_parent }}</p>
						@if ($event->weddingEvent->groom_instagram)
							<a href="https://instagram.com/{{ $event->weddingEvent->groom_instagram }}" target="_blank"
								class="text-navy hover:text-gold"><i class="fab fa-instagram"></i></a>
						@endif
					</div>
				</div>

				<!-- Bride -->
				<div class="text-center md:text-right flex flex-col md:flex-row-reverse gap-6 items-center" data-aos="fade-left">
					<div class="w-32 h-40 bg-gray-200 border-4 border-white shadow-md rotate-[3deg] overflow-hidden">
						<img
							src="{{ isset($event->weddingEvent->bride_photo) ? (Str::startsWith($event->weddingEvent->bride_photo, 'http') ? $event->weddingEvent->bride_photo : Storage::url($event->weddingEvent->bride_photo)) : 'https://via.placeholder.com/150' }}"
							class="w-full h-full object-cover">
					</div>
					<div>
						<h3 class="font-bold text-xl uppercase mb-1">{{ $event->weddingEvent->bride_name }}</h3>
						<p class="text-xs text-gray-500 uppercase tracking-widest mb-3">Co-Pilot</p>
						<p class="font-mono text-sm text-gray-600 mb-2">Daughter of {{ $event->weddingEvent->bride_parent }}</p>
						@if ($event->weddingEvent->bride_instagram)
							<a href="https://instagram.com/{{ $event->weddingEvent->bride_instagram }}" target="_blank"
								class="text-navy hover:text-gold"><i class="fab fa-instagram"></i></a>
						@endif
					</div>
				</div>
			</div>
		</section>

		<!-- Our Journey (Flight Log) -->
		@if (isset($event->eventJourneys) && count($event->eventJourneys) > 0)
			<section class="max-w-3xl mx-auto px-4 py-20">
				<h2 class="text-center font-bold text-3xl mb-12 uppercase tracking-wide" data-aos="fade-up">Flight Log</h2>
				<div class="space-y-8 relative">
					<div class="absolute left-[19px] top-2 bottom-2 w-0.5 border-l-2 border-dashed border-gray-300"></div>
					@foreach ($event->eventJourneys as $story)
						<div class="flex gap-8 relative" data-aos="fade-up">
							<div
								class="w-10 h-10 rounded-full bg-navy text-white flex items-center justify-center shrink-0 z-10 border-4 border-gray-100">
								<i class="fas fa-map-pin text-sm"></i>
							</div>
							<div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-gold w-full">
								<div class="text-xs font-bold text-gold uppercase tracking-widest mb-1">
									{{ $story->journey_date ? (is_object($story->journey_date) ? $story->journey_date->format('Y') : \Carbon\Carbon::parse($story->journey_date)->format('Y')) : '' }}
								</div>
								<h4 class="font-bold text-lg mb-2">{{ $story->title }}</h4>
								<p class="text-gray-600 text-sm leading-relaxed font-mono">{{ $story->description }}</p>
							</div>
						</div>
					@endforeach
				</div>
			</section>
		@endif

		<!-- Events (Itinerary) -->
		<section class="bg-white py-20">
			<div class="max-w-5xl mx-auto px-4">
				<h2 class="text-center font-bold text-3xl mb-12 uppercase tracking-wide" data-aos="fade-up">Itinerary</h2>

				<div class="grid md:grid-cols-2 gap-8">
					@foreach ($event->eventLocations as $location)
						<div class="border-2 border-navy p-1 relative" data-aos="flip-up">
							<div
								class="border border-navy p-6 h-full flex flex-col justify-center items-center text-center bg-gray-50 border-dashed">
								<div class="absolute top-4 right-4 stamp">Confirmed</div>
								<h3 class="text-xl font-bold uppercase mb-2">{{ $location->location_type }}</h3>
								<div class="text-gold text-4xl font-mono mb-4">
									{{ \Carbon\Carbon::parse($location->event_time)->format('H:i') }}</div>
								<p class="font-bold text-navy mb-1">{{ $location->name }}</p>
								<p class="text-sm text-gray-500 max-w-xs mb-6">{{ $location->address }}</p>
								@if ($location->google_maps_url)
									<a href="{{ $location->google_maps_url }}" target="_blank"
										class="bg-navy text-white px-6 py-2 rounded-full text-xs uppercase tracking-widest hover:bg-gold transition">
										Get Directions
									</a>
								@endif
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</section>

		<!-- Gallery -->
		<section class="max-w-5xl mx-auto px-4 py-20">
			<h2 class="text-center font-bold text-3xl mb-12 uppercase tracking-wide" data-aos="fade-up">Travel Snaps</h2>
			<div class="columns-2 md:columns-4 gap-4">
				@if (isset($event->eventGalleries))
					@foreach ($event->eventGalleries as $photo)
						<div class="mb-4 break-inside-avoid shadow-lg rotate-1 hover:rotate-0 transition duration-300 p-2 bg-white pb-6"
							data-aos="zoom-in">
							<img
								src="{{ Str::startsWith($photo->image_path, 'http') ? $photo->image_path : Storage::url($photo->image_path) }}"
								class="w-full grayscale hover:grayscale-0 transition">
						</div>
					@endforeach
				@endif
			</div>
		</section>

		<!-- Gift & RSVP -->
		<section class="bg-navy text-white py-20 px-4 relative">
			<div class="absolute inset-0 passport-pattern opacity-10"></div>
			<div class="max-w-xl mx-auto relative z-10 text-center">

				<!-- Gift -->
				@if (isset($event->eventBanks))
					<div class="mb-16" data-aos="fade-up">
						<i class="fas fa-gift text-4xl text-gold mb-6"></i>
						<h2 class="text-2xl font-bold uppercase mb-8">Travel Fund</h2>
						<div class="space-y-4">
							@foreach ($event->eventBanks as $angpao)
								<div class="bg-white/10 p-4 rounded border border-white/20">
									<p class="font-bold">{{ $angpao->bank_name }}</p>
									<p class="font-mono text-xl my-2 select-all" id="acc-{{ $loop->index }}">{{ $angpao->account_number }}</p>
									<p class="text-xs text-gray-400">{{ $angpao->account_name }}</p>
									<button onclick="copyToClipboard('acc-{{ $loop->index }}')"
										class="text-gold text-xs uppercase underline mt-2">Copy</button>
								</div>
							@endforeach
						</div>
					</div>
				@endif

				<!-- RSVP -->
				<div class="bg-white text-navy p-8 rounded shadow-2xl skew-y-1" data-aos="fade-up">
					<h2 class="text-2xl font-bold uppercase mb-6 text-center">Flight Manifest</h2>
					<form id="rsvp-form" action="{{ route('frontend.rsvp', [$event->slug, $invitation->slug]) }}" method="POST"
						class="space-y-4 text-left">
						@csrf
						<div>
							<label class="block text-xs uppercase font-bold text-gray-400 mb-1">Passenger Name</label>
							<input type="text" value="{{ $invitation->guest_name }}" readonly
								class="w-full bg-gray-100 border-none p-3 font-mono">
						</div>
						<div>
							<label class="block text-xs uppercase font-bold text-gray-400 mb-1">Status</label>
							<select name="status" class="w-full bg-gray-100 border-none p-3 font-mono">
								<option value="yes">Checking In</option>
								<option value="no">Cancelling Flight</option>
							</select>
						</div>
						<div>
							<label class="block text-xs uppercase font-bold text-gray-400 mb-1">Seats Required</label>
							<select name="total_guest" class="w-full bg-gray-100 border-none p-3 font-mono">
								<option value="1">1 Seat</option>
								<option value="2">2 Seats</option>
							</select>
						</div>
						<div>
							<label class="block text-xs uppercase font-bold text-gray-400 mb-1">Message to Captain</label>
							<textarea name="message" class="w-full bg-gray-100 border-none p-3 font-mono h-24" placeholder="Safe travels!"></textarea>
						</div>
						<button type="submit"
							class="w-full bg-gold text-white font-bold py-4 uppercase tracking-widest hover:bg-navy hover:text-white transition">Confirm
							Seat</button>
					</form>
				</div>
			</div>
		</section>

		<!-- Wishes -->
		<section class="max-w-3xl mx-auto px-4 py-20" section id="wishes-section">
			<h2 class="text-center font-bold text-2xl mb-12 uppercase tracking-wide" data-aos="fade-up">Guestbook</h2>
			<div id="wishes-container" class="space-y-6 max-h-96 overflow-y-auto hide-scroll p-2">
				@if (isset($wishes))
					@foreach ($wishes as $wish)
						<div class="bg-white p-6 shadow border-b-2 border-gray-100" data-aos="fade-up">
							<div class="flex items-center gap-3 mb-3">
								<div class="w-8 h-8 bg-navy text-white flex items-center justify-center rounded-full text-xs">
									<i class="fas fa-user"></i>
								</div>
								<div>
									<h5 class="font-bold text-sm">{{ $wish->name }}</h5>
									<p class="text-[10px] text-gray-400">{{ $wish->created_at->diffForHumans() }}</p>
								</div>
							</div>
							<p class="text-gray-600 font-mono text-sm">"{{ $wish->message }}"</p>
						</div>
					@endforeach
				@endif
			</div>
		</section>

		<footer class="bg-navy text-white text-center py-6 border-t border-white/10 uppercase text-xs tracking-widest">
			<p>&copy; {{ date('Y') }} UndanganKita. All Rights Reserved.</p>
		</footer>

	</div>

	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		AOS.init();

		// Cover Logic
		const cover = document.getElementById('cover');
		const main = document.getElementById('main-content');
		const openBtn = document.getElementById('open-invitation');
		const audio = document.getElementById('bg-music');
		const musicBtn = document.getElementById('music-control');
		const musicIcon = document.getElementById('music-icon');

		openBtn.addEventListener('click', () => {
			cover.style.transition = 'transform 0.8s ease-in-out';
			cover.style.transform = 'translateY(-100%)';

			toggleMusic(true);
			musicBtn.classList.remove('hidden');

			setTimeout(() => {
				cover.style.display = 'none';
				main.style.display = 'block';
				AOS.refresh();
			}, 800);
		});

		let isPlaying = false;

		function toggleMusic(force = false) {
			if (force || !isPlaying) {
				audio.play();
				isPlaying = true;
				musicIcon.classList.add('spin', 'fa-compact-disc');
				musicIcon.classList.remove('fa-play');
			} else {
				audio.pause();
				isPlaying = false;
				musicIcon.classList.remove('spin', 'fa-compact-disc');
				musicIcon.classList.add('fa-play');
			}
		}

		function copyToClipboard(id) {
			const text = document.getElementById(id).innerText;
			navigator.clipboard.writeText(text).then(() => {
				alert('ACC Number Copied!');
			});
		}

		// AJAX RSVP
		document.getElementById('rsvp-form').addEventListener('submit', function(e) {
			e.preventDefault();
			const form = this;
			const btn = form.querySelector('button[type="submit"]');
			const originalText = btn.innerText;
			btn.innerText = 'Boarding...';
			btn.disabled = true;

			fetch(form.action, {
					method: 'POST',
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}',
						'Accept': 'application/json',
						'X-Requested-With': 'XMLHttpRequest'
					},
					body: new FormData(form)
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						alert('Check-in Successful! Welcome aboard.');
						form.reset();

						if (data.wish) {
							const container = document.getElementById('wishes-container');
							const section = document.getElementById('wishes-section');
							section.style.display = 'block';

							const html = `
                             <div class="bg-white p-6 shadow border-b-2 border-gray-100" data-aos="fade-up">
                                <div class="flex items-center gap-3 mb-3">
                                     <div class="w-8 h-8 bg-navy text-white flex items-center justify-center rounded-full text-xs">
                                         <i class="fas fa-user"></i>
                                     </div>
                                     <div>
                                         <h5 class="font-bold text-sm">${data.wish.name}</h5>
                                         <p class="text-[10px] text-gray-400">${data.wish.created_at_human}</p>
                                     </div>
                                </div>
                                <p class="text-gray-600 font-mono text-sm">"${data.wish.message}"</p>
                            </div>
                        `;
							container.insertAdjacentHTML('afterbegin', html);
						}
					} else {
						alert('Check-in failed. Please try again.');
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('System Error.');
				})
				.finally(() => {
					btn.innerText = originalText;
					btn.disabled = false;
				});
		});
	</script>
@endsection
