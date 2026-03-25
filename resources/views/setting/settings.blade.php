<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('system_settings') }}</title>

@extends('layouts.app')
@section('content')
@php
    $activeCurrency = \App\Services\CurrencyService::getActiveCurrency();
    $currencyLabel = $activeCurrency ? trim($activeCurrency->symbol . ' ' . $activeCurrency->code) : 'Rp';
    $currencyCode = $activeCurrency ? $activeCurrency->code : 'IDR';
    $currencyRate = $activeCurrency ? (float) $activeCurrency->exchange_rate : 1;
    $baseCurrencyCode = \App\Models\Setting::get('base_currency_code', 'IDR');
    $baseCurrency = \App\Models\Currency::where('code', $baseCurrencyCode)->first();
    $baseLabel = $baseCurrency ? trim($baseCurrency->symbol . ' ' . $baseCurrency->code) : $baseCurrencyCode;
    $themePrimary = \App\Models\Setting::get('theme_primary', '#7367f0');
    $themeSecondary = \App\Models\Setting::get('theme_secondary', '#00cfe8');
    $themeAccent = \App\Models\Setting::get('theme_accent', '#0f9b8e');
    $sidebarDashboardTextColor = \App\Models\Setting::get('sidebar_dashboard_text_color', '#ffffff');
@endphp
<script>
    window.gymCurrency = {
        label: @json($currencyLabel),
        code: @json($currencyCode),
        rate: @json($currencyRate),
        baseLabel: @json($baseLabel)
    };
    window.settingsI18n = {
        addDuration: @json(__('settings_add_duration')),
        addSession: @json(__('settings_add_session')),
        newMembership: @json(__('settings_new_membership')),
        durationOneMonth: @json(__('settings_duration_1_month')),
        newDuration: @json(__('settings_new_duration')),
        newCategory: @json(__('settings_new_category')),
        newTrainerType: @json(__('settings_new_trainer_type')),
        newSessionPackage: @json(__('settings_new_session_package')),
        durationDays: @json(__('settings_duration_days')),
        priceBaseLabel: @json(__('settings_price_base_label')),
        pricePlaceholder: @json(__('settings_price_placeholder'))
    };
</script>
<style>
    #membership-price-builder .card,
    #price-visit-builder .card,
    #trainer-price-builder .card {
        border-radius: 18px;
        box-shadow: 0 14px 28px rgba(18, 38, 63, 0.08);
    }
    #membership-price-builder .form-control,
    #price-visit-builder .form-control,
    #trainer-price-builder .form-control {
        border-radius: 12px;
    }
    #membership-price-builder .btn,
    #price-visit-builder .btn,
    #trainer-price-builder .btn {
        border-radius: 12px;
    }
    .settings-save-float {
        position: fixed;
        right: 24px;
        bottom: 24px;
        z-index: 1050;
    }
    .settings-save-float .btn {
        border-radius: 999px;
        padding: 12px 20px;
        box-shadow: 0 12px 24px rgba(15, 155, 142, 0.25);
    }
    .settings-tabs {
        position: sticky;
        top: 72px;
        z-index: 1020;
        background: #ffffff;
        padding: 12px 12px;
        border-radius: 16px;
        border: 1px solid #eef2f7;
        box-shadow: 0 10px 24px rgba(18, 38, 63, 0.08);
        margin-bottom: 20px;
        gap: 10px;
    }
    .settings-tabs .nav-link {
        border-radius: 999px;
        padding: 8px 16px;
        font-weight: 700;
        background: #f5f7fb;
        color: {{ $themeAccent }};
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }
    .settings-tabs .nav-link:hover,
    .settings-tabs .nav-link:focus {
        background: rgba(15, 118, 110, 0.08);
        border-color: {{ $themeSecondary }};
        color: {{ $themePrimary }};
        transform: translateY(-1px);
        box-shadow: 0 6px 12px rgba(15, 118, 110, 0.18);
    }
    .settings-tabs .nav-link.active {
        background: linear-gradient(135deg, {{ $themePrimary }}, {{ $themeSecondary }});
        color: {{ $sidebarDashboardTextColor }};
        border-color: transparent;
        box-shadow: 0 10px 18px rgba(15, 118, 110, 0.25);
    }
    .settings-section {
        scroll-margin-top: 110px;
    }
