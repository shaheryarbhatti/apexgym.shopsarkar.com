<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ __('edit_currency') }}</title>

    @extends('layouts.app')
    @section('content')
    @php
        $baseCurrencyCode = \App\Models\Setting::get('base_currency_code', 'IDR');
    @endphp

    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __('edit_currency') }}</h4>
                            <a href="{{ route('currencies.manage') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-arrow-left me-2"></i> {{ __('back_to_list') }}
                            </a>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Whoops!</strong> There were some problems with your input.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <form method="POST" action="{{ route('currencies.update', $currency->id) }}"
                                class="theme-form">
                                @csrf
                                @method('PUT')

                                <div class="row g-4">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">

                                        <div class="mb-3">
                                            <label class="col-form-label" for="name">{{ __('currency_name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name', $currency->name) }}" placeholder="e.g., US Dollar"
                                                required autofocus>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label" for="code">{{ __('currency_code') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="code" id="code"
                                                class="form-control @error('code') is-invalid @enderror"
                                                value="{{ old('code', $currency->code) }}" placeholder="e.g., USD"
                                                maxlength="3" required>
                                            @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">

                                        <div class="mb-3">
                                            <label class="col-form-label" for="symbol">{{ __('currency_symbol') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="symbol" id="symbol"
                                                class="form-control @error('symbol') is-invalid @enderror"
                                                value="{{ old('symbol', $currency->symbol) }}" placeholder="e.g., $"
                                                required>
                                            @error('symbol')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label" for="exchange_rate">{{ __('exchange_rate') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="number" step="0.000001" name="exchange_rate" id="exchange_rate"
                                                class="form-control @error('exchange_rate') is-invalid @enderror"
                                                value="{{ old('exchange_rate', $currency->exchange_rate) }}"
                                                placeholder="e.g., 15000.000000 ({{ $baseCurrencyCode }} per 1 unit)"
                                                required>
                                            @error('exchange_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">

                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_active"
                                                    value="1" id="is_active"
                                                    {{ old('is_active', $currency->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    {{ __('set_as_active_currency') }}
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary px-5">
                                        <i class="fa fa-refresh me-2"></i> {{ __('update_currency') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection

