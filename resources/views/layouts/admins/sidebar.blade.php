<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="{{ route('admin') }}" class="brand-link">
		<img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="{{ config('app.name') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">{{ config('app.name') }}</span>
	</a>
	
	<!-- Sidebar -->
	<div class="sidebar">
		
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				
				<li class="nav-item">
					<a href="{{ route('admin') }}" class="nav-link {{ @$title['active']=='dashboard' ? 'active' : '' }}">
						<i class="nav-icon fas fa-chart-line"></i>
						<p>Dashboard</p>
					</a>
				</li>
				
				<li class="nav-item">
					<a href="{{ route('admin.users') }}" class="nav-link {{ @$title['active']=='users' ? 'active' : '' }}">
						<i class="nav-icon fas fa-users"></i>
						<p>Users</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin.stores') }}" class="nav-link {{ @$title['active']=='stores' ? 'active' : '' }}">
						<i class="nav-icon fas fa-users"></i>
						<p>Stores</p>
					</a>
				</li>
				
				<li class="nav-item">
					<a href="{{ route('admin.orders') }}" class="nav-link {{ @$title['active']=='orders' ? 'active' : '' }}">
						<i class="nav-icon fas fa-sort-amount-up"></i>
						<p>Orders</p>
					</a>
				</li>

				{{--
				<li class="nav-item">
					<a href="{{ route('attributes.index') }}" class="nav-link {{ @$title['active']=='attribute' ? 'active' : '' }}">
						<i class="nav-icon fas fa-list"></i>
						<p>Attributes</p>
					</a>
				</li>
				
				<li class="nav-item">
					<a href="{{ route('admin.category') }}" class="nav-link {{ @$title['active']=='category' ? 'active' : '' }}">
						<i class="nav-icon fas fa-list"></i>
						<p>Category</p>
					</a>
				</li>
				
				<li class="nav-item">
					<a href="{{ route('admin.products') }}" class="nav-link {{ @$title['active']=='products' ? 'active' : '' }}">
						<i class="nav-icon fas fa-box-open"></i>
						<p>Products</p>
					</a>
				</li>
				--}}
				
				<li class="nav-item">
					<a href="{{ route('admin.promocode') }}" class="nav-link {{ @$title['active']=='promocode' ? 'active' : '' }}">
						<i class="nav-icon fas fa-tags"></i>
						<p>Promocode</p>
					</a>
				</li>
				
				<li class="nav-item">
					<a href="{{ route('admin.settings') }}" class="nav-link {{ @$title['active']=='settings' ? 'active' : '' }}">
						<i class="nav-icon fas fa-cog"></i>
						<p>Settings</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="{{ route('admin.profile') }}" class="nav-link {{ @$title['active']=='profile' ? 'active' : '' }}">
						<i class="nav-icon fas fa-user"></i>
						<p>Profile</p>
					</a>
				</li>
				
				
				
			</ul>
		</nav>
	</div>
</aside>