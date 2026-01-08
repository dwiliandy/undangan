@extends('layouts.frontend', ['hideNav' => true])

@section('title', $event->title)

@section('content')
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@300;400;600;700&display=swap"
		rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

	<style>
		:root {
			--netflix-red: #E50914;
			--netflix-black: #141414;
			--netflix-dark-gray: #181818;
			--netflix-light-gray: #b3b3b3;
		}

		body {
			background-color: var(--netflix-black);
			color: white;
			font-family: 'Open Sans', sans-serif;
		}

		.font-bebas {
			font-family: 'Bebas Neue', cursive;
		}

		.btn-play {
			background-color: white;
			color: black;
			transition: all 0.2s;
		}

		.btn-play:hover {
			background-color: rgba(255, 255, 255, 0.75);
		}

		.btn-more {
			background-color: rgba(109, 109, 110, 0.7);
			color: white;
			transition: all 0.2s;
		}

		.btn-more:hover {
			background-color: rgba(109, 109, 110, 0.4);
		}

		.hide-scroll::-webkit-scrollbar {
			display: none;
		}

		.hide-scroll {
			-ms-overflow-style: none;
			scrollbar-width: none;
		}

		.netflix-card {
			transition: transform 0.3s, z-index 0.3s;
		}

		.netflix-card:hover {
			transform: scale(1.05);
			z-index: 10;
		}

		#cover {
			background-color: #141414;
		}

		.profile-gate-img:hover {
			border: 3px solid white;
		}
	</style>

	<!-- Audio Control -->
	<audio id="bg-music" loop>
		<source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3" type="audio/mpeg">
	</audio>
	<!-- Mute Button in Navbar -->

	<!-- Cover Section (Who's Watching?) -->
	<div id="cover"
		class="fixed inset-0 z-50 flex flex-col justify-center items-center text-center animate-fade-in bg-[#141414] px-4">
		<h1 class="text-3xl md:text-5xl font-bebas mb-8 md:mb-12 tracking-wide text-white">Who's Watching?</h1>

		<div class="flex flex-wrap justify-center gap-6 md:gap-16 max-w-4xl">
			<!-- Profile 1 -->
			<div class="group cursor-pointer open-invitation-trigger relative profile-item">
				<div
					class="w-24 h-24 md:w-40 md:h-40 rounded overflow-hidden mb-4 border-2 border-transparent group-hover:border-white transition profile-gate-img relative">
					<img
						src="{{ isset($event->weddingEvent->groom_photo) ? (Str::startsWith($event->weddingEvent->groom_photo, 'http') ? $event->weddingEvent->groom_photo : Storage::url($event->weddingEvent->groom_photo)) : 'https://via.placeholder.com/200' }}"
						class="w-full h-full object-cover">
					<!-- Overlay Play Icon -->
					<div
						class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition profile-overlay">
						<i class="fas fa-play text-white text-3xl"></i>
					</div>
					<!-- Edit Overlay -->
					<div class="absolute inset-0 bg-black/70 flex items-center justify-center opacity-0 transition edit-overlay hidden">
						<i class="fas fa-pencil-alt text-white text-3xl"></i>
					</div>
				</div>
				<span class="text-gray-400 group-hover:text-white text-lg md:text-xl font-light">Groom's Guest</span>
			</div>

			<!-- Profile 2 -->
			<div class="group cursor-pointer open-invitation-trigger relative profile-item">
				<div
					class="w-24 h-24 md:w-40 md:h-40 rounded overflow-hidden mb-4 border-2 border-transparent group-hover:border-white transition profile-gate-img relative">
					<img
						src="{{ isset($event->weddingEvent->bride_photo) ? (Str::startsWith($event->weddingEvent->bride_photo, 'http') ? $event->weddingEvent->bride_photo : Storage::url($event->weddingEvent->bride_photo)) : 'https://via.placeholder.com/200' }}"
						class="w-full h-full object-cover">
					<div
						class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition profile-overlay">
						<i class="fas fa-play text-white text-3xl"></i>
					</div>
					<!-- Edit Overlay -->
					<div class="absolute inset-0 bg-black/70 flex items-center justify-center opacity-0 transition edit-overlay hidden">
						<i class="fas fa-pencil-alt text-white text-3xl"></i>
					</div>
				</div>
				<span class="text-gray-400 group-hover:text-white text-lg md:text-xl font-light">Bride's Guest</span>
			</div>
		</div>

		<button id="manage-profiles-btn"
			class="mt-12 md:mt-16 border border-gray-600 text-gray-500 px-6 py-2 uppercase tracking-widest text-xs md:text-sm hover:border-white hover:text-white transition">
			Manage Profiles
		</button>
	</div>

	<!-- Main Content -->
	<div id="main-content" class="min-h-screen hidden relative overflow-x-hidden">

		<!-- Navbar -->
		<nav
			class="fixed top-0 w-full z-40 transition-all duration-500 bg-gradient-to-b from-black/80 to-transparent p-4 flex justify-between items-center"
			id="navbar">
			<div class="text-[#E50914] text-2xl md:text-3xl font-bebas tracking-wider cursor-pointer">UNDANGAN</div>
			<div class="flex items-center gap-4 text-white text-sm">
				<button onclick="toggleMusic()" id="music-btn"><i class="fas fa-volume-mute text-xl"></i></button>
				<img src="https://upload.wikimedia.org/wikipedia/commons/0/0b/Netflix-avatar.png"
					class="w-8 h-8 rounded animate-pulse">
			</div>
		</nav>

		<!-- Hero Section -->
		<div class="relative h-[80vh] w-full">
			<!-- Background Image -->
			<div class="absolute inset-0">
				<img
					src="{{ isset($event->eventGalleries[0]) ? (Str::startsWith($event->eventGalleries[0]->image_path, 'http') ? $event->eventGalleries[0]->image_path : Storage::url($event->eventGalleries[0]->image_path)) : 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1920&q=80' }}"
					class="w-full h-full object-cover">
				<div class="absolute inset-0 bg-gradient-to-t from-[#141414] via-black/40 to-black/30"></div>
				<div class="absolute inset-0 bg-gradient-to-r from-black/80 via-transparent to-transparent"></div>
			</div>

			<!-- Content -->
			<div class="absolute bottom-0 left-0 w-full p-6 md:p-12 pb-24 md:pb-32 z-10 max-w-2xl">
				<div class="flex items-center gap-2 mb-4">
					<img
						src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/08/Netflix_2015_logo.svg/1200px-Netflix_2015_logo.svg.png"
						class="h-8 md:h-10 object-contain drop-shadow-lg filter brightness-0 invert opacity-100 hidden">
					<span class="text-[#E50914] font-bold tracking-widest text-xs md:text-sm uppercase">N &nbsp; S E R I E S</span>
				</div>

				<h1 class="text-5xl md:text-7xl font-bebas mb-4 leading-none text-shadow-lg">
					{{ $event->weddingEvent->groom_name }} <br> & {{ $event->weddingEvent->bride_name }}
				</h1>

				<div class="flex items-center gap-4 text-green-400 font-bold text-sm mb-6">
					<span>98% Match</span>
					<span class="text-gray-300 font-normal">2026</span>
					<span class="border border-gray-500 px-1 text-[10px] text-gray-300 rounded font-normal">U</span>
					<span class="text-gray-300 font-normal">1 Season</span>
				</div>

				<p class="text-white text-sm md:text-lg mb-8 drop-shadow-md text-gray-200 line-clamp-3 md:line-clamp-none">
					Two souls, one destiny. Join {{ $event->weddingEvent->groom_name }} and {{ $event->weddingEvent->bride_name }} as
					they embark on their greatest adventure yet. A story of love, laughter, and happily ever after.
				</p>

				<div class="flex gap-4">
					<button onclick="scrollToSection('rsvp-section')"
						class="btn-play px-6 py-2 md:px-8 md:py-3 rounded font-bold flex items-center gap-2 text-sm md:text-base">
						<i class="fas fa-play"></i> RSVP
					</button>
					<button onclick="scrollToSection('details-section')"
						class="btn-more px-6 py-2 md:px-8 md:py-3 rounded font-bold flex items-center gap-2 text-sm md:text-base">
						<i class="fas fa-info-circle"></i> More Info
					</button>
				</div>
			</div>
		</div>

		<!-- Episodes (Journey) -->
		<div class="px-6 md:px-12 -mt-10 relative z-20 space-y-12 pb-20">

			@if (isset($event->eventJourneys) && count($event->eventJourneys) > 0)
				<section>
					<h3 class="text-xl md:text-2xl font-bold mb-4 text-white">Episodes</h3>
					<div class="flex overflow-x-auto gap-4 pb-4 hide-scroll">
						@foreach ($event->eventJourneys as $index => $story)
							<div class="min-w-[250px] md:min-w-[300px] cursor-pointer group relative netflix-card">
								<div class="aspect-video bg-gray-800 rounded-md overflow-hidden relative">
									<div class="absolute inset-0 flex items-center justify-center text-4xl font-bold text-gray-700 bg-gray-900">
										{{ $index + 1 }}
									</div>
									<div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition"></div>
									<div class="absolute bottom-2 left-2 right-2">
										<h4 class="font-bold text-sm truncate">{{ $story->title }}</h4>
										<span
											class="text-xs text-gray-400">{{ $story->journey_date ? (is_object($story->journey_date) ? $story->journey_date->format('Y') : \Carbon\Carbon::parse($story->journey_date)->format('Y')) : '' }}</span>
									</div>
									<div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition shadow">
										<i class="far fa-play-circle text-2xl"></i>
									</div>
								</div>
								<p class="text-xs text-gray-400 mt-2 line-clamp-2 hover:line-clamp-none transition delay-75">
									{{ $story->description }}</p>
							</div>
						@endforeach
					</div>
				</section>
			@endif

			<!-- Location Details -->
			<section id="details-section">
				<h3 class="text-xl md:text-2xl font-bold mb-4 text-white">Upcoming Events</h3>
				<div class="grid md:grid-cols-2 gap-6">
					@foreach ($event->eventLocations as $location)
						<div class="bg-[#181818] rounded-md p-6 hover:bg-[#222] transition duration-300">
							<div class="flex items-start gap-4">
								<div class="text-[#E50914] text-xl pt-1"><i class="fas fa-calendar-day"></i></div>
								<div>
									<h4 class="font-bold text-lg mb-1">{{ strtoupper($location->location_type) }}</h4>
									<p class="text-green-400 font-bold mb-2">
										{{ \Carbon\Carbon::parse($location->event_time)->format('F d, Y • H:i') }}</p>
									<p class="font-semibold text-white mb-1">{{ $location->name }}</p>
									<p class="text-gray-400 text-sm mb-4">{{ $location->address }}</p>
									@if ($location->google_maps_url)
										<a href="{{ $location->google_maps_url }}" target="_blank"
											class="inline-block bg-white text-black text-xs font-bold px-4 py-2 rounded hover:bg-gray-200 transition">
											<i class="fas fa-map-marker-alt mr-1"></i> Remind Me
										</a>
									@endif
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</section>

			<!-- Cast (Profile) -->
			<section>
				<h3 class="text-xl md:text-2xl font-bold mb-4 text-white">Top Cast</h3>
				<div class="flex gap-6 overflow-x-auto pb-4 hide-scroll">
					<!-- Groom -->
					<div class="min-w-[140px] text-center">
						<div
							class="w-24 h-24 mx-auto rounded-full overflow-hidden mb-2 border-2 border-transparent hover:border-white transition cursor-pointer">
							<img
								src="{{ isset($event->weddingEvent->groom_photo) ? (Str::startsWith($event->weddingEvent->groom_photo, 'http') ? $event->weddingEvent->groom_photo : Storage::url($event->weddingEvent->groom_photo)) : 'https://via.placeholder.com/150' }}"
								class="w-full h-full object-cover">
						</div>
						<h4 class="font-bold text-sm">{{ $event->weddingEvent->groom_name }}</h4>
						<p class="text-xs text-gray-400">Groom</p>
						@if ($event->weddingEvent->groom_instagram)
							<a href="https://instagram.com/{{ $event->weddingEvent->groom_instagram }}"
								class="text-[#E50914] text-xs mt-1 block hover:underline">@ {{ $event->weddingEvent->groom_instagram }}</a>
						@endif
					</div>
					<!-- Bride -->
					<div class="min-w-[140px] text-center">
						<div
							class="w-24 h-24 mx-auto rounded-full overflow-hidden mb-2 border-2 border-transparent hover:border-white transition cursor-pointer">
							<img
								src="{{ isset($event->weddingEvent->bride_photo) ? (Str::startsWith($event->weddingEvent->bride_photo, 'http') ? $event->weddingEvent->bride_photo : Storage::url($event->weddingEvent->bride_photo)) : 'https://via.placeholder.com/150' }}"
								class="w-full h-full object-cover">
						</div>
						<h4 class="font-bold text-sm">{{ $event->weddingEvent->bride_name }}</h4>
						<p class="text-xs text-gray-400">Bride</p>
						@if ($event->weddingEvent->bride_instagram)
							<a href="https://instagram.com/{{ $event->weddingEvent->bride_instagram }}"
								class="text-[#E50914] text-xs mt-1 block hover:underline">@ {{ $event->weddingEvent->bride_instagram }}</a>
						@endif
					</div>
				</div>
			</section>

			<!-- Gallery (More Like This) -->
			@if (isset($event->eventGalleries))
				<section>
					<h3 class="text-xl md:text-2xl font-bold mb-4 text-white">More Like This</h3>
					<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
						@foreach ($event->eventGalleries as $photo)
							<div
								class="aspect-[16/9] bg-gray-800 rounded overflow-hidden cursor-pointer hover:scale-105 transition duration-300 relative group">
								<img
									src="{{ Str::startsWith($photo->image_path, 'http') ? $photo->image_path : Storage::url($photo->image_path) }}"
									class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition">
							</div>
						@endforeach
					</div>
				</section>
			@endif

			<!-- RSVP Section -->
			<section id="rsvp-section" class="max-w-4xl mx-auto pt-10">
				<div class="bg-black/50 p-8 rounded-lg border border-gray-800">
					<h3 class="text-2xl font-bold mb-6 text-center">Join The Party</h3>
					<form id="rsvp-form" action="{{ route('frontend.rsvp', [$event->slug, $invitation->slug]) }}" method="POST"
						class="space-y-6">
						@csrf
						<div class="grid md:grid-cols-2 gap-6">
							<div>
								<label class="block text-sm text-gray-400 mb-1">Name</label>
								<input type="text" value="{{ $invitation->guest_name }}" readonly
									class="w-full bg-[#333] border-none rounded text-white py-3 px-4 focus:ring-0">
							</div>
							<div>
								<label class="block text-sm text-gray-400 mb-1">Status</label>
								<select name="status"
									class="w-full bg-[#333] border-none rounded text-white py-3 px-4 focus:ring-0 cursor-pointer">
									<option value="yes">Currently Watching (Will Attend)</option>
									<option value="no">Remove form List (Can't Attend)</option>
								</select>
							</div>
						</div>
						<div>
							<label class="block text-sm text-gray-400 mb-1">Party Size</label>
							<select name="total_guest"
								class="w-full bg-[#333] border-none rounded text-white py-3 px-4 focus:ring-0 cursor-pointer">
								<option value="1">1 Profile</option>
								<option value="2">2 Profiles</option>
							</select>
						</div>
						<div>
							<label class="block text-sm text-gray-400 mb-1">Review (Wishes)</label>
							<textarea name="message" class="w-full bg-[#333] border-none rounded text-white py-3 px-4 focus:ring-0 h-24"
							 placeholder="Write a review..."></textarea>
						</div>
						<button type="submit" class="w-full bg-[#E50914] hover:bg-red-700 text-white font-bold py-4 rounded transition">
							Submit Review
						</button>
					</form>
				</div>
			</section>

			<!-- Reviews / Wishes -->
			<section id="wishes-section">
				<h3 class="text-xl md:text-2xl font-bold mb-4 text-white">Reviews</h3>
				<div id="wishes-container" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
					@if (isset($wishes))
						@foreach ($wishes as $wish)
							<div class="bg-[#181818] p-4 rounded text-sm">
								<div class="flex justify-between items-center mb-2">
									<span class="font-bold text-white">{{ $wish->name }}</span>
									<div class="flex text-[#E50914] text-xs">
										<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
											class="fas fa-star"></i><i class="fas fa-star"></i>
									</div>
								</div>
								<p class="text-gray-400 mb-2">"{{ $wish->message }}"</p>
								<span class="text-xs text-gray-600 uppercase">{{ $wish->created_at->diffForHumans() }}</span>
							</div>
						@endforeach
					@endif
				</div>
			</section>

			<!-- Footer -->
			<footer class="py-10 text-center text-gray-500 text-sm mt-10 border-t border-gray-800">
				<div class="flex justify-center gap-6 mb-4">
					<i class="fab fa-facebook-f hover:text-white cursor-pointer"></i>
					<i class="fab fa-instagram hover:text-white cursor-pointer"></i>
					<i class="fab fa-twitter hover:text-white cursor-pointer"></i>
					<i class="fab fa-youtube hover:text-white cursor-pointer"></i>
				</div>
				<div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto text-xs mb-4">
					<a href="#" class="hover:underline">Audio Description</a>
					<a href="#" class="hover:underline">Help Center</a>
					<a href="#" class="hover:underline">Gift Cards</a>
					<a href="#" class="hover:underline">Media Center</a>
					<a href="#" class="hover:underline">Investor Relations</a>
					<a href="#" class="hover:underline">Jobs</a>
					<a href="#" class="hover:underline">Terms of Use</a>
					<a href="#" class="hover:underline">Privacy</a>
					<a href="#" class="hover:underline">Legal Notices</a>
					<a href="#" class="hover:underline">Cookie Preferences</a>
					<a href="#" class="hover:underline">Corporate Information</a>
					<a href="#" class="hover:underline">Contact Us</a>
				</div>
				<p>&copy; {{ date('Y') }} UndanganKita. All Rights Reserved.</p>
			</footer>

		</div>
	</div>

	<!-- Scripts -->
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		AOS.init();

		// Cover Logic
		const triggers = document.querySelectorAll('.open-invitation-trigger');
		const cover = document.getElementById('cover');
		const main = document.getElementById('main-content');
		const audio = document.getElementById('bg-music');
		const musicBtn = document.getElementById('music-btn');
		const manageBtn = document.getElementById('manage-profiles-btn');
		let isEditing = false;

		// Manage Profiles Logic
		manageBtn.addEventListener('click', (e) => {
			e.stopPropagation(); // Prevent propagation
			isEditing = !isEditing;

			const editOverlays = document.querySelectorAll('.edit-overlay');
			const playOverlays = document.querySelectorAll('.profile-overlay');

			if (isEditing) {
				manageBtn.innerText = "Done";
				manageBtn.classList.add('bg-white', 'text-black', 'border-white');
				manageBtn.classList.remove('text-gray-500', 'border-gray-600');

				editOverlays.forEach(el => {
					el.classList.remove('hidden');
					setTimeout(() => el.classList.remove('opacity-0'), 50);
				});
				// Disable play overlays
				triggers.forEach(t => t.style.pointerEvents = 'none');
				// Actually we want the click on profile to just stop editing if in edit mode, 
				// but let's keep it simple: clicks on "Edit" just disable edit mode.

				// Re-enable click to allow "Edit" action which just exits edit mode in this fake app
				triggers.forEach(t => {
					t.style.pointerEvents = 'auto';
				});

			} else {
				manageBtn.innerText = "Manage Profiles";
				manageBtn.classList.remove('bg-white', 'text-black', 'border-white');
				manageBtn.classList.add('text-gray-500', 'border-gray-600');

				editOverlays.forEach(el => {
					el.classList.add('opacity-0');
					setTimeout(() => el.classList.add('hidden'), 300);
				});
			}
		});

		triggers.forEach(trigger => {
			trigger.addEventListener('click', () => {
				if (isEditing) {
					// If in edit mode, clicking a profile just exits edit mode (simulation)
					manageBtn.click();
					return;
				}

				// Fade out cover
				cover.style.transition = 'opacity 0.5s';
				cover.style.opacity = '0';

				// Play music
				audio.play().then(() => {
					musicBtn.innerHTML = '<i class="fas fa-volume-up text-xl"></i>';
				}).catch(() => {
					// Autoplay blocked
					musicBtn.innerHTML = '<i class="fas fa-volume-mute text-xl"></i>';
				});

				setTimeout(() => {
					cover.style.display = 'none';
					main.classList.remove('hidden');
					main.classList.add('animate-fade-in');
					AOS.refresh(); // Refresh AOS
				}, 500);
			});
		});

		function toggleMusic() {
			if (audio.paused) {
				audio.play();
				musicBtn.innerHTML = '<i class="fas fa-volume-up text-xl"></i>';
			} else {
				audio.pause();
				musicBtn.innerHTML = '<i class="fas fa-volume-mute text-xl"></i>';
			}
		}

		function scrollToSection(id) {
			document.getElementById(id).scrollIntoView({
				behavior: 'smooth'
			});
		}

		// Navbar Scroll
		window.addEventListener('scroll', () => {
			const nav = document.getElementById('navbar');
			if (window.scrollY > 50) {
				nav.classList.add('bg-black');
				nav.classList.remove('bg-gradient-to-b');
			} else {
				nav.classList.remove('bg-black');
				nav.classList.add('bg-gradient-to-b');
			}
		});

		// AJAX RSVP
		document.getElementById('rsvp-form').addEventListener('submit', function(e) {
			e.preventDefault();
			const form = this;
			const btn = form.querySelector('button[type="submit"]');
			const originalText = btn.innerText;
			btn.innerText = 'Submitting...';
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
						alert('Review Submitted!');
						form.reset();

						if (data.wish) {
							const container = document.getElementById('wishes-container');
							const section = document.getElementById('wishes-section');
							section.style.display = 'block';

							const html = `
                             <div class="bg-[#181818] p-4 rounded text-sm animate-pulse">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-white">${data.wish.name}</span>
                                    <div class="flex text-[#E50914] text-xs">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <p class="text-gray-400 mb-2">"${data.wish.message}"</p>
                                <span class="text-xs text-gray-600 uppercase">${data.wish.created_at_human}</span>
                            </div>
                        `;
							container.insertAdjacentHTML('afterbegin', html);
						}
					} else {
						alert('Failed to submit.');
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
