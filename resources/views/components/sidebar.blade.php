@php
    $sidebarBgColor = \App\Models\Setting::get('sidebar_bg_color', '#ffffff');
    $sidebarBgStart = \App\Models\Setting::get('sidebar_bg_start', '');
    $sidebarBgEnd = \App\Models\Setting::get('sidebar_bg_end', '');
    $sidebarTabBg = \App\Models\Setting::get('sidebar_tab_bg_color', '#ffffff');
    $sidebarTabText = \App\Models\Setting::get('sidebar_tab_text_color', '#2a2f45');
    $logoOverlayColor = \App\Models\Setting::get('logo_overlay_color', '');
    $logoOverlayClass = $logoOverlayColor ? 'has-overlay' : '';
    $adminLogoUrl = asset('public/' . \App\Models\Setting::get('admin_logo', 'assets/images/logo/logo-icon.png'));
    $sidebarBackground = ($sidebarBgStart && $sidebarBgEnd)
        ? 'linear-gradient(180deg, ' . $sidebarBgStart . ' 0%, ' . $sidebarBgEnd . ' 100%)'
        : $sidebarBgColor;
    $sidebarBackgroundStyle = "background: {$sidebarBackground};";
@endphp
<style>
    .sidebar-wrapper .sidebar-link .fa-angle-right,
    .sidebar-wrapper .sidebar-link .fa-angle-down,
    .sidebar-wrapper .sidebar-link .fa-angle-left,
    .sidebar-wrapper .according-menu i,
    .sidebar-wrapper .sidebar-link .according-menu i {
        color: {{ $sidebarTabText }} !important;
    }
