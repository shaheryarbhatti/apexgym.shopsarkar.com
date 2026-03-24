<!-- Page Sidebar Start -->
<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div class="sidebar-header d-flex align-items-center justify-content-between px-3 py-2">
        <!-- Logo - centered or left aligned -->
        <a class="logo" href="{{ route('home') }}">
            <img class="img-fluid for-light"
                src="{{ asset('public/' . \App\Models\Setting::get('admin_logo', 'assets/images/logo/logo-icon.png')) }}"
                alt="SkyFitnessGym" style="max-width: 67% !important;">
            <img class="img-fluid for-dark"
                src="{{ asset('public/' . \App\Models\Setting::get('admin_logo', 'assets/images/logo/logo-icon.png')) }}"
                alt="SkyFitnessGym Dark" style="max-width: 67% !important;">
        </a>


    </div>

    <!-- Logo icon for collapsed mode -->
    <div class="logo-icon-wrapper d-none">
        <a href="{{ route('home') }}">
            <img class="img-fluid"
                src="{{ asset('public/' . \App\Models\Setting::get('admin_logo', 'assets/images/logo/logo-icon.png')) }}"
                alt="Admin Logo" style="max-height: 50px; width: auto;">
        </a>
    </div>

    <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow">
            <i data-feather="arrow-left"></i>
        </div>

        <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">

                <!-- <li class="back-btn">
                    <a href="{{ route('home') }}">
                        <img class="img-fluid" src="{{ asset('public/assets/images/logo/logo-icon.png') }}" alt="">
                    </a>
                    <div class="mobile-back text-end">
                        <span>{{ __('back') }}</span>
                        <i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                    </div>
                </li> -->




                <li class="sidebar-list">

                    <a class="sidebar-link sidebar-title" href="{{ route('home') }}">
                        <i class="fa fa-tachometer me-2" style="font-size: 1.1rem; color: var(--theme-default);"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>

                </li>

                <li class="sidebar-list">

                    <a class="sidebar-link" href="{{ route('home') }}">
                        <i class="fa fa-tachometer me-2" style="font-size: 1.1rem; color: var(--theme-default);"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>

                </li>


                @php
                $user = auth()->user();
                if ($user) {
                $modules = \App\Models\SidebarModule::with('options')
                ->where(function($q) use ($user) {
                $q->where('permission', null)
                ->orWhere(function($qq) use ($user) {
                $qq->whereNotNull('permission')
                ->whereIn('permission', $user->getAllPermissions()->pluck('name'));
                });
                })
                ->orderBy('order')
                ->get();
                } else {
                $modules = collect();
                }

                @endphp

                @foreach($modules as $module)
                <li class="sidebar-list">
                    @if($module->options->count() > 0)
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                        <i class="fa {{ $module->icon }} me-2"
                            style="font-size: 1.1rem; color: var(--theme-default);"></i>
                        <span>{{ __($module->title) }}</span>
                    </a>
                    <ul class="sidebar-submenu">
                        @foreach($module->options as $option)
                        @php
                        $hasPermission = !$option->permission || $user->hasPermissionTo($option->permission);
                        @endphp
                        @if($hasPermission)
                        <li><a href="{{ route($option->route) }}">{{ __($option->title) }}</a></li>
                        @endif
                        @endforeach
                    </ul>
                    @else
                    <a class="sidebar-link sidebar-title link-nav" href="javascript:void(0)">
                        <i class="fa {{ $module->icon }} me-2"
                            style="font-size: 1.1rem; color: var(--theme-default);"></i>
                        <span>{{ __($module->title) }}</span>
                    </a>
                    @endif
                </li>
                @endforeach

            </ul>
        </div>

        <div class="right-arrow" id="right-arrow">
            <i data-feather="arrow-right"></i>
        </div>
    </nav>

    <!-- User Profile / Footer Section (modern touch) -->
    <div class="sidebar-footer border-top p-2" style="position: absolute; bottom: 0; width: 100%; background: #fff;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img class="img-30 rounded-circle"
                    src="{{ Auth::user()->image ? asset('public/storage/'.Auth::user()->image) : asset('public/assets/images/dashboard/user.png') }}"
                    alt="">
                <div class="ms-2">
                    <span class="d-block f-12 fw-bold text-dark">{{ Str::limit(Auth::user()->name, 10) }}</span>
                </div>
            </div>
            <a href="javascript:void(0)"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out text-danger"></i>
            </a>
        </div>
    </div>
</div>
<!-- Page Sidebar Ends -->
