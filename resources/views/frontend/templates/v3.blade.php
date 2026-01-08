@extends('layouts.frontend', ['hideNav' => true])

@section('title', $event->title)

@section('content')
	<!-- AOS -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<!-- Fonts -->
	<link
		href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&display=swap"
		rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

	<style>
		.font-cinzel {
			font-family: 'Cinzel', serif;
		}

		.font-serif {
			font-family: 'Cormorant Garamond', serif;
		}

		.text-gold {
			color: #d4af37;
			background: -webkit-linear-gradient(#f4d07c, #cba353);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
		}

		.bg-gold {
			background: linear-gradient(to right, #9d7c3c, #f4d07c, #9d7c3c);
		}

		.border-gold {
			border-color: #9d7c3c;
		}

		#main-content {
			display: none;
		}

		.open-btn-animate {
			animation: pulse 3s infinite;
		}

		.spin {
			animation: spin 8s linear infinite;
		}

		@keyframes pulse {
			0% {
				box-shadow: 0 0 0 0 rgba(244, 208, 124, 0.4);
			}

			70% {
				box-shadow: 0 0 0 10px rgba(244, 208, 124, 0);
			}

			100% {
				box-shadow: 0 0 0 0 rgba(244, 208, 124, 0);
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
		class="fixed bottom-6 right-6 z-50 bg-[#111] border border-[#9d7c3c] text-[#d4af37] p-4 rounded-full shadow-2xl hidden hover:bg-[#222] transition"
		onclick="toggleMusic()">
		<i class="fas fa-compact-disc spin text-xl" id="music-icon"></i>
	</button>

	<!-- Cover Section -->
	<!-- Cover Section -->
	<div id="cover"
		class="fixed inset-0 z-50 bg-[#050505] flex flex-col justify-center items-center text-center p-6 bg-cover bg-center overflow-y-auto">
		<div
			class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] pointer-events-none">
		</div>

		<div class="relative z-10 border border-gold p-8 md:p-12 max-w-md w-full m-auto bg-black/80 backdrop-blur-sm">
			<h4 class="text-gold tracking-[0.3em] uppercase text-xs mb-4" data-aos="fade-down">Save The Date</h4>
			<div class="absolute -top-1 -left-1 w-2 h-2 border-t border-l border-[#9d7c3c]"></div>
			<div class="absolute -top-1 -right-1 w-2 h-2 border-t border-r border-[#9d7c3c]"></div>
			<div class="absolute -bottom-1 -left-1 w-2 h-2 border-b border-l border-[#9d7c3c]"></div>
			<div class="absolute -bottom-1 -right-1 w-2 h-2 border-b border-r border-[#9d7c3c]"></div>

			<p class="text-[#666] text-[10px] uppercase tracking-widest mb-2">Special Invitation For</p>
			<h2 class="text-xl font-serif text-[#e0e0e0]">{{ $invitation->guest_name }}</h2>
			@if ($invitation->guest_address)
				<p class="text-[#9d7c3c] text-[10px] uppercase tracking-widest mt-2">{{ $invitation->guest_address }}</p>
			@endif
		</div>

		<!-- Countdown Cover -->
		<div class="flex space-x-4 mb-10 text-[#f4d07c] relative z-20 mt-8">
			<div class="text-center"><span id="c-days" class="text-xl font-cinzel block">00</span><span
					class="text-[9px] uppercase text-[#666]">Days</span></div>
			<div class="text-center"><span id="c-hours" class="text-xl font-cinzel block">00</span><span
					class="text-[9px] uppercase text-[#666]">Hrs</span></div>
			<div class="text-center"><span id="c-minutes" class="text-xl font-cinzel block">00</span><span
					class="text-[9px] uppercase text-[#666]">Min</span></div>
			<div class="text-center"><span id="c-seconds" class="text-xl font-cinzel block">00</span><span
					class="text-[9px] uppercase text-[#666]">Sec</span></div>
		</div>

		<button id="open-invitation"
			class="relative z-50 px-10 py-3 bg-gradient-to-r from-[#9d7c3c] to-[#7a5e2a] text-[#111] font-bold text-xs uppercase tracking-[0.2em] hover:brightness-110 transition open-btn-animate shadow-lg cursor-pointer">
			Open Invitation
		</button>
	</div>

	<div id="main-content" class="min-h-screen bg-[#0f0f0f] text-[#e0e0e0] font-serif overflow-x-hidden">

		<div class="max-w-xl mx-auto min-h-screen flex flex-col relative border-x border-[#333] shadow-2xl bg-[#111]">

			<!-- Ornament Top -->
			<div class="h-1 bg-gold"></div>

			<main class="flex-grow flex flex-col items-center p-0 text-center relative z-10 pb-20">

				<!-- Hero -->
				<section class="py-20 w-full px-8">
					<p class="text-[#9d7c3c] text-xs uppercase tracking-[0.3em] mb-6" data-aos="fade-down">The Wedding Of</p>
					<h1 class="text-4xl md:text-5xl font-cinzel text-gold mb-8 leading-snug" data-aos="zoom-in">
						{{ $event->weddingEvent->groom_name ?? 'Groom' }} <br> <span
							class="text-3xl text-[#555] font-serif italic my-2 block">&</span>
						{{ $event->weddingEvent->bride_name ?? 'Bride' }}
					</h1>
					<p class="text-[#666] text-sm max-w-xs mx-auto mb-10" data-aos="fade-up">
						With joyful hearts we ask you to be present at our wedding ceremony
					</p>
				</section>

				<!-- Profile -->
				<section class="w-full bg-[#161616] py-16 px-8 border-y border-[#333]">
					<div class="space-y-12">
						<div data-aos="fade-right">
							<div class="w-24 h-24 rounded-full border border-[#9d7c3c] p-1 mx-auto mb-4">
								<img
									src="{{ isset($event->weddingEvent->groom_photo) ? (Str::startsWith($event->weddingEvent->groom_photo, 'http') ? $event->weddingEvent->groom_photo : Storage::url($event->weddingEvent->groom_photo)) : 'https://via.placeholder.com/150' }}"
									class="w-full h-full rounded-full object-cover">
							</div>
							<h3 class="text-xl font-cinzel text-gold">{{ $event->weddingEvent->groom_name ?? 'The Groom' }}</h3>
							<p class="text-[10px] uppercase text-[#666] tracking-widest mt-1">Son of
								{{ $event->weddingEvent->groom_parent ?? 'Unknown' }}</p>
							<div class="mt-4 flex justify-center text-[#d4af37]">
								@if ($event->weddingEvent->groom_instagram)
									<a href="https://instagram.com/{{ $event->weddingEvent->groom_instagram }}" target="_blank"
										class="hover:text-white transition"><i class="fab fa-instagram"></i></a>
								@endif
							</div>
						</div>
						<div class="w-px h-10 bg-[#333] mx-auto"></div>
						<div data-aos="fade-left">
							<div class="w-24 h-24 rounded-full border border-[#9d7c3c] p-1 mx-auto mb-4">
								<img
									src="{{ isset($event->weddingEvent->bride_photo) ? (Str::startsWith($event->weddingEvent->bride_photo, 'http') ? $event->weddingEvent->bride_photo : Storage::url($event->weddingEvent->bride_photo)) : 'https://via.placeholder.com/150' }}"
									class="w-full h-full rounded-full object-cover">
							</div>
							<h3 class="text-xl font-cinzel text-gold">{{ $event->weddingEvent->bride_name ?? 'The Bride' }}</h3>
							<p class="text-[10px] uppercase text-[#666] tracking-widest mt-1">Daughter of
								{{ $event->weddingEvent->bride_parent ?? 'Unknown' }}</p>
							<div class="mt-4 flex justify-center text-[#d4af37]">
								@if ($event->weddingEvent->bride_instagram)
									<a href="https://instagram.com/{{ $event->weddingEvent->bride_instagram }}" target="_blank"
										class="hover:text-white transition"><i class="fab fa-instagram"></i></a>
								@endif
							</div>
						</div>
					</div>
				</section>

				<!-- Love Story -->
				@if (isset($event->eventJourneys) && count($event->eventJourneys) > 0)
					<section class="py-16 px-8 w-full">
						<h2 class="text-2xl font-cinzel text-gold mb-10" data-aos="fade-up">Our Journey</h2>
						<div class="space-y-8 border-l border-[#333] ml-4 pl-8 text-left">
							@foreach ($event->eventJourneys as $story)
								<div class="relative" data-aos="fade-up">
									<div class="absolute -left-[37px] top-1 w-2 h-2 bg-[#9d7c3c] rotate-45"></div>
									<span class="text-[#9d7c3c] text-xs font-bold">
										{{ $story->journey_date ? (is_object($story->journey_date) ? $story->journey_date->format('Y') : \Carbon\Carbon::parse($story->journey_date)->format('Y')) : '' }}
									</span>
									<h4 class="text-lg text-[#e0e0e0] font-cinzel">{{ $story->title }}</h4>
									<p class="text-sm text-[#666] mt-1">{{ $story->description }}</p>
								</div>
							@endforeach
						</div>
					</section>
				@endif

				<!-- Events List -->
				<section class="py-16 px-8 w-full bg-[#161616] border-y border-[#333]">
					<h2 class="text-2xl font-cinzel text-gold mb-12" data-aos="fade-up">Save The Date</h2>
					<div class="space-y-8">
						@if (isset($event->eventLocations))
							@foreach ($event->eventLocations as $location)
								<div class="border border-[#333] p-8 bg-[#111] hover:border-[#9d7c3c] transition duration-500"
									data-aos="flip-up">
									<h3 class="text-[#9d7c3c] uppercase text-xs tracking-[0.2em] mb-4">{{ $location->location_type }}</h3>
									<p class="text-3xl text-white font-cinzel mb-2">
										{{ \Carbon\Carbon::parse($location->event_time)->format('h:i A') }}</p>
									<p class="text-[#888] text-sm font-bold mb-4">{{ $location->name }}</p>
									<p class="text-[#666] text-xs mb-6">{{ $location->address }}</p>
									@if ($location->google_maps_url)
										<a href="{{ $location->google_maps_url }}" target="_blank"
											class="text-[10px] uppercase tracking-widest text-[#9d7c3c] border-b border-[#9d7c3c] pb-1 hover:text-white hover:border-white transition">View
											Location</a>
									@endif
								</div>
							@endforeach
						@endif
					</div>
				</section>

				<!-- Gallery -->
				@if (isset($event->eventGalleries))
					<section class="w-full">
						<div class="grid grid-cols-2">
							@foreach ($event->eventGalleries as $photo)
								<div class="aspect-square grayscale hover:grayscale-0 transition duration-700" data-aos="fade-in">
									<img
										src="{{ Str::startsWith($photo->image_path, 'http') ? $photo->image_path : Storage::url($photo->image_path) }}"
										class="w-full h-full object-cover">
								</div>
							@endforeach
						</div>
					</section>
				@endif

				<!-- Gift & RSVP -->
				<section class="py-16 px-8 w-full">
					<!-- Gift -->
					@if (isset($event->eventBanks))
						<div class="mb-16" data-aos="fade-up">
							<h2 class="text-2xl font-cinzel text-gold mb-8">Wedding Gift</h2>
							<div class="space-y-4">
								@foreach ($event->eventBanks as $angpao)
									<div class="border border-[#333] p-6 rounded bg-[#161616]">
										<p class="text-[#9d7c3c] font-cinzel mb-2">{{ $angpao->bank_name }}</p>
										<p class="text-xl text-white font-serif mb-1 select-all" id="acc-{{ $loop->index }}">
											{{ $angpao->account_number }}</p>
										<p class="text-xs text-[#666] uppercase mb-4">{{ $angpao->account_name }}</p>
										<button onclick="copyToClipboard('acc-{{ $loop->index }}')"
											class="text-[10px] bg-[#333] text-[#aaa] px-3 py-1 rounded hover:bg-[#444] transition">Copy</button>
									</div>
								@endforeach
							</div>
						</div>
					@endif

					<!-- RSVP -->
					<div class="w-full border-t border-[#333] pt-12" data-aos="fade-up">
						<h3 class="text-gold font-cinzel mb-6">RSVP</h3>
						<form id="rsvp-form" action="{{ route('frontend.rsvp', [$event->slug, $invitation->slug]) }}" method="POST"
							class="space-y-6 text-left max-w-sm mx-auto">
							@csrf
							<input type="text"
								class="w-full bg-[#111] border-b border-[#333] text-[#e0e0e0] py-2 px-2 focus:outline-none focus:border-[#d4af37] text-sm"
								placeholder="Name" value="{{ $invitation->guest_name ?? '' }}" readonly>
							<select name="status"
								class="w-full bg-[#111] border-b border-[#333] text-[#e0e0e0] py-2 px-2 focus:outline-none focus:border-[#d4af37] text-sm">
								<option value="yes">Will Attend</option>
								<option value="no">Cannot Attend</option>
							</select>
							<select name="total_guest"
								class="w-full bg-[#111] border-b border-[#333] text-[#e0e0e0] py-2 px-2 focus:outline-none focus:border-[#d4af37] text-sm">
								<option value="1">1 Person</option>
								<option value="2">2 Persons</option>
							</select>
							<textarea name="message"
							 class="w-full bg-[#111] border-b border-[#333] text-[#e0e0e0] py-2 px-2 focus:outline-none focus:border-[#d4af37] text-sm h-20"
							 placeholder="Wishes"></textarea>
							<button type="submit"
								class="w-full border border-[#9d7c3c] text-[#9d7c3c] hover:bg-[#9d7c3c] hover:text-[#111] transition py-3 text-xs uppercase tracking-widest mt-4">
								Confirm Attendance
							</button>
						</form>
					</div>
				</section>

				<!-- Wishes List -->
				<!-- Wishes List -->
				<section class="w-full py-16 px-8 bg-[#161616] border-t border-[#333]" id="wishes-section">
					<h2 class="text-2xl font-cinzel text-gold mb-10" data-aos="fade-up">Wishes</h2>
					<div id="wishes-container" class="space-y-4 max-h-80 overflow-y-auto hide-scroll text-left">
						@if (isset($wishes))
							@foreach ($wishes as $wish)
								<div class="p-4 border border-[#333] bg-[#111]" data-aos="fade-up">
									<div class="flex justify-between items-baseline mb-2">
										<span class="text-[#d4af37] font-bold text-sm">{{ $wish->name }}</span>
										<span class="text-[10px] text-[#555]">{{ $wish->created_at->diffForHumans() }}</span>
									</div>
									<p class="text-xs text-[#888] italic">"{{ $wish->message }}"</p>
								</div>
							@endforeach
						@endif
					</div>
				</section>

			</main>

			<!-- Footer -->
			<footer class="py-10 bg-[#111] text-center border-t border-[#333]">
				<p class="text-[#666] text-[10px] uppercase tracking-widest">&copy; {{ date('Y') }} UndanganKita. All Rights
					Reserved.</p>
			</footer>

			<!-- Ornament Bottom -->
			<div class="h-1 bg-gold"></div>
		</div>
	</div>

	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		// Open Invitation Logic
		document.getElementById('open-invitation').addEventListener('click', function() {
			const cover = document.getElementById('cover');
			const main = document.getElementById('main-content');

			// Play Music
			toggleMusic(true);
			document.getElementById('music-control').classList.remove('hidden');

			cover.style.transition = "opacity 0.8s ease-out";
			cover.style.opacity = "0";

			setTimeout(() => {
				cover.style.display = 'none';
				main.style.display = 'block';
				AOS.init();
			}, 800);
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

						// Add wish if present
						if (data.wish) {
							const container = document.getElementById('wishes-container');
							const section = document.getElementById('wishes-section');
							section.style.display = 'block';

							const html = `
                            <div class="p-4 border border-[#333] bg-[#111]" data-aos="fade-up">
                                <div class="flex justify-between items-baseline mb-2">
                                    <span class="text-[#d4af37] font-bold text-sm">${data.wish.name}</span>
                                    <span class="text-[10px] text-[#555]">${data.wish.created_at_human}</span>
                                </div>
                                <p class="text-xs text-[#888] italic">"${data.wish.message}"</p>
                            </div>
                        `;
							container.insertAdjacentHTML('afterbegin', html);
						}
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
