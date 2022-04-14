<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{Storage::url(settings()->favicon) }}" class=" brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ settings()->appName }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="{{ (strtolower(langDirection()) == 'rtl')? ' padding-right: 10px;': '' }}">
            <div class="image">
                <img  data-src="{{ Storage::url( Auth::guard('admin')->user()->avatar) }}" class=" lazyload img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('admin.UsersAccountEdit', Auth::guard('admin')->user()->_id) }}" class="d-block">{{ Auth::guard('admin')->user()->getFullName() }}</a>
            </div>

        </div>

        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                @can('browse-dashboard')
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{trans('app.dashboard')}}
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
                @endcan

                @can('viewAny', App\Models\User::class)
                <li class="nav-item menu {{ (Request::is('admin/users/*') || Request::is('admin/users') || Request::is('admin/user/*') ? 'menu-is-opening menu-open' : '') }}">
                    <a href="#" class="nav-link {{ (Request::is('admin/users/*') || Request::is('admin/users') || Request::is('admin/user/*') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            {{trans('app.users.users')}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item ">
                            <a href="{{ route('admin.Users')}}" class="nav-link {{ (Request::is('admin/users/*') || Request::is('admin/users') || Request::is('admin/user/*') ? 'active' : '') }}">
                                <!-- <i class="far fa-users-cog nav-icon"></i> -->
                                <i class="fas fa-users-cog"></i>
                                <p>{{trans('app.accountsManagement')}}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                @can('viewAny', App\Models\Settings::class)
                <li class="nav-item">
                    <a href="{{ route('admin.appSettings') }}" class="nav-link {{ (Request::is('admin/app/setting') || Request::is('admin/app/settings') || Request::is('admin/app/settings/*') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            {{trans('app.appSettings')}}
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
                @endcan
                @can('viewAny', App\Models\Language::class)
                <li class="nav-item">
                    <a href="{{ route('admin.languages') }}" class="nav-link {{ (Request::is('admin/languages') || Request::is('admin/languages/*') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-language"></i>
                        <p>
                            {{trans('app.languages')}}
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
                @endcan
                @can('browse-files')
                <li class="nav-item">
                    <a href="{{ route('admin.manageFiles') }}" class="nav-link {{ (Request::is('admin/files/manage') || Request::is('admin/files/manage/*') ? 'active' : '') }}">
                        <i class="nav-icon far fa-folder"></i>
                        <p>
                            {{trans('app.manageFiles')}}
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
                @endcan

                @can('viewAny', App\Models\Role::class)
                <li class="nav-item">
                    <a href="{{ route('admin.showRoles') }}" class="nav-link {{ (Request::is('admin/roles') || Request::is('admin/roles/*') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <!-- <i class="nav-icon fas fa-user-lock"></i> -->
                        <p>
                            {{trans('app.roles')}}
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
                @endcan

                @can('viewAny', App\Models\Announcement::class)
                <li class="nav-item">
                    <a href="{{ route('admin.announcement') }}" class="nav-link {{ (Request::is('admin/announcements') || Request::is('admin/announcements/*') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>
                            {{trans('app.announcement')}}
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
                @endcan

                @can('viewAny', App\Models\Audience::class)
                <li class="nav-item">
                    <a href="{{ route('admin.audiences') }}" class="nav-link {{ (Request::is('admin/audiences') || Request::is('admin/audiences/*') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <!-- <i class="nav-icon fas fa-user-lock"></i> -->
                        <p>
                            {{trans('app.audiences')}}
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
                @endcan

                <!-- @can('viewAny', App\Models\Audience::class) -->
                <li class="nav-item">
                    <a href="{{ route('admin.reports') }}" class="nav-link {{ (Request::is('admin/reports') || Request::is('admin/reports/*') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-bug"></i>
                        <p>
                            {{trans('app.reports')}}
                        </p>
                    </a>
                </li>
                <!-- @endcan -->

                <!-- @can('viewAny', App\Models\Audience::class) -->
                <li class="nav-item">
                    <a href="{{ route('admin.audiences') }}" class="nav-link {{ (Request::is('admin/certificates') || Request::is('admin/certificates/*') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-certificate"></i>

                        <p>
                            {{trans('app.certificate')}}
                        </p>
                    </a>
                </li>
                <!-- @endcan -->

                <li class="nav-item">
                    <a href="{{ route('admin.audiences') }}" class="nav-link {{ (Request::is('admin/support') || Request::is('admin/support/*') ? 'active' : '') }}">
                        <i class="nav-icon far fa-comment-dots"></i>

                        <p>
                            {{trans('app.support')}}
                        </p>
                    </a>
                </li>

                <li class="nav-header"></li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            {{trans('app.logout')}}
                        </p>
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
