@php
    $themePrimary = \App\Models\Setting::get('theme_primary', '#7367f0');
    $themeSecondary = \App\Models\Setting::get('theme_secondary', '#00cfe8');
    $dashboardTextColor = \App\Models\Setting::get('sidebar_dashboard_text_color', '#ffffff');
@endphp
<!-- Page Sidebar Start -->
<div class="sidebar-wrapper" data-layout="stroke-svg"
    style="background: linear-gradient(180deg, #ffffff 0%, #f6f8ff 100%); box-shadow: 0 10px 30px rgba(18, 38, 63, 0.08);">
    <div>
        <div class="logo-wrapper" style="padding: 22px 18px 16px; border-bottom: 1px solid rgba(0,0,0,0.06);">
            <a class="logo" href="{{ route('home') }}">
                <img class="img-fluid for-light"
                    src="{{ asset('public/' . \App\Models\Setting::get('admin_logo', 'assets/images/logo/logo-icon.png')) }}"
                    alt="SkyFitnessGym" style="max-width: 67% !important;">
                <img class="img-fluid for-dark"
                    src="{{ asset('public/' . \App\Models\Setting::get('admin_logo', 'assets/images/logo/logo-icon.png')) }}"
                    alt="SkyFitnessGym Dark" style="max-width: 67% !important;">
            </a>
            <div class="toggle-sidebar d-block d-lg-none d-flex align-items-center justify-content-center"
                style="height: 40px; width: 40px; background: #f1f4ff; border-radius: 10px;">
                <i class="fa fa-bars" style="color: #2a2f45; font-size: 22px; cursor: pointer;"></i>
            </div>
        </div>
        <div class="logo-icon-wrapper" style="padding: 10px 12px;"><a href="{{ route('home') }}">
                <img class="img-fluid"
                    src="{{ asset('public/' . \App\Models\Setting::get('admin_logo', 'assets/images/logo/logo-icon.png')) }}"
                    alt="Admin Logo" style="max-height: 50px; width: auto;">
            </a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar" style="padding: 14px 10px 20px;">
                    <li class="sidebar-list">

                        <a class="sidebar-link link-nav"
                            href="{{ route('home') }}"
                            style="background: linear-gradient(90deg, {{ $themePrimary }} 0%, {{ $themeSecondary }} 100%); color: {{ $dashboardTextColor }}; border-radius: 14px; padding: 12px 14px; box-shadow: 0 8px 18px rgba(0,0,0,0.15);">
                            <i class="fa fa-tachometer me-2"
                                style="font-size: 1.1rem; color: {{ $dashboardTextColor }};"></i>
                            <span style="color: {{ $dashboardTextColor }};">{{ __('Dashboard') }}</span>
                        </a>

                    </li>

                    <li class="sidebar-list" style="margin-top: 10px;">
                        <div class="sidebar-section-title"
                            style="padding: 6px 12px; font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; color: #8a93a6;">
                            {{ __('Main Navigation') }}
                        </div>
                    </li>

                    <li class="sidebar-list" style="margin-bottom: 6px;">

                        <a class="sidebar-link link-nav"
                            href="{{ route('home') }}"
                            style="background: linear-gradient(90deg, {{ $themePrimary }} 0%, {{ $themeSecondary }} 100%); color: {{ $dashboardTextColor }}; border-radius: 14px; padding: 12px 14px; box-shadow: 0 8px 18px rgba(0,0,0,0.15);">
                            <i class="fa fa-tachometer me-2"
                                style="font-size: 1.1rem; color: {{ $dashboardTextColor }};"></i>
                            <span style="color: {{ $dashboardTextColor }};">{{ __('Dashboard') }}</span>
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
                    <li class="sidebar-list" style="margin-bottom: 6px;">
                        @if($module->options->count() > 0)
                        <a class="sidebar-link sidebar-title"
                            href="javascript:void(0)"
                            style="border-radius: 12px; padding: 10px 12px; transition: all .2s ease; border: 1px solid rgba(0,0,0,0.04); background: #fff;">
                            <i class="fa {{ $module->icon }} me-2"
                                style="font-size: 1.05rem; color: {{ $themePrimary }};"></i>
                            <span style="font-weight: 600; color: #2a2f45;">{{ __($module->title) }}</span>
                        </a>
                        <ul class="sidebar-submenu" style="margin-top: 6px; margin-left: 6px;">
                            @foreach($module->options as $option)
                            @php
                            $hasPermission = !$option->permission || $user->hasPermissionTo($option->permission);
                            @endphp
                            @if($hasPermission)
                            <li>
                                <a href="{{ route($option->route) }}"
                                    style="border-radius: 10px; padding: 9px 12px; margin: 4px 0; background: #f7f9ff; color: #3c4560; border: 1px solid rgba(0,0,0,0.06);">
                                    {{ __($option->title) }}
                                </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                        @else
                        <a class="sidebar-link sidebar-title link-nav"
                            href="javascript:void(0)"
                            style="border-radius: 12px; padding: 10px 12px; transition: all .2s ease; border: 1px solid rgba(0,0,0,0.04); background: #fff;">
                            <i class="fa {{ $module->icon }} me-2"
                                style="font-size: 1.05rem; color: {{ $themePrimary }};"></i>
                            <span style="font-weight: 600; color: #2a2f45;">{{ __($module->title) }}</span>
                        </a>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends -->
