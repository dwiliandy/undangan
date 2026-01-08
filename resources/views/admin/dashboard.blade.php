@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
	<div class="bg-white rounded-lg shadow-md p-6">
		<h2 class="text-2xl font-semibold text-gray-800 mb-4">Welcome to Dashboard</h2>
		<p class="text-gray-600">You are logged in as Admin!</p>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
			<div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
				<h3 class="font-bold text-blue-700">Total Events</h3>
				<p class="text-3xl font-bold text-blue-800 mt-2">0</p>
			</div>
			<div class="bg-green-50 p-4 rounded-lg border border-green-100">
				<h3 class="font-bold text-green-700">Active Invitations</h3>
				<p class="text-3xl font-bold text-green-800 mt-2">0</p>
			</div>
			<div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
				<h3 class="font-bold text-purple-700">Total Users</h3>
				<p class="text-3xl font-bold text-purple-800 mt-2">0</p>
			</div>
		</div>
	</div>
@endsection
