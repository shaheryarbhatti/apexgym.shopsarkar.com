<!-- Google font -->
@php
    $faviconPath = \App\Models\Setting::get('favicon', 'assets/images/favicon.png');
@endphp
<link rel="icon" href="{{ asset('public/' . $faviconPath) }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('public/' . $faviconPath) }}" type="image/x-icon">

<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap"
    rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
    rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/font-awesome.css')}}">
<!-- ico-font-->
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/icofont.css')}}">
<!-- Themify icon-->
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/themify.css')}}">
<!-- Flag icon-->
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/flag-icon.css')}}">
<!-- Feather icon-->
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/feather-icon.css')}}">
<!-- Plugins css start-->
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/slick.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/slick-theme.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/scrollbar.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/flatpickr/flatpickr.min.css')}}">
<!-- Plugins css Ends-->
<!-- Bootstrap css-->
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/bootstrap.css')}}">
<!-- App css-->
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/style.css')}}">
<link id="color" rel="stylesheet" href="{{ asset('public/assets/css/color-1.css')}}" media="screen">
<!-- Responsive css-->
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/responsive.css')}}">

<link href="{{ asset('public/assets/fontawesome/css/fontawesome.css')}}" rel="stylesheet" />
<link href="{{ asset('public/assets/fontawesome/css/brands.css')}}" rel="stylesheet" />
<link href="{{ asset('public/assets/fontawesome/css/solid.css')}}" rel="stylesheet" />
<link href="{{ asset('public/assets/fontawesome/css/sharp-thin.css')}}" rel="stylesheet" />
<link href="{{ asset('public/assets/fontawesome/css/sharp-duotone-thin.css')}}" rel="stylesheet" />

@php
    $themePrimary = \App\Models\Setting::get('theme_primary', '#7367f0');
    $themeSecondary = \App\Models\Setting::get('theme_secondary', '#00cfe8');
    $themeAccent = \App\Models\Setting::get('theme_accent', '#0f9b8e');
    $metaKeywords = \App\Models\Setting::get('meta_keywords', 'gym, fitness, membership, attendance, payments');
    $metaDescription = \App\Models\Setting::get('meta_description', 'Gym management system for memberships, attendance, and billing.');
    $metaAuthor = \App\Models\Setting::get('meta_author', 'Sky Fitness Gym');
    $currentTimezone = \App\Models\Setting::get('timezone', config('app.timezone', 'UTC'));
    $headerBgColor = \App\Models\Setting::get('header_bg_color', '#ffffff');
    $headerBgStart = \App\Models\Setting::get('header_bg_start', '');
    $headerBgEnd = \App\Models\Setting::get('header_bg_end', '');
    $headerTexture = \App\Models\Setting::get('header_texture', '');
    $headerTextureUrl = $headerTexture ? asset('public/' . $headerTexture) : '';
    $headerBackground = ($headerBgStart && $headerBgEnd)
        ? 'linear-gradient(90deg, ' . $headerBgStart . ' 0%, ' . $headerBgEnd . ' 100%)'
        : $headerBgColor;
    $headerBackgroundStyle = $headerTextureUrl
        ? "background-image: url('{$headerTextureUrl}'), {$headerBackground}; background-repeat: no-repeat, no-repeat; background-size: 100% 100%, cover; background-position: center;"
        : "background: {$headerBackground};";
