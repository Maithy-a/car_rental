<header class="navbar navbar-expand-md d-print-none fixed-top">
	<div class="container-fluid">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
			aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<ul class="navbar-nav flex-row order-md-last ms-auto">
			<li class="nav-item dropdown">
				<a href="#" class="nav-link gap-2 d-flex lh-1 text-reset" data-bs-toggle="dropdown"
					aria-label="Open user menu">
					<span class="avatar"
						style="background-image: url(https://cdn.pixabay.com/photo/2016/03/11/02/08/speedometer-1249610_1280.jpg)"></span>
					<div class="d-none d-xl-block text-success">
						<div style="text-transform:capitalize; text-decoration: underline; text-underline-offset: 5px;">
							<?php echo htmlentities($_SESSION['alogin']); ?>
						</div>
						<div class="small mt-2 text-secondary">Administrator</div>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
					<a href="change-password.php" class="dropdown-item">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-edit">
							<path stroke="none" d="M0 0h24v24H0z" fill="none" />
							<path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
							<path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
							<path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
						</svg>
						Account
					</a>
					<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#logoutModal"
						class="dropdown-item text-danger">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout">
							<path stroke="none" d="M0 0h24v24H0z" fill="none" />
							<path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
							<path d="M9 12h12l-3 -3" />
							<path d="M18 15l3 -3" />
						</svg>
						Logout
					</a>
				</div>
			</li>
		</ul>

		<!-- collapse menu fro small screens -->
		<div class="collapse navbar-collapse" id="navbar-menu">
			<ul class="navbar-nav me-auto d-lg-none">
				<li class="nav-item"><span class="nav-link disabled text-muted">Main</span></li>
				<li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="ti ti-dashboard"></i> Dashboard</a></li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Brands</a>
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

						</span>
						Update Contact Info
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="manage-subscribers.php">
						<span class="nav-link-icon">
						</span>
						Manage Subscribers
					</a>
				</li>
			</ul>
		</div>
	</div>
</header>

<?php include('includes/leftbar.php'); ?>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content shadow">
			<div class="modal-header">
				<h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				Are you sure you want to logout?
			</div>
			<div class="modal-footer border-0">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<a href="logout.php" class="btn btn-danger">Logout</a>
			</div>
		</div>
	</div>
</div>