</style>
<!-- Page Sidebar Start -->
<div class="sidebar-wrapper" data-layout="stroke-svg"
    style="{{ $sidebarBackgroundStyle }} box-shadow: 0 10px 30px rgba(18, 38, 63, 0.08);">
    <div>
        <div class="logo-wrapper" style="padding: 22px 18px 16px; border-bottom: 1px solid rgba(0,0,0,0.06);">
            <a class="logo" href="{{ route('home') }}">
                <span class="logo-overlay-wrap {{ $logoOverlayClass }}"
                      style="--logo-color: {{ $logoOverlayColor ?: 'transparent' }}; --logo-url: url('{{ $adminLogoUrl }}'); max-width: 67% !important;">
                    <img class="img-fluid for-light logo-img"
                        src="{{ $adminLogoUrl }}"
                        alt="SkyFitnessGym" style="max-width: 67% !important;">
                    <img class="img-fluid for-dark logo-img"
                        src="{{ $adminLogoUrl }}"
                        alt="SkyFitnessGym Dark" style="max-width: 67% !important;">
                    <span class="logo-overlay-mask" aria-hidden="true"></span>
                </span>
            </a>
            <div class="toggle-sidebar d-block d-lg-none d-flex align-items-center justify-content-center"
                style="height: 40px; width: 40px; background: #f1f4ff; border-radius: 10px;">
                <i class="fa fa-bars" style="color: #2a2f45; font-size: 22px; cursor: pointer;"></i>
            </div>
        </div>
        <div class="logo-icon-wrapper" style="padding: 10px 12px;"><a href="{{ route('home') }}">
                <span class="logo-overlay-wrap {{ $logoOverlayClass }}"
                      style="--logo-color: {{ $logoOverlayColor ?: 'transparent' }}; --logo-url: url('{{ $adminLogoUrl }}');">
                    <img class="img-fluid logo-img"
                        src="{{ $adminLogoUrl }}"
                        alt="Admin Logo" style="max-height: 50px; width: auto;">
                    <span class="logo-overlay-mask" aria-hidden="true"></span>
                </span>
            </a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar" style="padding: 14px 10px 20px;">
                    <li class="sidebar-list" style="margin-top: 20px;">

                        <a class="sidebar-link link-nav"
                            href="{{ route('home') }}"
                            style="background: {{ $sidebarTabBg }}; color: {{ $sidebarTabText }}; border-radius: 14px; padding: 12px 14px; box-shadow: 0 8px 18px rgba(0,0,0,0.15);">
                            <i class="fa fa-tachometer me-2"
                                style="font-size: 1.1rem; color: {{ $sidebarTabText }};"></i>
                            <span style="color: {{ $sidebarTabText }};">{{ __('Dashboard') }}</span>
                        </a>

                    </li>

                    <!-- <li class="sidebar-list" style="margin-top: 10px;">
                        <div class="sidebar-section-title"
                            style="padding: 6px 12px; font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; color: #8a93a6;">
                            {{ __('Main Navigation') }}
                        </div>
                    </li> -->

                    <li class="sidebar-list" style="margin-bottom: 6px;margin-top: 20px;">

                        <a class="sidebar-link link-nav"
                            href="{{ route('home') }}"
                            style="background: {{ $sidebarTabBg }}; color: {{ $sidebarTabText }}; border-radius: 14px; padding: 12px 14px; box-shadow: 0 8px 18px rgba(0,0,0,0.15);">
                            <i class="fa fa-tachometer me-2"
                                style="font-size: 1.1rem; color: {{ $sidebarTabText }};"></i>
                            <span style="color: {{ $sidebarTabText }};">{{ __('Dashboard') }}</span>
                        </a>

                    </li>


                    @php
                    $user = auth()->user();
                    $isSuper = $user && $user->hasRole('Super Admin');
                    if ($user) {
                        $modules = \App\Models\SidebarModule::with('options')
                            ->orderBy('order')
                            ->get();
                    } else {
                    $modules = collect();
                    }

                    @endphp

                    @foreach($modules as $module)
                    @php
                        $moduleVisible = $isSuper || ! $module->permission || $user->hasPermissionTo($module->permission);
                        $visibleOptions = collect();
                        foreach ($module->options as $option) {
                            $basePermission = explode('.', $option->permission)[0] ?? $option->permission;
                            $legacyBase = 'manage-' . \Illuminate\Support\Str::singular($basePermission);
                            $actionPermissions = [
                                $basePermission . '.view',
                                $basePermission . '.add',
                                $basePermission . '.edit',
                                $basePermission . '.delete',
                                $legacyBase . '.view',
                                $legacyBase . '.add',
                                $legacyBase . '.edit',
                                $legacyBase . '.delete',
                            ];
                            $hasOptionPermission = $isSuper || ! $option->permission || $user->hasPermissionTo($option->permission);
                            $hasActionPermission = $isSuper || $user->canAny($actionPermissions);
                            if ($hasOptionPermission || $hasActionPermission) {
                                $visibleOptions->push($option);
                            }
                        }
                        if ($visibleOptions->isNotEmpty()) {
                            $moduleVisible = true;
                        }
                    @endphp
                    @if($moduleVisible)
                    <li class="sidebar-list" style="margin-bottom: 6px;">
                        @if($visibleOptions->count() > 0)
                        <a class="sidebar-link sidebar-title"
                            href="javascript:void(0)"
                            style="border-radius: 12px; padding: 10px 12px; transition: all .2s ease; border: 1px solid rgba(0,0,0,0.04); background: {{ $sidebarTabBg }};">
                            <i class="fa {{ $module->icon }} me-2"
                                style="font-size: 1.05rem; color: {{ $sidebarTabText }};"></i>
                            <span style="font-weight: 600; color: {{ $sidebarTabText }};">{{ __($module->title) }}</span>
                        </a>
                        <ul class="sidebar-submenu" style="margin-top: 6px; margin-left: 6px;">
                            @foreach($visibleOptions as $option)
                            <li>
                                <a href="{{ route($option->route) }}"
                                    style="border-radius: 10px; padding: 9px 12px; margin: 4px 0; background: {{ $sidebarTabBg }}; color: {{ $sidebarTabText }}; border: 1px solid rgba(0,0,0,0.06);">
                                    {{ __($option->title) }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <a class="sidebar-link sidebar-title link-nav"
                            href="javascript:void(0)"
                            style="border-radius: 12px; padding: 10px 12px; transition: all .2s ease; border: 1px solid rgba(0,0,0,0.04); background: {{ $sidebarTabBg }};">
                            <i class="fa {{ $module->icon }} me-2"
                                style="font-size: 1.05rem; color: {{ $sidebarTabText }};"></i>
                            <span style="font-weight: 600; color: {{ $sidebarTabText }};">{{ __($module->title) }}</span>
                        </a>
                        @endif
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends -->
