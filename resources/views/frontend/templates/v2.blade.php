@extends('layouts.frontend', ['hideNav' => true])

@section('title', $event->title)

@section('content')
	<!-- CSS Dependencies -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Nunito:wght@300;400;600;700&display=swap"
		rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

	<style>
		.font-cursive {
			font-family: 'Great Vibes', cursive;
		}

		.font-sans {
			font-family: 'Nunito', sans-serif;
		}

		#main-content {
			display: none;
		}

		.open-btn-animate {
			animation: bounce 2s infinite;
		}

		.spin {
			animation: spin 8s linear infinite;
		}

		@keyframes spin {
			100% {
				transform: rotate(360deg);
			}
		}

		@keyframes blob {
			0% {
				transform: translate(0px, 0px) scale(1);
			}

			33% {
				transform: translate(30px, -50px) scale(1.1);
			}

			66% {
				transform: translate(-20px, 20px) scale(0.9);
			}

			100% {
				transform: translate(0px, 0px) scale(1);
			}
		}

		.animate-blob {
			animation: blob 7s infinite;
		}

		.animation-delay-2000 {
			animation-delay: 2s;
		}

		.animation-delay-4000 {
			animation-delay: 4s;
		}

		/* Hide scrollbar for gallery */
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
		class="fixed bottom-4 right-4 z-50 bg-white/80 backdrop-blur p-3 rounded-full shadow-lg text-pink-500 hidden"
		onclick="toggleMusic()">
		<i class="fas fa-compact-disc spin" id="music-icon"></i>
	</button>

	<!-- Cover Section (Full Screen) -->
	<div id="cover"
		class="fixed inset-0 z-50 bg-dark-blue flex flex-col justify-center items-center text-center bg-cover bg-center overflow-y-auto"
		style="background-image: url('https://images.unsplash.com/photo-1511285560982-1351cdeb9821?auto=format&fit=crop&w=1920&q=80');">
		<div class="absolute inset-0 bg-black/60"></div>
		<!-- Floating Petals Decoration -->
		<div class="absolute top-10 left-10 text-pink-200 opacity-50"><i class="fas fa-heart fa-2x animate-bounce"></i></div>
		<div class="absolute bottom-10 right-10 text-purple-200 opacity-50"><i class="fas fa-heart fa-3x animate-pulse"></i>
		</div>

		<p class="text-pink-500 font-sans uppercase tracking-[0.2em] text-xs md:text-sm font-bold mb-4">
			The Wedding Of</p>

		<div class="relative mb-8">
			<div
				class="absolute -inset-4 bg-gradient-to-r from-pink-300 to-purple-300 rounded-full opacity-30 blur-lg animate-blob">
			</div>

			<h1 class="relative text-5xl md:text-7xl font-cursive text-gray-800 leading-tight">
				{{ $event->weddingEvent->groom_name ?? 'Groom' }} <br> <span class="text-3xl text-gray-400">&</span> <br>
				{{ $event->weddingEvent->bride_name ?? 'Bride' }}
			</h1>
		</div>

		@if (isset($invitation))
			<div class="bg-white/60 backdrop-blur-sm border border-pink-100 p-6 rounded-2xl w-full max-w-xs shadow-sm mb-8">
				<p class="text-gray-500 italic mb-2 font-sans text-sm">Hello,</p>
				<h2 class="text-2xl font-bold font-sans text-gray-800">{{ $invitation->guest_name }}</h2>
				@if ($invitation->guest_address)
					<p class="text-gray-400 text-xs mt-1">{{ $invitation->guest_address }}</p>
				@endif
			</div>
		@endif

		<!-- Countdown in Cover -->
		<div class="flex space-x-3 mb-8 text-gray-600">
			<div class="text-center"><span id="c-days" class="text-xl font-bold block">00</span><span
					class="text-[10px] uppercase">Days</span></div>
			<div class="text-center"><span id="c-hours" class="text-xl font-bold block">00</span><span
					class="text-[10px] uppercase">Hrs</span></div>
			<div class="text-center"><span id="c-minutes" class="text-xl font-bold block">00</span><span
					class="text-[10px] uppercase">Min</span></div>
			<div class="text-center"><span id="c-seconds" class="text-xl font-bold block">00</span><span
					class="text-[10px] uppercase">Sec</span></div>
		</div>

		<button id="open-invitation"
			class="bg-gradient-to-r from-pink-400 to-purple-400 text-white px-8 py-3 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition font-sans font-bold tracking-wider text-sm open-btn-animate z-20">
			<i class="fas fa-envelope-open mr-2"></i> Open Invitation
		</button>
	</div>

	<!-- Main Content -->
	<div id="main-content" class="min-h-screen bg-[#fff0f3] text-gray-800 font-sans overflow-x-hidden relative pb-20">

		<!-- Background Ornaments -->
		<div
			class="fixed top-0 left-0 w-48 md:w-80 h-48 md:h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
		</div>
		<div
			class="fixed top-0 right-0 w-48 md:w-80 h-48 md:h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
		</div>

		<div class="relative z-10 max-w-3xl mx-auto px-4 md:px-0">

			<!-- Hero / Intro -->
			<section class="min-h-screen flex flex-col justify-center items-center text-center py-10">
				<p class="text-pink-500 uppercase tracking-widest text-xs font-bold mb-4" data-aos="fade-down">Valid Thru
					{{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}</p>
				<h1 class="text-4xl md:text-6xl font-cursive text-gray-800 mb-6" data-aos="zoom-in">
					{{ $event->weddingEvent->groom_name ?? 'Groom' }} <span class="text-pink-400">&</span>
					{{ $event->weddingEvent->bride_name ?? 'Bride' }}
				</h1>
				<p class="text-gray-500 max-w-md mx-auto leading-relaxed mb-8" data-aos="fade-up">
					We invite you to share in our joy as we stand together to exchange vows and begin our new life together.
				</p>
				<div class="w-20 h-1 bg-pink-300 rounded-full mb-10" data-aos="scale-x"></div>
			</section>

			<!-- Bride & Groom Profile -->
			<section class="py-12 space-y-12">
				<div class="bg-white/70 backdrop-blur rounded-3xl p-6 md:p-10 shadow-sm border border-white" data-aos="fade-right">
					<div class="flex flex-col md:flex-row items-center gap-6">
						<div class="w-32 h-32 bg-gray-300 rounded-full overflow-hidden flex-shrink-0 border-4 border-pink-100">
							<img
								src="{{ isset($event->weddingEvent->groom_photo) ? (Str::startsWith($event->weddingEvent->groom_photo, 'http') ? $event->weddingEvent->groom_photo : Storage::url($event->weddingEvent->groom_photo)) : 'https://via.placeholder.com/150' }}"
								alt="Groom" class="w-full h-full object-cover">
						</div>
						<div class="text-center md:text-left">
							<h3 class="text-2xl font-cursive text-gray-800 mb-2">{{ $event->weddingEvent->groom_name ?? 'The Groom' }}</h3>
							<p class="text-sm text-gray-500 mb-2">Son of {{ $event->weddingEvent->groom_parent ?? 'Mr & Mrs. Groom' }}</p>
							<p class="text-gray-600 italic">"I promise to be your navigator, best friend, and husband."</p>
							<div class="mt-4 flex justify-center md:justify-start space-x-3 text-pink-400">
								@if ($event->weddingEvent->groom_instagram)
									<a href="https://instagram.com/{{ $event->weddingEvent->groom_instagram }}" target="_blank"><i
											class="fab fa-instagram"></i></a>
								@endif
							</div>
						</div>
					</div>
				</div>

				<div class="bg-white/70 backdrop-blur rounded-3xl p-6 md:p-10 shadow-sm border border-white" data-aos="fade-left">
					<div class="flex flex-col md:flex-row-reverse items-center gap-6">
						<div class="w-32 h-32 bg-gray-300 rounded-full overflow-hidden flex-shrink-0 border-4 border-purple-100">
							<img
								src="{{ isset($event->weddingEvent->bride_photo) ? (Str::startsWith($event->weddingEvent->bride_photo, 'http') ? $event->weddingEvent->bride_photo : Storage::url($event->weddingEvent->bride_photo)) : 'https://via.placeholder.com/150' }}"
								alt="Bride" class="w-full h-full object-cover">
						</div>
						<div class="text-center md:text-right">
							<h3 class="text-2xl font-cursive text-gray-800 mb-2">{{ $event->weddingEvent->bride_name ?? 'The Bride' }}</h3>
							<p class="text-sm text-gray-500 mb-2">Daughter of {{ $event->weddingEvent->bride_parent ?? 'Mr & Mrs. Bride' }}
							</p>
							<p class="text-gray-600 italic">"I promise to be your comfort, best friend, and wife."</p>
							<div class="mt-4 flex justify-center md:justify-end space-x-3 text-purple-400">
								@if ($event->weddingEvent->bride_instagram)
									<a href="https://instagram.com/{{ $event->weddingEvent->bride_instagram }}" target="_blank"><i
											class="fab fa-instagram"></i></a>
								@endif
							</div>
						</div>
					</div>
				</div>
			</section>

			<!-- Love Story -->
			@if (isset($event->eventJourneys) && count($event->eventJourneys) > 0)
				<section class="py-12">
					<h2 class="text-3xl font-cursive text-center mb-10 text-pink-500" data-aos="fade-up">Our Love Journey</h2>
					<div class="relative border-l-2 border-pink-200 ml-6 md:ml-1/2 space-y-10">
						@foreach ($event->eventJourneys as $story)
							<div class="relative pl-8 md:pl-12" data-aos="fade-up">
								<div class="absolute -left-[9px] top-0 w-4 h-4 bg-pink-400 rounded-full border-2 border-white"></div>
								<span class="text-xs font-bold text-pink-400 bg-pink-50 px-2 py-1 rounded mb-2 inline-block">
									{{ $story->journey_date ? (is_object($story->journey_date) ? $story->journey_date->format('Y') : \Carbon\Carbon::parse($story->journey_date)->format('Y')) : '' }}
								</span>
								<h4 class="text-lg font-bold text-gray-800">{{ $story->title }}</h4>
								<p class="text-sm text-gray-600 mt-1">{{ $story->description }}</p>
							</div>
						@endforeach
					</div>
				</section>
			@endif

			<!-- Events -->
			<section class="py-12">
				<h2 class="text-3xl font-cursive text-center mb-10 text-purple-500" data-aos="fade-up">Save The Date</h2>
				<div class="grid md:grid-cols-2 gap-6">
					@if (isset($event->eventLocations))
						@foreach ($event->eventLocations as $location)
							<div
								class="bg-white rounded-2xl p-6 text-center shadow-md border-b-4 border-pink-200 hover:-translate-y-1 transition duration-300"
								data-aos="flip-left" data-aos-delay="{{ $loop->index * 100 }}">
								<div class="w-12 h-12 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-4 text-pink-400">
									<i class="fas fa-calendar-alt text-xl"></i>
								</div>
								<h3 class="font-bold text-gray-800 text-lg uppercase tracking-wider mb-2">{{ $location->location_type }}</h3>
								<p class="text-3xl font-cursive text-pink-500 mb-2">
									{{ \Carbon\Carbon::parse($location->event_time)->format('h:i A') }}</p>
								<p class="text-sm text-gray-600 font-bold mb-1">{{ $location->name }}</p>
								<p class="text-xs text-gray-500 mb-4">{{ $location->address }}</p>
								@if ($location->google_maps_url)
									<a href="{{ $location->google_maps_url }}" target="_blank"
										class="inline-block bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-xs font-bold hover:bg-gray-200 transition">
										<i class="fas fa-map-marked-alt mr-1"></i> Google Maps
									</a>
								@endif
							</div>
						@endforeach
					@endif
				</div>
			</section>

			<!-- Gallery -->
			@if (isset($event->eventGalleries) && count($event->eventGalleries) > 0)
				<section class="py-12">
					<h2 class="text-3xl font-cursive text-center mb-10 text-pink-500" data-aos="fade-up">Our Moments</h2>
					<div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4">
						@foreach ($event->eventGalleries as $photo)
							<div class="aspect-square bg-gray-200 rounded-lg overflow-hidden cursor-pointer hover:opacity-90 transition"
								data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
								<img
									src="{{ Str::startsWith($photo->image_path, 'http') ? $photo->image_path : Storage::url($photo->image_path) }}"
									alt="Gallery" class="w-full h-full object-cover">
							</div>
						@endforeach
					</div>
				</section>
			@endif

			<!-- Wedding Gift / Angpao -->
			@if (isset($event->eventBanks) && count($event->eventBanks) > 0)
				<section class="py-12 text-center" data-aos="fade-up">
					<h2 class="text-3xl font-cursive mb-6 text-gray-800">Wedding Gift</h2>
					<p class="text-sm text-gray-500 mb-8 max-w-md mx-auto">Your presence is the greatest gift. However, if you wish to
						honor us with a gift, a digital envelope is available.</p>

					<div class="grid md:grid-cols-2 gap-4">
						@foreach ($event->eventBanks as $angpao)
							<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center">
								<div class="text-purple-500 mb-2"><i class="fas fa-wallet fa-2x"></i></div>
								<h4 class="font-bold text-gray-800">{{ $angpao->bank_name }}</h4>
								<p class="text-lg font-mono text-gray-600 my-2 select-all" id="account-{{ $loop->index }}">
									{{ $angpao->account_number }}</p>
								<p class="text-xs text-gray-400 mb-4">a.n {{ $angpao->account_name }}</p>
								<button onclick="copyToClipboard('account-{{ $loop->index }}')"
									class="text-xs bg-purple-50 text-purple-600 px-4 py-2 rounded-full hover:bg-purple-100 transition">
									<i class="far fa-copy mr-1"></i> Copy Number
								</button>
							</div>
						@endforeach
					</div>
				</section>
			@endif

			<!-- RSVP Form -->
			<section class="py-12 bg-white rounded-3xl p-6 md:p-10 shadow-lg border-t-8 border-pink-300" data-aos="fade-up">
				<h2 class="text-3xl font-cursive text-center mb-8 text-gray-800">RSVP</h2>
				<form id="rsvp-form" action="{{ route('frontend.rsvp', [$event->slug, $invitation->slug]) }}" method="POST"
					class="space-y-4">
					@csrf
					<div>
						<label class="block text-xs font-bold text-gray-500 uppercase mb-1">Name</label>
						<input type="text"
							class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-pink-400"
							placeholder="Your Name" value="{{ $invitation->guest_name ?? '' }}" readonly>
					</div>
					<div>
						<label class="block text-xs font-bold text-gray-500 uppercase mb-1">Will you attend?</label>
						<select name="status"
							class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-pink-400">
							<option value="yes">Yes, I will attend</option>
							<option value="no">Sorry, I can't attend</option>
						</select>
					</div>
					<div>
						<label class="block text-xs font-bold text-gray-500 uppercase mb-1">Total Guests</label>
						<select name="total_guest"
							class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-pink-400">
							<option value="1">1 Person</option>
							<option value="2">2 Persons</option>
						</select>
					</div>
					<div>
						<label class="block text-xs font-bold text-gray-500 uppercase mb-1">Message</label>
						<textarea name="message"
						 class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-pink-400 h-24"
						 placeholder="Give your wishes..."></textarea>
					</div>
					<button type="submit"
						class="w-full bg-pink-500 text-white font-bold py-4 rounded-lg hover:bg-pink-600 transition shadow-lg shadow-pink-500/30">
						Send Confirmation <i class="fas fa-paper-plane ml-2"></i>
					</button>
				</form>
			</section>

			<!-- Wishes List -->
			<section class="py-12" id="wishes-section">
				<h2 class="text-3xl font-cursive text-center mb-8 text-gray-800">Wedding Wishes</h2>
				<div id="wishes-container" class="space-y-4 overflow-y-auto max-h-96 pr-2 hide-scroll">
					@if (isset($wishes))
						@foreach ($wishes as $wish)
							<div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100" data-aos="fade-up">
								<div class="flex items-center space-x-2 mb-2">
									<div
										class="w-8 h-8 bg-gradient-to-br from-pink-200 to-purple-200 rounded-full flex items-center justify-center text-xs font-bold text-white">
										{{ substr($wish->name, 0, 1) }}
									</div>
									<div>
										<h5 class="font-bold text-sm text-gray-800">{{ $wish->name }}</h5>
										<span class="text-[10px] text-gray-400">{{ $wish->created_at->diffForHumans() }}</span>
									</div>
								</div>
								<p class="text-sm text-gray-600 pl-10">{{ $wish->message }}</p>
							</div>
						@endforeach
					@endif
				</div>
			</section>

			<footer class="text-center py-10 text-gray-400 text-xs">
				<p>&copy; {{ date('Y') }} UndanganKita. All Rights Reserved.</p>
			</footer>

		</div>
	</div>

	<!-- Scripts -->
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		// Open Invitation
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
				AOS.init({
					duration: 800,
					once: true
				});
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
				musicIcon.classList.remove('fa-pause');
				musicIcon.classList.add('fa-compact-disc');
			} else {
				audio.pause();
				isPlaying = false;
				musicIcon.classList.remove('spin');
				musicIcon.classList.remove('fa-compact-disc');
				musicIcon.classList.add('fa-pause');
			}
		}

		// Copy Clipboard
		function copyToClipboard(elementId) {
			const text = document.getElementById(elementId).innerText;
			navigator.clipboard.writeText(text).then(() => {
				alert('Copied to clipboard!');
			});
		}

		// Countdown
		const eventDate = new Date("{{ $event->event_date }}").getTime();

		function updateTimer() {
			const now = new Date().getTime();
			const distance = eventDate - now;

			const d = Math.floor(distance / (1000 * 60 * 60 * 24));
			const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			const s = Math.floor((distance % (1000 * 60)) / 1000);

			// Update Cover
			document.getElementById("c-days").innerText = d < 10 ? '0' + d : d;
			document.getElementById("c-hours").innerText = h < 10 ? '0' + h : h;
			document.getElementById("c-minutes").innerText = m < 10 ? '0' + m : m;
			document.getElementById("c-seconds").innerText = s < 10 ? '0' + s : s;
		}

		setInterval(updateTimer, 1000);
		updateTimer();

		// AJAX RSVP
		document.getElementById('rsvp-form').addEventListener('submit', function(e) {
			e.preventDefault();
			const form = this;
			const btn = form.querySelector('button[type="submit"]');
			const originalText = btn.innerHTML;
			btn.innerHTML = 'Sending... <i class="fas fa-spinner fa-spin ml-2"></i>';
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

							// Get first letter
							const firstLetter = data.wish.name.charAt(0);

							const html = `
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100" data-aos="fade-up">
								<div class="flex items-center space-x-2 mb-2">
									<div
										class="w-8 h-8 bg-gradient-to-br from-pink-200 to-purple-200 rounded-full flex items-center justify-center text-xs font-bold text-white">
										${firstLetter}
									</div>
									<div>
										<h5 class="font-bold text-sm text-gray-800">${data.wish.name}</h5>
										<span class="text-[10px] text-gray-400">${data.wish.created_at_human}</span>
									</div>
								</div>
								<p class="text-sm text-gray-600 pl-10">${data.wish.message}</p>
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
					btn.innerHTML = originalText;
					btn.disabled = false;
				});
		});
	</script>
@endsection
