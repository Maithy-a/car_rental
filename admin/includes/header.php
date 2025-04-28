
<header class="navbar navbar-expand-lg navbar-dark bg-dark  fixed-top">
	<div class="container-fluid">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
			aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand d-none d-lg-block" href="dashboard.php">Car Rental Portal</a>
		<div class="collapse navbar-collapse" id="navbar-menu">
			<ul class="navbar-nav me-auto d-lg-none">
				<li class="nav-item">
					<span class="nav-link disabled text-muted">Main</span>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="dashboard.php">
						<span class="nav-link-icon">
							<i class="ti ti-dashboard"></i>
						</span>
						Dashboard
					</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#brands" data-bs-toggle="dropdown"
						data-bs-auto-close="outside" role="button" aria-expanded="false">
						<span class="nav-link-icon">
							<i class="ti ti-files"></i>
						</span>
						Brands
					</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="create-brand.php">Create Brand</a></li>
						<li><a class="dropdown-item" href="manage-brands.php">Manage Brands</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#vehicles" data-bs-toggle="dropdown"
						data-bs-auto-close="outside" role="button" aria-expanded="false">
						<span class="nav-link-icon">
							<i class="ti ti-car"></i>
						</span>
						Vehicles
					</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="post-avehical.php">Post a Vehicle</a></li>
						<li><a class="dropdown-item" href="manage-vehicles.php">Manage Vehicles</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#bookings" data-bs-toggle="dropdown"
						data-bs-auto-close="outside" role="button" aria-expanded="false">
						<span class="nav-link-icon">
							<i class="ti ti-calendar"></i>
						</span>
						Bookings
					</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="new-bookings.php">New</a></li>
						<li><a class="dropdown-item" href="confirmed-bookings.php">Confirmed</a></li>
						<li><a class="dropdown-item" href="canceled-bookings.php">Canceled</a></li>
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="testimonials.php">
						<span class="nav-link-icon">
							<i class="ti ti-messages"></i>
						</span>
						Manage Testimonials
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="manage-conactusquery.php">
						<span class="nav-link-icon">
							<i class="ti ti-mail"></i>
						</span>
						Manage Contacts
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="reg-users.php">
						<span class="nav-link-icon">
							<i class="ti ti-users"></i>
						</span>
						Register Users
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="manage-pages.php">
						<span class="nav-link-icon">
							<i class="ti ti-files"></i>
						</span>
						Manage Pages
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="update-contactinfo.php">
						<span class="nav-link-icon">
							<i class="ti ti-info-circle"></i>
						</span>
						Update Contact Info
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="manage-subscribers.php">
						<span class="nav-link-icon">
							<i class="ti ti-users"></i>
						</span>
						Manage Subscribers
					</a>
				</li>
			</ul>
			<ul class="navbar-nav flex-row order-md-last ms-auto">
				<div class="navbar-nav flex-row order-md-last ms-auto">
					<div class="nav-item dropdown">
						<a href="#" class="nav-link d-flex lh-1 text-reset" data-bs-toggle="dropdown"
							aria-label="Open user menu">
							<span class="avatar avatar-sm"
								style="background-image: url(https://i.ibb.co/3mPPb02W/IMG-20250108-WA0010.jpg)"></span>
							<div class="d-none d-xl-block ps-2">
								<div><?php echo htmlentities($_SESSION['alogin']); ?></div>
								<div class="mt-1 small text-secondary">Administrator</div>
							</div>
						</a>
						<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
							<a href="logout.php" class="dropdown-item text-danger">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
									fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
									stroke-linejoin="round"
									class="icon icon-tabler icons-tabler-outline icon-tabler-run">
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<path d="M13 4m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
									<path d="M4 17l5 1l.75 -1.5" />
									<path d="M15 21l0 -4l-4 -3l1 -6" />
									<path d="M7 12l0 -3l5 -1l3 3l3 1" />
								</svg>
								Logout</a>
						</div>
					</div>

					<!-- User Dropdown -->
					<li class="nav-item dropdown">
						<div class="nav-item dropdown">
							<ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="accountDropdown">
								<li><a class="dropdown-item" href="change-password.php">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round"
											class="icon icon-tabler icons-tabler-outline icon-tabler-lock-off">
											<path stroke="none" d="M0 0h24v24H0z" fill="none" />
											<path
												d="M15 11h2a2 2 0 0 1 2 2v2m0 4a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2h4" />
											<path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
											<path d="M8 11v-3m.719 -3.289a4 4 0 0 1 7.281 2.289v4" />
											<path d="M3 3l18 18" />
										</svg>
										Change Password
									</a></li>
								<li>
									<hr class="dropdown-divider">
								</li>
								<li>
									<a class="dropdown-item text-danger" href="logout.php">

										Logout
									</a>
								</li>
							</ul>
					</li>
			</ul>
		</div>
	</div>
</header>

<?php include('includes/leftbar.php'); ?>