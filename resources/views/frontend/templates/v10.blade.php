@extends('layouts.frontend', ['hideNav' => true])

@section('title', $event->title)

@section('content')
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


	<style>
		/* Instagram-like Fonts & Base */
		body {
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
			background-color: #fafafa;
		}

		.phone-container {
			max-width: 480px;
			margin: 0 auto;
			background-color: #fff;
			min-height: 100vh;
			border-left: 1px solid #dbdbdb;
			border-right: 1px solid #dbdbdb;
			padding-bottom: 60px;
			/* Height of bottom nav */
			position: relative;
		}

		/* Story Rings */
		.story-ring {
			background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
			padding: 2px;
			border-radius: 50%;
			display: inline-block;
		}

		.story-ring-inner {
			background: #fff;
			padding: 2px;
			border-radius: 50%;
			display: block;
		}

		.story-ring img {
			display: block;
			border-radius: 50%;
			width: 60px;
			height: 60px;
			object-fit: cover;
		}

		/* Verified Badge */
		.verified-badge {
			color: #3897f0;
			margin-left: 4px;
			font-size: 0.8em;
		}

		/* Audio Control as Floating "Reel" icon */
		.music-control {
			position: fixed;
			bottom: 80px;
			right: 20px;
			z-index: 50;
			width: 40px;
			height: 40px;
			background: rgba(0, 0, 0, 0.7);
			color: white;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			cursor: pointer;
			animation: spin 4s linear infinite;
		}

		.music-control.paused {
			animation: none;
		}

		@keyframes spin {
			100% {
				transform: rotate(360deg);
			}
		}

		.hidden {
			display: none !important;
		}

		/* Open Button Pulse */
		@keyframes pulse-btn {
			0% {
				box-shadow: 0 0 0 0 rgba(0, 149, 246, 0.7);
			}

			70% {
				box-shadow: 0 0 0 10px rgba(0, 149, 246, 0);
			}

			100% {
				box-shadow: 0 0 0 0 rgba(0, 149, 246, 0);
			}
		}

		.btn-open {
			animation: pulse-btn 2s infinite;
		}

		/* Post Interactions */
		.interaction-icon {
			font-size: 1.5rem;
			cursor: pointer;
			transition: transform 0.1s;
		}

		.interaction-icon:active {
			transform: scale(1.2);
		}

		.liked {
			color: #ed4956;
		}
	</style>

	<!-- Background Music -->
	<audio id="bg-music" loop>
		<source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
	</audio>
	<div id="music-btn" class="music-control hidden" onclick="toggleMusic()">
		<i class="fas fa-music"></i>
	</div>

	<!-- COVER SECTION (Splash) -->
	<div id="cover"
		class="fixed inset-0 z-50 bg-white flex flex-col items-center justify-center text-center max-w-[480px] mx-auto border-x border-gray-200">
		<div class="mb-6 story-ring p-1 scale-150">
			<div class="story-ring-inner">
				<img
					src="{{ isset($event->weddingEvent->groom_photo) ? Storage::url($event->weddingEvent->groom_photo) : 'https://via.placeholder.com/150' }}"
					alt="Couple">
			</div>
		</div>
		<h1 class="text-2xl font-bold mb-1">
			{{ $event->weddingEvent->groom_name ?? 'Groom' }} & {{ $event->weddingEvent->bride_name ?? 'Bride' }}
			<i class="fas fa-check-circle verified-badge"></i>
		</h1>
		<p class="text-gray-500 mb-8 max-w-xs mx-auto">
			You are invited to our wedding celebration.
		</p>

		<!-- Countdown Cover -->
		<div class="flex space-x-4 text-center mb-10 justify-center">
			<div class="bg-gray-50 p-2 rounded w-16">
				<span id="c-days" class="text-xl font-bold block">00</span>
				<span class="text-[10px] uppercase text-gray-400">Days</span>
			</div>
			<div class="bg-gray-50 p-2 rounded w-16">
				<span id="c-hours" class="text-xl font-bold block">00</span>
				<span class="text-[10px] uppercase text-gray-400">Hrs</span>
			</div>
			<div class="bg-gray-50 p-2 rounded w-16">
				<span id="c-minutes" class="text-xl font-bold block">00</span>
				<span class="text-[10px] uppercase text-gray-400">Min</span>
			</div>
			<div class="bg-gray-50 p-2 rounded w-16">
				<span id="c-seconds" class="text-xl font-bold block">00</span>
				<span class="text-[10px] uppercase text-gray-400">Sec</span>
			</div>
		</div>


		<button id="open-invitation" class="btn-open bg-[#0095f6] text-white px-8 py-3 rounded font-bold text-sm">
			View Invitation
		</button>

		<div class="mt-8">
			<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Instagram_logo.svg/1200px-Instagram_logo.svg.png"
				alt="Instagram" class="w-24 mx-auto opacity-50">
		</div>
	</div>


	<div id="main-content" class="phone-container hidden">

		<!-- Header -->
		<header class="sticky top-0 z-40 bg-white border-b border-gray-200 px-4 py-3 flex justify-between items-center">
			<div class="text-xl font-bold font-serif italic">WeddingGram</div>
			<div class="flex space-x-4 text-2xl">
				<i class="far fa-heart"></i>
				<i class="far fa-paper-plane"></i>
			</div>
		</header>

		<!-- Stories -->
		<div class="py-4 border-b border-gray-200 overflow-x-auto whitespace-nowrap px-4 hide-scroll">
			<!-- Story Item: Groom -->
			<div class="inline-block text-center mr-4">
				<div class="story-ring">
					<div class="story-ring-inner">
						<img
							src="{{ isset($event->weddingEvent->groom_photo) ? Storage::url($event->weddingEvent->groom_photo) : 'https://via.placeholder.com/150' }}"
							alt="Groom">
					</div>
				</div>
				<p class="text-xs mt-1 truncate w-16 text-gray-700">Groom</p>
			</div>
			<!-- Story Item: Bride -->
			<div class="inline-block text-center mr-4">
				<div class="story-ring">
					<div class="story-ring-inner">
						<img
							src="{{ isset($event->weddingEvent->bride_photo) ? Storage::url($event->weddingEvent->bride_photo) : 'https://via.placeholder.com/150' }}"
							alt="Bride">
					</div>
				</div>
				<p class="text-xs mt-1 truncate w-16 text-gray-700">Bride</p>
			</div>
			<!-- Story Item: Location -->
			<div class="inline-block text-center mr-4">
				<div class="story-ring p-[1px] bg-gray-300 border-none">
					<!-- Unseen/Grayed if wanted, keeping colored for "live" feel -->
					<div class="story-ring-inner">
						<div class="w-[60px] h-[60px] bg-gray-100 rounded-full flex items-center justify-center text-2xl">
							📍
						</div>
					</div>
				</div>
				<p class="text-xs mt-1 truncate w-16 text-gray-700">Location</p>
			</div>
			<!-- Story Item: Date -->
			<div class="inline-block text-center mr-4">
				<div class="story-ring p-[1px] bg-gray-300 border-none">
					<div class="story-ring-inner">
						<div class="w-[60px] h-[60px] bg-gray-100 rounded-full flex items-center justify-center text-2xl">
							📅
						</div>
					</div>
				</div>
				<p class="text-xs mt-1 truncate w-16 text-gray-700">Date</p>
			</div>
		</div>

		<!-- POST 1: Main Couple -->
		<article class="bg-white mb-4">
			<!-- Header -->
			<div class="flex items-center p-3">
				<div class="story-ring p-0.5 mr-3 w-8 h-8 flex items-center justify-center">
					<img
						src="{{ isset($event->weddingEvent->groom_photo) ? Storage::url($event->weddingEvent->groom_photo) : 'https://via.placeholder.com/150' }}"
						class="w-full h-full rounded-full">
				</div>
				<div class="flex-1">
					<div class="font-bold text-sm">{{ $event->weddingEvent->groom_name }} & {{ $event->weddingEvent->bride_name }} <i
							class="fas fa-check-circle verified-badge"></i></div>
					<div class="text-xs text-gray-500">{{ $event->location_name ?? 'Wedding Location' }}</div>
				</div>
				<i class="fas fa-ellipsis-h text-gray-500"></i>
			</div>
			<!-- Image -->
			<div class="w-full bg-gray-100 aspect-square relative" data-aos="fade-in">
				<div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
					<p class="text-lg font-serif">The Wedding Of</p>
					<h2 class="text-4xl font-serif italic my-4">{{ $event->weddingEvent->groom_name }} <br> &
						<br>{{ $event->weddingEvent->bride_name }}</h2>
					<p class="text-sm font-light">{{ \Carbon\Carbon::parse($event->event_date)->format('l, d F Y') }}</p>
				</div>
				<img src="https://www.transparenttextures.com/patterns/clean-gray-paper.png"
					class="absolute inset-0 w-full h-full opacity-30 pointer-events-none">
			</div>

			<!-- Actions -->
			<div class="p-3">
				<div class="flex justify-between text-2xl mb-2">
					<div class="flex space-x-4">
						<i class="far fa-heart interaction-icon" onclick="toggleLike(this)"></i>
						<a href="#rsvp-section"><i class="far fa-comment interaction-icon"></i></a>
						<i class="far fa-paper-plane interaction-icon"></i>
					</div>
					<i class="far fa-bookmark interaction-icon"></i>
				</div>
				<div class="font-bold text-sm mb-1">2,492 likes</div>
				<div class="text-sm">
					<span class="font-bold mr-1">{{ $event->weddingEvent->groom_name }}</span>
					<span>We are getting married! Please join us in our celebration of love. #WeddingDay #{{ $event->slug }}</span>
				</div>
				<div class="text-xs text-gray-500 mt-1 uppercase">2 HOURS AGO</div>
			</div>
		</article>

		<!-- POST 2: Profile Groom -->
		<article class="bg-white mb-4 border-t border-gray-100">
			<div class="flex items-center p-3">
				<img
					src="{{ isset($event->weddingEvent->groom_photo) ? Storage::url($event->weddingEvent->groom_photo) : 'https://via.placeholder.com/150' }}"
					class="w-8 h-8 rounded-full mr-3 object-cover">
				<div class="font-bold text-sm flex-1">{{ $event->weddingEvent->groom_name }}</div>
				<button class="text-[#0095f6] font-bold text-sm text-blue-500 text-xs">Follow</button>
			</div>
			<div class="w-full aspect-[4/5] bg-gray-100 overflow-hidden" data-aos="fade-up">
				<img
					src="{{ isset($event->weddingEvent->groom_photo) ? Storage::url($event->weddingEvent->groom_photo) : 'https://via.placeholder.com/400x500' }}"
					class="w-full h-full object-cover">
			</div>
			<div class="p-3">
				<div class="flex justify-between text-2xl mb-2">
					<div class="flex space-x-4">
						<i class="far fa-heart interaction-icon" onclick="toggleLike(this)"></i>
						<i class="far fa-comment interaction-icon"></i>
					</div>
				</div>
				<div class="text-sm">
					<span class="font-bold mr-1">{{ $event->weddingEvent->groom_name }}</span>
					<span>The Groom. Son of {{ $event->weddingEvent->groom_parent }}</span>
				</div>
				@if ($event->weddingEvent->groom_instagram)
					<a href="https://instagram.com/{{ $event->weddingEvent->groom_instagram }}" target="_blank"
						class="text-blue-900 text-xs block mt-1">@ {{ $event->weddingEvent->groom_instagram }}</a>
				@endif
			</div>
		</article>

		<!-- POST 3: Profile Bride -->
		<article class="bg-white mb-4 border-t border-gray-100">
			<div class="flex items-center p-3">
				<img
					src="{{ isset($event->weddingEvent->bride_photo) ? Storage::url($event->weddingEvent->bride_photo) : 'https://via.placeholder.com/150' }}"
					class="w-8 h-8 rounded-full mr-3 object-cover">
				<div class="font-bold text-sm flex-1">{{ $event->weddingEvent->bride_name }}</div>
				<button class="text-[#0095f6] font-bold text-sm text-blue-500 text-xs">Follow</button>
			</div>
			<div class="w-full aspect-[4/5] bg-gray-100 overflow-hidden" data-aos="fade-up">
				<img
					src="{{ isset($event->weddingEvent->bride_photo) ? Storage::url($event->weddingEvent->bride_photo) : 'https://via.placeholder.com/400x500' }}"
					class="w-full h-full object-cover">
			</div>
			<div class="p-3">
				<div class="flex justify-between text-2xl mb-2">
					<div class="flex space-x-4">
						<i class="far fa-heart interaction-icon" onclick="toggleLike(this)"></i>
						<i class="far fa-comment interaction-icon"></i>
					</div>
				</div>
				<div class="text-sm">
					<span class="font-bold mr-1">{{ $event->weddingEvent->bride_name }}</span>
					<span>The Bride. Daughter of {{ $event->weddingEvent->bride_parent }}</span>
				</div>
				@if ($event->weddingEvent->bride_instagram)
					<a href="https://instagram.com/{{ $event->weddingEvent->bride_instagram }}" target="_blank"
						class="text-blue-900 text-xs block mt-1">@ {{ $event->weddingEvent->bride_instagram }}</a>
				@endif
			</div>
		</article>

		<!-- POST 4: Events & Location -->
		@if (isset($event->eventLocations) && count($event->eventLocations) > 0)
			@foreach ($event->eventLocations as $location)
				<article class="bg-white mb-4 border-t border-gray-100">
					<div class="flex items-center p-3">
						<div class="w-8 h-8 rounded-full mr-3 bg-red-100 flex items-center justify-center"><i
								class="fas fa-map-marker-alt text-red-500 text-sm"></i></div>
						<div class="font-bold text-sm flex-1">{{ $location->location_type }}</div>
					</div>
					<div class="w-full bg-gray-100 p-8 text-center" data-aos="zoom-in">
						<h3 class="text-2xl font-serif mb-2">{{ $location->location_type }}</h3>
						<p class="text-lg font-bold">{{ \Carbon\Carbon::parse($location->event_time)->format('H:i') }} WIB</p>
						<p class="text-gray-600 mb-4">{{ \Carbon\Carbon::parse($event->event_date)->format('l, d F Y') }}</p>
						<div class="border-t border-b border-gray-300 py-4 my-4">
							<p class="font-bold">{{ $location->name }}</p>
							<p class="text-sm text-gray-500 px-8">{{ $location->address }}</p>
						</div>
						@if ($location->google_maps_url)
							<a href="{{ $location->google_maps_url }}" target="_blank"
								class="inline-block bg-[#0095f6] text-white px-6 py-2 rounded text-sm font-bold">View Location</a>
						@endif
					</div>
					<div class="p-3">
						<div class="flex justify-between text-2xl mb-2">
							<div class="flex space-x-4">
								<i class="far fa-heart interaction-icon" onclick="toggleLike(this)"></i>
							</div>
						</div>
						<div class="text-sm">
							<span class="font-bold mr-1">Location</span>
							<span>Save the date and don't get lost! 🗺️</span>
						</div>
					</div>
				</article>
			@endforeach
		@endif


		<!-- POST 5: Gallery (Carousel) -->
		@if (isset($event->eventGalleries) && count($event->eventGalleries) > 0)
			<article class="bg-white mb-4 border-t border-gray-100">
				<div class="flex items-center p-3">
					<div class="w-8 h-8 rounded-full mr-3 bg-purple-100 flex items-center justify-center"><i
							class="fas fa-images text-purple-500 text-sm"></i></div>
					<div class="font-bold text-sm flex-1">Our Moments</div>
				</div>

				<div class="overflow-x-scroll flex snap-x snap-mandatory hide-scroll">
					@foreach ($event->eventGalleries as $photo)
						<div class="snap-start min-w-full aspect-[4/5] relative">
							<img src="{{ Storage::url($photo->image_path) }}" class="w-full h-full object-cover">
							@if ($photo->caption)
								<div class="absolute bottom-4 left-4 right-4 bg-black/50 text-white text-xs p-2 rounded">
									{{ $photo->caption }}
								</div>
							@endif
							<div class="absolute top-4 right-4 bg-black/50 text-white text-xs px-2 py-1 rounded-full">
								{{ $loop->iteration }}/{{ count($event->eventGalleries) }}
							</div>
						</div>
					@endforeach
				</div>

				<div class="p-3">
					<div class="flex justify-between text-2xl mb-2">
						<div class="flex space-x-4">
							<i class="far fa-heart interaction-icon" onclick="toggleLike(this)"></i>
						</div>
					</div>
					<div class="text-sm">
						<span class="font-bold mr-1">Gallery</span>
						<span>Capturing our favorite moments together. 📸</span>
					</div>
				</div>
			</article>
		@endif

		<!-- POST 6: RSVP Form (Sponsored Ad Style) -->
		<article class="bg-white mb-4 border-t border-gray-100" id="rsvp-section">
			<div class="flex items-center p-3 justify-between">
				<div class="flex items-center">
					<div class="w-8 h-8 rounded-full mr-3 bg-gray-200 flex items-center justify-center"><i
							class="fas fa-envelope-open-text text-gray-500 text-sm"></i></div>
					<div>
						<div class="font-bold text-sm">RSVP</div>
						<div class="text-xs text-gray-400">Sponsored</div>
					</div>
				</div>
			</div>

			<div class="p-6 bg-blue-50">
				<h3 class="text-center font-bold mb-4 text-[#0095f6]">Will you attend?</h3>
				<form id="rsvp-form" action="{{ route('frontend.rsvp', [$event->slug, $invitation->slug]) }}" method="POST"
					class="space-y-4">
					@csrf
					<div>
						<input type="text" name="name" value="{{ $invitation->guest_name ?? '' }}" placeholder="Your Name"
							class="w-full border border-gray-300 rounded p-2 text-sm bg-white focus:border-blue-500 focus:outline-none">
					</div>
					<div class="flex space-x-2">
						<select name="attendance"
							class="w-1/2 border border-gray-300 rounded p-2 text-sm bg-white focus:border-blue-500 focus:outline-none">
							<option value="valid">Attend</option>
							<option value="unable">Unable</option>
						</select>
						<select name="total_guest"
							class="w-1/2 border border-gray-300 rounded p-2 text-sm bg-white focus:border-blue-500 focus:outline-none">
							<option value="1">1 Person</option>
							<option value="2">2 Persons</option>
						</select>
					</div>
					<div>
						<textarea name="message" placeholder="Write a wish..."
						 class="w-full border border-gray-300 rounded p-2 text-sm bg-white focus:border-blue-500 focus:outline-none h-20"></textarea>
					</div>
					<button type="submit"
						class="w-full bg-[#0095f6] text-white py-2 rounded font-bold text-sm hover:bg-blue-600 transition">Confim
						Presence</button>
				</form>
			</div>
			<div class="p-3 border-t border-gray-100 bg-blue-50 text-center">
				<p class="text-xs text-blue-900 font-bold">Sign up to let us know!</p>
			</div>
		</article>

		<!-- POST 7: Gift (Optional) -->
		@if (isset($event->eventBanks) && count($event->eventBanks) > 0)
			<article class="bg-white mb-4 border-t border-gray-100">
				<div class="flex items-center p-3">
					<div class="w-8 h-8 rounded-full mr-3 bg-green-100 flex items-center justify-center"><i
							class="fas fa-gift text-green-500 text-sm"></i></div>
					<div class="font-bold text-sm flex-1">Wedding Gift</div>
				</div>
				<div class="p-6 text-center space-y-4">
					<p class="text-sm text-gray-600">Your blessing is the greatest gift. However, if you wish to give something, it
						will be appreciated.</p>
					@foreach ($event->eventBanks as $index => $angpao)
						<div class="border border-green-200 bg-green-50 rounded p-4 relative">
							<i class="far fa-credit-card mx-auto text-2xl text-green-600 mb-2"></i>
							<h4 class="font-bold text-sm">{{ $angpao->bank_name }}</h4>
							<p class="text-lg font-mono my-1 select-all" id="acc-{{ $index }}">{{ $angpao->account_number }}</p>
							<p class="text-xs text-gray-500 uppercase">{{ $angpao->account_name }}</p>
							<button onclick="copyToClipboard('acc-{{ $index }}')"
								class="mt-2 text-xs text-green-600 font-bold underline">Copy Number</button>
						</div>
					@endforeach
				</div>
			</article>
		@endif


		<!-- POST 8: Wishes (Comments) -->
		<article class="bg-white mb-20 border-t border-gray-100"> <!-- mb-20 for bottom nav space -->
			<div class="flex items-center p-3">
				<div class="font-bold text-sm">Comments (Wishes)</div>
			</div>

			<div class="px-3" id="wishes-container">
				@if (isset($wishes))
					@foreach ($wishes as $wish)
						<div class="mb-3 flex group">
							<div
								class="w-8 h-8 rounded-full bg-gray-200 mr-3 flex-shrink-0 flex items-center justify-center text-xs font-bold text-gray-500">
								{{ substr($wish->name, 0, 1) }}
							</div>
							<div>
								<div class="text-sm">
									<span class="font-bold mr-1">{{ $wish->name }}</span>
									<span class="text-gray-800">{{ $wish->message }}</span>
								</div>
								<div class="flex items-center mt-1 space-x-3 text-xs text-gray-500">
									<span>{{ $wish->created_at->diffForHumans(null, true, true) }}</span>
									<span class="font-bold cursor-pointer">Reply</span>
								</div>
							</div>
							<div class="ml-auto flex items-center">
								<i class="far fa-heart text-xs text-gray-400 cursor-pointer hover:text-red-500" onclick="toggleLike(this)"></i>
							</div>
						</div>
					@endforeach
				@endif
			</div>
		</article>


		<!-- Bottom Nav -->
		<nav
			class="fixed bottom-0 max-w-[480px] w-full bg-white border-t border-gray-200 flex justify-around py-3 z-50 text-2xl text-gray-800">
			<a href="#" onclick="window.scrollTo(0, 0); return false;"><i class="fas fa-home text-black"></i></a>
			<i class="fas fa-search"></i>
			<i class="far fa-plus-square"></i>
			<i class="far fa-heart"></i>
			<div class="w-6 h-6 rounded-full overflow-hidden border border-black">
				<img
					src="{{ isset($event->weddingEvent->groom_photo) ? Storage::url($event->weddingEvent->groom_photo) : 'https://via.placeholder.com/150' }}"
					class="w-full h-full object-cover">
			</div>
		</nav>

	</div>


	<!-- Scripts -->
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		// Init AOS
		AOS.init();

		// Open Invitation
		document.getElementById('open-invitation').addEventListener('click', function() {
			const cover = document.getElementById('cover');
			const main = document.getElementById('main-content');

			// Audio
			toggleMusic(true);
			document.getElementById('music-btn').classList.remove('hidden');

			cover.style.transition = "opacity 0.5s ease";
			cover.style.opacity = "0";

			setTimeout(() => {
				cover.style.display = 'none';
				main.classList.remove('hidden');
				window.scrollTo(0, 0);
			}, 500);
		});

		// Like Toggle
		function toggleLike(el) {
			if (el.classList.contains('far')) {
				el.classList.remove('far');
				el.classList.add('fas');
				el.classList.add('liked');
				el.classList.add('text-red-500');
			} else {
				el.classList.add('far');
				el.classList.remove('fas');
				el.classList.remove('liked');
				el.classList.remove('text-red-500');
			}
		}

		// Music
		const audio = document.getElementById('bg-music');
		const musicBtn = document.getElementById('music-btn');
		let isPlaying = false;

		function toggleMusic(forcePlay = false) {
			if (forcePlay || !isPlaying) {
				audio.play().catch(e => console.log("Audio play failed interaction needed"));
				isPlaying = true;
				musicBtn.classList.remove('paused');
			} else {
				audio.pause();
				isPlaying = false;
				musicBtn.classList.add('paused');
			}
		}

		// Countdown
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

		// Copy Text
		function copyToClipboard(id) {
			const text = document.getElementById(id).innerText;
			navigator.clipboard.writeText(text).then(() => {
				alert('Copied to clipboard!');
			});
		}

		// Ajax RSVP
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
						alert('Comment posted (RSVP Sent)!');
						form.reset();

						// Add wish if present
						if (data.wish) {
							const container = document.getElementById('wishes-container');

							const html = `
                                <div class="mb-3 flex group animate-fade-in-up">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 mr-3 flex-shrink-0 flex items-center justify-center text-xs font-bold text-gray-500">
                                        ${data.wish.name.substring(0,1)}
                                    </div>
                                    <div>
                                        <div class="text-sm">
                                            <span class="font-bold mr-1">${data.wish.name}</span>
                                            <span class="text-gray-800">${data.wish.message}</span>
                                        </div>
                                        <div class="flex items-center mt-1 space-x-3 text-xs text-gray-500">
                                            <span>Just now</span>
                                            <span class="font-bold cursor-pointer">Reply</span>
                                        </div>
                                    </div>
                                     <div class="ml-auto flex items-center">
                                        <i class="far fa-heart text-xs text-gray-400 cursor-pointer hover:text-red-500" onclick="toggleLike(this)"></i>
                                    </div>
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
