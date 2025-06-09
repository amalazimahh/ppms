<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="logo-mini">
                <img src="{{ asset('black') }}/img/web-statistics.png" alt="PPMS Logo" style="height:42px;width:auto;">
            </a>
            <a href="#" class="simple-text logo-normal">PPMS</a>
        </div>
        <ul class="nav">

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
                        <li @if ($pageSlug == 'projectsList') class="active" @endif>
                            <a href="{{ route('pages.admin.projectsList')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Projects List') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'users') class="active" @endif>
                            <a href="{{ route('pages.admin.rkn')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('RKN List') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

             <!-- Manage Users Tab -->
             <li>
                <a data-toggle="collapse" href="#manage-users" aria-expanded="true">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Manage Users') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="manage-users">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'user-management') class="active" @endif>
                            <a href="{{ route('pages.admin.user_management')  }}">
                            <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Users') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'password-reset-request') class="active" @endif>
                            <a href="{{ route('pages.admin.password-reset-requests') }}">
                                <i class="tim-icons icon-key-25"></i>
                                <p>{{ __('Password Reset Requests') }}</p>
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

            <!-- project team -->
            <li @if ($pageSlug == 'notifications') class="active" @endif>
                <a href="{{ route('pages.admin.project_team')  }}">
                    <i class="tim-icons icon-badge"></i>
                    <p>{{ __('Project Team') }}</p>
                </a>
            </li>

            <!-- Notification Tab -->
            <li @if ($pageSlug == 'notifications') class="active" @endif>
                <a href="{{ route('pages.admin.contractor')  }}">
                    <i class="tim-icons icon-bus-front-12"></i>
                    <p>{{ __('Contractors') }}</p>
                </a>
            </li>

            @endif

            <!-- sidebar for project manager -->
            @if(session('roles') == 2)
            <!-- Project Manager Dashboard -->
            <li @if ($pageSlug == 'dashboard') class="active" @endif>
                <a href="{{ route('pages.project_manager.dashboard')  }}">
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
                            <a href="{{ route('pages.project_manager.project-dashboard')  }}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                <p>{{ __('Project Dashboard') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'users') class="active" @endif>
                            <a href="{{ route('pages.project_manager.projectsList')  }}">
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
        </ul>
    </div>
</div>