@endphp
<meta name="keywords" content="{{ $metaKeywords }}">
<meta name="description" content="{{ $metaDescription }}">
<meta name="author" content="{{ $metaAuthor }}">
<style>
    :root {
        --theme-default: {{ $themePrimary }};
        --theme-secondary: {{ $themeSecondary }};
        --theme-accent: {{ $themeAccent }};
    }

    .btn-primary,
    .btn-primary:focus {
        background-color: var(--theme-default) !important;
        border-color: var(--theme-default) !important;
    }

    .btn-primary:hover {
        background-color: var(--theme-secondary) !important;
        border-color: var(--theme-secondary) !important;
    }

    .btn-outline-primary {
        color: var(--theme-default) !important;
        border-color: var(--theme-default) !important;
    }

    .btn-outline-primary:hover {
        background-color: var(--theme-default) !important;
        border-color: var(--theme-default) !important;
        color: #ffffff !important;
    }

    .bg-primary {
        background-color: var(--theme-default) !important;
    }

    .text-primary {
        color: var(--theme-default) !important;
    }

    .border-primary {
        border-color: var(--theme-default) !important;
    }

    .badge.bg-primary,
    .badge.bg-primary.text-white {
        background-color: var(--theme-default) !important;
    }

    .page-item.active .page-link {
        background-color: var(--theme-default) !important;
        border-color: var(--theme-default) !important;
    }

    .page-link:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.12);
    }

    .form-check-input:checked {
        background-color: var(--theme-default) !important;
        border-color: var(--theme-default) !important;
    }

    .nav-pills .nav-link.active,
    .nav-pills .show > .nav-link {
        background-color: var(--theme-default) !important;
    }

    .progress-bar {
        background-color: var(--theme-default) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: var(--theme-default) !important;
        border-color: var(--theme-default) !important;
        color: #ffffff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--theme-secondary) !important;
        border-color: var(--theme-secondary) !important;
        color: #ffffff !important;
    }

    .logo-overlay-wrap {
        position: relative;
        display: inline-block;
    }

    .logo-overlay-wrap .logo-img {
        display: block;
    }

    .logo-overlay-mask {
        position: absolute;
        inset: 0;
        background: var(--logo-color, transparent);
        -webkit-mask-image: var(--logo-url);
        mask-image: var(--logo-url);
        -webkit-mask-repeat: no-repeat;
        mask-repeat: no-repeat;
        -webkit-mask-size: contain;
        mask-size: contain;
        -webkit-mask-position: center;
        mask-position: center;
        display: none;
    }

    .logo-overlay-wrap.has-overlay .logo-img {
        opacity: 0;
    }

    .logo-overlay-wrap.has-overlay .logo-overlay-mask {
        display: block;
    }

    .doc-blink {
        animation: docPulse 1.8s ease-in-out infinite;
        box-shadow: 0 0 0 rgba(79, 70, 229, 0.5);
        border-radius: 999px;
        font-weight: 700;
    }

    @keyframes docPulse {
        0% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.35); }
        70% { box-shadow: 0 0 0 14px rgba(79, 70, 229, 0); }
        100% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0); }
    }
</style>

