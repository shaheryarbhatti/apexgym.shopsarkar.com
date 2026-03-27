<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('attendance_logs') }}</title>

@extends('layouts.app')
@section('content')
<style>
.flatpickr-day.selected {
    background: var(--theme-default, #7367f0) !important;
    border-color: var(--theme-default, #7367f0) !important;
}
</style>
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('attendance_logs') }}</h4>
                    </div>

                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                                    <input type="text" id="attendanceSearch" class="form-control" placeholder="{{ __('search_for_attendance') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="date" id="attendanceStartDate" class="form-control" placeholder="{{ __('start_date') }}">
                            </div>
                            <div class="col-md-4">
                                <input type="date" id="attendanceEndDate" class="form-control" placeholder="{{ __('end_date') }}">
                            </div>
                        </div>
                        <div class="table-responsive custom-scrollbar mb-4">
                            <table id="attendanceTable" class="display table table-hover table-bordered"
                                style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('member') }}</th>
                                        <th>{{ __('date') }}</th> {{-- This uses attendance_date --}}
                                        <th>{{ __('check_in') }}</th>
                                        <th>{{ __('check_out') }}</th>
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
    justify-content: center;
    gap: 0.2rem;
    padding: 0.25rem 0;
}

/* Each page item/button */
.dataTables_paginate .page-item .page-link {
    border-radius: 8px !important;
    width: 30px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    padding: 0;
    margin: 0 1px;
    border: 1px solid #e2e6ea;
    color: #5a6470;
    background-color: #fff;
    transition: all 0.15s ease;
    font-weight: 600;
    font-size: 0.85rem;
}

/* Hover effect (like template subtle hover) */
.dataTables_paginate .page-item .page-link:hover {
    background-color: var(--theme-default, #7367f0) !important;
    color: white !important;
    border-color: var(--theme-default, #7367f0) !important;
}

/* Active / current page (blue background, white text) */
.dataTables_paginate .page-item.active .page-link {
    background-color: var(--theme-default, #7367f0) !important;
    border-color: var(--theme-default, #7367f0) !important;
    color: white !important;
    box-shadow: 0 3px 10px rgba(115, 103, 240, 0.25);
    font-weight: 700;
}

/* Disabled buttons (Previous/Next when at end) */
.dataTables_paginate .page-item.disabled .page-link {
    color: #b7c0c8 !important;
    background-color: #f6f7f9 !important;
    border-color: #e2e6ea !important;
    cursor: not-allowed;
}

/* First/Last/Previous/Next text buttons */
.dataTables_paginate .page-item:first-child .page-link,
.dataTables_paginate .page-item:last-child .page-link {
    border-radius: 10px !important;
    width: auto;
    padding: 0 0.6rem;
    min-width: 44px;
    font-size: 0.8rem;
}

/* Extra spacing below search bar & above table */
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 2.5rem !important;
}

.dataTables_wrapper .dataTables_paginate {
    margin-top: 1rem !important;
}

/* Mobile adjustments */
@media (max-width: 576px) {
    .dataTables_paginate .page-link {
        width: 28px;
        height: 28px;
        line-height: 28px;
        font-size: 0.8rem;
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
    var table = $('#attendanceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("attendance.manage") }}',
            data: function(d) {
                d.start_date = $('#attendanceStartDate').val();
                d.end_date = $('#attendanceEndDate').val();
            }
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'member_name',
                name: 'user.name'
            },
            {
                data: 'attendance_date',
                name: 'created_at'
            }, // Data mapped from created_at
            {
                data: 'check_in',
                name: 'checkin_time'
            },
            {
                data: 'check_out',
                name: 'checkout_time'
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

    $('#attendanceSearch').on('keyup', function () {
        table.search(this.value).draw();
    });

    $('#attendanceStartDate, #attendanceEndDate').on('change', function () {
        table.ajax.reload();
    });
});
</script>
@endpush