</style>
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header pb-0">
                        <h4>{{ __('system_settings') }}</h4>
                    </div>
                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
                        @csrf
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @php $guestMode = env('GUEST_MODE') === 'on'; @endphp
                            @if ($guestMode)
                                <div class="alert alert-warning">
                                    {{ __('settings_guest_mode_block') }}
                                </div>
                            @endif
                            <fieldset {{ $guestMode ? 'disabled' : '' }}>
                            <ul class="nav nav-pills gap-2 flex-wrap settings-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings-branding">{{ __('settings_tab_branding') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings-theme-colors">{{ __('settings_tab_theme') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings-login-text">{{ __('settings_tab_login_text') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings-meta-tags">{{ __('settings_tab_meta_tags') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings-smtp">{{ __('settings_tab_smtp') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings-license">{{ __('settings_tab_license') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings-membership-price">{{ __('settings_tab_membership_price') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings-price-visit">{{ __('settings_tab_price_visit') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings-freeze-price">{{ __('settings_tab_freeze_price') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings-trainer-price">{{ __('settings_tab_trainer_price') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings-card-design">{{ __('settings_tab_card_design') }}</a>
                                </li>
                            </ul>
                            <div class="row settings-section" id="settings-branding">
                                <div class="col-sm-12 mb-4">
                                    <label class="form-label fw-bold">{{ __('footer_text') }}</label>
                                    <input type="text" name="footer_text" class="form-control"
                                           value="{{ \App\Models\Setting::get('footer_text') }}"
                                           placeholder="e.g. Copyright 2026 © Sky Fitness Gym" {{ $guestMode ? 'disabled' : '' }}>
                                </div>

                                <div class="col-xl-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('login_logo') }}</label>
                                    <input type="file" name="login_logo" class="form-control mb-2" {{ $guestMode ? 'disabled' : '' }}>
                                    <div class="preview-box border p-2 text-center bg-light">
                                        <img src="{{ asset('public/' .\App\Models\Setting::get('login_logo', 'public/assets/images/logo/logo.png')) }}"
                                             style="max-height: 80px; width: auto;">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('admin_logo') }}</label>
                                    <input type="file" name="admin_logo" class="form-control mb-2" {{ $guestMode ? 'disabled' : '' }}>
                                    <div class="preview-box border p-2 text-center bg-light">
                                        <img src="{{ asset('public/' .\App\Models\Setting::get('admin_logo', 'public/assets/images/logo/logo_dark.png')) }}"
                                             style="max-height: 80px; width: auto;">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('login_background_image') }}</label>
                                    <input type="file" name="login_bg_image" class="form-control mb-2" {{ $guestMode ? 'disabled' : '' }}>
                                    <div class="preview-box border p-2 text-center bg-light">
                                        <img src="{{ asset('public/' .\App\Models\Setting::get('login_bg_image', 'public/assets/images/login/bg.jpg')) }}"
                                             style="max-height: 80px; width: 100%; object-fit: cover;">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_favicon') }}</label>
                                    <input type="file" name="favicon" class="form-control mb-2" accept="image/png,image/x-icon,image/vnd.microsoft.icon" {{ $guestMode ? 'disabled' : '' }}>
                                    <div class="preview-box border p-2 text-center bg-light">
                                        <img src="{{ asset('public/' .\App\Models\Setting::get('favicon', 'assets/images/favicon.png')) }}"
                                             style="max-height: 48px; width: auto;">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row settings-section" id="settings-theme-colors">
                                <div class="col-12 mb-2">
                                    <h5 class="mb-1">{{ __('settings_theme_colors') }}</h5>
                                    <p class="text-muted mb-0">{{ __('settings_theme_desc') }}</p>
                                </div>

                                <div class="col-xl-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_primary_color') }}</label>
                                    <div class="input-group">
                                        <input type="color" name="theme_primary" class="form-control form-control-color"
                                               value="{{ \App\Models\Setting::get('theme_primary', '#7367f0') }}">
                                        <input type="text" name="theme_primary_text" class="form-control"
                                               value="{{ \App\Models\Setting::get('theme_primary', '#7367f0') }}"
                                               placeholder="#7367f0">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_secondary_color') }}</label>
                                    <div class="input-group">
                                        <input type="color" name="theme_secondary" class="form-control form-control-color"
                                               value="{{ \App\Models\Setting::get('theme_secondary', '#00cfe8') }}">
                                        <input type="text" name="theme_secondary_text" class="form-control"
                                               value="{{ \App\Models\Setting::get('theme_secondary', '#00cfe8') }}"
                                               placeholder="#00cfe8">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_accent_color') }}</label>
                                    <div class="input-group">
                                        <input type="color" name="theme_accent" class="form-control form-control-color"
                                               value="{{ \App\Models\Setting::get('theme_accent', '#0f9b8e') }}">
                                        <input type="text" name="theme_accent_text" class="form-control"
                                               value="{{ \App\Models\Setting::get('theme_accent', '#0f9b8e') }}"
                                               placeholder="#0f9b8e">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_sidebar_dashboard_text_color') }}</label>
                                    <div class="input-group">
                                        <input type="color" name="sidebar_dashboard_text_color" class="form-control form-control-color"
                                               value="{{ \App\Models\Setting::get('sidebar_dashboard_text_color', '#ffffff') }}">
                                        <input type="text" name="sidebar_dashboard_text_color_text" class="form-control"
                                               value="{{ \App\Models\Setting::get('sidebar_dashboard_text_color', '#ffffff') }}"
                                               placeholder="#ffffff">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row settings-section" id="settings-login-text">
                                <div class="col-12 mb-2">
                                    <h5 class="mb-1">{{ __('settings_login_text') }}</h5>
                                    <p class="text-muted mb-0">{{ __('settings_login_text_desc') }}</p>
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_login_heading') }}</label>
                                    <input type="text" name="login_heading" class="form-control"
                                           value="{{ \App\Models\Setting::get('login_heading', 'Train Smarter, Track Faster') }}">
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_login_badge_text') }}</label>
                                    <input type="text" name="login_badge_text" class="form-control"
                                           value="{{ \App\Models\Setting::get('login_badge_text', 'Sky Fitness Gym') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_login_heading_color') }}</label>
                                    <div class="input-group">
                                        <input type="color" name="login_heading_color" class="form-control form-control-color"
                                               value="{{ \App\Models\Setting::get('login_heading_color', '#ffffff') }}">
                                        <input type="text" name="login_heading_color_text" class="form-control"
                                               value="{{ \App\Models\Setting::get('login_heading_color', '#ffffff') }}"
                                               placeholder="#ffffff">
                                    </div>
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_login_description') }}</label>
                                    <textarea name="login_description" class="form-control" rows="3">{{ \App\Models\Setting::get('login_description', 'Streamline daily operations with member profiles, smart attendance, and simple billing in one place.') }}</textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_login_bullet_1') }}</label>
                                    <input type="text" name="login_bullet_1" class="form-control"
                                           value="{{ \App\Models\Setting::get('login_bullet_1', 'Fast member check-ins') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_login_bullet_2') }}</label>
                                    <input type="text" name="login_bullet_2" class="form-control"
                                           value="{{ \App\Models\Setting::get('login_bullet_2', 'Clean, modern reports') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_login_barcode_toggle') }}</label>
                                    <div class="form-check form-switch mt-2">
                                        <input type="hidden" name="login_barcode_enabled" value="0">
                                        <input class="form-check-input" type="checkbox" role="switch" id="login_barcode_enabled"
                                               name="login_barcode_enabled" value="1"
                                               {{ \App\Models\Setting::get('login_barcode_enabled', '1') === '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="login_barcode_enabled">{{ __('settings_login_barcode_toggle_desc') }}</label>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row settings-section" id="settings-meta-tags">
                                <div class="col-12 mb-2">
                                    <h5 class="mb-1">{{ __('settings_meta_tags') }}</h5>
                                    <p class="text-muted mb-0">{{ __('settings_meta_tags_desc') }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_meta_author') }}</label>
                                    <input type="text" name="meta_author" class="form-control"
                                           value="{{ \App\Models\Setting::get('meta_author', 'Sky Fitness Gym') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_meta_keywords') }}</label>
                                    <input type="text" name="meta_keywords" class="form-control"
                                           value="{{ \App\Models\Setting::get('meta_keywords', 'gym, fitness, membership, attendance, payments') }}">
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_meta_description') }}</label>
                                    <textarea name="meta_description" class="form-control" rows="3">{{ \App\Models\Setting::get('meta_description', 'Gym management system for memberships, attendance, and billing.') }}</textarea>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row settings-section" id="settings-smtp">
                                <div class="col-12 mb-2">
                                    <h5 class="mb-1">{{ __('settings_smtp') }}</h5>
                                    <p class="text-muted mb-0">{{ __('settings_smtp_desc') }}</p>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_smtp_host') }}</label>
                                    <input type="text" name="smtp_host" class="form-control"
                                           value="{{ \App\Models\Setting::get('smtp_host') }}" placeholder="smtp.example.com">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_smtp_port') }}</label>
                                    <input type="text" name="smtp_port" class="form-control"
                                           value="{{ \App\Models\Setting::get('smtp_port') }}" placeholder="587">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_smtp_encryption') }}</label>
                                    <select name="smtp_encryption" class="form-select">
                                        @php $smtpEnc = \App\Models\Setting::get('smtp_encryption', 'tls'); @endphp
                                        <option value="">{{ __('settings_smtp_none') }}</option>
                                        <option value="tls" {{ $smtpEnc === 'tls' ? 'selected' : '' }}>TLS</option>
                                        <option value="ssl" {{ $smtpEnc === 'ssl' ? 'selected' : '' }}>SSL</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_smtp_username') }}</label>
                                    <input type="text" name="smtp_username" class="form-control"
                                           value="{{ \App\Models\Setting::get('smtp_username') }}" placeholder="user@example.com">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_smtp_password') }}</label>
                                    <input type="password" name="smtp_password" class="form-control"
                                           value="{{ \App\Models\Setting::get('smtp_password') }}" placeholder="••••••••">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_smtp_from_email') }}</label>
                                    <input type="email" name="smtp_from_email" class="form-control"
                                           value="{{ \App\Models\Setting::get('smtp_from_email') }}" placeholder="noreply@example.com">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_smtp_from_name') }}</label>
                                    <input type="text" name="smtp_from_name" class="form-control"
                                           value="{{ \App\Models\Setting::get('smtp_from_name') }}" placeholder="Sky Fitness Gym">
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row settings-section" id="settings-license">
                                <div class="col-12 mb-2">
                                    <h5 class="mb-1">{{ __('settings_license') }}</h5>
                                    <p class="text-muted mb-0">{{ __('settings_license_desc') }}</p>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">{{ __('license_client_name') }}</label>
                                    <input type="text" name="license_client_name" class="form-control"
                                           value="{{ \App\Models\Setting::get('license_client_name') }}" placeholder="Sky Fitness Gym">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">{{ __('license_server_url') }}</label>
                                    <input type="text" name="license_server_url" class="form-control"
                                           value="{{ \App\Models\Setting::get('license_server_url') }}" placeholder="https://license.example.com">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">{{ __('license_key') }}</label>
                                    <input type="text" name="license_key" class="form-control"
                                           value="{{ \App\Models\Setting::get('license_key') }}" placeholder="LIC-XXXX-XXXX-XXXX">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">{{ __('license_project_key') }}</label>
                                    <input type="text" name="license_project_key" class="form-control"
                                           value="{{ \App\Models\Setting::get('license_project_key') }}" placeholder="PRJ-XXXX-XXXX">
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row settings-section" id="settings-membership-price">
                                <div class="col-12 mb-2">
                                    <h5 class="mb-1">{{ __('settings_membership_price') }}</h5>
                                    <p class="text-muted mb-0">{{ __('settings_membership_price_desc') }}</p>
                                </div>

                                <div class="col-12">
                                    <div id="membership-price-builder" class="row g-4"></div>
                                    <input type="hidden" name="membership_pricing" id="membership_pricing"
                                           value="{{ \App\Models\Setting::get('membership_pricing', '') }}">
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <button type="button" class="btn btn-outline-primary" id="add-membership-btn">
                                            <i class="fa fa-plus-circle me-2"></i> {{ __('settings_add_membership') }}
                                        </button>
                                        <small class="text-muted">{{ __('settings_remember_save') }}</small>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row settings-section" id="settings-price-visit">
                                <div class="col-12 mb-2">
                                    <h5 class="mb-1">{{ __('settings_price_per_visit') }}</h5>
                                    <p class="text-muted mb-0">{{ __('settings_price_per_visit_desc') }}</p>
                                </div>

                                <div class="col-12">
                                    <div id="price-visit-builder" class="row g-4"></div>
                                    <input type="hidden" name="price_visit" id="price_visit"
                                           value="{{ \App\Models\Setting::get('price_visit', '') }}">
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <button type="button" class="btn btn-outline-primary" id="add-visit-btn">
                                            <i class="fa fa-plus-circle me-2"></i> {{ __('settings_add_category') }}
                                        </button>
                                        <small class="text-muted">{{ __('settings_remember_save') }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- <hr class="my-4">

                            <div class="row settings-section" id="settings-freeze-price">
                                <div class="col-12 mb-2">
                                    <h5 class="mb-1">{{ __('settings_freeze_membership_price') }}</h5>
                                    <p class="text-muted mb-0">{{ __('settings_freeze_membership_price_desc') }}</p>
                                </div>

                                <div class="col-12">
                                    <div class="border rounded-3 p-3 bg-light">
                                        <label class="form-label text-dark fw-bold mb-2">{{ __('settings_freeze_price_label', ['currency' => $baseLabel]) }}</label>
                                        <input type="text" name="freeze_membership_price" id="freeze_membership_price" class="form-control"
                                               value="{{ \App\Models\Setting::get('freeze_membership_price', '') }}"
                                               placeholder="{{ __('settings_price_placeholder', ['currency' => $baseLabel]) }}">
                                        <small class="text-muted d-block mt-2" id="freeze_membership_preview"></small>
                                    </div>
                                </div>
                            </div> -->

                            <hr class="my-4">

                            <div class="row settings-section" id="settings-trainer-price">
                                <div class="col-12 mb-2">
                                    <h5 class="mb-1">{{ __('settings_trainer_price') }}</h5>
                                    <p class="text-muted mb-0">{{ __('settings_trainer_price_desc') }}</p>
                                </div>

                                <div class="col-12">
                                    <div id="trainer-price-builder" class="row g-4"></div>
                                    <input type="hidden" name="trainer_pricing" id="trainer_pricing"
                                           value="{{ \App\Models\Setting::get('trainer_pricing', '') }}">
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <button type="button" class="btn btn-outline-primary" id="add-trainer-btn">
                                            <i class="fa fa-plus-circle me-2"></i> {{ __('settings_add_trainer_type') }}
                                        </button>
                                        <small class="text-muted">{{ __('settings_remember_save') }}</small>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row settings-section" id="settings-card-design">
                                <div class="col-12 mb-2">
                                    <h5 class="mb-1">{{ __('settings_card_design') }}</h5>
                                    <p class="text-muted mb-0">{{ __('settings_card_design_desc') }}</p>
                                </div>

                                <div class="col-xl-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_card_bg_color') }}</label>
                                    <div class="input-group">
                                        <input type="color" name="card_bg_color" class="form-control form-control-color"
                                               value="{{ \App\Models\Setting::get('card_bg_color', '#0b1d2c') }}">
                                        <input type="text" name="card_bg_color_text" class="form-control"
                                               value="{{ \App\Models\Setting::get('card_bg_color', '#0b1d2c') }}"
                                               placeholder="#0b1d2c">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_card_text_color') }}</label>
                                    <div class="input-group">
                                        <input type="color" name="card_text_color" class="form-control form-control-color"
                                               value="{{ \App\Models\Setting::get('card_text_color', '#ffffff') }}">
                                        <input type="text" name="card_text_color_text" class="form-control"
                                               value="{{ \App\Models\Setting::get('card_text_color', '#ffffff') }}"
                                               placeholder="#ffffff">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_card_title') }}</label>
                                    <input type="text" name="card_title" class="form-control"
                                           value="{{ \App\Models\Setting::get('card_title', 'Membership Card') }}">
                                </div>

                                <div class="col-xl-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('settings_card_logo_source') }}</label>
                                    <div class="d-flex gap-3 flex-wrap">
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="card_logo_source" value="login"
                                                   {{ \App\Models\Setting::get('card_logo_source', 'login') === 'login' ? 'checked' : '' }}>
                                            <span class="form-check-label">{{ __('settings_card_logo_login') }}</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="card_logo_source" value="admin"
                                                   {{ \App\Models\Setting::get('card_logo_source', 'login') === 'admin' ? 'checked' : '' }}>
                                            <span class="form-check-label">{{ __('settings_card_logo_admin') }}</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="border rounded-3 p-3 bg-light">
                                        <div class="d-flex flex-column align-items-center gap-3">
                                            <div id="card-preview"
                                                 style="width: 220px; height: 360px; border-radius: 18px; background: {{ \App\Models\Setting::get('card_bg_color', '#0b1d2c') }}; color: {{ \App\Models\Setting::get('card_text_color', '#ffffff') }}; display: flex; flex-direction: column; align-items: center; justify-content: flex-start; padding: 24px 18px; box-shadow: 0 14px 28px rgba(18, 38, 63, 0.18);">
                                                <div id="card-logo-wrap" style="width: 110px; height: 110px; display: flex; align-items: center; justify-content: center;">
                                                    <img id="card-logo-preview"
                                                         src="{{ \App\Models\Setting::get('card_logo_source', 'login') === 'admin'
                                                            ? asset('public/' . \App\Models\Setting::get('admin_logo', 'public/assets/images/logo/logo_dark.png'))
                                                            : asset('public/' . \App\Models\Setting::get('login_logo', 'public/assets/images/logo/logo.png')) }}"
                                                         alt="logo" style="max-width: 100%; max-height: 100%;">
                                                </div>
                                                <div style="margin-top: 0px; text-align: center;">
                                                    <div id="card-title-preview" style="font-weight: 700; letter-spacing: 0.04em; font-size: 14px;">
                                                        {{ \App\Models\Setting::get('card_title', 'Membership Card') }}
                                                    </div>
                                                </div>
                                                <div style="margin-top: auto; width: 100%; height: 6px; background: rgba(255,255,255,0.2); border-radius: 999px;"></div>
                                            </div>
                                            <p class="text-muted mb-0 text-center">{{ __('settings_card_note') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </fieldset>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">{{ __('save_settings') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="settings-save-float">
    <button class="btn btn-primary" type="submit" form="settingsForm">
        <i class="fa fa-save me-2"></i>{{ __('save_settings') }}
    </button>
</div>
<script>
    (function() {
        const pairs = [
            { color: 'theme_primary', text: 'theme_primary_text' },
            { color: 'theme_secondary', text: 'theme_secondary_text' },
            { color: 'theme_accent', text: 'theme_accent_text' },
            { color: 'card_bg_color', text: 'card_bg_color_text' },
            { color: 'card_text_color', text: 'card_text_color_text' },
            { color: 'sidebar_dashboard_text_color', text: 'sidebar_dashboard_text_color_text' },
            { color: 'login_heading_color', text: 'login_heading_color_text' }
        ];

        const isHex = (val) => /^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/.test(val);

        pairs.forEach((pair) => {
            const colorInput = document.querySelector(`input[name="${pair.color}"]`);
            const textInput = document.querySelector(`input[name="${pair.text}"]`);
            if (!colorInput || !textInput) return;

            colorInput.addEventListener('input', () => {
                textInput.value = colorInput.value;
            });

            textInput.addEventListener('input', () => {
                if (isHex(textInput.value)) {
                    colorInput.value = textInput.value;
                    if (pair.color === 'card_bg_color' || pair.color === 'card_text_color') {
                        updateCardPreview();
                    }
                }
            });
        });

        const updateCardPreview = () => {
            const bgInput = document.querySelector('input[name="card_bg_color"]');
            const textColorInput = document.querySelector('input[name="card_text_color"]');
            const titleInput = document.querySelector('input[name="card_title"]');
            const logoChoice = document.querySelector('input[name="card_logo_source"]:checked');
            const preview = document.getElementById('card-preview');
            const titlePreview = document.getElementById('card-title-preview');
            const logoPreview = document.getElementById('card-logo-preview');
            if (!preview || !titlePreview || !logoPreview) return;

            if (bgInput) {
                preview.style.background = bgInput.value;
            }
            if (textColorInput) {
                preview.style.color = textColorInput.value;
            }
            if (titleInput) {
                titlePreview.textContent = titleInput.value || '{{ __('settings_card_default_title') }}';
            }
            if (logoChoice) {
                const source = logoChoice.value;
                const loginLogo = @json(asset('public/' . \App\Models\Setting::get('login_logo', 'public/assets/images/logo/logo.png')));
                const adminLogo = @json(asset('public/' . \App\Models\Setting::get('admin_logo', 'public/assets/images/logo/logo_dark.png')));
                logoPreview.src = source === 'admin' ? adminLogo : loginLogo;
            }
        };

        const bgInput = document.querySelector('input[name="card_bg_color"]');
        const textColorInput = document.querySelector('input[name="card_text_color"]');
        const titleInput = document.querySelector('input[name="card_title"]');
        const logoRadios = document.querySelectorAll('input[name="card_logo_source"]');
        if (bgInput) bgInput.addEventListener('input', updateCardPreview);
        if (textColorInput) textColorInput.addEventListener('input', updateCardPreview);
        if (titleInput) titleInput.addEventListener('input', updateCardPreview);
        logoRadios.forEach((radio) => radio.addEventListener('change', updateCardPreview));
        updateCardPreview();
    })();

    (function() {
        const currency = window.gymCurrency || { label: 'Rp', code: 'IDR', rate: 1, baseLabel: 'Rp' };
        const numberFormat = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: currency.code === 'IDR' ? 0 : 2,
            maximumFractionDigits: currency.code === 'IDR' ? 0 : 2
        });
        const sanitizePrice = (value) => String(value ?? '').replace(/[^0-9.]/g, '');
        const formatPrice = (value) => {
            const cleaned = sanitizePrice(value);
            if (!cleaned) return '';
            const num = Number(cleaned);
            if (Number.isNaN(num)) return '';
            const converted = currency.rate ? (num / currency.rate) : num;
            return numberFormat.format(converted);
        };

        const input = document.getElementById('freeze_membership_price');
        const preview = document.getElementById('freeze_membership_preview');
        if (!input || !preview) return;

        const updatePreview = () => {
            const cleaned = sanitizePrice(input.value);
            input.value = cleaned;
            const formatted = formatPrice(cleaned);
            preview.textContent = formatted ? `≈ ${currency.label} ${formatted}` : '';
        };

        input.addEventListener('input', updatePreview);
        updatePreview();
    })();

    (function() {
        const container = document.getElementById('trainer-price-builder');
        const addBtn = document.getElementById('add-trainer-btn');
        const hiddenInput = document.getElementById('trainer_pricing');

        if (!container || !addBtn || !hiddenInput) {
            return;
        }

        const currency = window.gymCurrency || { label: 'Rp', code: 'IDR', rate: 1, baseLabel: 'Rp' };
        const i18n = window.settingsI18n || {};
        const baseLabelText = (i18n.priceBaseLabel || 'Price (Base :currency)').replace(':currency', currency.baseLabel);
        const pricePlaceholderText = (i18n.pricePlaceholder || ':currency 0').replace(':currency', currency.baseLabel);
        const numberFormat = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: currency.code === 'IDR' ? 0 : 2,
            maximumFractionDigits: currency.code === 'IDR' ? 0 : 2
        });
        const sanitizePrice = (value) => String(value ?? '').replace(/[^0-9.]/g, '');
        const formatPrice = (value) => {
            const cleaned = sanitizePrice(value);
            if (!cleaned) return '';
            const num = Number(cleaned);
            if (Number.isNaN(num)) return '';
            const converted = currency.rate ? (num / currency.rate) : num;
            return numberFormat.format(converted);
        };

        let existing = [];
        if (hiddenInput.value) {
            try {
                existing = JSON.parse(hiddenInput.value);
            } catch (err) {
                existing = [];
            }
        }

        const defaultTrainer = () => ({
            title: i18n.newTrainerType || 'Regular',
            sessions: [{ title: i18n.newSessionPackage || '8 session package', days: '30', price: '' }]
        });

        const render = () => {
            container.innerHTML = '';
            const data = getData();

            data.forEach((trainer, tIndex) => {
                const col = document.createElement('div');
                col.className = 'col-xl-6 col-lg-6';
                col.innerHTML = `
                    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <input type="text" class="form-control fw-bold" value="${escapeHtml(trainer.title)}"
                                    data-role="trainer-title" data-index="${tIndex}">
                                <button type="button" class="btn btn-outline-danger btn-sm ms-2" data-role="trainer-remove" data-index="${tIndex}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <div class="trainer-sessions" data-index="${tIndex}"></div>
                            <button type="button" class="btn btn-outline-secondary w-100 mt-3" data-role="trainer-add-session" data-index="${tIndex}">
                                <i class="fa fa-plus-circle me-2"></i> ${i18n.addSession || 'Add Session'}
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(col);

                const sessionContainer = col.querySelector('.trainer-sessions');
                trainer.sessions.forEach((session, sIndex) => {
                    const display = formatPrice(session.price);
                    const sessionItem = document.createElement('div');
                    sessionItem.className = 'p-3 mb-3 border rounded-3';
                    sessionItem.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <input type="text" class="form-control me-2" value="${escapeHtml(session.title)}"
                                data-role="session-title" data-index="${tIndex}" data-sindex="${sIndex}">
                            <button type="button" class="btn btn-outline-danger btn-sm" data-role="trainer-remove-session" data-index="${tIndex}" data-sindex="${sIndex}">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label fw-bold mb-1">${i18n.durationDays || 'Duration (days)'}</label>
                                <input type="text" class="form-control" value="${escapeHtml(session.days)}"
                                    data-role="session-days" data-index="${tIndex}" data-sindex="${sIndex}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold mb-1">${baseLabelText}</label>
                                <input type="text" class="form-control" value="${escapeHtml(session.price)}"
                                    data-role="session-price" data-index="${tIndex}" data-sindex="${sIndex}">
                                <small class="text-muted d-block mt-1" data-role="session-display">
                                    ${display ? `≈ ${currency.label} ${display}` : ''}
                                </small>
                            </div>
                        </div>
                    `;
                    sessionContainer.appendChild(sessionItem);
                });
            });

            syncHidden();
        };

        const getData = () => {
            if (!container.dataset.state) {
                container.dataset.state = JSON.stringify(existing.length ? existing : [defaultTrainer()]);
            }
            return JSON.parse(container.dataset.state);
        };

        const setData = (data) => {
            container.dataset.state = JSON.stringify(data);
            syncHidden();
        };

        const syncHidden = () => {
            hiddenInput.value = container.dataset.state || '';
        };

        const escapeHtml = (value) => {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        };

        addBtn.addEventListener('click', () => {
            const data = getData();
            data.push(defaultTrainer());
            setData(data);
            render();
        });

        container.addEventListener('click', (event) => {
            const target = event.target.closest('button');
            if (!target) return;

            const role = target.getAttribute('data-role');
            const tIndex = Number(target.getAttribute('data-index'));
            const sIndex = Number(target.getAttribute('data-sindex'));
            const data = getData();

            if (role === 'trainer-remove') {
                data.splice(tIndex, 1);
                setData(data.length ? data : [defaultTrainer()]);
                render();
                return;
            }

            if (role === 'trainer-add-session') {
                data[tIndex].sessions.push({ title: i18n.newSessionPackage || 'New session package', days: '30', price: '' });
                setData(data);
                render();
                return;
            }

            if (role === 'trainer-remove-session') {
                data[tIndex].sessions.splice(sIndex, 1);
                if (!data[tIndex].sessions.length) {
                    data[tIndex].sessions.push({ title: i18n.newSessionPackage || 'New session package', days: '30', price: '' });
                }
                setData(data);
                render();
            }
        });

        container.addEventListener('input', (event) => {
            const target = event.target;
            const role = target.getAttribute('data-role');
            if (!role) return;

            const tIndex = Number(target.getAttribute('data-index'));
            const sIndex = Number(target.getAttribute('data-sindex'));
            const data = getData();

            if (role === 'trainer-title') {
                data[tIndex].title = target.value;
            }
            if (role === 'session-title') {
                data[tIndex].sessions[sIndex].title = target.value;
            }
            if (role === 'session-days') {
                data[tIndex].sessions[sIndex].days = target.value;
            }
            if (role === 'session-price') {
                const cleaned = sanitizePrice(target.value);
                data[tIndex].sessions[sIndex].price = cleaned;
                const displayNode = target.parentElement?.querySelector('[data-role="session-display"]');
                if (displayNode) {
                    const formatted = formatPrice(cleaned);
                    displayNode.textContent = formatted ? `≈ ${currency.label} ${formatted}` : '';
                }
            }

            setData(data);
        });

        render();
    })();

    (function() {
        const container = document.getElementById('membership-price-builder');
        const addMembershipBtn = document.getElementById('add-membership-btn');
        const hiddenInput = document.getElementById('membership_pricing');

        if (!container || !addMembershipBtn || !hiddenInput) {
            return;
        }

        const currency = window.gymCurrency || { label: 'Rp', code: 'IDR', rate: 1, baseLabel: 'Rp' };
        const i18n = window.settingsI18n || {};
        const baseLabelText = (i18n.priceBaseLabel || 'Price (Base :currency)').replace(':currency', currency.baseLabel);
        const pricePlaceholderText = (i18n.pricePlaceholder || ':currency 0').replace(':currency', currency.baseLabel);
        const numberFormat = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: currency.code === 'IDR' ? 0 : 2,
            maximumFractionDigits: currency.code === 'IDR' ? 0 : 2
        });
        const sanitizePrice = (value) => String(value ?? '').replace(/[^0-9.]/g, '');
        const formatPrice = (value) => {
            const cleaned = sanitizePrice(value);
            if (!cleaned) return '';
            const num = Number(cleaned);
            if (Number.isNaN(num)) return '';
            const converted = currency.rate ? (num / currency.rate) : num;
            return numberFormat.format(converted);
        };

        let existing = [];
        if (hiddenInput.value) {
            try {
                existing = JSON.parse(hiddenInput.value);
            } catch (err) {
                existing = [];
            }
        }

        const defaultMembership = () => ({
            title: i18n.newMembership || 'New Membership',
            durations: [{ title: i18n.durationOneMonth || 'Duration 1 month', price: '' }]
        });

        const render = () => {
            container.innerHTML = '';
            const data = getData();

            data.forEach((membership, mIndex) => {
                const col = document.createElement('div');
                col.className = 'col-xl-4 col-md-6';

                col.innerHTML = `
                    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <input type="text" class="form-control fw-bold" value="${escapeHtml(membership.title)}"
                                    data-role="membership-title" data-index="${mIndex}">
                                <button type="button" class="btn btn-outline-danger btn-sm ms-2" data-role="remove-membership" data-index="${mIndex}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>

                            <div class="membership-durations" data-index="${mIndex}"></div>

                            <button type="button" class="btn btn-outline-secondary w-100 mt-3" data-role="add-duration" data-index="${mIndex}">
                                <i class="fa fa-plus-circle me-2"></i> ${i18n.addDuration || 'Add Duration'}
                            </button>
                        </div>
                    </div>
                `;

                container.appendChild(col);

                const durationsContainer = col.querySelector('.membership-durations');
                membership.durations.forEach((duration, dIndex) => {
                    const durationItem = document.createElement('div');
                    durationItem.className = 'p-3 mb-3 border rounded-3';
                    const display = formatPrice(duration.price);
                    durationItem.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <input type="text" class="form-control me-2" value="${escapeHtml(duration.title)}"
                                data-role="duration-title" data-index="${mIndex}" data-dindex="${dIndex}">
                            <button type="button" class="btn btn-outline-danger btn-sm" data-role="remove-duration" data-index="${mIndex}" data-dindex="${dIndex}">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control" placeholder="${pricePlaceholderText}"
                            value="${escapeHtml(duration.price)}" data-role="duration-price" data-index="${mIndex}" data-dindex="${dIndex}">
                        <small class="text-muted d-block mt-1" data-role="price-display">
                            ${display ? `≈ ${currency.label} ${display}` : ''}
                        </small>
                    `;
                    durationsContainer.appendChild(durationItem);
                });
            });

            syncHidden();
        };

        const getData = () => {
            if (!container.dataset.state) {
                container.dataset.state = JSON.stringify(existing.length ? existing : [defaultMembership()]);
            }
            return JSON.parse(container.dataset.state);
        };

        const setData = (data) => {
            container.dataset.state = JSON.stringify(data);
            syncHidden();
        };

        const syncHidden = () => {
            hiddenInput.value = container.dataset.state || '';
        };

        const escapeHtml = (value) => {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        };

        addMembershipBtn.addEventListener('click', () => {
            const data = getData();
            data.push(defaultMembership());
            setData(data);
            render();
        });

        container.addEventListener('click', (event) => {
            const target = event.target.closest('button');
            if (!target) return;

            const role = target.getAttribute('data-role');
            const mIndex = Number(target.getAttribute('data-index'));
            const dIndex = Number(target.getAttribute('data-dindex'));
            const data = getData();

            if (role === 'remove-membership') {
                data.splice(mIndex, 1);
                setData(data.length ? data : [defaultMembership()]);
                render();
                return;
            }

            if (role === 'add-duration') {
                data[mIndex].durations.push({ title: i18n.newDuration || 'New Duration', price: '' });
                setData(data);
                render();
                return;
            }

            if (role === 'remove-duration') {
                data[mIndex].durations.splice(dIndex, 1);
                if (!data[mIndex].durations.length) {
                    data[mIndex].durations.push({ title: i18n.newDuration || 'New Duration', price: '' });
                }
                setData(data);
                render();
            }
        });

        container.addEventListener('input', (event) => {
            const target = event.target;
            const role = target.getAttribute('data-role');
            if (!role) return;

            const mIndex = Number(target.getAttribute('data-index'));
            const dIndex = Number(target.getAttribute('data-dindex'));
            const data = getData();

            if (role === 'membership-title') {
                data[mIndex].title = target.value;
            }
            if (role === 'duration-title') {
                data[mIndex].durations[dIndex].title = target.value;
            }
            if (role === 'duration-price') {
                const cleaned = sanitizePrice(target.value);
                data[mIndex].durations[dIndex].price = cleaned;
                    const displayNode = target.parentElement?.querySelector('[data-role="price-display"]');
                    if (displayNode) {
                        const formatted = formatPrice(cleaned);
                        displayNode.textContent = formatted ? `≈ ${currency.label} ${formatted}` : '';
                    }
            }

            setData(data);
        });

        render();
    })();

    (function() {
        const container = document.getElementById('price-visit-builder');
        const addBtn = document.getElementById('add-visit-btn');
        const hiddenInput = document.getElementById('price_visit');

        if (!container || !addBtn || !hiddenInput) {
            return;
        }

        const currency = window.gymCurrency || { label: 'Rp', code: 'IDR', rate: 1, baseLabel: 'Rp' };
        const i18n = window.settingsI18n || {};
        const baseLabelText = (i18n.priceBaseLabel || 'Price (Base :currency)').replace(':currency', currency.baseLabel);
        const pricePlaceholderText = (i18n.pricePlaceholder || ':currency 0').replace(':currency', currency.baseLabel);
        const numberFormat = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: currency.code === 'IDR' ? 0 : 2,
            maximumFractionDigits: currency.code === 'IDR' ? 0 : 2
        });
        const sanitizePrice = (value) => String(value ?? '').replace(/[^0-9.]/g, '');
        const formatPrice = (value) => {
            const cleaned = sanitizePrice(value);
            if (!cleaned) return '';
            const num = Number(cleaned);
            if (Number.isNaN(num)) return '';
            const converted = currency.rate ? (num / currency.rate) : num;
            return numberFormat.format(converted);
        };

        let existing = [];
        if (hiddenInput.value) {
            try {
                existing = JSON.parse(hiddenInput.value);
            } catch (err) {
                existing = [];
            }
        }

        const defaultItem = () => ({ title: i18n.newCategory || 'New Category', price: '' });

        const render = () => {
            container.innerHTML = '';
            const data = getData();

            data.forEach((item, index) => {
                const col = document.createElement('div');
                col.className = 'col-xl-4 col-md-6';
                const display = formatPrice(item.price);
                col.innerHTML = `
                    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <input type="text" class="form-control fw-bold" value="${escapeHtml(item.title)}"
                                    data-role="visit-title" data-index="${index}">
                                <button type="button" class="btn btn-outline-danger btn-sm ms-2" data-role="visit-remove" data-index="${index}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <label class="form-label fw-bold mb-2">${baseLabelText}</label>
                            <input type="text" class="form-control" placeholder="${pricePlaceholderText}"
                                value="${escapeHtml(item.price)}" data-role="visit-price" data-index="${index}">
                            <small class="text-muted d-block mt-1" data-role="visit-display">
                                ${display ? `≈ ${currency.label} ${display}` : ''}
                            </small>
                        </div>
                    </div>
                `;
                container.appendChild(col);
            });

            syncHidden();
        };

        const getData = () => {
            if (!container.dataset.state) {
                container.dataset.state = JSON.stringify(existing.length ? existing : [defaultItem()]);
            }
            return JSON.parse(container.dataset.state);
        };

        const setData = (data) => {
            container.dataset.state = JSON.stringify(data);
            syncHidden();
        };

        const syncHidden = () => {
            hiddenInput.value = container.dataset.state || '';
        };

        const escapeHtml = (value) => {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        };

        addBtn.addEventListener('click', () => {
            const data = getData();
            data.push(defaultItem());
            setData(data);
            render();
        });

        container.addEventListener('click', (event) => {
            const target = event.target.closest('button');
            if (!target) return;
            if (target.getAttribute('data-role') !== 'visit-remove') return;

            const index = Number(target.getAttribute('data-index'));
            const data = getData();
            data.splice(index, 1);
            setData(data.length ? data : [defaultItem()]);
            render();
        });

        container.addEventListener('input', (event) => {
            const target = event.target;
            const role = target.getAttribute('data-role');
            if (!role) return;

            const index = Number(target.getAttribute('data-index'));
            const data = getData();

            if (role === 'visit-title') {
                data[index].title = target.value;
            }
            if (role === 'visit-price') {
                const cleaned = sanitizePrice(target.value);
                data[index].price = cleaned;
                const displayNode = target.parentElement?.querySelector('[data-role="visit-display"]');
                if (displayNode) {
                    const formatted = formatPrice(cleaned);
                    displayNode.textContent = formatted ? `≈ ${currency.label} ${formatted}` : '';
                }
            }

            setData(data);
        });

        render();
    })();

    (function() {
        const tabs = document.querySelectorAll('.settings-tabs a[href^="#"]');
        if (!tabs.length) {
            return;
        }
        const setActive = (targetId) => {
            tabs.forEach((tab) => {
                const isActive = tab.getAttribute('href') === targetId;
                tab.classList.toggle('active', isActive);
            });
        };

        if (window.location.hash) {
            setActive(window.location.hash);
        } else {
            setActive(tabs[0].getAttribute('href'));
        }

        tabs.forEach((tab) => {
            tab.addEventListener('click', (event) => {
                const targetId = tab.getAttribute('href');
                const target = document.querySelector(targetId);
                if (!target) {
                    return;
                }
                event.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                history.replaceState(null, '', targetId);
                setActive(targetId);
            });
        });
    })();
</script>
@endsection
