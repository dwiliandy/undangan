@extends('layouts.frontend', ['hideNav' => true])

@section('title', $event->title)

@section('content')
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Rye&family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
	<!-- AOS -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

	<style>
		body {
			background-color: #2c1e16;
			background-image: url('https://www.transparenttextures.com/patterns/wood-pattern.png');
			/* Fallback/Blend */
			font-family: 'Cinzel', serif;
			color: #4a3b2a;
			overflow-x: hidden;
		}

		.parchment-bg {
			background-color: #f4e4bc;
			background-image: url('https://www.transparenttextures.com/patterns/aged-paper.png');
			min-height: 100vh;
			max-width: 600px;
			margin: 0 auto;
			box-shadow: 0 0 50px rgba(0, 0, 0, 0.5);
			position: relative;
			overflow: hidden;
		}

		/* Torn Edge Effect Top/Bottom */
		.torn-edge-top {
			height: 20px;
			background: linear-gradient(135deg, transparent 50%, #f4e4bc 50%), linear-gradient(45deg, #f4e4bc 50%, transparent 50%);
			background-size: 20px 20px;
			margin-top: -10px;
		}

		.pirate-font {
			font-family: 'Rye', serif;
		}

		/* WANTED POSTER */
		.wanted-poster {
			background: #fff8dc;
			border: 4px solid #4a3b2a;
			padding: 20px;
			margin: 20px auto;
			max-width: 320px;
			text-align: center;
			box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
			position: relative;
			transform: rotate(-2deg);
		}

		.wanted-poster:nth-child(even) {
			transform: rotate(2deg);
		}

		.wanted-header {
			font-family: 'Rye', serif;
			font-size: 3rem;
			color: #4a3b2a;
			letter-spacing: 2px;
			line-height: 1;
			margin-bottom: 5px;
			text-transform: uppercase;
		}

		.wanted-subheader {
			font-family: 'Cinzel', serif;
			font-weight: bold;
			font-size: 0.9rem;
			margin-bottom: 10px;
			border-bottom: 2px solid #4a3b2a;
			padding-bottom: 5px;
		}

		.wanted-image-container {
			width: 100%;
			height: 350px;
			/* Portrait aspect ratio */
			background: #ccc;
			border: 2px solid #4a3b2a;
			margin-bottom: 10px;
			overflow: hidden;
			position: relative;
		}

		.wanted-image-container img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			filter: sepia(0.3) contrast(1.1);
		}

		.wanted-name {
			font-family: 'Rye', serif;
			font-size: 1.8rem;
			text-transform: uppercase;
			margin: 10px 0 5px;
			line-height: 1.2;
			word-wrap: break-word;
		}

		.bounty {
			font-family: 'Rye', serif;
			font-size: 1.2rem;
			color: #4a3b2a;
			border-top: 2px solid #4a3b2a;
			padding-top: 5px;
			margin-top: 10px;
		}

		.belly-icon {
			font-family: sans-serif;
			/* Simulating the B symbol */
			font-weight: bold;
		}

		/* Floating Elements */
		.skull-icon {
			font-size: 3rem;
			color: #4a3b2a;
			opacity: 0.8;
			margin: 20px 0;
			animation: float 3s ease-in-out infinite;
		}

		@keyframes float {

			0%,
			100% {
				transform: translateY(0);
			}

			50% {
				transform: translateY(-10px);
			}
		}

		/* Buttons */
		.pirate-btn {
			background-color: #8b0000;
			color: #fffbd5;
			font-family: 'Rye', serif;
			border: 2px solid #fffbd5;
			padding: 12px 30px;
			text-transform: uppercase;
			letter-spacing: 1px;
			cursor: pointer;
			transition: all 0.3s;
			box-shadow: 3px 3px 0 #000;
			display: inline-block;
			text-decoration: none;
		}

		.pirate-btn:hover {
			background-color: #a52a2a;
			transform: translate(-1px, -1px);
			box-shadow: 4px 4px 0 #000;
		}

		.pirate-btn:active {
			transform: translate(2px, 2px);
			box-shadow: 1px 1px 0 #000;
		}

		/* Map Section */
		.map-section {
			background-image: url('https://www.transparenttextures.com/patterns/black-scales.png');
			background-color: #d2b48c;
			padding: 30px 20px;
			border: 3px dashed #8b4513;
			margin: 20px;
			position: relative;
		}

		.x-mark {
			color: #8b0000;
			font-family: 'Rye', serif;
			font-size: 4rem;
			position: absolute;
			top: -20px;
			right: -10px;
			transform: rotate(-15deg);
		}

		/* Music Control */
		.music-control-pirate {
			position: fixed;
			bottom: 20px;
			right: 20px;
			z-index: 100;
			background: #8b0000;
			width: 50px;
			height: 50px;
			border-radius: 50%;
			border: 2px solid #ffd700;
			color: #ffd700;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 1.5rem;
			cursor: pointer;
		}

		/* Cover */
		#cover {
			background-image: url('https://www.transparenttextures.com/patterns/wood-pattern.png');
			background-color: #2c1e16;
			color: #f4e4bc;
			text-align: center;
		}

		.jolly-roger {
			width: 150px;
			margin-bottom: 20px;
			filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.5));
		}
	</style>

	<!-- Audio -->
	<audio id="bg-music" loop>
		<!-- Suggesting We Are! or Binks Sake if user had it, fallback to generic -->
		<source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3" type="audio/mpeg">
	</audio>
	<div id="music-btn" class="music-control-pirate hidden" onclick="toggleMusic()">
		<i class="fas fa-compact-disc fa-spin"></i>
	</div>


	<div id="cover" class="fixed inset-0 z-50 flex flex-col items-center justify-center p-6 bg-[#2c1e16] text-center">
		<!-- Luffy's Jolly Roger -->
		<img src="{{ asset('image/v11/luffy_jollyRoger.jpg') }}" alt="Jolly Roger" class="jolly-roger animate-pulse">

		<h2 class="pirate-font text-xl mb-1 text-[#f4e4bc]">THE NEW ADVENTURE OF</h2>
		<h1 class="pirate-font text-3xl mb-4 text-[#ffd700] drop-shadow-lg uppercase leading-tight">
			{{ $event->weddingEvent->groom_name }} <br>
			<span class="text-xl">&</span> <br>
			{{ $event->weddingEvent->bride_name }}
		</h1>

		<div class="mb-10 text-xl font-serif text-[#f4e4bc]">
			Is About To Begin!
		</div>

		<button id="open-invitation" class="pirate-btn text-xl z-20 relative">
			SET SAIL!
		</button>

		<!-- Sunny Go Ornament -->
		<img src="{{ asset('image/v11/sunny_go.png') }}"
			class="absolute bottom-4 left-4 w-32 md:w-48 opacity-90 animate-bounce cursor-pointer hover:scale-110 transition z-10"
			alt="Thousand Sunny" style="animation-duration: 3s;">

		<!-- Going Merry Ornament -->
		<div class="absolute top-4 right-4 z-10 opacity-80">
			<img src="https://static.wikia.nocookie.net/onepiece/images/6/6f/Going_Merry_Infobox.png"
				class="w-24 md:w-32 transform -rotate-12" alt="Going Merry">
		</div>
	</div>


	<div id="main-content" class="parchment-bg hidden">

		<!-- Hero -->
		<section class="p-8 text-center pt-16 relative">
			<h1 class="pirate-font text-4xl mb-2">THE GRAND<br>WEDDING</h1>
			<div class="w-32 h-1 bg-[#4a3b2a] mx-auto mb-4"></div>
			<p class="font-bold text-xl uppercase tracking-widest mb-8">
				{{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
			</p>

			<!-- Groom Wanted Poster -->
			<div class="wanted-poster" data-aos="flip-left">
				<div class="wanted-header">WANTED</div>
				<div class="wanted-subheader">ONLY ALIVE</div>
				<div class="wanted-image-container">
					<img
						src="{{ isset($event->weddingEvent->groom_photo) ? Storage::url($event->weddingEvent->groom_photo) : asset('image/couple/grooms.jpg') }}"
						alt="Groom">
				</div>
				<div class="wanted-name">{{ $event->weddingEvent->groom_name }}</div>
				<p class="font-serif text-sm italic mb-1">Son of {{ $event->weddingEvent->groom_parent }}</p>

				<div class="bounty">
					<span class="belly-icon">฿</span> 5,500,000,000 -
				</div>
				<p class="text-xs uppercase mt-2 font-bold">GROOM OF THE SEAS</p>
			</div>

			<div class="my-8 text-3xl font-bold pirate-font text-[#8b0000]">&</div>

			<!-- Bride Wanted Poster -->
			<div class="wanted-poster" data-aos="flip-right">
				<div class="wanted-header">WANTED</div>
				<div class="wanted-subheader">ONLY ALIVE</div>
				<div class="wanted-image-container">
					<img
						src="{{ isset($event->weddingEvent->bride_photo) ? Storage::url($event->weddingEvent->bride_photo) : asset('image/couple/brides.jpg') }}"
						alt="Bride">
				</div>
				<div class="wanted-name">{{ $event->weddingEvent->bride_name }}</div>
				<p class="font-serif text-sm italic mb-1">Daughter of {{ $event->weddingEvent->bride_parent }}</p>

				<div class="bounty">
					<span class="belly-icon">฿</span> 5,000,000,000 -
				</div>
				<p class="text-xs uppercase mt-2 font-bold">BRIDE OF THE SEAS</p>
			</div>

		</section>

		<!-- Love Story (Treasure Map Style) -->
		<section class="p-6 text-center relative overflow-hidden" id="love-story-section">

			<i class="fas fa-map-marked-alt text-4xl text-[#8b4513] mb-4 relative z-10"></i>
			<h2 class="pirate-font text-2xl mb-8 relative z-10">THE VOYAGE OF LOVE</h2>

			<div class="relative w-full max-w-lg mx-auto">
				<!-- SVG Path Container -->
				<svg class="absolute top-0 left-0 w-full h-full pointer-events-none" style="z-index: 0; min-height: 600px;"
					preserveAspectRatio="none">
					<!-- The Path (Dashed initially, then becomes solid or draws) -->
					<path id="map-path" d="M 150 20 Q 250 150 150 250 Q 50 400 150 550" stroke="#8b4513" stroke-width="4"
						fill="none" stroke-dasharray="1000" stroke-dashoffset="1000" style="transition: stroke-dashoffset 4s linear;" />
				</svg>

				@if (isset($event->eventJourneys))
					<div class="space-y-24 relative z-10 pt-10">
						@foreach ($event->eventJourneys as $index => $journey)
							<div
								class="island-item relative bg-[#fff8dc] border-2 border-[#8b4513] p-4 mx-auto transform hover:scale-105 transition duration-300 shadow-lg opacity-0 translate-y-10"
								style="max-width:280px; {{ $index % 2 == 0 ? 'margin-right: auto; margin-left: 20px;' : 'margin-left: auto; margin-right: 20px;' }}"
								data-index="{{ $index }}">

								<!-- Island Marker -->
								<div
									class="absolute -top-4 -left-4 w-10 h-10 bg-[#8b0000] rounded-full flex items-center justify-center text-[#ffd700] font-bold border-2 border-[#ffd700]">
									{{ $index + 1 }}
								</div>

								<h3 class="pirate-font text-lg text-[#8b4513] border-b border-[#8b4513] pb-1 mb-2">
									{{ $journey->title }}
								</h3>
								<p class="font-bold text-sm mb-1 text-[#5c4033]">
									{{ \Carbon\Carbon::parse($journey->journey_date)->format('F Y') }}
								</p>
								<p class="text-sm italic font-serif leading-snug">"{{ $journey->description }}"</p>
							</div>
						@endforeach
					</div>
				@endif
			</div>

			<div class="mt-12 relative z-10">
				<p class="font-bold">And so, the greatest adventure begins...</p>
			</div>
		</section>

		<script>
			document.addEventListener('DOMContentLoaded', function() {
				// Custom Intersection Observer for Map Animation
				const section = document.getElementById('love-story-section');
				const path = document.getElementById('map-path');
				const islands = document.querySelectorAll('.island-item');

				const observer = new IntersectionObserver((entries) => {
					entries.forEach(entry => {
						if (entry.isIntersecting) {
							// Start Path Animation
							path.style.strokeDashoffset = '0';

							// Animate Islands sequentially
							islands.forEach((island, index) => {
								setTimeout(() => {
									island.classList.remove('opacity-0', 'translate-y-10');
									island.classList.add('opacity-100', 'translate-y-0');
								}, (index + 1) * 800); // Staggered delay aligned with path drawing
							});

							observer.unobserve(entry.target);
						}
					});
				}, {
					threshold: 0.2
				});

				observer.observe(section);
			});
		</script>


		<!-- Locations (Treasure Map) -->
		<section class="p-4">
			@if (isset($event->eventLocations) && count($event->eventLocations) > 0)
				<h2 class="pirate-font text-3xl text-center mb-6">DESTINATIONS</h2>

				@foreach ($event->eventLocations as $location)
					<div class="map-section" data-aos="zoom-in">
						<div class="x-mark">X</div>
						<h3 class="pirate-font text-xl mb-2 uppercase border-b-2 border-[#8b4513] inline-block">
							{{ $location->location_type }}</h3>
						<p class="text-3xl font-bold font-serif my-2">{{ \Carbon\Carbon::parse($location->event_time)->format('H:i') }}
						</p>
						<p class="font-bold text-lg">{{ $location->name }}</p>
						<p class="text-sm mb-4">{{ $location->address }}</p>

						@if ($location->google_maps_url)
							<a href="{{ $location->google_maps_url }}" target="_blank" class="pirate-btn text-sm">
								<i class="fas fa-map-marked-alt mr-2"></i> LOG POSE
							</a>
						@endif
					</div>
				@endforeach
			@endif
		</section>

		<!-- Gallery -->
		@if (isset($event->eventGalleries) && count($event->eventGalleries) > 0)
			<section class="p-6 text-center bg-[#eaddcf]">
				<h2 class="pirate-font text-3xl mb-8">ADVENTURE LOGS</h2>
				<div class="grid grid-cols-2 gap-4">
					@foreach ($event->eventGalleries as $photo)
						<div class="border-4 border-[#4a3b2a] bg-white p-2 transform hover:scale-105 transition duration-300"
							data-aos="fade-up">
							<img src="{{ Storage::url($photo->image_path) }}" class="w-full h-32 object-cover sepia">
						</div>
					@endforeach
				</div>
			</section>
		@endif

		<!-- RSVP -->
		<section class="p-8 text-center bg-[#4a3b2a] text-[#f4e4bc] relative mt-10">
			<div
				class="absolute top-0 left-0 w-full h-4 bg-[url('https://www.transparenttextures.com/patterns/black-scales.png')] opacity-20">
			</div>

			<h2 class="pirate-font text-3xl mb-4 text-[#ffd700]">JOIN THE CREW!</h2>
			<p class="mb-8">Will you board our ship and sail with us?</p>

			<form id="rsvp-form" action="{{ route('frontend.rsvp', [$event->slug, $invitation->slug]) }}" method="POST"
				class="space-y-4 max-w-sm mx-auto">
				@csrf
				<input type="text" name="name" value="{{ $invitation->guest_name ?? '' }}"
					class="w-full p-3 bg-[#f4e4bc] text-[#4a3b2a] font-bold border-2 border-[#ffd700] placeholder-[#8b4513]"
					placeholder="Pirate Name">

				<select name="status" class="w-full p-3 bg-[#f4e4bc] text-[#4a3b2a] font-bold border-2 border-[#ffd700]">
					<option value="yes">I'll Board the Ship! (Attend)</option>
					<option value="no">Stranded on Island... (Unable)</option>
				</select>

				<select name="total_guest" class="w-full p-3 bg-[#f4e4bc] text-[#4a3b2a] font-bold border-2 border-[#ffd700]">
					<option value="1">1 Nakama</option>
					<option value="2">2 Nakamas</option>
				</select>

				<textarea name="message"
				 class="w-full p-3 bg-[#f4e4bc] text-[#4a3b2a] font-bold border-2 border-[#ffd700] h-24 placeholder-[#8b4513]"
				 placeholder="Leave a message for the Captains..."></textarea>

				<button type="submit" class="pirate-btn w-full text-lg mt-4">SEND BIRD</button>
			</form>
		</section>

		<!-- Wishes -->
		<section class="p-6 pb-24 bg-[#f4e4bc]">
			<h2 class="pirate-font text-2xl text-center mb-8">MESSAGES FROM THE SEA</h2>
			<div id="wishes-container" class="space-y-6">
				@if (isset($wishes))
					@foreach ($wishes as $wish)
						<div class="bg-white p-4 border-2 border-[#4a3b2a] relative ml-4" data-aos="fade-right">
							<i class="fas fa-quote-left absolute -left-3 -top-3 text-2xl text-[#8b0000] bg-[#f4e4bc] rounded-full"></i>
							<p class="font-bold text-[#8b0000] mb-1">{{ $wish->name }}</p>
							<p class="italic text-sm text-gray-800">"{{ $wish->message }}"</p>
						</div>
					@endforeach
				@endif
			</div>
		</section>

		<footer class="text-center p-4 text-xs opacity-50">
			&copy; {{ date('Y') }} THE GRAND LINE WEDDING. <br> ALL RIGHTS RESERVED.
		</footer>

	</div>

	<!-- Scripts -->
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		AOS.init();

		// Open
		document.getElementById('open-invitation').addEventListener('click', function() {
			const cover = document.getElementById('cover');
			const main = document.getElementById('main-content');

			toggleMusic(true);
			document.getElementById('music-btn').classList.remove('hidden');

			cover.style.transition = "transform 1s cubic-bezier(0.68, -0.55, 0.27, 1.55)";
			cover.style.transform = "translateY(-150%)"; // Fly up like a cannonball

			setTimeout(() => {
				cover.style.display = 'none';
				main.classList.remove('hidden');
				AOS.refresh();
			}, 800);
		});

		// Music
		const audio = document.getElementById('bg-music');
		const musicBtn = document.querySelector('#music-btn i');
		let isPlaying = false;

		function toggleMusic(forcePlay = false) {
			if (forcePlay || !isPlaying) {
				audio.play().catch(e => console.log("Audio play failed interaction needed"));
				isPlaying = true;
				musicBtn.classList.remove('fa-play');
				musicBtn.classList.add('fa-compact-disc');
				musicBtn.classList.add('fa-spin');
			} else {
				audio.pause();
				isPlaying = false;
				musicBtn.classList.add('fa-play');
				musicBtn.classList.remove('fa-compact-disc');
				musicBtn.classList.remove('fa-spin');
			}
		}

		// Ajax RSVP
		document.getElementById('rsvp-form').addEventListener('submit', function(e) {
			e.preventDefault();
			const form = this;
			const btn = form.querySelector('button[type="submit"]');
			const originalText = btn.innerText;
			btn.innerText = 'SENDING BIRD...';
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
						alert('Message sent to the Grand Line!');
						form.reset();

						// Add wish if present
						if (data.wish) {
							const container = document.getElementById('wishes-container');

							const html = `
                                <div class="bg-white p-4 border-2 border-[#4a3b2a] relative ml-4" data-aos="fade-right">
                                    <i class="fas fa-quote-left absolute -left-3 -top-3 text-2xl text-[#8b0000] bg-[#f4e4bc] rounded-full"></i>
                                    <p class="font-bold text-[#8b0000] mb-1">${data.wish.name}</p>
                                    <p class="italic text-sm text-gray-800">"${data.wish.message}"</p>
                                </div>
                            `;
							container.insertAdjacentHTML('afterbegin', html);
						}
					} else {
						alert('The bird got lost (Error). Please try again.');
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
