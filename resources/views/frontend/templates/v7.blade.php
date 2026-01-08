@extends('layouts.frontend', ['hideNav' => true])

@section('title', $event->title)

@section('content')
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700&display=swap" rel="stylesheet">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

	<style>
		body {
			background-color: #121212;
			color: white;
			font-family: 'Outfit', sans-serif;
		}

		.bg-gradient-music {
			background: linear-gradient(180deg, #535353 0%, #121212 100%);
		}

		.glass-panel {
			background: rgba(255, 255, 255, 0.05);
			backdrop-filter: blur(10px);
			border: 1px solid rgba(255, 255, 255, 0.1);
		}

		.progress-bar {
			background: #4d4d4d;
			height: 4px;
			border-radius: 2px;
			overflow: hidden;
			position: relative;
		}

		.progress-fill {
			background: #1db954;
			height: 100%;
			width: 30%;
		}

		.spin-slow {
			animation: spin 10s linear infinite;
		}

		@keyframes spin {
			100% {
				transform: rotate(360deg);
			}
		}

		.equalizer-bar {
			width: 3px;
			background: #1db954;
			animation: equalize 1s infinite ease-in-out alternate;
		}

		@keyframes equalize {
			0% {
				height: 5px;
			}

			100% {
				height: 20px;
			}
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
	</style>

	<!-- Audio Control (Will built into UI) -->
	<audio id="bg-music" loop>
		<source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3" type="audio/mpeg">
	</audio>

	<!-- Cover (Album Release) -->
	<div id="cover"
		class="fixed inset-0 z-50 bg-[#121212] flex flex-col justify-center items-center text-center p-6 bg-gradient-music">

		<div class="w-64 h-64 shadow-2xl mb-8 relative group">
			<!-- Composite Album Art -->
			<div class="absolute inset-0 bg-gray-800 rounded shadow-lg overflow-hidden">
				<img
					src="{{ isset($event->eventGalleries[0]) ? (Str::startsWith($event->eventGalleries[0]->image_path, 'http') ? $event->eventGalleries[0]->image_path : Storage::url($event->eventGalleries[0]->image_path)) : 'https://via.placeholder.com/300' }}"
					class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition duration-500">
			</div>
			<div class="absolute inset-0 flex items-center justify-center">
				<div class="w-16 h-16 bg-white/20 backdrop-blur rounded-full flex items-center justify-center">
					<i class="fas fa-music text-2xl text-white"></i>
				</div>
			</div>
		</div>

		<h2 class="text-[#1db954] text-xs font-bold uppercase tracking-widest mb-2">New Release Single</h2>
		<h1 class="text-4xl md:text-5xl font-bold mb-2">{{ $event->weddingEvent->groom_name }} &
			{{ $event->weddingEvent->bride_name }}</h1>
		<p class="text-gray-400 mb-8">The Wedding Album • {{ \Carbon\Carbon::parse($event->event_date)->format('Y') }}</p>

		@if (isset($invitation))
			<div class="bg-white/10 p-4 rounded-lg mb-8 max-w-xs w-full backdrop-blur-sm">
				<p class="text-[10px] uppercase text-gray-400 mb-1">Exclusive Invite For</p>
				<h3 class="font-bold text-lg">{{ $invitation->guest_name }}</h3>
			</div>
		@endif

		<button id="open-invitation"
			class="bg-[#1db954] text-black px-8 py-3 rounded-full font-bold uppercase text-xs tracking-widest hover:scale-105 transition transform">
			<i class="fas fa-play mr-2"></i> Play Now
		</button>
	</div>

	<!-- Main Content -->
	<div id="main-content" class="min-h-screen bg-[#121212] pb-24 overflow-x-hidden">

		<!-- Header / Now Playing -->
		<header class="p-6 md:p-12 bg-gradient-to-b from-[#535353] to-[#121212] relative">
			<div class="max-w-4xl mx-auto flex flex-col md:flex-row items-end gap-8">
				<div class="w-48 h-48 md:w-60 md:h-60 shadow-2xl relative group shrink-0" data-aos="zoom-in">
					<img
						src="{{ isset($event->eventGalleries[0]) ? (Str::startsWith($event->eventGalleries[0]->image_path, 'http') ? $event->eventGalleries[0]->image_path : Storage::url($event->eventGalleries[0]->image_path)) : 'https://via.placeholder.com/300' }}"
						class="w-full h-full object-cover shadow-lg">
				</div>
				<div class="w-full" data-aos="fade-up">
					<p class="text-xs font-bold uppercase tracking-widest mb-2">The Wedding Of</p>
					<h1 class="text-4xl md:text-7xl font-bold mb-4 md:mb-6 leading-tight">{{ $event->weddingEvent->groom_name }} <br> &
						{{ $event->weddingEvent->bride_name }}</h1>
					<div class="flex items-center gap-2 text-sm text-gray-300">
						<div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center text-black text-[10px] font-bold">W
						</div>
						<span class="font-bold text-white">Wedding</span>
						<span>•</span>
						<span>{{ \Carbon\Carbon::parse($event->event_date)->format('Y') }}</span>
						<span>•</span>
						<span>1 Song, 3 min 45 sec</span>
					</div>

					<!-- Music Controls -->
					<div class="mt-6 flex items-center gap-4">
						<button
							class="w-12 h-12 bg-[#1db954] rounded-full flex items-center justify-center text-black hover:scale-105 transition shadow-lg"
							onclick="toggleMusic()" id="main-play-btn">
							<i class="fas fa-pause text-xl" id="main-play-icon"></i>
						</button>
						<button class="text-gray-400 hover:text-white"><i class="far fa-heart text-2xl"></i></button>
						<button class="text-gray-400 hover:text-white"><i class="fas fa-ellipsis-h text-2xl"></i></button>
					</div>
				</div>
			</div>
		</header>

		<!-- Artists (Profile) -->
		<section class="max-w-4xl mx-auto px-6 py-8">
			<h3 class="text-xl font-bold mb-6 hover:underline cursor-pointer">Featuring Artists</h3>
			<div class="grid md:grid-cols-2 gap-6">
				<!-- Groom -->
				<div class="glass-panel p-4 rounded-md flex items-center gap-4 group hover:bg-white/10 transition"
					data-aos="fade-right">
					<div class="w-20 h-20 rounded-full overflow-hidden shrink-0">
						<img
							src="{{ isset($event->weddingEvent->groom_photo) ? (Str::startsWith($event->weddingEvent->groom_photo, 'http') ? $event->weddingEvent->groom_photo : Storage::url($event->weddingEvent->groom_photo)) : 'https://via.placeholder.com/150' }}"
							class="w-full h-full object-cover">
					</div>
					<div>
						<h4 class="font-bold text-lg">{{ $event->weddingEvent->groom_name }}</h4>
						<p class="text-xs text-gray-400 mb-2">Groom • Son of {{ $event->weddingEvent->groom_parent }}</p>
						@if ($event->weddingEvent->groom_instagram)
							<a href="https://instagram.com/{{ $event->weddingEvent->groom_instagram }}" target="_blank"
								class="text-xs border border-gray-600 px-3 py-1 rounded-full hover:border-white transition">Follow</a>
						@endif
					</div>
				</div>
				<!-- Bride -->
				<div class="glass-panel p-4 rounded-md flex items-center gap-4 group hover:bg-white/10 transition"
					data-aos="fade-left">
					<div class="w-20 h-20 rounded-full overflow-hidden shrink-0">
						<img
							src="{{ isset($event->weddingEvent->bride_photo) ? (Str::startsWith($event->weddingEvent->bride_photo, 'http') ? $event->weddingEvent->bride_photo : Storage::url($event->weddingEvent->bride_photo)) : 'https://via.placeholder.com/150' }}"
							class="w-full h-full object-cover">
					</div>
					<div>
						<h4 class="font-bold text-lg">{{ $event->weddingEvent->bride_name }}</h4>
						<p class="text-xs text-gray-400 mb-2">Bride • Daughter of {{ $event->weddingEvent->bride_parent }}</p>
						@if ($event->weddingEvent->bride_instagram)
							<a href="https://instagram.com/{{ $event->weddingEvent->bride_instagram }}" target="_blank"
								class="text-xs border border-gray-600 px-3 py-1 rounded-full hover:border-white transition">Follow</a>
						@endif
					</div>
				</div>
			</div>
		</section>

		<!-- Tracklist (Journey) -->
		@if (isset($event->eventJourneys) && count($event->eventJourneys) > 0)
			<section class="max-w-4xl mx-auto px-6 py-4">
				<div
					class="flex items-center text-gray-400 text-xs border-b border-gray-800 pb-2 mb-4 uppercase tracking-widest sticky top-0 bg-[#121212] z-10 pt-4">
					<div class="w-8 text-center">#</div>
					<div class="flex-grow">Title</div>
					<div class="hidden md:block w-32 text-right"><i class="far fa-clock"></i></div>
				</div>

				<div class="space-y-2">
					@foreach ($event->eventJourneys as $index => $story)
						<div class="flex items-center hover:bg-white/10 p-2 rounded group transition" data-aos="fade-up"
							data-aos-delay="{{ $index * 50 }}">
							<div class="w-8 text-center text-gray-400 group-hover:hidden">{{ $index + 1 }}</div>
							<div class="w-8 text-center hidden group-hover:block text-[#1db954]"><i class="fas fa-play"></i></div>
							<div class="flex-grow">
								<h4 class="font-bold text-white text-sm md:text-base">{{ $story->title }}</h4>
								<p class="text-xs text-gray-400">{{ $story->description }}</p>
							</div>
							<div class="hidden md:block w-32 text-right text-xs text-gray-400">
								{{ $story->journey_date ? (is_object($story->journey_date) ? $story->journey_date->format('Y') : \Carbon\Carbon::parse($story->journey_date)->format('Y')) : '' }}
							</div>
						</div>
					@endforeach
				</div>
			</section>
		@endif

		<!-- Tour Dates (Events) -->
		<section class="max-w-4xl mx-auto px-6 py-12">
			<h3 class="text-xl font-bold mb-6">On Tour</h3>
			<div class="space-y-4">
				@foreach ($event->eventLocations as $location)
					<div class="glass-panel p-6 rounded flex flex-col md:flex-row items-center gap-6" data-aos="flip-up">
						<div class="bg-[#2a2a2a] p-3 rounded text-center min-w-[80px]">
							<span
								class="block text-xs uppercase text-green-400">{{ \Carbon\Carbon::parse($location->event_time)->format('M') }}</span>
							<span class="block text-2xl font-bold">{{ \Carbon\Carbon::parse($location->event_time)->format('d') }}</span>
						</div>
						<div class="flex-grow text-center md:text-left">
							<h4 class="font-bold text-lg hover:underline cursor-pointer">{{ $location->name }}</h4>
							<p class="text-sm text-gray-400">{{ ucfirst($location->location_type) }} •
								{{ \Carbon\Carbon::parse($location->event_time)->format('H:i') }}</p>
							<p class="text-xs text-gray-500 mt-1">{{ $location->address }}</p>
						</div>
						@if ($location->google_maps_url)
							<a href="{{ $location->google_maps_url }}" target="_blank"
								class="border border-white/50 text-white px-6 py-2 rounded-full text-xs font-bold hover:border-white hover:scale-105 transition">
								Get Tickets
							</a>
						@endif
					</div>
				@endforeach
			</div>
		</section>

		<!-- Gift & RSVP -->
		<section class="max-w-4xl mx-auto px-6 py-8 grid md:grid-cols-2 gap-8">
			<!-- Merch (Gift) -->
			@if (isset($event->eventBanks))
				<div class="glass-panel p-8 rounded" data-aos="fade-up">
					<h3 class="font-bold text-lg mb-4">Support The Artist</h3>
					<p class="text-xs text-gray-400 mb-6">Digital gifts are appreciated.</p>
					<div class="space-y-4">
						@foreach ($event->eventBanks as $angpao)
							<div class="bg-[#282828] p-4 rounded flex items-center gap-4">
								<div class="w-10 h-10 bg-[#333] rounded-full flex items-center justify-center text-[#1db954]">
									<i class="fas fa-wallet"></i>
								</div>
								<div>
									<p class="font-bold text-sm">{{ $angpao->bank_name }}</p>
									<p class="font-mono text-xs select-all text-gray-300" id="acc-{{ $loop->index }}">
										{{ $angpao->account_number }}</p>
								</div>
								<button onclick="copyToClipboard('acc-{{ $loop->index }}')"
									class="ml-auto text-xs text-gray-400 hover:text-white">Copy</button>
							</div>
						@endforeach
					</div>
				</div>
			@endif

			<!-- Fan Club (RSVP) -->
			<div class="glass-panel p-8 rounded" data-aos="fade-up">
				<h3 class="font-bold text-lg mb-4">Join The Fan Club (RSVP)</h3>
				<form id="rsvp-form" action="{{ route('frontend.rsvp', [$event->slug, $invitation->slug]) }}" method="POST"
					class="space-y-4">
					@csrf
					<div>
						<input type="text" value="{{ $invitation->guest_name }}" readonly
							class="w-full bg-[#3e3e3e] border-none rounded p-3 text-sm text-white focus:ring-1 focus:ring-green-500">
					</div>
					<div class="grid grid-cols-2 gap-4">
						<select name="status"
							class="w-full bg-[#3e3e3e] border-none rounded p-3 text-sm text-white focus:ring-1 focus:ring-green-500">
							<option value="yes">I'm Going!</option>
							<option value="no">Can't Go</option>
						</select>
						<select name="total_guest"
							class="w-full bg-[#3e3e3e] border-none rounded p-3 text-sm text-white focus:ring-1 focus:ring-green-500">
							<option value="1">1 Ticket</option>
							<option value="2">2 Tickets</option>
						</select>
					</div>
					<textarea name="message"
					 class="w-full bg-[#3e3e3e] border-none rounded p-3 text-sm text-white focus:ring-1 focus:ring-green-500 h-24"
					 placeholder="Leave a comment..."></textarea>

					<button type="submit"
						class="w-full bg-[#1db954] text-black font-bold py-3 rounded-full hover:scale-105 transition">
						Post Comment
					</button>
				</form>
			</div>
		</section>

		<!-- Comments (Wishes) -->
		<section class="max-w-4xl mx-auto px-6 py-8" id="wishes-section">
			<h3 class="font-bold text-lg mb-6">Fan Comments</h3>
			<div id="wishes-container" class="space-y-4">
				@if (isset($wishes))
					@foreach ($wishes as $wish)
						<div class="flex gap-4 group" data-aos="fade-up">
							<div
								class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 shrink-0 flex items-center justify-center text-xs font-bold">
								{{ substr($wish->name, 0, 1) }}
							</div>
							<div class="flex-grow border-b border-gray-800 pb-4">
								<div class="flex justify-between items-baseline mb-1">
									<h5 class="font-bold text-sm hover:underline cursor-pointer">{{ $wish->name }}</h5>
									<span class="text-xs text-gray-500">{{ $wish->created_at->diffForHumans() }}</span>
								</div>
								<p class="text-sm text-gray-300">{{ $wish->message }}</p>
								<div class="flex gap-4 mt-2 text-xs text-gray-500">
									<span class="hover:text-white cursor-pointer"><i class="far fa-heart mr-1"></i> Like</span>
									<span class="hover:text-white cursor-pointer">Reply</span>
								</div>
							</div>
						</div>
					@endforeach
				@endif
			</div>
		</section>

		<!-- Player Bar (Fixed Bottom) -->
		<div class="fixed bottom-0 w-full bg-[#181818] border-t border-[#282828] p-4 flex items-center justify-between z-40">
			<div class="flex items-center gap-4 w-1/3">
				<div class="w-14 h-14 bg-gray-800 hidden md:block group relative">
					<img
						src="{{ isset($event->weddingEvent->groom_photo) ? (Str::startsWith($event->weddingEvent->groom_photo, 'http') ? $event->weddingEvent->groom_photo : Storage::url($event->weddingEvent->groom_photo)) : 'https://via.placeholder.com/56' }}"
						class="w-full h-full object-cover">
					<div class="absolute top-0 right-0 p-1 opacity-0 group-hover:opacity-100 transition">
						<i class="fas fa-chevron-up bg-black/50 rounded-full w-4 h-4 flex items-center justify-center text-[8px]"></i>
					</div>
				</div>
				<div class="overflow-hidden">
					<h4 class="text-sm font-bold text-white truncate hover:underline cursor-pointer">The Wedding Celebration</h4>
					<p class="text-xs text-gray-400 hover:underline cursor-pointer">{{ $event->weddingEvent->groom_name }} &
						{{ $event->weddingEvent->bride_name }}</p>
				</div>
				<i class="far fa-heart text-[#1db954] ml-2 hidden md:block"></i>
			</div>

			<div class="flex flex-col items-center w-1/3">
				<div class="flex items-center gap-6 mb-1 text-gray-400">
					<i class="fas fa-random text-xs hover:text-white cursor-pointer hidden md:block"></i>
					<i class="fas fa-step-backward text-base hover:text-white cursor-pointer"></i>
					<button
						class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-black hover:scale-105 transition"
						onclick="toggleMusic()">
						<i class="fas fa-pause text-sm" id="bar-play-icon"></i>
					</button>
					<i class="fas fa-step-forward text-base hover:text-white cursor-pointer"></i>
					<i class="fas fa-redo text-xs hover:text-white cursor-pointer hidden md:block"></i>
				</div>
				<div class="w-full max-w-md flex items-center gap-2 text-[10px] text-gray-400 hidden md:flex">
					<span>0:00</span>
					<div class="flex-grow h-1 bg-gray-600 rounded-full overflow-hidden">
						<div class="h-full bg-white w-1/3 rounded-full hover:bg-green-500"></div>
					</div>
					<span>3:45</span>
				</div>
			</div>

			<div class="flex items-center justify-end gap-2 w-1/3 text-gray-400">
				<i class="fas fa-list hover:text-white cursor-pointer hidden md:block"></i>
				<i class="fas fa-volume-up hover:text-white cursor-pointer ml-2"></i>
				<div class="w-20 h-1 bg-gray-600 rounded-full overflow-hidden hidden md:block">
					<div class="h-full bg-white w-3/4 rounded-full hover:bg-green-500"></div>
				</div>
			</div>
		</div>

	</div>

	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		AOS.init();

		// Cover Logic
		const cover = document.getElementById('cover');
		const main = document.getElementById('main-content');
		const openBtn = document.getElementById('open-invitation');
		const audio = document.getElementById('bg-music');
		const mainPlayBtn = document.getElementById('main-play-btn');
		const mainPlayIcon = document.getElementById('main-play-icon');
		const barPlayIcon = document.getElementById('bar-play-icon');

		openBtn.addEventListener('click', () => {
			cover.style.transition = 'opacity 0.8s ease-out';
			cover.style.opacity = '0';

			toggleMusic(true);

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
				if (mainPlayIcon) {
					mainPlayIcon.classList.remove('fa-play');
					mainPlayIcon.classList.add('fa-pause');
				}
				if (barPlayIcon) {
					barPlayIcon.classList.remove('fa-play');
					barPlayIcon.classList.add('fa-pause');
				}
			} else {
				audio.pause();
				isPlaying = false;
				if (mainPlayIcon) {
					mainPlayIcon.classList.add('fa-play');
					mainPlayIcon.classList.remove('fa-pause');
				}
				if (barPlayIcon) {
					barPlayIcon.classList.add('fa-play');
					barPlayIcon.classList.remove('fa-pause');
				}
			}
		}

		function copyToClipboard(id) {
			const text = document.getElementById(id).innerText;
			navigator.clipboard.writeText(text).then(() => {
				alert('Number Copied!');
			});
		}

		// AJAX RSVP
		document.getElementById('rsvp-form').addEventListener('submit', function(e) {
			e.preventDefault();
			const form = this;
			const btn = form.querySelector('button[type="submit"]');
			const originalText = btn.innerText;
			btn.innerText = 'Posting...';
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
						alert('Comment Posted!');
						form.reset();

						if (data.wish) {
							const container = document.getElementById('wishes-container');
							const section = document.getElementById('wishes-section');
							section.style.display = 'block';

							const html = `
                             <div class="flex gap-4 group" data-aos="fade-up">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-blue-500 shrink-0 flex items-center justify-center text-xs font-bold">
                                    ${data.wish.name.charAt(0)}
                                </div>
                                <div class="flex-grow border-b border-gray-800 pb-4">
                                    <div class="flex justify-between items-baseline mb-1">
                                        <h5 class="font-bold text-sm hover:underline cursor-pointer">${data.wish.name}</h5>
                                        <span class="text-xs text-gray-500">${data.wish.created_at_human}</span>
                                    </div>
                                    <p class="text-sm text-gray-300">${data.wish.message}</p>
                                    <div class="flex gap-4 mt-2 text-xs text-gray-500">
                                        <span class="hover:text-white cursor-pointer"><i class="far fa-heart mr-1"></i> Like</span>
                                        <span class="hover:text-white cursor-pointer">Reply</span>
                                    </div>
                                </div>
                            </div>
                        `;
							container.insertAdjacentHTML('afterbegin', html);
						}
					} else {
						alert('Post failed.');
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
