<nav class="navbar navbar-vertical navbar-expand-lg navbar-light d-none d-lg-block">
	<div class="container-fluid">
		<div class="collapse navbar-collapse" id="sidebar-menu">
			<ul class="nav flex-column nav-list mt-6">
				<li class="nav-item mb-5">
					<a class="nav-link" href="dashboard.php" style="border-left: 2px solid red;">
						<span class="nav-link-icon d-md-none d-lg-inline-block">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round"
								class="icon icon-tabler icons-tabler-outline icon-tabler-layout-dashboard">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
								<path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
								<path
									d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
								<path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
							</svg>
						</span>
						Dashboard
					</a>
				</li>
				<li class="nav-item dropdown mb-2">
					<a class="nav-link dropdown-toggle" href="#brands" data-bs-toggle="dropdown"
						data-bs-auto-close="outside" role="button" aria-expanded="true">
						<span class="nav-link-icon d-md-none d-lg-inline-block">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round"
								class="icon icon-tabler icons-tabler-outline icon-tabler-brand-pagekit">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M12.077 20h-5.077v-16h11v14h-5.077" />
							</svg>
						</span>
						Brands
					</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="create-brand.php">Create Brand</a></li>
						<li><a class="dropdown-item" href="manage-brands.php">Manage Brands</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown mb-2">
					<a class="nav-link dropdown-toggle" href="#vehicles" data-bs-toggle="dropdown"
						data-bs-auto-close="outside" role="button" aria-expanded="false">
						<span class="nav-link-icon d-md-none d-lg-inline-block">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								fill="currentColor"
								class="icon icon-tabler icons-tabler-filled icon-tabler-steering-wheel">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path
									d="M17 3.34a10 10 0 1 1 -15 8.66l.005 -.324a10 10 0 0 1 14.995 -8.336m-13 8.66a8 8 0 0 0 7 7.937v-5.107a3 3 0 0 1 -1.898 -2.05l-5.07 -1.504q -.031 .36 -.032 .725m15.967 -.725l-5.069 1.503a3 3 0 0 1 -1.897 2.051v5.108a8 8 0 0 0 6.985 -8.422zm-11.967 -6.204a8 8 0 0 0 -3.536 4.244l4.812 1.426a3 3 0 0 1 5.448 0l4.812 -1.426a8 8 0 0 0 -11.536 -4.244" />
							</svg>
						</span>
						Fleet
					</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="post-avehical.php">Post a Vehicle</a></li>
						<li><a class="dropdown-item" href="manage-vehicles.php">Manage Vehicles</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown mb-2">
					<a class="nav-link dropdown-toggle" href="#bookings" data-bs-toggle="dropdown"
						data-bs-auto-close="outside" role="button" aria-expanded="false">
						<span class="nav-link-icon d-md-none d-lg-inline-block">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round"
								class="icon icon-tabler icons-tabler-outline icon-tabler-brand-booking">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path
									d="M4 18v-9.5a4.5 4.5 0 0 1 4.5 -4.5h7a4.5 4.5 0 0 1 4.5 4.5v7a4.5 4.5 0 0 1 -4.5 4.5h-9.5a2 2 0 0 1 -2 -2z" />
								<path d="M8 12h3.5a2 2 0 1 1 0 4h-3.5v-7a1 1 0 0 1 1 -1h1.5a2 2 0 1 1 0 4h-1.5" />
								<path d="M16 16l.01 0" />
							</svg>
						</span>
						Bookings
					</a>
					<ul class="dropdown-menu">
						<li><a href="manage-bookings.php" class="dropdown-item">Manage Bookings</a></li>
						<li><a class="dropdown-item" href="new-bookings.php">New</a></li>
						<li><a class="dropdown-item" href="confirmed-bookings.php">Confirmed</a></li>
						<li><a class="dropdown-item" href="canceled-bookings.php">Canceled</a></li>
					</ul>
				</li>
				<li class="nav-item mb-2">
					<a class="nav-link" href="testimonials.php">
						<span class="nav-link-icon d-md-none d-lg-inline-block">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round"
								class="icon icon-tabler icons-tabler-outline icon-tabler-message-star">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M8 9h8" />
								<path d="M8 13h4.5" />
								<path
									d="M10.325 19.605l-2.325 1.395v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5" />
								<path
									d="M17.8 20.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z" />
							</svg>
						</span>
						Testimonials
					</a>
				</li>
				<li class="nav-item dropdown mb-2">
					<a class="nav-link dropdown-toggle" href="#bookings" data-bs-toggle="dropdown"
						data-bs-auto-close="outside" role="button" aria-expanded="false">
						<span class="nav-link-icon d-md-none d-lg-inline-block">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round"
								class="icon icon-tabler icons-tabler-outline icon-tabler-address-book">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path
									d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" />
								<path d="M10 16h6" />
								<path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
								<path d="M4 8h3" />
								<path d="M4 12h3" />
								<path d="M4 16h3" />
							</svg>
						</span>
						Contacts
					</a>
					<ul class="dropdown-menu">
						<li><a class="nav-link" href="manage-conactusquery.php">
								<span class="nav-link-icon d-md-none d-lg-inline-block">
								</span>
								Queries
							</a>
						</li>
						<li>
							<a class="nav-link" href="update-contactinfo.php">
								<span class="nav-link-icon d-md-none d-lg-inline-block">
								</span>
								Contact Info
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item mb-2">
					<a class="nav-link" href="reg-users.php">
						<span class="nav-link-icon d-md-none d-lg-inline-block">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round"
								class="icon icon-tabler icons-tabler-outline icon-tabler-users-group">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
								<path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
								<path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
								<path d="M17 10h2a2 2 0 0 1 2 2v1" />
								<path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
								<path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
							</svg>
						</span>
						Users
					</a>
				</li>
				<li class="nav-item mb-2">
					<a class="nav-link" href="manage-pages.php">
						<span class="nav-link-icon d-md-none d-lg-inline-block">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round"
								class="icon icon-tabler icons-tabler-outline icon-tabler-app-window">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path
									d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
								<path d="M6 8h.01" />
								<path d="M9 8h.01" />
							</svg>
						</span>
						Pages
					</a>
				</li>
				<li class="nav-item mb-2">
					<a class="nav-link" href="manage-subscribers.php">
						<span class="nav-link-icon d-md-none d-lg-inline-block">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round"
								class="icon icon-tabler icons-tabler-outline icon-tabler-bell-plus">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path
									d="M12.5 17h-8.5a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6a2 2 0 1 1 4 0a7 7 0 0 1 4 6v1" />
								<path d="M9 17v1a3 3 0 0 0 3.51 2.957" />
								<path d="M16 19h6" />
								<path d="M19 16v6" />
							</svg>
						</span>
						Subscribers
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>