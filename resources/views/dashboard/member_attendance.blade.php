<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ __('Member Attendance') }}</title>

    @extends('layouts.app')
    @section('content')
    <style>
    .attendance-card {
        border-radius: 16px;
        box-shadow: 0 12px 28px rgba(18, 38, 63, 0.08);
    }

    .badge-soft {
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1.5rem !important;
    }

    .dataTables_wrapper .dataTables_paginate {
        margin-top: 1.5rem !important;
    }
    </style>
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card attendance-card" style="margin-top: 20px;">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __('Your Attendance History') }}</h4>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-arrow-left me-2"></i> {{ __('Back to Dashboard') }}
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar mb-4">
                                <table id="memberAttendanceTable" class="display table table-hover table-bordered"
                                    style="width:100%">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Check In') }}</th>
                                            <th>{{ __('Check Out') }}</th>
                                            <th>{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
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

    .member-card-preview {
        width: 260px;
        min-height: 420px;
        border-radius: 18px;
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding: 24px 18px;
        box-shadow: 0 18px 36px rgba(12, 33, 51, 0.25);
    }

    .member-card-logo {
        max-height: 90px;
        width: auto;
        margin-bottom: 18px;
        object-fit: contain;
    }

    .member-card-title {
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 18px;
        text-align: center;
    }

    .member-card-name {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 4px;
        text-align: center;
    }

    .member-card-code {
        font-size: 0.9rem;
        opacity: 0.85;
        margin-bottom: 18px;
    }

    .member-card-barcode {
        background: #fff;
        padding: 8px;
        border-radius: 10px;
    }

    .member-detail-card {
        border: 1px solid #e9ecef;
        border-radius: 16px;
        padding: 20px;
        background: #fff;
        box-shadow: 0 10px 24px rgba(18, 38, 63, 0.08);
    }

    .detail-label {
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.06em;
        color: #8a93a6;
        margin-bottom: 2px;
    }

    .detail-value {
        font-weight: 600;
        color: #1f2a37;
    }

    /* Mobile adjustments */
    @media (max-width: 576px) {
        .dataTables_paginate .page-link {
            width: 32px;
            height: 32px;
            line-height: 32px;
            font-size: 0.875rem;
        }

        .member-card-preview {
            width: 100%;
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
        $('#memberAttendanceTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('member.attendance') }}',
            responsive: true,
            order: [
                [1, 'desc']
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'date',
                    name: 'attendance_date'
                },
                {
                    data: 'checkin',
                    name: 'checkin_time'
                },
                {
                    data: 'checkout',
                    name: 'checkout_time'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                }
            ],
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [
                [2, 'asc']
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
