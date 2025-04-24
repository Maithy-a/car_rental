<?php
session_start();
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
}
?>
<!-- Topbar -->
<header class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom fixed-top">
	<div class="container-fluid">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
			aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand d-none d-lg-block" href="dashboard.php">Car Rental Portal</a>
		<div class="collapse navbar-collapse" id="navbar-menu">
			<!-- Sidebar Menu Items for Mobile -->
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
			<!-- Topbar Items -->
			<ul class="navbar-nav ms-auto">
				<!-- Mode Toggle -->
				<li class="nav-item d-flex align-items-center">
					<a href="#" class="nav-link px-0" id="theme-toggle" title="Toggle theme">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-moon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
					</a>
				</li>
				<!-- User Dropdown -->
				<li class="nav-item dropdown">
					<a class="btn nav-link dropdown-toggle d-flex align-items-center" href="#" id="accountDropdown"
						role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<span>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round"
								class="icon icon-tabler icons-tabler-outline icon-tabler-user-cog">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
								<path d="M6 21v-2a4 4 0 0 1 4 -4h2.5" />
								<path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
								<path d="M19.001 15.5v1.5" />
								<path d="M19.001 21v1.5" />
								<path d="M22.032 17.25l-1.299 .75" />
								<path d="M17.27 20l-1.3 .75" />
								<path d="M15.97 17.25l1.3 .75" />
								<path d="M20.733 20l1.3 .75" />
							</svg>
							<?php echo htmlentities($_SESSION['alogin']); ?>
						</span>
					</a>
					<ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="accountDropdown">
						<li><a class="dropdown-item" href="change-password.php">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
									fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
									stroke-linejoin="round"
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
						<li><a class="dropdown-item text-danger" href="logout.php">
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
								Logout
							</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</header>

<script>
	const themeToggle = document.getElementById('theme-toggle');
	const body = document.body;
	themeToggle.addEventListener('click', (e) => {
		e.preventDefault();
		body.classList.toggle('theme-dark');
		const isDark = body.classList.contains('theme-dark');
		themeToggle.innerHTML = isDark ? '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-sun"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>' : '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-moon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>';
	});
</script>