<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ __('add_new_invoice') }}</title>

    @extends('layouts.app')
    @section('content')

    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __('add_new_invoice') }}</h4>
                            <a href="{{ route('invoices.manage') }}" class="btn btn-outline-secondary btn-sm">
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

                            <form method="POST" action="{{ route('invoices.store') }}" class="theme-form">
                                @csrf

                                <div class="row g-4">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">

                                        <div class="mb-3">

                                            <label class="col-form-label" for="fee">{{ __('fee') }} (RP) <span
                                                    class="text-danger">*</span></label>
                                                    <small class="text-muted">Fee amount in Indonesian Rupiah (RP)</small>
                                            <input type="number" step="0.01" name="fee" id="fee"
                                                class="form-control @error('fee') is-invalid @enderror"
                                                value="{{ old('fee') }}" placeholder="0.00" required autofocus>
                                            @error('fee')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>

                                        <div class="mb-3">
                                            <label class="box-col-12 text-start">{{ __('start_date') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xxl-9 box-col-12">
                                                <div class="input-group flatpicker-calender">
                                                    <input
                                                        class="form-control @error('start_date') is-invalid @enderror"
                                                        name="start_date" placeholder="{{ __('start_date') }}"
                                                        type="date" value="{{ old('start_date') }}" required>
                                                    @error('start_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">

                                    <div class="mb-3">
                                            <label class="col-form-label" for="member_id">{{ __('select_member') }}
                                                <span class="text-danger">*</span></label>
                                            <select name="member_id" id="member_id"
                                                class="form-select @error('member_id') is-invalid @enderror" required>
                                                <option value="">Select</option>
                                                @foreach($members as $member)
                                                <option value="{{ $member->id }}"
                                                    {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                                    {{ $member->full_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('member_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="box-col-12 text-start">{{ __('end_date') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xxl-9 box-col-12">
                                                <div class="input-group flatpicker-calender">
                                                    <input class="form-control @error('end_date') is-invalid @enderror"
                                                        name="end_date" placeholder="{{ __('end_date') }}" type="date"
                                                        value="{{ old('end_date') }}" required>
                                                    @error('end_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-12 text-end mt-4">
                                        <button type="submit" class="btn btn-primary px-5 py-2">
                                            <i class="fa fa-save me-2"></i> {{ __('save_invoice') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum date for start_date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('start_date').setAttribute('min', today);

        // Set minimum date for end_date based on start_date
        document.getElementById('start_date').addEventListener('change', function() {
            const startDate = this.value;
            document.getElementById('end_date').setAttribute('min', startDate);
        });

        // Currency conversion preview (optional enhancement)
        const feeInput = document.getElementById('fee');
        const currencySelect = document.getElementById('currency_id');

        function updateFeePreview() {
            const fee = parseFloat(feeInput.value) || 0;
            const currencyId = currencySelect.value;

            if (fee > 0 && currencyId) {
                // This would require AJAX call to get conversion rate
                // For now, just show the base amount
                console.log('Fee in RP:', fee);
            }
        }

        feeInput.addEventListener('input', updateFeePreview);
        currencySelect.addEventListener('change', updateFeePreview);
    });
    </script>
    @endpush

