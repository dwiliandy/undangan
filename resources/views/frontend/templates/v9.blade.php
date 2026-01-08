@extends('layouts.frontend', ['hideNav' => true])

@section('title', $event->title)

@section('content')
	<!-- Fonts -->
	<link
		href="https://fonts.googleapis.com/css2?family=Anton&family=Roboto+Condensed:ital,wght@0,400;0,700;1,400;1,700&display=swap"
		rel="stylesheet">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

	<style>
		:root {
			--sport-blue: #003366;
			--sport-red: #cc0000;
			--sport-yellow: #ffcc00;
			--sport-gray: #f2f2f2;
		}

		body {
			font-family: 'Roboto Condensed', sans-serif;
			background-color: var(--sport-gray);
			overflow-x: hidden;
		}

		h1,
		h2,
		h3,
		h4,
		.font-heading {
			font-family: 'Anton', sans-serif;
			text-transform: uppercase;
		}

		.bg-blue {
			background-color: var(--sport-blue);
		}

		.text-blue {
			color: var(--sport-blue);
		}

		.bg-red {
			background-color: var(--sport-red);
		}

		.text-red {
			color: var(--sport-red);
		}

		.skew-box {
			transform: skew(-15deg);
		}

		.unskew-text {
			transform: skew(15deg);
		}

		.striped-bg {
			background: repeating-linear-gradient(45deg,
					#f2f2f2,
					#f2f2f2 10px,
					#e6e6e6 10px,
					#e6e6e6 20px);
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

		.jersey-font {
			font-family: 'Anton', sans-serif;
			letter-spacing: 2px;
		}
	</style>

	<!-- Audio Control -->
	<audio id="bg-music" loop>
		<!-- Intense Sports Intro vibe if possible, defaulting to generic upbeat -->
		<source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-15.mp3" type="audio/mpeg">
	</audio>
	<button id="music-control"
		class="fixed bottom-6 right-6 z-50 bg-white text-blue border-4 border-blue p-3 rounded-full shadow-xl hidden animate-bounce"
		onclick="toggleMusic()">
		<i class="fas fa-volume-up text-xl" id="music-icon"></i>
	</button>

	<!-- Cover (Match Poster) -->
	<div id="cover"
		class="fixed inset-0 z-50 bg-blue flex flex-col justify-center items-center text-center overflow-y-auto">
		<!-- Background Elements -->
		<div class="absolute inset-0 opacity-20 transform scale-150 rotate-12 pointer-events-none">
			<div class="h-full w-1/3 bg-white absolute top-0 left-0"></div>
			<div class="h-full w-1/3 bg-red absolute top-0 right-0"></div>
		</div>

		<div class="relative z-10 w-full max-w-sm mx-auto px-4 m-auto py-10">
			<div class="bg-white p-1 skew-box mb-8 shadow-2xl border-l-8 border-red">
				<div class="bg-blue p-8 unskew-text border-2 border-white">
					<p class="text-yellow-400 font-bold tracking-widest text-sm mb-2">OFFICIAL MATCHDAY</p>
					<h1 class="text-white text-5xl md:text-6xl italic leading-none mb-2">
						{{ explode(' ', $event->weddingEvent->groom_name)[0] }}
						<span class="text-red">vs</span>
						{{ explode(' ', $event->weddingEvent->bride_name)[0] }}
					</h1>
					<p class="text-white text-lg tracking-[0.2em] font-bold mt-4 border-t border-white/30 pt-4">THE WEDDING FINAL</p>
				</div>
			</div>

			@if (isset($invitation))
				<div class="bg-white text-blue transform -skew-x-12 inline-block px-8 py-2 mb-8 shadow-lg">
					<div class="transform skew-x-12 text-center">
						<p class="text-xs font-bold uppercase text-red">Ticket Holder</p>
						<h3 class="text-2xl font-heading">{{ $invitation->guest_name }}</h3>
					</div>
				</div>
			@endif

			<div class="flex flex-col gap-4">
				<button id="open-invitation"
					class="group relative bg-red text-white font-heading text-2xl py-4 px-12 clip-path-polygon hover:bg-white hover:text-red transition duration-300 border-4 border-white shadow-2xl">
					<span
						class="absolute inset-0 w-full h-full bg-red transform scale-x-0 group-hover:scale-x-100 transition origin-left"></span>
					<span class="relative">KICK OFF</span>
				</button>
			</div>
		</div>
	</div>

	<!-- Main Content -->
	<div id="main-content" class="min-h-screen pb-20 overflow-x-hidden relative striped-bg">

		<!-- Scoreboard Header -->
		<header class="fixed top-0 w-full z-40">
			<div class="bg-blue text-white p-2 border-b-4 border-red shadow-lg">
				<div class="max-w-4xl mx-auto flex justify-between items-center px-2">
					<div class="flex items-center gap-4">
						<div class="font-heading text-xl bg-white text-blue px-2 skew-box transform -translate-y-1"><span
								class="block unskew-text">LIVE</span></div>
						<div class="hidden md:block font-bold text-sm tracking-widest">THE WEDDING CHAMPIONSHIP</div>
					</div>
					<div class="flex items-center gap-4 font-mono text-xl font-bold text-yellow-500">
						<span id="countdown">00:00:00</span>
					</div>
				</div>
			</div>
		</header>

		<!-- Hero Card -->
		<section
			class="mt-20 px-4 pt-12 pb-20 bg-white shadow-xl max-w-5xl mx-auto mb-12 clip-path-hero relative overflow-hidden">
			<!-- VS Background -->
			<div class="absolute inset-0 flex">
				<div class="w-1/2 bg-blue relative overflow-hidden">
					<img
						src="{{ isset($event->weddingEvent->groom_photo) ? (Str::startsWith($event->weddingEvent->groom_photo, 'http') ? $event->weddingEvent->groom_photo : Storage::url($event->weddingEvent->groom_photo)) : 'https://via.placeholder.com/300' }}"
						class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-overlay grayscale">
				</div>
				<div class="w-1/2 bg-red relative overflow-hidden">
					<img
						src="{{ isset($event->weddingEvent->bride_photo) ? (Str::startsWith($event->weddingEvent->bride_photo, 'http') ? $event->weddingEvent->bride_photo : Storage::url($event->weddingEvent->bride_photo)) : 'https://via.placeholder.com/300' }}"
						class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-overlay grayscale">
				</div>
			</div>

			<div class="relative z-10 text-center">
				<div class="inline-block bg-white px-8 py-4 skew-box mb-8 border-b-8 border-yellow-500 shadow-xl">
					<div class="unskew-text">
						<p class="text-gray-500 font-bold tracking-widest text-xs mb-1">
							{{ \Carbon\Carbon::parse($event->event_date)->format('l, d F Y') }}</p>
						<h1 class="text-blue text-5xl md:text-7xl leading-none">
							{{ explode(' ', $event->weddingEvent->groom_name)[0] }}
							<span class="text-red mx-2 text-3xl align-middle">VS</span>
							{{ explode(' ', $event->weddingEvent->bride_name)[0] }}
						</h1>
					</div>
				</div>
				<p class="text-white text-shadow-md font-bold text-xl uppercase tracking-widest drop-shadow-lg">Save The Date</p>
			</div>
		</section>

		<!-- Line Up (Couple) -->
		<section class="max-w-4xl mx-auto px-4 mb-20">
			<div class="flex items-center justify-center gap-4 mb-12">
				<div class="h-1 bg-red flex-grow skew-box"></div>
				<h2 class="text-4xl text-blue text-center italic font-bold">STARTING LINEUP</h2>
				<div class="h-1 bg-red flex-grow skew-box"></div>
			</div>

			<div class="grid md:grid-cols-2 gap-12">
				<!-- Groom Card -->
				<div class="bg-white shadow-2xl relative group overflow-hidden border-t-8 border-blue" data-aos="fade-right">
					<div class="absolute top-0 right-0 bg-blue text-white px-4 py-2 font-heading text-2xl z-10">01</div>
					<div class="h-64 overflow-hidden relative">
						<div class="absolute inset-0 bg-gradient-to-t from-blue to-transparent z-10 opacity-70"></div>
						<img
							src="{{ isset($event->weddingEvent->groom_photo) ? (Str::startsWith($event->weddingEvent->groom_photo, 'http') ? $event->weddingEvent->groom_photo : Storage::url($event->weddingEvent->groom_photo)) : 'https://via.placeholder.com/300' }}"
							class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
						<div class="absolute bottom-4 left-4 z-20">
							<h3 class="text-white text-3xl italic">{{ $event->weddingEvent->groom_name }}</h3>
							<p class="text-yellow-400 font-bold uppercase">Captain (Groom)</p>
						</div>
					</div>
					<div class="p-6">
						<div class="flex justify-between items-center mb-4">
							<div class="text-left">
								<p class="text-xs text-gray-500 uppercase font-bold">Signed From</p>
								<p class="font-bold text-blue">{{ $event->weddingEvent->groom_parent }}</p>
							</div>
							@if ($event->weddingEvent->groom_instagram)
								<a href="https://instagram.com/{{ $event->weddingEvent->groom_instagram }}"
									class="text-blue text-2xl hover:text-red transition"><i class="fab fa-instagram"></i></a>
							@endif
						</div>
						<div class="grid grid-cols-3 gap-2 text-center border-t border-gray-100 pt-4">
							<div class="border-r border-gray-100">
								<span class="block font-heading text-xl text-blue">STR</span>
								<span class="text-xs text-gray-400 font-bold">99</span>
							</div>
							<div class="border-r border-gray-100">
								<span class="block font-heading text-xl text-blue">SPD</span>
								<span class="text-xs text-gray-400 font-bold">88</span>
							</div>
							<div>
								<span class="block font-heading text-xl text-blue">CHA</span>
								<span class="text-xs text-gray-400 font-bold">100</span>
							</div>
						</div>
					</div>
				</div>

				<!-- Bride Card -->
				<div class="bg-white shadow-2xl relative group overflow-hidden border-t-8 border-red" data-aos="fade-left">
					<div class="absolute top-0 right-0 bg-red text-white px-4 py-2 font-heading text-2xl z-10">02</div>
					<div class="h-64 overflow-hidden relative">
						<div class="absolute inset-0 bg-gradient-to-t from-red to-transparent z-10 opacity-70"></div>
						<img
							src="{{ isset($event->weddingEvent->bride_photo) ? (Str::startsWith($event->weddingEvent->bride_photo, 'http') ? $event->weddingEvent->bride_photo : Storage::url($event->weddingEvent->bride_photo)) : 'https://via.placeholder.com/300' }}"
							class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
						<div class="absolute bottom-4 left-4 z-20">
							<h3 class="text-white text-3xl italic">{{ $event->weddingEvent->bride_name }}</h3>
							<p class="text-yellow-400 font-bold uppercase">Captain (Bride)</p>
						</div>
					</div>
					<div class="p-6">
						<div class="flex justify-between items-center mb-4">
							<div class="text-left">
								<p class="text-xs text-gray-500 uppercase font-bold">Signed From</p>
								<p class="font-bold text-red">{{ $event->weddingEvent->bride_parent }}</p>
							</div>
							@if ($event->weddingEvent->bride_instagram)
								<a href="https://instagram.com/{{ $event->weddingEvent->bride_instagram }}"
									class="text-red text-2xl hover:text-blue transition"><i class="fab fa-instagram"></i></a>
							@endif
						</div>
						<div class="grid grid-cols-3 gap-2 text-center border-t border-gray-100 pt-4">
							<div class="border-r border-gray-100">
								<span class="block font-heading text-xl text-red">INT</span>
								<span class="text-xs text-gray-400 font-bold">99</span>
							</div>
							<div class="border-r border-gray-100">
								<span class="block font-heading text-xl text-red">BEA</span>
								<span class="text-xs text-gray-400 font-bold">100</span>
							</div>
							<div>
								<span class="block font-heading text-xl text-red">LCK</span>
								<span class="text-xs text-gray-400 font-bold">95</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Stats (Story) -->
		@if (isset($event->eventJourneys) && count($event->eventJourneys) > 0)
			<section class="bg-blue pb-20 pt-12 skew-y-2 transform -mb-10 relative z-10">
				<div class="-skew-y-2">
					<div class="max-w-4xl mx-auto px-4">
						<h2 class="text-4xl text-white text-center italic font-bold mb-12 uppercase">Season Highlights</h2>
						<div class="space-y-4">
							@foreach ($event->eventJourneys as $index => $story)
								<div class="flex items-stretch bg-white shadow-lg overflow-hidden group hover:-translate-y-1 transition"
									data-aos="fade-up">
									<div class="bg-yellow-400 w-16 flex items-center justify-center font-heading text-3xl text-blue shrink-0">
										{{ $index + 1 }}
									</div>
									<div class="p-4 flex-grow">
										<div class="flex justify-between items-start">
											<h4 class="font-bold text-blue text-xl uppercase">{{ $story->title }}</h4>
											<span class="bg-gray-200 text-gray-600 text-xs px-2 py-1 font-bold rounded">
												{{ $story->journey_date ? (is_object($story->journey_date) ? $story->journey_date->format('M Y') : \Carbon\Carbon::parse($story->journey_date)->format('M Y')) : '' }}
											</span>
										</div>
										<p class="text-gray-600 mt-2">{{ $story->description }}</p>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</section>
		@endif

		<!-- Fixtures (Events) -->
		<section class="py-24 px-4 max-w-5xl mx-auto">
			<div class="flex items-center justify-center gap-4 mb-12">
				<h2 class="text-4xl text-blue text-center italic font-bold">MATCH FIXTURES</h2>
			</div>

			<div class="grid md:grid-cols-2 gap-8">
				@foreach ($event->eventLocations as $location)
					<div class="bg-white border-2 border-gray-200 p-6 relative hover:border-blue transition group" data-aos="zoom-in">
						<div
							class="absolute top-0 right-0 bg-gray-200 text-gray-500 px-3 py-1 text-xs font-bold uppercase group-hover:bg-blue group-hover:text-white transition">
							{{ $location->location_type }}
						</div>

						<div class="flex gap-4 items-center mb-6">
							<div class="text-center">
								<span
									class="block text-4xl font-heading text-red">{{ \Carbon\Carbon::parse($location->event_time)->format('H:i') }}</span>
								<span class="block text-xs font-bold text-gray-400">KICK OFF</span>
							</div>
							<div class="h-10 w-px bg-gray-300"></div>
							<div>
								<h3 class="font-bold text-xl text-blue uppercase">{{ $location->name }}</h3>
								<p class="text-sm text-gray-500">{{ $location->address }}</p>
							</div>
						</div>

						@if ($location->google_maps_url)
							<a href="{{ $location->google_maps_url }}" target="_blank"
								class="block text-center bg-gray-100 text-gray-800 py-3 font-bold uppercase hover:bg-yellow-400 hover:text-blue transition skew-box">
								<span class="block unskew-text">Stadium Map</span>
							</a>
						@endif
					</div>
				@endforeach
			</div>
		</section>

		<!-- Gallery -->
		@if (isset($event->eventGalleries))
			<section class="py-12 bg-gray-900 text-white clip-path-gallery">
				<div class="max-w-6xl mx-auto px-4">
					<h2 class="text-4xl text-white text-center italic font-bold mb-12 uppercase">INSTANT REPLAY</h2>
					<div class="grid grid-cols-2 md:grid-cols-4 gap-2">
						@foreach ($event->eventGalleries as $photo)
							<div class="aspect-video bg-gray-800 overflow-hidden relative group" data-aos="scale-up">
								<img
									src="{{ Str::startsWith($photo->image_path, 'http') ? $photo->image_path : Storage::url($photo->image_path) }}"
									class="w-full h-full object-cover group-hover:scale-110 transition duration-500 opacity-60 group-hover:opacity-100">
								<div class="absolute top-2 left-2 bg-red text-white text-[10px] px-2 py-0.5 font-bold uppercase">Live</div>
							</div>
						@endforeach
					</div>
				</div>
			</section>
		@endif

		<!-- Gift & RSVP -->
		<section class="max-w-4xl mx-auto px-4 py-20">
			<div class="grid md:grid-cols-2 gap-8">
				<!-- Support (Gift) -->
				@if (isset($event->eventBanks))
					<div class="bg-blue text-white p-8 clip-path-left" data-aos="fade-right">
						<h3 class="text-3xl font-heading mb-6 italic">Support The Team</h3>
						<div class="space-y-6">
							@foreach ($event->eventBanks as $angpao)
								<div class="bg-white/10 p-4 border-l-4 border-yellow-400">
									<p class="text-yellow-400 font-bold text-sm">{{ $angpao->bank_name }}</p>
									<p class="font-heading text-2xl tracking-widest mb-1 select-all" id="acc-{{ $loop->index }}">
										{{ $angpao->account_number }}</p>
									<p class="text-xs text-gray-300 mb-2">{{ $angpao->account_name }}</p>
									<button onclick="copyToClipboard('acc-{{ $loop->index }}')"
										class="text-xs bg-yellow-400 text-blue px-3 py-1 font-bold uppercase hover:bg-white transition">Copy</button>
								</div>
							@endforeach
						</div>
					</div>
				@endif

				<!-- RSVP -->
				<div class="bg-white p-8 shadow-xl border-t-8 border-red" data-aos="fade-left">
					<h3 class="text-3xl font-heading text-blue mb-6 italic">Confirm Attendance</h3>
					<form id="rsvp-form" action="{{ route('frontend.rsvp', [$event->slug, $invitation->slug]) }}" method="POST"
						class="space-y-4">
						@csrf
						<div>
							<label class="block text-xs font-bold text-gray-500 uppercase mb-1">Fan Name</label>
							<input type="text" value="{{ $invitation->guest_name }}" readonly
								class="w-full bg-gray-100 border-2 border-gray-200 p-3 font-bold text-blue">
						</div>
						<div class="grid grid-cols-2 gap-4">
							<div>
								<label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status</label>
								<select name="status"
									class="w-full bg-gray-100 border-2 border-gray-200 p-3 font-bold text-blue focus:border-red outline-none transition">
									<option value="yes">Attending Match</option>
									<option value="no">Can't Attend</option>
								</select>
							</div>
							<div>
								<label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tickets</label>
								<select name="total_guest"
									class="w-full bg-gray-100 border-2 border-gray-200 p-3 font-bold text-blue focus:border-red outline-none transition">
									<option value="1">1 Ticket</option>
									<option value="2">2 Tickets</option>
								</select>
							</div>
						</div>
						<div>
							<label class="block text-xs font-bold text-gray-500 uppercase mb-1">Cheer / Chant</label>
							<textarea name="message"
							 class="w-full bg-gray-100 border-2 border-gray-200 p-3 font-bold text-blue h-24 focus:border-red outline-none transition"
							 placeholder="Go Team!"></textarea>
						</div>
						<button type="submit"
							class="w-full bg-red text-white font-heading text-2xl py-3 transform hover:-translate-y-1 hover:shadow-lg transition">
							SUBMIT
						</button>
					</form>
				</div>
			</div>
		</section>

		<!-- Fan Zone (Wishes) -->
		<section class="pb-20 px-4" id="wishes-section">
			<h2 class="text-4xl text-blue text-center italic font-bold mb-12 uppercase">FAN ZONE</h2>
			<div id="wishes-container" class="max-w-3xl mx-auto space-y-4 max-h-[500px] overflow-y-auto hide-scroll px-2">
				@if (isset($wishes))
					@foreach ($wishes as $wish)
						<div class="bg-white p-4 border-l-4 border-blue shadow flex gap-4" data-aos="fade-up">
							<div class="bg-gray-200 w-12 h-12 flex items-center justify-center font-heading text-xl text-gray-400 shrink-0">
								{{ substr($wish->name, 0, 1) }}
							</div>
							<div>
								<div class="flex items-baseline gap-2 mb-1">
									<h5 class="font-bold text-blue">{{ $wish->name }}</h5>
									<span class="text-[10px] text-gray-400 font-bold uppercase">{{ $wish->created_at->diffForHumans() }}</span>
								</div>
								<p class="text-sm font-bold text-gray-600 italic">"{{ $wish->message }}"</p>
							</div>
						</div>
					@endforeach
				@endif
			</div>
		</section>

		<footer class="bg-blue text-white py-12 text-center relative overflow-hidden">
			<div class="relative z-10">
				<h2 class="font-heading text-4xl mb-2">GAME OVER</h2>
				<p class="text-xs font-bold tracking-widest text-gray-400">&copy; {{ date('Y') }} UndanganKita. All Rights
					Reserved.</p>
			</div>
			<!-- Background Lines -->
			<div class="absolute inset-0 opacity-10 flex justify-center">
				<div class="w-px h-full bg-white mx-10"></div>
				<div class="w-px h-full bg-white mx-10"></div>
				<div class="w-px h-full bg-white mx-10"></div>
			</div>
		</footer>

	</div>

	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		// AOS.init(); // Moved to open trigger

		// Cover Logic
		const cover = document.getElementById('cover');
		const main = document.getElementById('main-content');
		const openBtn = document.getElementById('open-invitation');
		const audio = document.getElementById('bg-music');
		const musicBtn = document.getElementById('music-control');
		const musicIcon = document.getElementById('music-icon');

		openBtn.addEventListener('click', () => {
			// Slide up effect for cover
			cover.style.transition = 'transform 0.5s cubic-bezier(0.7,0,0.3,1)';
			cover.style.transform = 'translateY(-100%)';

			toggleMusic(true);
			musicBtn.classList.remove('hidden');

			setTimeout(() => {
				cover.style.display = 'none';
				main.style.display = 'block';
				AOS.init(); // Init AOS after visible
			}, 500);
		});

		let isPlaying = false;

		function toggleMusic(force = false) {
			if (force || !isPlaying) {
				audio.play();
				isPlaying = true;
				musicIcon.classList.remove('fa-volume-mute');
				musicIcon.classList.add('fa-volume-up');
			} else {
				audio.pause();
				isPlaying = false;
				musicIcon.classList.add('fa-volume-mute');
				musicIcon.classList.remove('fa-volume-up');
			}
		}

		function copyToClipboard(id) {
			const text = document.getElementById(id).innerText;
			navigator.clipboard.writeText(text).then(() => {
				alert('ACC Number Copied!');
			});
		}

		// Countdown
		const eventDateStr = "{{ $event->event_date }}";
		const eventDate = new Date(eventDateStr).getTime();

		function updateTimer() {
			const now = new Date().getTime();
			const distance = eventDate - now;

			if (distance < 0) {
				document.getElementById("countdown").innerText = "MATCH STARTED";
				return;
			}

			const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			const seconds = Math.floor((distance % (1000 * 60)) / 1000);

			// Format like a game clock
			document.getElementById("countdown").innerText =
				(hours < 10 ? "0" + hours : hours) + ":" +
				(minutes < 10 ? "0" + minutes : minutes) + ":" +
				(seconds < 10 ? "0" + seconds : seconds);
		}
		setInterval(updateTimer, 1000);
		updateTimer();

		// AJAX RSVP
		document.getElementById('rsvp-form').addEventListener('submit', function(e) {
			e.preventDefault();
			const form = this;
			const btn = form.querySelector('button[type="submit"]');
			const originalText = btn.innerText;
			btn.innerText = 'PROCESSING...';
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
						alert('Attendance Confirmed! See you at the game.');
						form.reset();

						if (data.wish) {
							const container = document.getElementById('wishes-container');
							section = document.getElementById(
								'wishes-section'); // Global var if needed (using id here)
							// document.getElementById('wishes-section').style.display = 'block'; // Already visible

							const html = `
                             <div class="bg-white p-4 border-l-4 border-blue shadow flex gap-4" data-aos="fade-up">
                                <div class="bg-gray-200 w-12 h-12 flex items-center justify-center font-heading text-xl text-gray-400 shrink-0">
                                     ${data.wish.name.charAt(0)}
                                </div>
                                <div>
                                     <div class="flex items-baseline gap-2 mb-1">
                                         <h5 class="font-bold text-blue">${data.wish.name}</h5>
                                         <span class="text-[10px] text-gray-400 font-bold uppercase">${data.wish.created_at_human}</span>
                                     </div>
                                     <p class="text-sm font-bold text-gray-600 italic">"${data.wish.message}"</p>
                                </div>
                            </div>
                        `;
							container.insertAdjacentHTML('afterbegin', html);
						}
					} else {
						alert('Submission failed.');
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