</head>

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="theme-loader">
            <div class="loader-p"></div>
        </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start   -->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-header" data-texture="{{ $headerTextureUrl }}" data-base-bg="{{ $headerBackground }}" style="{{ $headerBackgroundStyle }}">
            <div class="header-wrapper row m-0">
                <div class="header-logo-wrapper col-auto p-0">
                    <div class="logo-wrapper"><a href="index.html"> <img class="img-fluid for-light"
                                src="{{asset('public/assets/images/logo/logo.png')}}" alt=""><img
                                class="img-fluid for-dark" src="{{asset('public/assets/images/logo/logo_dark.png')}}"
                                alt=""></a></div>
                    <div class="toggle-sidebar d-block d-lg-none d-flex align-items-center justify-content-center"
                        style="height: 40px; width: 40px;">
                        <i class="fa fa-bars" style="color: #000000; font-size: 24px; cursor: pointer;"></i>
                    </div>
                </div>
                <form class="col-sm-4 form-inline search-full d-none d-xl-block" action="#" method="get">
                    <div class="form-group">
                        <div class="Typeahead Typeahead--twitterUsers">
                            <div class="u-posRelative">
                                <!-- <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Type to Search .." name="q" title="" autofocus>
                  <svg class="search-bg svg-color">
                    <use href="https://admin.pixelstrap.net/zono/assets/svg/icon-sprite.svg#search"></use>
                  </svg> -->
                            </div>
                        </div>
                    </div>
                </form>
                <div class="nav-right col-xl-8 col-lg-12 col-auto pull-right right-header p-0">
                    @php
                        $docUser = auth()->user();
                        $canDocumentation = $docUser && ($docUser->hasRole('Super Admin') || $docUser->canAny(['members.documentation', 'manage-member.documentation']));
                    @endphp
                    <ul class="nav-menus">
                        @if ($canDocumentation)
                        <li class="d-none d-lg-inline-block me-3">
                            <span class="badge rounded-pill bg-light text-dark border px-3 py-2 d-inline-flex align-items-center justify-content-center">
                                <i class="fa fa-clock me-2 text-primary"></i>Time Zone: {{ $currentTimezone }}
                            </span>
                        </li>
                        <li class="d-none d-md-inline-block me-3">
                            <a href="{{ route('documentation') }}" class="btn btn-primary doc-blink px-3">
                                <i class="fa fa-book me-2"></i>{{ __('system_documentation') }}
                            </a>
                        </li>
                        @endif
                        <li class="language-nav">
                            <div class="translate_wrapper">
                                <div class="current_lang">
                                    <div class="lang">
                                        <!-- Show current language flag & code -->
                                        @if (app()->getLocale() === 'en')
                                        <i class="flag-icon flag-icon-us"></i>
                                        <span class="lang-txt box-col-none">EN</span>
                                        @elseif (app()->getLocale() === 'id')
                                        <i class="flag-icon flag-icon-id"></i>
                                        <span class="lang-txt box-col-none">IDR</span>
                                        @else
                                        <!-- Fallback to English -->
                                        <i class="flag-icon flag-icon-us"></i>
                                        <span class="lang-txt box-col-none">EN</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="more_lang">
                                    <div class="lang {{ app()->getLocale() === 'en' ? 'selected' : '' }}"
                                        data-value="en">
                                        <a href="{{ route('language.switch', 'en') }}"
                                            style="display: flex; align-items: center; gap: 8px;">
                                            <i class="flag-icon flag-icon-us"></i>
                                            <span class="lang-txt">English</span>
                                        </a>
                                    </div>

                                    <div class="lang {{ app()->getLocale() === 'id' ? 'selected' : '' }}"
                                        data-value="id">
                                        <a href="{{ route('language.switch', 'id') }}"
                                            style="display: flex; align-items: center; gap: 8px;">
                                            <i class="flag-icon flag-icon-id"></i>
                                            <span class="lang-txt">Bahasa Indonesia</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="profile-nav onhover-dropdown pe-0 py-0">
                            <div class="d-flex align-items-center profile-media">
                                <img class="b-r-25"
                                    src="{{ Auth::user()->image ? asset('public/storage/' . Auth::user()->image) : asset('public/assets/images/dashboard/profile.png') }}"
                                    alt="User Profile" style="width: 40px; height: 40px; object-fit: cover;">
                                <div class="flex-grow-1 user"><span>{{ Auth::user()->name ?? 'Admin' }}</span>
                                    <p class="mb-0 font-nunito">
                                        {{ Auth::user()->roles->pluck('name')->first() ?? __('Guest') }}
                                        <svg>
                                            <use
                                                href="https://admin.pixelstrap.net/zono/assets/svg/icon-sprite.svg#header-arrow-down">
                                            </use>
                                        </svg>
                                    </p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                @if (Auth::user()->hasRole(['Admin', 'Super Admin', 'Manager']))
                                <li><a href="{{ route('settings.index') }}"><i
                                            data-feather="settings"></i><span>{{ __('Settings') }}</span></a>
                                </li>
                                @endif
                                <li><a href="{{ route('userlogout') }}"> <i
                                            data-feather="log-in"></i><span>{{ __('Log Out') }}</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <script class="result-template" type="text/x-handlebars-template">
                    <div class="ProfileCard u-cf">
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName"></div>
            </div>
            </div>
          </script>
                <script class="empty-template" type="text/x-handlebars-template">
                    <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div>
                    </script>
            </div>
        </div>
        <!-- Page Header Ends                              -->
        <!-- Page body Start -->
        <div class="page-body-wrapper">
