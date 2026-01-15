@extends('layouts.frontend', ['hideNav' => true])

@section('title', $event->title)

@section('content')
	<!-- AOS CSS -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

	<!-- Comic Font -->
	<link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">

	<style>
		body {
			font-family: 'Bangers', cursive;
			background-color: #f0f0f0;
			letter-spacing: 1px;
		}

		.comic-bg {
			background-image: radial-gradient(#e5e7eb 20%, transparent 20%),
				radial-gradient(#e5e7eb 20%, transparent 20%);
			background-size: 20px 20px;
			background-position: 0 0, 10px 10px;
		}

		.open-btn-animate {
			animation: pulse 2s infinite;
		}

		.spin {
			animation: spin 8s linear infinite;
		}

		.comic-border {
			border: 4px solid black;
			box-shadow: 10px 10px 0 black;
		}

		.comic-text-shadow {
			text-shadow: 3px 3px 0 black;
		}

		@keyframes pulse {
			0% {
				transform: scale(1);
				box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7);
			}

			70% {
				transform: scale(1.05);
				box-shadow: 0 0 0 10px rgba(220, 38, 38, 0);
			}

			100% {
				transform: scale(1);
				box-shadow: 0 0 0 0 rgba(220, 38, 38, 0);
			}
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
		class="fixed bottom-6 right-6 z-50 bg-red-600 text-white p-4 rounded-full shadow-2xl hidden hover:bg-red-700 transition comic-border"
		onclick="toggleMusic()">
		<i class="fas fa-compact-disc spin text-xl" id="music-icon"></i>
	</button>

	<!-- COVER SECTION -->
	<div id="cover"
		class="fixed inset-0 z-50 bg-blue-600 flex flex-col justify-center items-center text-center p-6 comic-bg">
		<div class="mb-8 animate__animated animate__zoomIn">
			@if (isset($event->birthdayEvent->photo))
				<div class="w-48 h-48 rounded-full border-4 border-black overflow-hidden mx-auto shadow-2xl bg-white relative">
					<img src="{{ Storage::url($event->birthdayEvent->photo) }}" class="w-full h-full object-cover">
					<div class="absolute -bottom-2 -right-2 bg-yellow-400 border-2 border-black px-2 py-1 transform rotate-12">
						<span class="text-black text-lg">POW!</span>
					</div>
				</div>
			@else
				<div
					class="w-48 h-48 bg-white rounded-full border-4 border-black flex items-center justify-center mx-auto shadow-2xl">
					<span class="text-8xl">🦸</span>
				</div>
			@endif
		</div>

		<p class="text-white text-2xl uppercase tracking-widest mb-4 comic-text-shadow">Calling All Heroes For</p>

		<h1 class="text-5xl md:text-7xl text-yellow-400 mb-2 comic-text-shadow transform -rotate-2">
			{{ $event->birthdayEvent->person_name ?? 'Super Kid' }}
		</h1>

		@if (isset($event->birthdayEvent->age))
			<p class="text-3xl text-white mb-8 comic-text-shadow mt-2">Level {{ $event->birthdayEvent->age }} Mission!</p>
		@endif

		<!-- Countdown -->
		<div class="flex space-x-4 text-center mb-10 justify-center">
			<div class="bg-red-600 border-2 border-black p-2 w-20 transform -rotate-3 hover:rotate-0 transition">
				<span id="c-days" class="text-3xl text-white block">00</span>
				<span class="text-xs uppercase text-yellow-300">Days</span>
			</div>
			<div class="bg-blue-600 border-2 border-black p-2 w-20 transform rotate-3 hover:rotate-0 transition">
				<span id="c-hours" class="text-3xl text-white block">00</span>
				<span class="text-xs uppercase text-yellow-300">Hrs</span>
			</div>
			<div class="bg-yellow-500 border-2 border-black p-2 w-20 transform -rotate-3 hover:rotate-0 transition">
				<span id="c-minutes" class="text-3xl text-black block">00</span>
				<span class="text-xs uppercase text-black">Min</span>
			</div>
			<div class="bg-green-600 border-2 border-black p-2 w-20 transform rotate-3 hover:rotate-0 transition">
				<span id="c-seconds" class="text-3xl text-white block">00</span>
				<span class="text-xs uppercase text-yellow-300">Sec</span>
			</div>
		</div>

		@if (isset($invitation))
			<div class="mb-8 bg-white border-2 border-black inline-block px-6 py-2 transform rotate-2">
				<p class="text-sm text-gray-500">Top Secret Invite For:</p>
				<h3 class="text-2xl text-black">{{ $invitation->guest_name }}</h3>
			</div>
		@endif

		<button id="open-invitation"
			class="bg-red-600 text-white px-10 py-4 text-xl border-2 border-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-y-1 hover:shadow-none transition-all duration-200 uppercase tracking-widest open-btn-animate">
			Start Mission
		</button>
	</div>

	<!-- MAIN CONTENT (Hidden initially) -->
	<div id="main-content"
		class="hidden min-h-screen bg-yellow-400 flex flex-col items-center p-4 text-center pb-20 comic-bg">

		<!-- Header Image Area -->
		<div class="w-full max-w-2xl mt-8 mb-8" data-aos="zoom-in-down">
			<div class="bg-white border-4 border-black p-4 transform rotate-1 shadow-[10px_10px_0px_0px_rgba(0,0,0,1)]">
				@if (isset($event->birthdayEvent->photo))
					<div class="h-64 md:h-96 w-full overflow-hidden border-2 border-black">
						<img src="{{ Storage::url($event->birthdayEvent->photo) }}" class="w-full h-full object-cover">
					</div>
				@else
					<div class="h-64 md:h-96 w-full bg-blue-100 flex items-center justify-center border-2 border-black">
						<span class="text-6xl">💥</span>
					</div>
				@endif
				<div class="mt-4">
					<h1 class="text-5xl md:text-6xl text-red-600 comic-text-shadow">
						{{ $event->birthdayEvent->person_name ?? 'Super Kid' }}</h1>
					@if (isset($event->birthdayEvent->age))
						<p class="text-2xl text-blue-600 mt-2">Birthday Mission #{{ $event->birthdayEvent->age }}</p>
					@endif
				</div>
			</div>
		</div>

		<!-- Details Card -->
		<div
			class="bg-white border-4 border-black p-8 max-w-md w-full mb-8 transform -rotate-1 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]"
			data-aos="fade-up">
			<div
				class="absolute -top-6 -right-6 bg-red-600 text-white p-4 rounded-full border-2 border-black transform rotate-12 z-10 w-20 h-20 flex items-center justify-center">
				<span class="text-xl">BAM!</span>
			</div>

			<h2 class="text-3xl text-black mb-6 underline decoration-wavy decoration-blue-400">Mission Details</h2>

			<div class="space-y-6 text-xl">
				<div>
					<span class="bg-blue-100 px-2 py-1 border border-black inline-block transform -rotate-2 mb-2">When?</span>
					<p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($event->event_date)->format('l, d F Y') }}</p>
				</div>

				@if (isset($event->eventLocations) && $event->eventLocations->count() > 0)
					<div class="mt-4">
						<span class="bg-yellow-100 px-2 py-1 border border-black inline-block transform rotate-2 mb-2">Where?</span>
						@foreach ($event->eventLocations as $loc)
							<div class="mb-4 bg-gray-50 p-2 border border-black border-dashed">
								<p class="font-bold text-red-600">{{ $loc->name }}</p>
								<p class="text-base text-gray-600">{{ $loc->address }}</p>
								<p class="text-base font-bold text-blue-600">@ {{ \Carbon\Carbon::parse($loc->event_time)->format('H:i') }}</p>
								@if ($loc->google_maps_url)
									<a href="{{ $loc->google_maps_url }}" target="_blank"
										class="block mt-2 bg-black text-white py-1 px-3 text-sm hover:bg-gray-800">Locate Base</a>
								@endif
							</div>
						@endforeach
					</div>
				@endif
			</div>

			<div class="mt-8 mb-4">
				<p class="text-black text-lg bg-yellow-200 border-2 border-black p-4 transform rotate-1">"Suit up! We need you for
					the ultimate party!"</p>
			</div>
		</div>

		<!-- RSVP Form -->
		<div class="w-full max-w-md" data-aos="flip-up">
			<div class="bg-blue-600 border-4 border-black p-1">
				<form id="rsvp-form" action="{{ route('frontend.rsvp', [$event->slug, $invitation->slug]) }}" method="POST"
					class="bg-white border-2 border-black p-6 text-left">
					@csrf
					<h3 class="text-3xl text-red-600 mb-6 text-center comic-text-shadow">RSVP HQ</h3>

					<div class="mb-4">
						<label class="block text-black mb-1 text-lg">Agent Name</label>
						<input type="text" name="name" value="{{ $invitation->guest_name }}"
							class="w-full border-2 border-black p-2 text-xl focus:bg-yellow-50 focus:outline-none" placeholder="Agent Name">
					</div>

					<div class="mb-4">
						<label class="block text-black mb-1 text-lg">Status Report</label>
						<select name="status"
							class="w-full border-2 border-black p-2 text-xl focus:bg-yellow-50 focus:outline-none bg-white">
							<option value="yes">Mission Accepted!</option>
							<option value="no">Mission Impossible</option>
						</select>
					</div>

					<div class="mb-6">
						<label class="block text-black mb-1 text-lg">Message for Hero</label>
						<textarea name="message" class="w-full border-2 border-black p-2 text-xl focus:bg-yellow-50 focus:outline-none"
						 rows="3" placeholder="Secret Message..."></textarea>
					</div>

					<button type="submit"
						class="w-full bg-red-600 text-white text-2xl py-3 border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-0.5 hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all">
						SEND REPORT
					</button>
				</form>
			</div>
		</div>

		<div class="mt-12 text-black text-lg font-bold">
			POWERED BY UNDANGAN
		</div>
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

			cover.style.transition = "transform 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55), opacity 0.8s";
			cover.style.transform = "translateY(-100%) rotate(-5deg)";
			cover.style.opacity = "0";

			setTimeout(() => {
				cover.style.display = 'none';
				main.classList.remove('hidden');
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

		// Countdown Timer
		const eventDate = new Date("{{ $event->event_date }}").getTime();

		function updateTimer() {
			const now = new Date().getTime();
			const distance = eventDate - now;

			const days = Math.floor(distance / (1000 * 60 * 60 * 24));
			const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			const seconds = Math.floor((distance % (1000 * 60)) / 1000);

			if (document.getElementById("c-days")) {
				document.getElementById("c-days").innerText = days < 10 ? '0' + days : days;
				document.getElementById("c-hours").innerText = hours < 10 ? '0' + hours : hours;
				document.getElementById("c-minutes").innerText = minutes < 10 ? '0' + minutes : minutes;
				document.getElementById("c-seconds").innerText = seconds < 10 ? '0' + seconds : seconds;
			}
		}
		setInterval(updateTimer, 1000);
		updateTimer();

		// AJAX RSVP
		document.getElementById('rsvp-form').addEventListener('submit', function(e) {
			e.preventDefault();
			const form = this;
			const btn = form.querySelector('button[type="submit"]');
			const originalText = btn.innerText;
			btn.innerText = 'TRANSMITTING...';
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
						alert('hq received your report, agent!');
						form.reset();
					} else {
						alert('Transmission failed. Retry!');
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('Signal lost.');
				})
				.finally(() => {
					btn.innerText = originalText;
					btn.disabled = false;
				});
		});
	</script>
@endsection
