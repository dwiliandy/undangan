@extends('layouts.frontend', ['hideNav' => true])

@section('title', $event->title)

@section('content')
	<!-- AOS -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

	<style>
		.font-game {
			font-family: 'Press Start 2P', cursive;
		}

		.text-neon-green {
			color: #0f0;
			text-shadow: 0 0 5px #0f0, 0 0 10px #0f0;
		}

		.text-neon-pink {
			color: #f0f;
			text-shadow: 0 0 5px #f0f;
		}

		.bg-game-dark {
			background-color: #050505;
			background-image:
				linear-gradient(rgba(0, 255, 0, 0.03) 1px, transparent 1px),
				linear-gradient(90deg, rgba(0, 255, 0, 0.03) 1px, transparent 1px);
			background-size: 20px 20px;
		}

		.border-pixel {
			box-shadow:
				-4px 0 0 0 white,
				4px 0 0 0 white,
				0 -4px 0 0 white,
				0 4px 0 0 white;
			margin: 4px;
		}

		.btn-pixel {
			box-shadow: inset 4px 4px 0px 4px rgba(255, 255, 255, 0.2),
				inset -4px -4px 0px 4px rgba(0, 0, 0, 0.2);
			image-rendering: pixelated;
		}

		.btn-pixel:active {
			box-shadow: inset 4px 4px 0px 4px rgba(0, 0, 0, 0.5);
			transform: translateY(2px);
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

		/* Glitch Effect */
		.glitch {
			position: relative;
		}

		.glitch::before,
		.glitch::after {
			content: attr(data-text);
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		}

		.glitch::before {
			left: 2px;
			text-shadow: -1px 0 #f0f;
			clip: rect(44px, 450px, 56px, 0);
			animation: glitch-anim 5s infinite linear alternate-reverse;
		}

		.glitch::after {
			left: -2px;
			text-shadow: -1px 0 #0f0;
			clip: rect(44px, 450px, 56px, 0);
			animation: glitch-anim2 5s infinite linear alternate-reverse;
		}

		@keyframes glitch-anim {
			0% {
				clip: rect(31px, 9999px, 11px, 0);
			}

			50% {
				clip: rect(54px, 9999px, 86px, 0);
			}

			100% {
				clip: rect(2px, 9999px, 10px, 0);
			}
		}

		@keyframes glitch-anim2 {
			0% {
				clip: rect(87px, 9999px, 20px, 0);
			}

			50% {
				clip: rect(2px, 9999px, 91px, 0);
			}

			100% {
				clip: rect(55px, 9999px, 9px, 0);
			}
		}
	</style>

	<!-- Audio Control -->
	<!-- 8-bit Wedding March ideally -->
	<audio id="bg-music" loop>
		<source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3" type="audio/mpeg">
	</audio>
	<button id="music-control"
		class="fixed bottom-6 right-6 z-50 bg-black border-2 border-[#0f0] text-[#0f0] p-3 shadow-2xl hidden hover:bg-[#111] transition font-game text-xs"
		onclick="toggleMusic()">
		<i class="fas fa-compact-disc spin text-lg mr-2" id="music-icon"></i> MUSIC: OFF
	</button>

	<!-- Cover Section -->
	<div id="cover"
		class="fixed inset-0 z-50 bg-black flex flex-col justify-center items-center text-center p-8 overflow-y-auto font-game text-white scrollbar-hide">
		<div class="m-auto w-full max-w-lg">
			<div class="mb-10 animate-pulse text-neon-green text-[10px] md:text-sm">LOADING NEW GAME...</div>

			<h1 class="text-2xl md:text-4xl text-white mb-8 leading-snug glitch"
				data-text="{{ $event->weddingEvent->groom_name }} & {{ $event->weddingEvent->bride_name }}">
				{{ $event->weddingEvent->groom_name ?? 'Groom' }} <br> <span class="text-neon-pink text-xl">&</span> <br>
				{{ $event->weddingEvent->bride_name ?? 'Bride' }}
			</h1>

			@if (isset($invitation))
				<div class="border-4 border-white p-6 w-full max-w-sm mb-10 bg-[#111]">
					<p class="text-[#0f0] text-[8px] mb-4">PLAYER INVITED:</p>
					<h2 class="text-lg text-white" style="line-height: 1.5;">{{ $invitation->guest_name }}</h2>
					@if ($invitation->guest_address)
						<p class="text-[#f0f] text-[8px] mt-4">LOCATION: {{ $invitation->guest_address }}</p>
					@endif
				</div>
			@endif

			<!-- Countdown Cover -->
			<div class="flex space-x-4 mb-12 text-[#0f0] text-[10px] md:text-xs">
				<div class="text-center bg-[#111] p-2 border border-[#0f0]">
					<span id="c-days" class="block text-lg mb-1">00</span> DAYS
				</div>
				<div class="text-center bg-[#111] p-2 border border-[#0f0]">
					<span id="c-hours" class="block text-lg mb-1">00</span> HRS
				</div>
				<div class="text-center bg-[#111] p-2 border border-[#0f0]">
					<span id="c-minutes" class="block text-lg mb-1">00</span> MIN
				</div>
				<div class="text-center bg-[#111] p-2 border border-[#0f0]">
					<span id="c-seconds" class="block text-lg mb-1">00</span> SEC
				</div>
			</div>

			<button id="open-invitation"
				class="bg-[#0f0] text-black border-4 border-white px-6 py-4 font-bold text-xs hover:scale-110 transition btn-pixel animate-bounce">
				PRESS START
			</button>
		</div>

		<div id="main-content" class="min-h-screen bg-game-dark text-white font-game overflow-x-hidden">

			<div class="max-w-xl mx-auto min-h-screen flex flex-col relative border-x-4 border-[#222] shadow-2xl bg-[#0a0a0a]">

				<main class="flex-grow flex flex-col items-center p-0 text-center relative z-10 pb-20">

					<!-- Hero -->
					<!-- Pixel Art Heart could be here -->
					<section class="py-20 w-full px-4">
						<div class="text-neon-pink text-[10px] mb-6 animate-pulse" data-aos="fade-down">QUEST: THE WEDDING</div>
						<h1 class="text-2xl md:text-3xl text-white mb-2 leading-loose" data-aos="zoom-in">
							{{ $event->weddingEvent->groom_name ?? 'Groom' }}
						</h1>
						<div class="text-4xl text-neon-green my-2">&</div>
						<h1 class="text-2xl md:text-3xl text-white mb-8 leading-loose" data-aos="zoom-in">
							{{ $event->weddingEvent->bride_name ?? 'Bride' }}
						</h1>
						<p class="text-gray-400 text-[8px] max-w-xs mx-auto mb-10 leading-loose" data-aos="fade-up">
							Accept this quest to join us in our co-op adventure.
						</p>
					</section>

					<!-- Profile -->
					<section class="w-full bg-[#111] py-16 px-4 border-y-4 border-[#222]">
						<div class="space-y-16">
							<div data-aos="fade-right">
								<div class="w-32 h-32 mx-auto mb-6 relative">
									<div class="absolute inset-0 border-4 border-[#0f0]"></div>
									<img
										src="{{ isset($event->weddingEvent->groom_photo) ? (Str::startsWith($event->weddingEvent->groom_photo, 'http') ? $event->weddingEvent->groom_photo : Storage::url($event->weddingEvent->groom_photo)) : 'https://via.placeholder.com/150' }}"
										class="w-full h-full object-cover grayscale brightness-75">
								</div>
								<h3 class="text-sm text-neon-green mb-2">PLAYER 1</h3>
								<h2 class="text-lg">{{ $event->weddingEvent->groom_name ?? 'The Groom' }}</h2>
								<p class="text-[8px] text-gray-500 mt-2 leading-relaxed">Spawned by: <br>
									{{ $event->weddingEvent->groom_parent ?? 'Unknown' }}</p>
								@if ($event->weddingEvent->groom_instagram)
									<a href="https://instagram.com/{{ $event->weddingEvent->groom_instagram }}" target="_blank"
										class="inline-block mt-4 text-[#0f0] hover:text-white"><i class="fab fa-instagram text-xl"></i></a>
								@endif
							</div>

							<div class="text-2xl text-neon-pink animate-pulse">VS</div>

							<div data-aos="fade-left">
								<div class="w-32 h-32 mx-auto mb-6 relative">
									<div class="absolute inset-0 border-4 border-[#f0f]"></div>
									<img
										src="{{ isset($event->weddingEvent->bride_photo) ? (Str::startsWith($event->weddingEvent->bride_photo, 'http') ? $event->weddingEvent->bride_photo : Storage::url($event->weddingEvent->bride_photo)) : 'https://via.placeholder.com/150' }}"
										class="w-full h-full object-cover grayscale brightness-75">
								</div>
								<h3 class="text-sm text-neon-pink mb-2">PLAYER 2</h3>
								<h2 class="text-lg">{{ $event->weddingEvent->bride_name ?? 'The Bride' }}</h2>
								<p class="text-[8px] text-gray-500 mt-2 leading-relaxed">Spawned by: <br>
									{{ $event->weddingEvent->bride_parent ?? 'Unknown' }}</p>
								@if ($event->weddingEvent->bride_instagram)
									<a href="https://instagram.com/{{ $event->weddingEvent->bride_instagram }}" target="_blank"
										class="inline-block mt-4 text-[#f0f] hover:text-white"><i class="fab fa-instagram text-xl"></i></a>
								@endif
							</div>
						</div>
					</section>

					<!-- Love Story -->
					@if (isset($event->eventJourneys) && count($event->eventJourneys) > 0)
						<section class="py-16 px-4 w-full">
							<h2 class="text-sm text-neon-green mb-10 border-b-2 border-[#0f0] inline-block pb-2" data-aos="fade-up">QUEST LOG
							</h2>
							<div class="space-y-8 text-left max-w-xs mx-auto">
								@foreach ($event->eventJourneys as $story)
									<div class="relative bg-[#111] p-4 border-l-4 border-[#0f0]" data-aos="fade-up">
										<span class="text-[#0f0] text-[8px] block mb-2">
											>>
											{{ $story->journey_date ? (is_object($story->journey_date) ? $story->journey_date->format('Y') : \Carbon\Carbon::parse($story->journey_date)->format('Y')) : '' }}
										</span>
										<h4 class="text-xs text-white mb-2">{{ $story->title }}</h4>
										<p class="text-[8px] text-gray-400 leading-relaxed">{{ $story->description }}</p>
									</div>
								@endforeach
							</div>
						</section>
					@endif

					<!-- Events List -->
					<section class="py-16 px-4 w-full bg-[#111] border-y-4 border-[#222]">
						<h2 class="text-sm text-neon-pink mb-12 border-b-2 border-[#f0f] inline-block pb-2" data-aos="fade-up">LEVELS</h2>
						<div class="space-y-8">
							@if (isset($event->eventLocations))
								@foreach ($event->eventLocations as $location)
									<div class="border-2 border-white p-6 bg-black hover:bg-[#111] transition" data-aos="flip-up">
										<h3 class="text-[#f0f] text-[8px] mb-4">>> {{ strtoupper($location->location_type) }}</h3>
										<p class="text-lg text-white mb-2 blink">
											{{ \Carbon\Carbon::parse($location->event_time)->format('H:i') }}
										</p>
										<p class="text-[#0f0] text-xs mb-4">{{ $location->name }}</p>
										<p class="text-gray-400 text-[8px] mb-6 leading-relaxed">{{ $location->address }}</p>
										@if ($location->google_maps_url)
											<a href="{{ $location->google_maps_url }}" target="_blank"
												class="text-[8px] bg-white text-black px-4 py-2 hover:bg-[#0f0] hover:text-black transition uppercase">
												MAP TRAJECTORY
											</a>
										@endif
									</div>
								@endforeach
							@endif
						</div>
					</section>

					<!-- Gallery -->
					@if (isset($event->eventGalleries))
						<section class="w-full py-16">
							<h2 class="text-sm text-white mb-10 border-b-2 border-white inline-block pb-2" data-aos="fade-up">SCREENSHOTS
							</h2>
							<div class="grid grid-cols-2 gap-2 px-2">
								@foreach ($event->eventGalleries as $photo)
									<div
										class="aspect-square grayscale hover:grayscale-0 transition duration-100 border-2 border-[#333] hover:border-[#0f0]"
										data-aos="fade-in">
										<img
											src="{{ Str::startsWith($photo->image_path, 'http') ? $photo->image_path : Storage::url($photo->image_path) }}"
											class="w-full h-full object-cover">
									</div>
								@endforeach
							</div>
						</section>
					@endif

					<!-- Gift & RSVP -->
					<section class="py-16 px-4 w-full">
						<!-- Gift -->
						@if (isset($event->eventBanks))
							<div class="mb-16" data-aos="fade-up">
								<h2 class="text-sm text-[#f0f] mb-8">LOOT BOX</h2>
								<div class="space-y-4">
									@foreach ($event->eventBanks as $angpao)
										<div class="border-2 border-dashed border-[#444] p-4 bg-[#0a0a0a]">
											<p class="text-[#0f0] mb-2 text-[10px]">{{ $angpao->bank_name }}</p>
											<p class="text-sm text-white mb-2 select-all tracking-widest" id="acc-{{ $loop->index }}">
												{{ $angpao->account_number }}</p>
											<p class="text-[8px] text-gray-500 mb-4">{{ $angpao->account_name }}</p>
											<button onclick="copyToClipboard('acc-{{ $loop->index }}')"
												class="text-[8px] bg-[#222] text-white px-3 py-1 border border-white hover:bg-white hover:text-black transition">COPY
												ID</button>
										</div>
									@endforeach
								</div>
							</div>
						@endif

						<!-- RSVP -->
						<div class="w-full border-t-4 border-[#222] pt-12" data-aos="fade-up">
							<h3 class="text-white text-sm mb-6 animate-pulse">>> CONFIRM SPAWN</h3>
							<form id="rsvp-form" action="{{ route('frontend.rsvp', [$event->slug, $invitation->slug]) }}" method="POST"
								class="space-y-6 text-left max-w-sm mx-auto">
								@csrf
								<div>
									<label class="text-[8px] text-[#0f0] block mb-2">PLAYER NAME</label>
									<input type="text"
										class="w-full bg-black border-2 border-[#333] text-white py-3 px-3 text-[10px] focus:outline-none focus:border-[#0f0] font-game"
										value="{{ $invitation->guest_name ?? '' }}" readonly>
								</div>

								<div>
									<label class="text-[8px] text-[#0f0] block mb-2">STATUS</label>
									<select name="status"
										class="w-full bg-black border-2 border-[#333] text-white py-3 px-3 text-[10px] focus:outline-none focus:border-[#0f0] font-game">
										<option value="yes">READY</option>
										<option value="no">AFK</option>
									</select>
								</div>

								<div>
									<label class="text-[8px] text-[#0f0] block mb-2">PARTY SIZE</label>
									<select name="total_guest"
										class="w-full bg-black border-2 border-[#333] text-white py-3 px-3 text-[10px] focus:outline-none focus:border-[#0f0] font-game">
										<option value="1">1 PLAYER</option>
										<option value="2">2 PLAYERS</option>
									</select>
								</div>

								<div>
									<label class="text-[8px] text-[#0f0] block mb-2">CHAT LOG</label>
									<textarea name="message"
									 class="w-full bg-black border-2 border-[#333] text-white py-3 px-3 text-[10px] focus:outline-none focus:border-[#0f0] font-game h-24"
									 placeholder="ENTER MESSAGE..."></textarea>
								</div>

								<button type="submit"
									class="w-full bg-[#0f0] text-black border-b-4 border-[#0a0] py-4 text-[10px] hover:translate-y-1 hover:border-b-0 transition mt-4 font-bold">
									SEND DATA
								</button>
							</form>
						</div>
					</section>

					<!-- Wishes List -->
					<section class="w-full py-16 px-4 bg-[#111] border-t-4 border-[#222]" id="wishes-section">
						<h2 class="text-sm text-[#0f0] mb-8" data-aos="fade-up">GLOBAL CHAT</h2>
						<div id="wishes-container" class="space-y-4 max-h-80 overflow-y-auto hide-scroll text-left">
							@if (isset($wishes))
								@foreach ($wishes as $wish)
									<div class="p-4 border-2 border-[#333] bg-black" data-aos="fade-up">
										<div class="flex justify-between items-baseline mb-2">
											<span class="text-[#f0f] text-[10px]">{{ $wish->name }}</span>
											<span class="text-[8px] text-gray-600">{{ $wish->created_at->diffForHumans() }}</span>
										</div>
										<p class="text-[8px] text-gray-300 leading-relaxed">"{{ $wish->message }}"</p>
									</div>
								@endforeach
							@endif
						</div>
					</section>

					</section>

				</main>

				<!-- Footer -->
				<footer class="py-10 bg-black text-center border-t-4 border-[#222]">
					<p class="text-[#0f0] text-[8px] font-game">&copy; {{ date('Y') }} UNDANGANKITA. GAME OVER.</p>
				</footer>

				<div class="h-2 bg-[#0f0] animate-pulse"></div>
			</div>
		</div>

		<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
		<script>
			// Open Invitation Logic
			document.getElementById('open-invitation').addEventListener('click', function() {
				const cover = document.getElementById('cover');
				const main = document.getElementById('main-content');
				const audio = document.getElementById('bg-music');
				const musicIcon = document.getElementById('music-icon');
				const musicBtn = document.getElementById('music-control');

				// Play Music
				audio.play().then(() => {
					isPlaying = true;
					musicBtn.classList.remove('hidden');
					musicBtn.innerHTML = '<i class="fas fa-compact-disc spin text-lg mr-2"></i> MUSIC: ON';
				}).catch(e => {
					console.log("Audio play failed (user interaction needed or blocked):", e);
					musicBtn.classList.remove('hidden');
				});

				cover.style.transition = "transform 0.5s steps(10)";
				cover.style.transform = "scaleY(0)";

				setTimeout(() => {
					cover.style.display = 'none';
					main.style.display = 'block';
					setTimeout(() => {
						AOS.init({
							duration: 0,
							easing: 'steps(4)'
						});
					}, 50);
				}, 500);
			});

			// Music Control
			const audio = document.getElementById('bg-music');
			const musicBtn = document.getElementById('music-control');
			let isPlaying = false;

			function toggleMusic() {
				if (!isPlaying) {
					audio.play();
					isPlaying = true;
					musicBtn.innerHTML = '<i class="fas fa-compact-disc spin text-lg mr-2"></i> MUSIC: ON';
					musicBtn.classList.add('text-[#0f0]', 'border-[#0f0]');
					musicBtn.classList.remove('text-gray-500', 'border-gray-500');
				} else {
					audio.pause();
					isPlaying = false;
					musicBtn.innerHTML = '<i class="fas fa-pause text-lg mr-2"></i> MUSIC: PAUSE';
					musicBtn.classList.remove('text-[#0f0]', 'border-[#0f0]');
					musicBtn.classList.add('text-gray-500', 'border-gray-500');
				}
			}

			function copyToClipboard(id) {
				const text = document.getElementById(id).innerText;
				navigator.clipboard.writeText(text).then(() => {
					alert('LOOT ID COPIED!');
				});
			}

			// Countdown
			const eventDate = new Date("{{ $event->event_date }}").getTime();

			function updateTimer() {
				const now = new Date().getTime();
				const distance = eventDate - now;

				const days = Math.max(0, Math.floor(distance / (1000 * 60 * 60 * 24)));
				const hours = Math.max(0, Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
				const minutes = Math.max(0, Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
				const seconds = Math.max(0, Math.floor((distance % (1000 * 60)) / 1000));

				if (document.getElementById("c-days")) {
					document.getElementById("c-days").innerText = days.toString().padStart(2, '0');
					document.getElementById("c-hours").innerText = hours.toString().padStart(2, '0');
					document.getElementById("c-minutes").innerText = minutes.toString().padStart(2, '0');
					document.getElementById("c-seconds").innerText = seconds.toString().padStart(2, '0');
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
							alert('DATA RECEIVED! GAME ON.');
							form.reset();

							if (data.wish) {
								const container = document.getElementById('wishes-container');
								const section = document.getElementById('wishes-section');
								section.style.display = 'block';

								const html = `
                            <div class="p-4 border-2 border-[#333] bg-black" data-aos="fade-up">
                                <div class="flex justify-between items-baseline mb-2">
                                    <span class="text-[#f0f] text-[10px]">${data.wish.name}</span>
                                    <span class="text-[8px] text-gray-600">${data.wish.created_at_human}</span>
                                </div>
                                <p class="text-[8px] text-gray-300 leading-relaxed">"${data.wish.message}"</p>
                            </div>
                        `;
								container.insertAdjacentHTML('afterbegin', html);
							}
						} else {
							alert('TRANSMISSION FAILED. RETRY?');
						}
					})
					.catch(error => {
						console.error('Error:', error);
						alert('ERROR IN SYSTEM.');
					})
					.finally(() => {
						btn.innerText = originalText;
						btn.disabled = false;
					});
			});
		</script>
	@endsection
