@extends('layouts.frontend')

@section('title', $event->title)

@section('content')
	<div class="min-h-screen flex items-center justify-center bg-gray-50">
		<div class="max-w-4xl w-full bg-white shadow-2xl rounded-xl overflow-hidden">
			<div class="md:flex">
				<div class="md:w-1/2 bg-cover bg-center h-64 md:h-auto"
					style="background-image: url('https://images.unsplash.com/photo-1522673607200-1645062cd95c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');">
					<!-- Placeholder Image -->
				</div>
				<div class="md:w-1/2 p-10 flex flex-col justify-center text-center">
					<h3 class="text-sm uppercase tracking-widest text-indigo-500 font-semibold mb-2">The Wedding Of</h3>
					<h1 class="text-4xl font-serif text-gray-900 mb-4">{{ $event->title }}</h1>

					<p class="text-gray-600 italic mb-8">
						"We invite you to celebrate our love."
					</p>

					<div class="mb-8">
						<p class="font-bold text-gray-800 text-lg">{{ \Carbon\Carbon::parse($event->event_date)->format('l, d F Y') }}</p>
						<p class="text-gray-500">At 10:00 AM</p>
						<p class="text-gray-500 mt-2">Grand Ballroom Hotel</p>
					</div>

					@if (isset($invitation))
						<div class="bg-indigo-50 p-4 rounded-lg mb-6 border border-indigo-100">
							<p class="text-gray-600 text-sm mb-1">Dear,</p>
							<h2 class="text-2xl font-bold text-indigo-800">{{ $invitation->guest_name }}</h2>
							@if ($invitation->guest_address)
								<p class="text-gray-500 text-xs mt-1">{{ $invitation->guest_address }}</p>
							@endif
							<p class="text-indigo-500 text-xs mt-2 italic">Special Invitation For You</p>
						</div>
						<button
							class="bg-indigo-600 text-white px-6 py-3 rounded-full hover:bg-indigo-700 transition transform hover:scale-105 shadow-md">
							Open Invitation
						</button>
					@else
						<div class="bg-yellow-50 p-3 rounded text-yellow-800 text-sm mb-6 border border-yellow-200">
							Preview Mode
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection
