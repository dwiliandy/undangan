@extends('layouts.frontend', ['hideNav' => true])

@section('title', $event->title)

@section('content')
	<!-- Fonts -->
	<link
		href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap"
		rel="stylesheet">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

	<style>
		:root {
			--sage: #8A9A5B;
			--cream: #FAF9F6;
			--earth: #4A403A;
			--leaf: #5F6F52;
		}

		body {
			background-color: var(--cream);
			color: var(--earth);
			font-family: 'Lato', sans-serif;
			overflow-x: hidden;
		}

		h1,
		h2,
		h3,
		h4,
		.font-serif {
			font-family: 'Playfair Display', serif;
		}

		.text-sage {
			color: var(--sage);
		}

		.text-earth {
			color: var(--earth);
		}

		.bg-sage {
			background-color: var(--sage);
		}

		.bg-earth {
			background-color: var(--earth);
		}

		.leaf-pattern {
			background-color: #FAF9F6;
			background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%238a9a5b' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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

		/* Leaf Animation */
		.falling-leaves {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			pointer-events: none;
			z-index: 1;
			overflow: hidden;
		}

		.leaf {
			position: absolute;
			top: -10%;
			width: 20px;
			height: 20px;
			background: var(--sage);
			opacity: 0.5;
			border-radius: 0 50% 0 50%;
			animation: fall 15s linear infinite, sway 4s ease-in-out infinite alternate;
		}

		.leaf:nth-child(2n) {
			background: #A9B388;
			width: 15px;
			height: 15px;
			animation-duration: 12s;
			animation-delay: 1s;
		}

		.leaf:nth-child(3n) {
			background: #B99470;
			width: 25px;
			height: 25px;
			animation-duration: 18s;
			animation-delay: 2s;
		}

		@keyframes fall {
			0% {
				top: -10%;
				transform: rotate(0deg);
			}

			100% {
				top: 110%;
				transform: rotate(720deg);
			}
		}

		@keyframes sway {
			0% {
				margin-left: -50px;
			}

			100% {
				margin-left: 50px;
			}
		}
	</style>

	<!-- Audio Control -->
	<audio id="bg-music" loop>
		<source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3" type="audio/mpeg">
	</audio>
	<button id="music-control"
		class="fixed bottom-6 right-6 z-50 bg-white text-earth p-3 rounded-full shadow-xl hidden hover:bg-sage hover:text-white transition border border-earth"
		onclick="toggleMusic()">
		<i class="fas fa-compact-disc spin text-xl" id="music-icon"></i>
	</button>

	<!-- Cover -->
	<div id="cover"
		class="fixed inset-0 z-50 bg-[#FAF9F6] flex flex-col justify-center items-center text-center p-6 leaf-pattern">
		<div class="border-2 border-sage p-2 rounded-full mb-8">
			<div
				class="border border-earth rounded-full p-12 w-64 h-64 flex flex-col items-center justify-center bg-white shadow-lg relative overflow-hidden">
				<div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/flower.png')]"></div>
				<!-- Leaf decoration -->
				<i class="fas fa-leaf text-sage text-2xl mb-4 absolute top-4 opacity-50"></i>

				<h2 class="font-serif text-earth text-lg mb-2">The Wedding of</h2>
				<h1 class="font-serif text-3xl font-bold text-sage italic">{{ $event->weddingEvent->groom_name }}</h1>
				<span class="font-serif text-xl text-earth my-1">&</span>
				<h1 class="font-serif text-3xl font-bold text-sage italic">{{ $event->weddingEvent->bride_name }}</h1>

				<i class="fas fa-leaf text-sage text-2xl mt-4 transform rotate-180 absolute bottom-4 opacity-50"></i>
			</div>
		</div>

		@if (isset($invitation))
			<p class="text-earth text-sm uppercase tracking-widest mb-2 font-serif">Dear</p>
			<h3 class="font-bold text-xl mb-8">{{ $invitation->guest_name }}</h3>
		@endif

		<button id="open-invitation"
			class="bg-sage text-white px-10 py-3 rounded-full font-serif text-lg hover:bg-earth transition shadow-lg flex items-center gap-2">
			<i class="fas fa-envelope-open-text"></i> Open Invitation
		</button>
	</div>

	<!-- Main Content -->
	<div id="main-content" class="min-h-screen pb-20 overflow-x-hidden relative">
		<div class="falling-leaves">
			<div class="leaf" style="left: 10%"></div>
			<div class="leaf" style="left: 30%"></div>
			<div class="leaf" style="left: 50%"></div>
			<div class="leaf" style="left: 70%"></div>
			<div class="leaf" style="left: 90%"></div>
		</div>

		<!-- Hero -->
		<header class="relative h-screen flex items-center justify-center text-center px-4">
			<div class="absolute inset-0 z-0">
				<img
					src="{{ isset($event->eventGalleries[0]) ? (Str::startsWith($event->eventGalleries[0]->image_path, 'http') ? $event->eventGalleries[0]->image_path : Storage::url($event->eventGalleries[0]->image_path)) : 'https://images.unsplash.com/photo-1542296332-2e44a4037213?q=80&w=2670&auto=format&fit=crop' }}"
					class="w-full h-full object-cover brightness-75">
			</div>

			<div
				class="relative z-10 bg-white/80 backdrop-blur-sm p-12 border border-white max-w-lg w-full shadow-2xl skew-x-[-2deg]"
				data-aos="zoom-in">
				<div class="skew-x-[2deg]">
					<p class="font-serif italic text-sage text-xl mb-4">We are getting married!</p>
					<h1 class="font-serif text-5xl md:text-6xl text-earth mb-4 leadin-tight">
						{{ $event->weddingEvent->groom_name }} <br> <span class="text-3xl text-sage">&</span> <br>
						{{ $event->weddingEvent->bride_name }}
					</h1>
					<p class="text-earth uppercase tracking-widest text-sm mt-6 border-t border-earth pt-6 inline-block">
						{{ \Carbon\Carbon::parse($event->event_date)->format('l, F jS, Y') }}
					</p>
				</div>
			</div>
		</header>

		<!-- Couple -->
		<section class="py-24 px-4 max-w-5xl mx-auto leaf-pattern">
			<div class="text-center mb-16" data-aos="fade-up">
				<i class="fas fa-seedling text-3xl text-sage mb-4"></i>
				<h2 class="font-serif text-4xl text-earth italic">The Happy Couple</h2>
			</div>

			<div class="grid md:grid-cols-2 gap-12 items-center">
				<!-- Groom -->
				<div class="text-center group" data-aos="fade-right">
					<div class="w-64 h-64 mx-auto rounded-full overflow-hidden border-8 border-white p-1 shadow-xl mb-6 relative">
						<div
							class="absolute inset-0 border-4 border-sage rounded-full z-10 opacity-0 group-hover:opacity-100 transition scale-95 group-hover:scale-100 duration-500">
						</div>
						<img
							src="{{ isset($event->weddingEvent->groom_photo) ? (Str::startsWith($event->weddingEvent->groom_photo, 'http') ? $event->weddingEvent->groom_photo : Storage::url($event->weddingEvent->groom_photo)) : 'https://via.placeholder.com/300' }}"
							class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-700">
					</div>
					<h3 class="font-serif text-3xl text-earth mb-2">{{ $event->weddingEvent->groom_name }}</h3>
					<p class="italic text-sage mb-2">The Groom</p>
					<p class="text-sm text-gray-500 mb-4">Son of {{ $event->weddingEvent->groom_parent }}</p>
					@if ($event->weddingEvent->groom_instagram)
						<a href="https://instagram.com/{{ $event->weddingEvent->groom_instagram }}" target="_blank"
							class="text-sage hover:text-earth transition"><i class="fab fa-instagram text-xl"></i></a>
					@endif
				</div>

				<!-- Bride -->
				<div class="text-center group" data-aos="fade-left">
					<div class="w-64 h-64 mx-auto rounded-full overflow-hidden border-8 border-white p-1 shadow-xl mb-6 relative">
						<div
							class="absolute inset-0 border-4 border-sage rounded-full z-10 opacity-0 group-hover:opacity-100 transition scale-95 group-hover:scale-100 duration-500">
						</div>
						<img
							src="{{ isset($event->weddingEvent->bride_photo) ? (Str::startsWith($event->weddingEvent->bride_photo, 'http') ? $event->weddingEvent->bride_photo : Storage::url($event->weddingEvent->bride_photo)) : 'https://via.placeholder.com/300' }}"
							class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-700">
					</div>
					<h3 class="font-serif text-3xl text-earth mb-2">{{ $event->weddingEvent->bride_name }}</h3>
					<p class="italic text-sage mb-2">The Bride</p>
					<p class="text-sm text-gray-500 mb-4">Daughter of {{ $event->weddingEvent->bride_parent }}</p>
					@if ($event->weddingEvent->bride_instagram)
						<a href="https://instagram.com/{{ $event->weddingEvent->bride_instagram }}" target="_blank"
							class="text-sage hover:text-earth transition"><i class="fab fa-instagram text-xl"></i></a>
					@endif
				</div>
			</div>
		</section>

		<!-- Story -->
		@if (isset($event->eventJourneys) && count($event->eventJourneys) > 0)
			<section class="py-24 px-4 bg-sage/10">
				<div class="max-w-4xl mx-auto">
					<div class="text-center mb-16" data-aos="fade-up">
						<h2 class="font-serif text-4xl text-earth italic">Our Love Story</h2>
					</div>

					<div
						class="space-y-12 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
						@foreach ($event->eventJourneys as $story)
							<div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active"
								data-aos="fade-up">
								<!-- Icon -->
								<div
									class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-300 group-[.is-active]:bg-sage text-slate-500 group-[.is-active]:text-emerald-50 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
									<i class="fas fa-heart text-xs"></i>
								</div>

								<!-- Card -->
								<div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-6 rounded border border-slate-200 shadow-sm">
									<time
										class="font-serif italic text-sage mb-1 block">{{ $story->journey_date ? (is_object($story->journey_date) ? $story->journey_date->format('Y') : \Carbon\Carbon::parse($story->journey_date)->format('Y')) : '' }}</time>
									<h3 class="font-bold text-earth text-lg mb-2">{{ $story->title }}</h3>
									<p class="text-gray-600 text-sm leading-relaxed">{{ $story->description }}</p>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</section>
		@endif

		<!-- Events -->
		<section class="py-24 px-4 leaf-pattern">
			<div class="max-w-4xl mx-auto">
				<div class="text-center mb-16" data-aos="fade-up">
					<h2 class="font-serif text-4xl text-earth italic">Save The Date</h2>
				</div>

				<div class="grid md:grid-cols-2 gap-8">
					@foreach ($event->eventLocations as $location)
						<div class="bg-white p-8 shadow-xl text-center border-t-4 border-sage relative overflow-hidden group"
							data-aos="fade-up" data-aos-delay="100">
							<div
								class="absolute -right-6 -top-6 w-20 h-20 bg-sage/10 rounded-full group-hover:scale-150 transition duration-500">
							</div>

							<h3 class="font-serif text-2xl mb-4 italic">{{ ucfirst($location->location_type) }}</h3>
							<div class="flex items-center justify-center gap-4 text-earth mb-6">
								<div class="text-right">
									<span class="block text-xs uppercase tracking-widest">Time</span>
									<span
										class="font-bold font-serif text-xl">{{ \Carbon\Carbon::parse($location->event_time)->format('H:i') }}</span>
								</div>
								<div class="w-px h-10 bg-gray-300"></div>
								<div class="text-left">
									<span class="block text-xs uppercase tracking-widest">Date</span>
									<span
										class="font-bold font-serif text-xl">{{ \Carbon\Carbon::parse($location->event_time)->format('M d') }}</span>
								</div>
							</div>

							<p class="font-bold text-earth text-lg mb-1">{{ $location->name }}</p>
							<p class="text-gray-500 text-sm mb-8 px-4">{{ $location->address }}</p>

							@if ($location->google_maps_url)
								<a href="{{ $location->google_maps_url }}" target="_blank"
									class="inline-block border border-sage text-sage px-6 py-2 rounded-full hover:bg-sage hover:text-white transition">
									View Map
								</a>
							@endif
						</div>
					@endforeach
				</div>
			</div>
		</section>

		<!-- Gallery -->
		<section class="py-24 px-4 bg-[#F2EFE9]">
			<div class="text-center mb-16" data-aos="fade-up">
				<i class="fas fa-camera-retro text-2xl text-sage mb-4"></i>
				<h2 class="font-serif text-4xl text-earth italic">Captured Moments</h2>
			</div>
			<div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-3 gap-4">
				@if (isset($event->eventGalleries))
					@foreach ($event->eventGalleries as $photo)
						<div class="aspect-square bg-white p-2 shadow hover:shadow-lg transition" data-aos="fade-in">
							<div class="w-full h-full overflow-hidden">
								<img
									src="{{ Str::startsWith($photo->image_path, 'http') ? $photo->image_path : Storage::url($photo->image_path) }}"
									class="w-full h-full object-cover hover:scale-110 transition duration-1000">
							</div>
						</div>
					@endforeach
				@endif
			</div>
		</section>

		<!-- Gift & RSVP -->
		<section class="py-24 px-4 leaf-pattern">
			<div class="max-w-xl mx-auto text-center">
				<!-- Gift -->
				@if (isset($event->eventBanks))
					<div class="mb-20" data-aos="fade-up">
						<h2 class="font-serif text-3xl text-earth italic mb-8">Wedding Gift</h2>
						<p class="text-gray-500 text-sm mb-8">Your presence is the greatest gift of all. However, if you wish to honor us
							with a gift, we have prepared the following.</p>

						@foreach ($event->eventBanks as $angpao)
							<div class="bg-white p-6 shadow-md rounded-lg border border-gray-100 mb-4 inline-block w-full">
								<div class="text-sage text-2xl mb-2"><i class="fas fa-gift"></i></div>
								<p class="font-bold uppercase tracking-widest text-xs text-gray-400 mb-1">{{ $angpao->bank_name }}</p>
								<p class="font-serif text-2xl text-earth mb-2 select-all" id="acc-{{ $loop->index }}">
									{{ $angpao->account_number }}</p>
								<p class="text-sm text-gray-500">{{ $angpao->account_name }}</p>
								<button onclick="copyToClipboard('acc-{{ $loop->index }}')"
									class="mt-4 text-xs bg-sage/10 text-sage px-4 py-1 rounded hover:bg-sage hover:text-white transition">Copy
									Number</button>
							</div>
						@endforeach
					</div>
				@endif

				<!-- RSVP -->
				<div class="bg-white p-8 md:p-12 shadow-2xl rounded-t-[50px] border-t-8 border-sage" data-aos="fade-up">
					<h2 class="font-serif text-3xl text-earth italic mb-8">Will You Be There?</h2>
					<form id="rsvp-form" action="{{ route('frontend.rsvp', [$event->slug, $invitation->slug]) }}" method="POST"
						class="space-y-6 text-left">
						@csrf
						<div>
							<label class="block text-sm font-bold text-gray-400 mb-1">Name</label>
							<input type="text" value="{{ $invitation->guest_name }}" readonly
								class="w-full bg-gray-50 border-gray-200 rounded p-3 focus:outline-none focus:border-sage">
						</div>
						<div class="grid grid-cols-2 gap-4">
							<div>
								<label class="block text-sm font-bold text-gray-400 mb-1">Attendance</label>
								<select name="status"
									class="w-full bg-gray-50 border-gray-200 rounded p-3 focus:outline-none focus:border-sage">
									<option value="yes">Joyfully Accept</option>
									<option value="no">Regretfully Decline</option>
								</select>
							</div>
							<div>
								<label class="block text-sm font-bold text-gray-400 mb-1">Guests</label>
								<select name="total_guest"
									class="w-full bg-gray-50 border-gray-200 rounded p-3 focus:outline-none focus:border-sage">
									<option value="1">1 Person</option>
									<option value="2">2 Persons</option>
								</select>
							</div>
						</div>
						<div>
							<label class="block text-sm font-bold text-gray-400 mb-1">Wishes</label>
							<textarea name="message"
							 class="w-full bg-gray-50 border-gray-200 rounded p-3 focus:outline-none focus:border-sage h-24"
							 placeholder="Write something sweet..."></textarea>
						</div>
						<button type="submit"
							class="w-full bg-sage text-white font-bold py-4 rounded hover:bg-earth transition shadow-lg">
							Send Confirmation
						</button>
					</form>
				</div>
			</div>
		</section>

		<!-- Wishes List -->
		<section class="py-24 px-4 bg-[#F2EFE9]" id="wishes-section">
			<div class="max-w-3xl mx-auto">
				<div class="text-center mb-12" data-aos="fade-up">
					<h2 class="font-serif text-3xl text-earth italic">Sweetest Wishes</h2>
				</div>

				<div id="wishes-container" class="grid md:grid-cols-2 gap-6 max-h-96 overflow-y-auto hide-scroll">
					@if (isset($wishes))
						@foreach ($wishes as $wish)
							<div class="bg-white p-6 rounded-br-[30px] shadow-sm border border-gray-100" data-aos="fade-up">
								<i class="fas fa-quote-left text-sage/20 text-4xl mb-2"></i>
								<p class="text-gray-600 font-serif italic mb-4">"{{ $wish->message }}"</p>
								<div class="flex items-center gap-3 border-t border-gray-100 pt-3">
									<div class="w-8 h-8 bg-earth text-white rounded-full flex items-center justify-center text-xs">
										{{ substr($wish->name, 0, 1) }}
									</div>
									<div>
										<h5 class="font-bold text-sm text-earth">{{ $wish->name }}</h5>
										<p class="text-[10px] text-gray-400">{{ $wish->created_at->diffForHumans() }}</p>
									</div>
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div>
		</section>

		<footer class="bg-earth text-[#FAF9F6] py-12 text-center text-sm">
			<i class="fab fa-envira text-4xl mb-6 text-sage"></i>
			<p class="mb-2 font-serif italic text-xl">Thank you for visiting</p>
			<p class="text-xs uppercase tracking-widest opacity-50">&copy; {{ date('Y') }} UndanganKita. All Rights
				Reserved.</p>
		</footer>
	</div>

	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		AOS.init();

		// Cover Logic
		const cover = document.getElementById('cover');
		const main = document.getElementById('main-content');
		const openBtn = document.getElementById('open-invitation');
		const audio = document.getElementById('bg-music');
		const musicBtn = document.getElementById('music-control');
		const musicIcon = document.getElementById('music-icon');

		openBtn.addEventListener('click', () => {
			cover.style.transition = 'opacity 1s ease-in-out';
			cover.style.opacity = '0';

			toggleMusic(true);
			musicBtn.classList.remove('hidden');

			setTimeout(() => {
				cover.style.display = 'none';
				main.style.display = 'block';
				AOS.refresh();
			}, 1000);
		});

		let isPlaying = false;

		function toggleMusic(force = false) {
			if (force || !isPlaying) {
				audio.play();
				isPlaying = true;
				musicIcon.classList.add('spin', 'fa-compact-disc');
				musicIcon.classList.remove('fa-play');
			} else {
				audio.pause();
				isPlaying = false;
				musicIcon.classList.remove('spin', 'fa-compact-disc');
				musicIcon.classList.add('fa-play');
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
						alert('Thank you! Your wish has been sent.');
						form.reset();

						if (data.wish) {
							const container = document.getElementById('wishes-container');
							const section = document.getElementById('wishes-section');
							section.style.display = 'block';

							const html = `
                            <div class="bg-white p-6 rounded-br-[30px] shadow-sm border border-gray-100" data-aos="fade-up">
                                <i class="fas fa-quote-left text-sage/20 text-4xl mb-2"></i>
                                <p class="text-gray-600 font-serif italic mb-4">"${data.wish.message}"</p>
                                <div class="flex items-center gap-3 border-t border-gray-100 pt-3">
                                    <div class="w-8 h-8 bg-earth text-white rounded-full flex items-center justify-center text-xs">
                                        ${data.wish.name.charAt(0)}
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-sm text-earth">${data.wish.name}</h5>
                                        <p class="text-[10px] text-gray-400">${data.wish.created_at_human}</p>
                                    </div>
                                </div>
                            </div>
                        `;
							container.insertAdjacentHTML('afterbegin', html);
						}
					} else {
						alert('Failed to send. Please try again.');
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
