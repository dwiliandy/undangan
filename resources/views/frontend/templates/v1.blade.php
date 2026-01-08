@extends('layouts.frontend', ['hideNav' => true])

@section('title', $event->title)

@section('content')
	<!-- AOS CSS -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

	<style>
		#main-content {
			display: none;
		}

		.open-btn-animate {
			animation: pulse 2s infinite;
		}

		.spin {
			animation: spin 8s linear infinite;
		}

		@keyframes pulse {
			0% {
				transform: scale(1);
				box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.7);
			}

			70% {
				transform: scale(1.05);
				box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
			}

			100% {
				transform: scale(1);
				box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
			}
		}

		@keyframes spin {
			100% {
				transform: rotate(360deg);
			}
		}

		.hide-scroll::-webkit-scrollbar {
			display: none;
		}

		.hide-scroll {
			-ms-overflow-style: none;
			scrollbar-width: none;
		}
	</style>

	<!-- Audio Control -->
	<audio id="bg-music" loop>
		<source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
	</audio>
	<button id="music-control"
		class="fixed bottom-6 right-6 z-50 bg-black text-white p-4 rounded-full shadow-2xl hidden hover:bg-gray-800 transition"
		onclick="toggleMusic()">
		<i class="fas fa-compact-disc spin text-xl" id="music-icon"></i>
	</button>

	<!-- Cover Section -->
	<div id="cover" class="fixed inset-0 z-50 bg-white flex flex-col justify-center items-center text-center p-6">
		<div class="absolute inset-0 z-0 opacity-10"
			style="background-image: url('https://www.transparenttextures.com/patterns/clean-gray-paper.png');"></div>

		<p class="text-xs md:text-sm tracking-[0.4em] uppercase mb-8 z-10 border-b border-black pb-2">The Wedding Of</p>
		<h1 class="text-5xl md:text-8xl font-serif font-light mb-10 z-10">{{ $event->wedding->groom_name ?? 'Groom' }} <span
				class="text-3xl italic">&</span> {{ $event->wedding->bride_name ?? 'Bride' }}</h1>

		@if (isset($invitation))
			<div class="z-10 w-full max-w-sm bg-gray-50 p-6 border border-gray-200 mb-8">
				<p class="text-[10px] uppercase tracking-widest text-gray-500 mb-2">Dear Special Guest,</p>
				<h2 class="text-2xl font-serif">{{ $invitation->guest_name }}</h2>
				@if ($invitation->guest_address)
					<p class="text-xs text-gray-400 mt-1 uppercase tracking-wider">{{ $invitation->guest_address }}</p>
				@endif
			</div>
		@endif

		<!-- Countdown Cover -->
		<div class="flex space-x-6 text-center mb-10 z-10">
			<div><span id="c-days" class="text-2xl font-serif block">00</span><span
					class="text-[9px] uppercase tracking-widest text-gray-400">Days</span></div>
			<div><span id="c-hours" class="text-2xl font-serif block">00</span><span
					class="text-[9px] uppercase tracking-widest text-gray-400">Hrs</span></div>
			<div><span id="c-minutes" class="text-2xl font-serif block">00</span><span
					class="text-[9px] uppercase tracking-widest text-gray-400">Min</span></div>
			<div><span id="c-seconds" class="text-2xl font-serif block">00</span><span
					class="text-[9px] uppercase tracking-widest text-gray-400">Sec</span></div>
		</div>

		<button id="open-invitation"
			class="z-10 bg-black text-white px-10 py-4 rounded-full text-xs uppercase tracking-[0.2em] hover:bg-gray-800 transition duration-500 open-btn-animate shadow-xl">
			Open Invitation
		</button>
	</div>

	<!-- Main Content -->
	<div id="main-content"
		class="min-h-screen bg-white text-gray-900 font-sans selection:bg-black selection:text-white pb-20">
		<!-- Hero Section -->
		<header class="min-h-screen flex flex-col justify-center items-center text-center px-4 relative overflow-hidden">
			<div class="absolute inset-0 z-0 opacity-5"
				style="background-image: url('https://www.transparenttextures.com/patterns/clean-gray-paper.png');"></div>

			<div data-aos="fade-down" data-aos-duration="1000">
				<p class="text-sm md:text-base tracking-[0.3em] uppercase mb-4">The Wedding Of</p>
			</div>

			<h1 class="text-5xl md:text-8xl font-serif font-light mb-6 tracking-tighter" data-aos="zoom-in"
				data-aos-duration="1200">
				{{ $event->wedding->groom_name ?? 'Groom' }} <span class="text-4xl align-middle italic">&</span>
				{{ $event->wedding->bride_name ?? 'Bride' }}
			</h1>

			<div class="w-16 h-px bg-black mb-8" data-aos="fade-up"></div>

			<div class="flex flex-col items-center space-y-4" data-aos="fade-up" data-aos-delay="200">
				<p class="text-xl md:text-2xl font-light tracking-wide">
					{{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
				</p>
			</div>
		</header>

		<!-- Couple Profile -->
		<section class="py-24 px-4 max-w-6xl mx-auto">
			<div class="text-center mb-16" data-aos="fade-up">
				<h2 class="text-3xl md:text-4xl font-serif mb-4">The Happy Couple</h2>
				<p class="text-gray-500 italic max-w-xl mx-auto">"Love is composed of a single soul inhabiting two bodies."</p>
			</div>

			<div class="grid md:grid-cols-2 gap-16 items-center">
				<!-- Groom -->
				<div class="text-center space-y-6" data-aos="fade-right">
					<div
						class="w-64 h-80 mx-auto bg-gray-200 overflow-hidden relative grayscale hover:grayscale-0 transition duration-700">
						<img src="https://via.placeholder.com/300x400" alt="Groom" class="w-full h-full object-cover">
					</div>
					<div>
						<h3 class="text-2xl font-serif">{{ $event->wedding->groom_name ?? 'The Groom' }}</h3>
						<p class="text-sm text-gray-500 uppercase tracking-widest mt-2">Son of {{ $event->wedding->groom_parent ?? '...' }}
						</p>
						<div class="flex justify-center gap-4 mt-4 text-gray-400">
							<a href="#" class="hover:text-black"><i class="fab fa-instagram"></i></a>
							<a href="#" class="hover:text-black"><i class="fab fa-twitter"></i></a>
						</div>
					</div>
				</div>

				<!-- Bride -->
				<div class="text-center space-y-6" data-aos="fade-left">
					<div
						class="w-64 h-80 mx-auto bg-gray-200 overflow-hidden relative grayscale hover:grayscale-0 transition duration-700">
						<img src="https://via.placeholder.com/300x400" alt="Bride" class="w-full h-full object-cover">
					</div>
					<div>
						<h3 class="text-2xl font-serif">{{ $event->wedding->bride_name ?? 'The Bride' }}</h3>
						<p class="text-sm text-gray-500 uppercase tracking-widest mt-2">Daughter of
							{{ $event->wedding->bride_parent ?? '...' }}</p>
						<div class="flex justify-center gap-4 mt-4 text-gray-400">
							<a href="#" class="hover:text-black"><i class="fab fa-instagram"></i></a>
							<a href="#" class="hover:text-black"><i class="fab fa-twitter"></i></a>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Love Story -->
		@if (isset($event->love_stories) && count($event->love_stories) > 0)
			<section class="py-24 bg-gray-50">
				<div class="max-w-3xl mx-auto px-4">
					<h2 class="text-3xl md:text-4xl font-serif text-center mb-16" data-aos="fade-up">Our Story</h2>
					<div class="border-l border-gray-300 ml-4 md:ml-0 md:pl-0 space-y-12">
						@foreach ($event->love_stories as $story)
							<div class="relative pl-8 md:pl-0 md:flex md:items-center md:justify-between group" data-aos="fade-up">
								<!-- Bullet -->
								<div
									class="absolute -left-[5px] top-0 md:left-1/2 md:-ml-1.5 w-3 h-3 bg-black rounded-full border-4 border-white">
								</div>

								<div class="md:w-1/2 md:pr-12 md:text-right {{ $loop->index % 2 != 0 ? 'md:order-1' : '' }}">
									<span class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1 block">{{ $story->year }}</span>
									<h4 class="text-xl font-serif mb-2">{{ $story->title }}</h4>
								</div>

								<div class="md:w-1/2 md:pl-12 {{ $loop->index % 2 != 0 ? 'md:order-2 md:!text-right' : '' }}">
									<!-- Fix order css logic if needed, simpler to keep left aligned for text on mobile -->
									<p class="text-gray-600 text-sm leading-relaxed">{{ $story->story }}</p>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</section>
		@endif

		<!-- Events -->
		<section class="py-24 px-4 max-w-5xl mx-auto">
			<h2 class="text-3xl md:text-4xl font-serif text-center mb-16" data-aos="fade-up">Event Details</h2>
			<div class="grid md:grid-cols-2 gap-8 text-center">
				@if (isset($event->locations) && count($event->locations) > 0)
					@foreach ($event->locations as $location)
						<div class="p-10 border border-gray-200 hover:border-black transition duration-500 bg-white" data-aos="fade-up"
							data-aos-delay="{{ $loop->index * 100 }}">
							<h4 class="text-xl font-bold uppercase tracking-widest mb-4">{{ $location->location_type }}</h4>
							<div class="w-10 h-px bg-black mx-auto mb-6"></div>
							<p class="text-5xl font-serif mb-4">{{ \Carbon\Carbon::parse($location->event_time)->format('H:i') }}</p>
							<p class="font-bold text-lg mb-1">{{ $location->name }}</p>
							<p class="text-gray-500 text-sm mb-6">{{ $location->address }}</p>
							@if ($location->google_maps_url)
								<a href="{{ $location->google_maps_url }}" target="_blank"
									class="inline-block border border-black px-6 py-2 text-xs uppercase tracking-widest hover:bg-black hover:text-white transition">View
									Map</a>
							@endif
						</div>
					@endforeach
				@endif
			</div>
		</section>

		<!-- Gallery -->
		@if (isset($event->gallery) && count($event->gallery) > 0)
			<section class="py-0">
				<div class="grid grid-cols-2 md:grid-cols-4">
					@foreach ($event->gallery as $photo)
						<div class="aspect-[3/4] relative group overflow-hidden bg-gray-100" data-aos="fade-in"
							data-aos-delay="{{ $loop->index * 50 }}">
							<img src="{{ $photo->photo_url }}"
								class="w-full h-full object-cover transition duration-700 group-hover:scale-110 grayscale group-hover:grayscale-0">
						</div>
					@endforeach
				</div>
			</section>
		@endif

		<!-- Gift & RSVP -->
		<section class="py-24 px-4 bg-black text-white text-center">
			<div class="max-w-4xl mx-auto">
				<!-- Gift -->
				@if (isset($event->angpaos) && count($event->angpaos) > 0)
					<div class="mb-20" data-aos="fade-up">
						<h2 class="text-3xl font-serif mb-8">Wedding Gift</h2>
						<p class="text-gray-400 text-sm mb-10">Your blessing is enough, but if you wish to give a gift:</p>
						<div class="grid md:grid-cols-2 gap-6">
							@foreach ($event->angpaos as $angpao)
								<div class="border border-gray-800 p-8 rounded-lg hover:border-gray-600 transition">
									<h4 class="font-bold uppercase tracking-widest mb-2">{{ $angpao->bank_name }}</h4>
									<p class="text-2xl font-serif mb-2 select-all" id="acc-{{ $loop->index }}">{{ $angpao->account_number }}
									</p>
									<p class="text-xs text-gray-500 uppercase tracking-wider mb-6">{{ $angpao->account_name }}</p>
									<button onclick="copyToClipboard('acc-{{ $loop->index }}')"
										class="text-xs uppercase tracking-widest text-gray-400 hover:text-white underline">Copy Account</button>
								</div>
							@endforeach
						</div>
					</div>
				@endif

				<!-- RSVP -->
				<div class="bg-white text-black p-8 md:p-16" data-aos="fade-up">
					<h2 class="text-3xl font-serif mb-8">R.S.V.P</h2>
					<form class="space-y-6 max-w-lg mx-auto text-left">
						<div>
							<label class="block text-xs uppercase tracking-widest mb-2">Name</label>
							<input type="text"
								class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-black transition"
								value="{{ $invitation->guest_name ?? '' }}">
						</div>
						<div class="grid grid-cols-2 gap-6">
							<div>
								<label class="block text-xs uppercase tracking-widest mb-2">Attendance</label>
								<select class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-black bg-transparent">
									<option>Valid</option>
									<option>Unable</option>
								</select>
							</div>
							<div>
								<label class="block text-xs uppercase tracking-widest mb-2">Guests</label>
								<select class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-black bg-transparent">
									<option>1</option>
									<option>2</option>
								</select>
							</div>
						</div>
						<div>
							<label class="block text-xs uppercase tracking-widest mb-2">Wishes</label>
							<textarea
							 class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-black transition h-20 bg-transparent"></textarea>
						</div>
						<button type="button"
							class="w-full bg-black text-white py-4 text-xs uppercase tracking-[0.2em] hover:bg-gray-800 transition mt-8">Send
							RSVP</button>
					</form>
				</div>
			</div>
		</section>

		<!-- Wishes List -->
		@if (isset($wishes) && count($wishes) > 0)
			<section class="py-24 px-4 bg-gray-50">
				<div class="max-w-3xl mx-auto">
					<h2 class="text-3xl font-serif text-center mb-12" data-aos="fade-up">Wishes</h2>
					<div class="space-y-6 max-h-96 overflow-y-auto hide-scroll p-2">
						@foreach ($wishes as $wish)
							<div class="bg-white p-6 shadow-sm border-l-4 border-black" data-aos="fade-up">
								<h5 class="font-bold text-sm mb-1">{{ $wish->name }}</h5>
								<p class="text-xs text-gray-400 mb-3">{{ $wish->created_at->diffForHumans() }}</p>
								<p class="text-sm text-gray-600 italic">"{{ $wish->message }}"</p>
							</div>
						@endforeach
					</div>
				</div>
			</section>
		@endif

		<footer
			class="py-10 text-center text-gray-400 text-[10px] uppercase tracking-widest border-t border-gray-100 bg-white">
			Created with Undangan
		</footer>
	</div>

	<!-- Scripts -->
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		// Open Invitation Logic
		document.getElementById('open-invitation').addEventListener('click', function() {
			const cover = document.getElementById('cover');
			const main = document.getElementById('main-content');

			// Play Music
			toggleMusic(true);
			document.getElementById('music-control').classList.remove('hidden');

			cover.style.transition = "transform 0.8s ease-in-out, opacity 0.8s";
			cover.style.transform = "translateY(-100%)";
			cover.style.opacity = "0";

			setTimeout(() => {
				cover.style.display = 'none';
				main.style.display = 'block';
				AOS.init();
			}, 600);
		});

		// Music Control
		const audio = document.getElementById('bg-music');
		const musicIcon = document.getElementById('music-icon');
		let isPlaying = false;

		function toggleMusic(forcePlay = false) {
			if (forcePlay || !isPlaying) {
				audio.play();
				isPlaying = true;
				musicIcon.classList.add('spin');
				musicIcon.classList.remove('fa-play');
				musicIcon.classList.add('fa-compact-disc');
			} else {
				audio.pause();
				isPlaying = false;
				musicIcon.classList.remove('spin');
				musicIcon.classList.remove('fa-compact-disc');
				musicIcon.classList.add('fa-play');
			}
		}

		function copyToClipboard(id) {
			const text = document.getElementById(id).innerText;
			navigator.clipboard.writeText(text).then(() => {
				alert('Copied to clipboard!');
			});
		}

		// Countdown Timer
		const eventDate = new Date("{{ $event->event_date }}").getTime();

		function updateTimer() {
			const now = new Date().getTime();
			const distance = eventDate - now;

			const days = Math.floor(distance / (1000 * 60 * 60 * 24));
			const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			const seconds = Math.floor((distance % (1000 * 60)) / 1000);

			// Universal updater for both cover and main if IDs exist
			if (document.getElementById("c-days")) {
				document.getElementById("c-days").innerText = days < 10 ? '0' + days : days;
				document.getElementById("c-hours").innerText = hours < 10 ? '0' + hours : hours;
				document.getElementById("c-minutes").innerText = minutes < 10 ? '0' + minutes : minutes;
				document.getElementById("c-seconds").innerText = seconds < 10 ? '0' + seconds : seconds;
			}
		}
		setInterval(updateTimer, 1000);
		updateTimer();
	</script>
@endsection
