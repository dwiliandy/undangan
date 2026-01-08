<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 shadow-sm rounded">
	<div class="container-fluid">
		<button type="button" id="sidebarCollapse" class="btn btn-dark d-inline-block d-lg-none ml-auto">
			<i class="fas fa-align-justify"></i>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="nav navbar-nav ms-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
						aria-expanded="false">
						{{ auth()->user()->name }}
					</a>
					<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
						<li>
							<form method="POST" action="{{ route('logout') }}">
								@csrf
								<button type="submit" class="dropdown-item">Logout</button>
							</form>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>
