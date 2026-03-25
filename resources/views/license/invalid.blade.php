@extends('layouts.app')

@section('content')
@php
    $clientName = \App\Models\Setting::get('license_client_name');
    $serverUrl = \App\Models\Setting::get('license_server_url');
    $licenseKey = \App\Models\Setting::get('license_key');
    $projectKey = \App\Models\Setting::get('license_project_key');

    $message = session('license_error') ?: __('license_invalid');
@endphp
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header pb-0">
                        <h4>{{ __('license_required') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('license_debug'))
                            <div class="alert alert-warning">
                                <strong>Debug:</strong> {{ session('license_debug') }}
                            </div>
                        @endif
                        <p class="text-muted mb-3">{{ __('license_fix_hint') }}</p>
                        <form method="POST" action="{{ route('license.update') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">{{ __('license_client_name') }}</label>
                                    <input type="text" name="license_client_name" class="form-control"
                                           value="{{ $clientName }}" placeholder="Sky Fitness Gym">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">{{ __('license_server_url') }}</label>
                                    <input type="text" name="license_server_url" class="form-control"
                                           value="{{ $serverUrl }}" placeholder="https://license.example.com">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">{{ __('license_key') }}</label>
                                    <input type="text" name="license_key" class="form-control"
                                           value="{{ $licenseKey }}" placeholder="LIC-XXXX-XXXX-XXXX">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">{{ __('license_project_key') }}</label>
                                    <input type="text" name="license_project_key" class="form-control"
                                           value="{{ $projectKey }}" placeholder="PRJ-XXXX-XXXX">
                                </div>

                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('update_license_settings') }}
                                </button>
                            </div>
                        </form>
                        <!-- <div class="mt-4 d-flex flex-wrap gap-2">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                {{ __('back_to_dashboard') }}
                            </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
