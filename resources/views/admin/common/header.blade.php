<nav class="navbar site-navbar navbar-fixed-top h_header">
	<div class="navbar-header">
		<button type="button" class="navbar-toggler" id="sidebarCollapse">
		<div class="wrapper-menu">
			<span class="line-menu half start"></span>
			<span class="line-menu"></span>
			<span class="line-menu half end"></span>
		</div>
		</button>
		<div class="navbar-brand navbar-brand-center">
			<a href="{{ route('dashboard') }}">
				<img src="{{ asset('images/logo.png') }}" alt="logo" width="200px;">
			</a>
		</div>
	</div>
	<div class="ml-auto">
		<div class="site-menubar h_menu">
			<ul class="site-menu">
				<li class="site-menu-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
					<a href="{{ route('dashboard') }}" class="waves-effect waves-theme  waves-round">
						<span class="site-menu-title">Dashboard</span>
					</a>
				</li>
				
				@if((new App\Http\Helpers\Common)::isAdmin()) 
				<li class="site-menu-item {{ Request::routeIs('clientslist') ? 'active' : '' }}">
					<a href="{{ route('clientslist') }}" class=" waves-effect waves-theme  waves-round">
						<span class="site-menu-title">Clients</span>
					</a>
				</li>
				<li class="site-menu-item {{ Request::routeIs('admin_users') ? 'active' : '' }} {{ Request::routeIs('admin_adduser') ? 'active' : '' }} @if(\Request::route()->getName() == 'admin_edituser') active  @endif">
					<a href="{{ route('admin_users') }}" class=" waves-effect waves-theme  waves-round">
						<span class="site-menu-title">Users</span>
					</a>
				</li>
				@endif
				
				<li class="site-menu-item  {{ Request::routeIs('surveylist') ? 'active' : '' }} {{ Request::routeIs('addsurvey') ? 'active' : '' }} @if(\Request::route()->getName() == 'editsurvey') active  @endif "   >
					<a href="{{ route('surveylist') }}" class=" waves-effect waves-theme  waves-round">
						<span class="site-menu-title">Surveys</span>
					</a>
				</li>
			</ul>
		</div>
		<ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
			<li class="nav-item dropdown profile">
				<a class="nav-link navbar-avatar  waves-effect waves-theme  waves-round" data-toggle="dropdown" href="#"
					aria-expanded="false" data-animation="scale-up" role="button">
					<span class="avatar avatar-online">
						<?php
							$imgUrl =  url(env('USER_THUMB_UPLOAD_PATH',''));
							$user_original_path = public_path() . env('USER_ORIGINAL_UPLOAD_PATH','');
							$user_thumb_path = public_path() . env('USER_THUMB_UPLOAD_PATH','');
						?>
						@if (empty(Auth::user()->profile_image) || !file_exists($user_thumb_path . Auth::user()->profile_image))
						<img src="{{ url('/images/' . env('DEFAULT_USER_IMAGE','')) }}" alt="Profile img" height="20" width="20" id="header_img">
						@else
						<?php  $imageUrl = url($imgUrl) . '/' . Auth::user()->profile_image; ?>
						<img src="<?= $imageUrl; ?>" alt="Profile img" height="20" width="20" id="header_img">
						@endif
					</span>
					<div class="hidden-md-down user-in username">{{ Auth::user()->fname }} {{ Auth::user()->lname }}
						<i class=" fa fa-angle-down  ml-3"></i>
					</div>
				</a>
				<ul class="dropdown-menu pullDown" role="menu">
					<li class="hidden-md-up">
						<div class="user-info usernameMenu">
							<h6 class="user-name m-b-0">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</h6>
						</div>
					</li>
					<li>
						<a class="dropdown-item waves-effect waves-classic showProfileModal" href="javascript:void(0)" >Profile</a>
					</li>
					<li>
						<a class="dropdown-item waves-effect waves-classic"
							data-toggle="modal" data-target="#changepassword"
						href="javascript:void(0)" role="menuitem">Change Password</a>
					</li>
					<li>
						<a class="dropdown-item waves-effect waves-classic" href="{{ route('logout') }}" onclick="event.preventDefault();
						document.getElementById('logout-form').submit(); role="menuitem">Logout</a>
					</li>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</ul>
			</li>
		</ul>
	</div>
</nav>