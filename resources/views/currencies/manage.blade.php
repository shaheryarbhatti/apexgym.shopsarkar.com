<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('manage_currencies') }}</title>

    @extends('layouts.app')
    @section('content')
    @php
        $user = auth()->user();
        $legacyCurrencyBase = 'manage-' . \Illuminate\Support\Str::singular('currencies');
        $canCurrencyAdd = $user && $user->canAny(['currencies.add', $legacyCurrencyBase . '.add']);
    @endphp

    <div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('manage_currencies') }}</h4>
                        @if($canCurrencyAdd)
                            <a href="{{ route('currencies.add') }}" class="btn btn-primary">
                                <i class="fa fa-plus me-2"></i> {{ __('add_new_currency') }}
                            </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="border rounded-3 p-3 mb-4 bg-light">
                            <form method="POST" action="{{ route('currencies.setBase') }}" class="row g-3 align-items-center">
                                @csrf
                                <div class="col-md-4">
                                    <label class="form-label fw-bold mb-1 text-dark d-block">Base Currency</label>
                                    <small class="text-dark d-block mt-1 mb-2">Exchange rates are recalculated relative to this base.</small>
                                    <select name="base_currency_id" class="form-select text-dark" required>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}" {{ $currency->code === $baseCurrencyCode ? 'selected' : '' }}>
                                                {{ $currency->name }} ({{ $currency->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold mb-1 text-dark">Current Base</label>
                                    <small class="text-dark d-block mt-1 mb-2">Currency Code.</small>
                                    <input type="text" class="form-control" value="{{ $baseCurrencyCode }}" readonly>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <button type="submit" class="btn btn-outline-primary mt-2 mt-md-4">
                                        <i class="fa fa-refresh me-2"></i> Set Base Currency
                                    </button>
                                </div>
                            </form>
                        </div>

                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <div class="table-responsive custom-scrollbar mb-4">
                            <table id="currenciesTable" class="display table table-hover table-bordered" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('name') }}</th>
                                        <th>{{ __('code') }}</th>
                                        <th>{{ __('symbol') }}</th>
                                        <th>{{ __('exchange_rate') }}</th>
                                        <th>{{ __('status') }}</th>
                                        <th>{{ __('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    @endsection

    @push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
    /* Force spacing between filter/search and table */

    div.dataTables_wrapper div.dataTables_filter {
        position: absolute;
        right: 53px;
        top: 0px;
    }

    /* Base pagination container */
    .dataTables_paginate .pagination {
        margin: 0 auto !important;
        /* Center it */
        justify-content: center;
        gap: 0.25rem;
        /* Space between buttons */
        padding: 0.5rem 0;
    }

    /* Each page item/button */
    .dataTables_paginate .page-item .page-link {
        border-radius: 50% !important;
        /* Fully rounded like template demo */
        width: 38px;
        height: 38px;
        line-height: 38px;
        text-align: center;
        padding: 0;
        margin: 0 2px;
        border: 1px solid #dee2e6;
        color: #495057;
        background-color: #fff;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    /* Hover effect (like template subtle hover) */
    .dataTables_paginate .page-item .page-link:hover {
        background-color: var(--theme-default, #7367f0) !important;
        color: white !important;
        border-color: var(--theme-default, #7367f0) !important;
        transform: scale(1.08);
    }

    /* Active / current page (blue background, white text) */
    .dataTables_paginate .page-item.active .page-link {
        background-color: var(--theme-default, #7367f0) !important;
        border-color: var(--theme-default, #7367f0) !important;
        color: white !important;
        box-shadow: 0 2px 6px rgba(115, 103, 240, 0.3);
        /* subtle shadow like premium templates */
        font-weight: bold;
    }

    /* Disabled buttons (Previous/Next when at end) */
    .dataTables_paginate .page-item.disabled .page-link {
        color: #adb5bd !important;
        background-color: #f8f9fa !important;
        border-color: #dee2e6 !important;
        cursor: not-allowed;
    }

    /* First/Last/Previous/Next text buttons */
    .dataTables_paginate .page-item:first-child .page-link,
    .dataTables_paginate .page-item:last-child .page-link {
        border-radius: 0.375rem !important;
        /* Less round for arrows */
        width: auto;
        padding: 0 1rem;
    }

    /* Extra spacing below search bar & above table */
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 2.5rem !important;
    }

    .dataTables_wrapper .dataTables_paginate {
        margin-top: 1.5rem !important;
    }

    /* Mobile adjustments */
    @media (max-width: 576px) {
        .dataTables_paginate .page-link {
            width: 32px;
            height: 32px;
            line-height: 32px;
            font-size: 0.875rem;
        }
    }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#currenciesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('currencies.manage') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'symbol',
                    name: 'symbol'
                },
                {
                    data: 'exchange_rate',
                    name: 'exchange_rate'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [
                [1, 'asc']
            ],
            language: {
                processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
            },
            responsive: true,
            dom: '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>tip',
        });
    });
    </script>
    @endpush
