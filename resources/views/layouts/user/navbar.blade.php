<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 shadow-sm rounded">
	<div class="container-fluid">
		<button type="button" id="sidebarCollapse" class="btn btn-dark d-inline-block d-lg-none ml-auto">
			<i class="fas fa-align-justify"></i>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="nav navbar-nav ms-auto">
				<!-- Language Switcher -->
				<li class="nav-item dropdown me-2">
					<a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="langDropdown" role="button"
						data-bs-toggle="dropdown" aria-expanded="false">
						@if (app()->getLocale() == 'id')
							<img src="https://flagcdn.com/w20/id.png" srcset="https://flagcdn.com/w40/id.png 2x" width="20"
								alt="Indonesia">
							<span class="ms-2 d-none d-lg-inline">ID</span>
						@else
							<img src="https://flagcdn.com/w20/gb.png" srcset="https://flagcdn.com/w40/gb.png 2x" width="20"
								alt="English">
							<span class="ms-2 d-none d-lg-inline">EN</span>
						@endif
					</a>
					<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
						<li>
							<a class="dropdown-item d-flex align-items-center" href="{{ route('lang.switch', 'id') }}">
								<img src="https://flagcdn.com/w20/id.png" srcset="https://flagcdn.com/w40/id.png 2x" width="20"
									alt="Indonesia" class="me-2">
								Bahasa Indonesia
							</a>
						</li>
						<li>
							<a class="dropdown-item d-flex align-items-center" href="{{ route('lang.switch', 'en') }}">
								<img src="https://flagcdn.com/w20/gb.png" srcset="https://flagcdn.com/w40/gb.png 2x" width="20"
									alt="English" class="me-2">
								English
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
						aria-expanded="false">
						{{ auth()->user()->name }}
					</a>
					<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
						<li>
							<form method="POST" action="{{ route('logout') }}">
								@csrf
								<button type="submit" class="dropdown-item">{{ __('user.logout') }}</button>
							</form>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>
