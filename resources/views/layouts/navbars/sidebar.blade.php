<div>
    Current Role: {{ session('roles') ?? 'Session not set' }}
</div>
<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('PPMS') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Dashboard') }}</a>
        </div>
        <ul class="nav">
            <!-- <li @if ($pageSlug == 'dashboard') class="active" @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li> -->

            <!-- Conditional links based on role -->
             @if(session('roles') == 1)

             <li @if ($pageSlug == 'dashboard') class="active" @endif>
                <a href="{{ route('pages.admin.dashboard')  }}">
                    <i class="tim-icons icon-chart-bar-32"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

            <!-- Manage Projects Tab -->
            <li>
                <a data-toggle="collapse" href="#manage-projects" aria-expanded="true">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Manage Projects') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="manage-projects">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'project-dashboard') class="active" @endif>
                            <a href="{{ route('pages.admin.project-dashboard')  }}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                <p>{{ __('Project Dashboard') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'users') class="active" @endif>
                            <a href="{{ route('pages.admin.projectsList')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Projects List') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Manage Users Tab -->
            <li @if ($pageSlug == 'users') class="active" @endif>
                <a href="{{ route('pages.admin.user_management')  }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('User Management') }}</p>
                </a>
            </li>

            <!-- <li @if ($pageSlug == 'users') class="active" @endif>
                <a href="{{ route('pages.admin.user_management')  }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('Manage Projects') }}</p>
                </a>
            </li> -->

            <!-- Notification Tab -->
            <li @if ($pageSlug == 'notifications') class="active" @endif>
                <a href="{{ route('pages.notification.index')  }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ __('Notifications') }}</p>
                </a>
            </li>

            @endif

            <!-- sidebar for project manager -->
            @if(session('roles') == 2)
            <li @if ($pageSlug == 'basicDetails') class="active" @endif>
                <a href="{{ route('pages.project_manager.forms.basicdetails')  }}">
                    <i class="tim-icons icon-chart-bar-32"></i>
                    <p>{{ __('Manage Projects') }}</p>
                </a>
            </li>

            <!-- Notification Tab -->
            <li @if ($pageSlug == 'notifications') class="active" @endif>
                <a href="{{ route('pages.notification.index')  }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ __('Notifications') }}</p>
                </a>
            </li>
            @endif

            @if(session('roles') == 3)
            <!-- Executive Dashboard -->
            <li @if ($pageSlug == 'dashboard') class="active" @endif>
                <a href="{{ route('pages.executive.dashboard')  }}">
                    <i class="tim-icons icon-chart-bar-32"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

            <!-- Manage Projects Tab -->
            <li>
                <a data-toggle="collapse" href="#manage-projects" aria-expanded="true">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Manage Projects') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="manage-projects">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'project-dashboard') class="active" @endif>
                            <a href="{{ route('pages.executive.project-dashboard')  }}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                <p>{{ __('Project Dashboard') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'users') class="active" @endif>
                            <a href="{{ route('pages.executive.projectsList')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Projects List') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Notification Tab -->
            <li @if ($pageSlug == 'notifications') class="active" @endif>
                <a href="{{ route('pages.notification.index')  }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ __('Notifications') }}</p>
                </a>
            </li>

            @endif


            <!-- <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="true">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Laravel Examples') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="laravel-examples">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'profile') class="active " @endif>
                            <a href="{{ route('profile.edit')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('User Profile') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'users') class="active " @endif>
                            <a href="{{ route('user.index')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('User Management') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li @if ($pageSlug == 'addprojects') class="active " @endif>
                <a href="{{ route('pages.addprojects') }}">
                    <i class="tim-icons icon-notes"></i>
                    <p>{{ __('Add New Projects') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'icons') class="active " @endif>
                <a href="{{ route('pages.icons') }}">
                    <i class="tim-icons icon-atom"></i>
                    <p>{{ __('Icons') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'maps') class="active " @endif>
                <a href="{{ route('pages.maps') }}">
                    <i class="tim-icons icon-pin"></i>
                    <p>{{ __('Maps') }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'tables') class="active " @endif>
                <a href="{{ route('pages.tables') }}">
                    <i class="tim-icons icon-puzzle-10"></i>
                    <p>{{ __('Table List') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'typography') class="active " @endif>
                <a href="{{ route('pages.typography') }}">
                    <i class="tim-icons icon-align-center"></i>
                    <p>{{ __('Typography') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'rtl') class="active " @endif>
                <a href="{{ route('pages.rtl') }}">
                    <i class="tim-icons icon-world"></i>
                    <p>{{ __('RTL Support') }}</p>
                </a>
            </li>
            <li class=" {{ $pageSlug == 'upgrade' ? 'active' : '' }} bg-info">

                <a href="{{ route('pages.upgrade') }}">
                    <i class="tim-icons icon-spaceship"></i>
                    <p>{{ __('Upgrade to PRO') }}</p>
                </a>
            </li> -->
        </ul>
    </div>
</div>
