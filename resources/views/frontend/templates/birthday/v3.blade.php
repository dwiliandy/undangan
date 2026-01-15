@extends('layouts.frontend', ['hideNav' => true])

@section('title', $event->title)

@section('content')
	<!-- AOS CSS -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

	<style>
		.open-btn-animate {
			animation: pulse 2s infinite;
		}

		.spin {
			animation: spin 8s linear infinite;
		}

		@keyframes pulse {
			0% {
				transform: scale(1);
				box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7);
			}

			70% {
				transform: scale(1.05);
				box-shadow: 0 0 0 10px rgba(22, 163, 74, 0);
			}

			100% {
				transform: scale(1);
				box-shadow: 0 0 0 0 rgba(22, 163, 74, 0);
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
		class="fixed bottom-6 right-6 z-50 bg-green-600 text-white p-4 rounded-full shadow-2xl hidden hover:bg-green-700 transition"
		onclick="toggleMusic()">
		<i class="fas fa-compact-disc spin text-xl" id="music-icon"></i>
	</button>

	<!-- COVER SECTION -->
	<div id="cover" class="fixed inset-0 z-50 bg-green-50 flex flex-col justify-center items-center text-center p-6">
		<div class="mb-8 animate__animated animate__bounceIn">
			@if (isset($event->birthdayEvent->photo))
				<div class="w-40 h-40 rounded-full border-4 border-green-300 overflow-hidden mx-auto shadow-lg">
					<img src="{{ Storage::url($event->birthdayEvent->photo) }}" class="w-full h-full object-cover">
				</div>
			@else
				<span class="text-6xl">🌿</span>
			@endif
		</div>

		<p class="text-green-600 uppercase tracking-widest mb-4">You Are Invited To</p>

		<h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-2">
			{{ $event->birthdayEvent->person_name ?? 'Birthday Kid' }}
		</h1>

		@if (isset($event->birthdayEvent->age))
			<p class="text-2xl text-green-600 font-bold mb-8">Is Turning {{ $event->birthdayEvent->age }}!</p>
		@endif

		<!-- Countdown -->
		<div class="flex space-x-4 text-center mb-10">
			<div class="bg-white p-3 rounded shadow-sm w-20">
				<span id="c-days" class="text-2xl font-bold block text-green-600">00</span>
				<span class="text-xs uppercase text-gray-400">Days</span>
			</div>
			<div class="bg-white p-3 rounded shadow-sm w-20">
				<span id="c-hours" class="text-2xl font-bold block text-green-600">00</span>
				<span class="text-xs uppercase text-gray-400">Hrs</span>
			</div>
			<div class="bg-white p-3 rounded shadow-sm w-20">
				<span id="c-minutes" class="text-2xl font-bold block text-green-600">00</span>
				<span class="text-xs uppercase text-gray-400">Min</span>
			</div>
			<div class="bg-white p-3 rounded shadow-sm w-20">
				<span id="c-seconds" class="text-2xl font-bold block text-green-600">00</span>
				<span class="text-xs uppercase text-gray-400">Sec</span>
			</div>
		</div>

		@if (isset($invitation))
			<div class="mb-8">
				<p class="text-sm text-gray-500">Special Invitation For:</p>
				<h3 class="text-xl font-bold">{{ $invitation->guest_name }}</h3>
			</div>
		@endif

		<button id="open-invitation"
			class="bg-green-600 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-green-700 transition transform hover:scale-105 open-btn-animate">
			Open Invitation
		</button>
	</div>

	<!-- MAIN CONTENT (Hidden initially) -->
	<div id="main-content"
		class="hidden min-h-screen bg-green-100 flex flex-col items-center justify-center p-4 text-center pb-20">
		<div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full" data-aos="zoom-in">
			<h1 class="text-4xl font-bold text-green-600 mb-2">Nature Birthday</h1>
			<p class="text-gray-500 uppercase tracking-widest mb-6">Garden Party</p>

			<div class="mb-6">
				@if (isset($event->birthdayEvent->photo))
					<div class="w-48 h-48 rounded-full border-4 border-green-100 overflow-hidden mx-auto shadow-md mb-4">
						<img src="{{ Storage::url($event->birthdayEvent->photo) }}" class="w-full h-full object-cover">
					</div>
				@else
					<div class="w-32 h-32 bg-green-50 rounded-full mx-auto flex items-center justify-center overflow-hidden mb-4">
						<span class="text-4xl">🍃</span>
					</div>
				@endif
				<h2 class="text-3xl font-bold text-gray-800">{{ $event->birthdayEvent->person_name ?? 'Birthday Kid' }}</h2>
				@if (isset($event->birthdayEvent->age))
					<p class="text-xl text-green-500 font-bold">Turning {{ $event->birthdayEvent->age }}</p>
				@endif
			</div>

			<div class="border-t border-b border-gray-200 py-4 mb-6">
				<p class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($event->event_date)->format('l, d F Y') }}</p>

				@if (isset($event->eventLocations) && $event->eventLocations->count() > 0)
					<div class="mt-4">
						@foreach ($event->eventLocations as $loc)
							<div class="mb-2">
								<p class="font-bold">{{ $loc->name }}</p>
								<p class="text-sm text-gray-500">{{ $loc->address }}</p>
								<p class="text-sm font-bold text-green-500">{{ \Carbon\Carbon::parse($loc->event_time)->format('H:i') }}</p>
								@if ($loc->google_maps_url)
									<a href="{{ $loc->google_maps_url }}" target="_blank" class="text-xs text-green-500 underline">View Map</a>
								@endif
							</div>
						@endforeach
					</div>
				@endif
			</div>

			<div class="mb-8">
				<p class="text-gray-600 mb-4">"A breath of fresh air and lots of fun!"</p>
			</div>

			<form id="rsvp-form" action="{{ route('frontend.rsvp', [$event->slug, $invitation->slug]) }}" method="POST"
				class="bg-green-50 p-4 rounded text-left">
				@csrf
				<h3 class="font-bold text-green-600 mb-3">RSVP</h3>
				<div class="mb-3">
					<input type="text" name="name" value="{{ $invitation->guest_name }}"
						class="w-full border rounded p-2 text-sm" placeholder="Your Name">
				</div>
				<div class="mb-3">
					<select name="status" class="w-full border rounded p-2 text-sm">
						<option value="yes">Yes, I'm In</option>
						<option value="no">No, I Can't</option>
					</select>
				</div>
				<div class="mb-3">
					<textarea name="message" class="w-full border rounded p-2 text-sm" placeholder="Wishes..."></textarea>
				</div>
				<button type="submit"
					class="w-full bg-green-600 text-white font-bold py-2 rounded hover:bg-green-700 text-sm">Send</button>
			</form>
		</div>

		<div class="mt-8 text-sm text-gray-500">
			Created with Undangan
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

			cover.style.transition = "transform 0.8s ease-in-out, opacity 0.8s";
			cover.style.transform = "translateY(-100%)";
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
			btn.innerText = 'Sending...';
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
						alert('Thank you! Your RSVP has been sent.');
						form.reset();
					} else {
						alert('Something went wrong. Please try again.');
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('Error submitting form.');
				})
				.finally(() => {
					btn.innerText = originalText;
					btn.disabled = false;
				});
		});
	</script>
@endsection
