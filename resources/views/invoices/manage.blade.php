<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('manage_invoices') }}</title>

    @extends('layouts.app')
    @section('content')

    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __('manage_invoices') }}</h4>
                        </div>

                        <div class="card-body">
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

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                                        <input type="text" id="invoiceSearch" class="form-control" placeholder="{{ __('search_for_invoice') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select id="invoiceTypeFilter" class="form-select">
                                        <option value="renew">{{ __('renew_invoice') }}</option>
                                        <option value="trainer">{{ __('trainer_invoice') }}</option>
                                        <option value="visit">{{ __('invoice_per_visit') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select id="invoiceStatusFilter" class="form-select">
                                        <option value="">{{ __('all_status') }}</option>
                                        <option value="final">{{ __('final') }}</option>
                                        <option value="draft">{{ __('draft') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" id="invoiceStartDate" class="form-control" placeholder="{{ __('start_date') }}">
                                </div>
                                <div class="col-md-4">
                                    <input type="date" id="invoiceEndDate" class="form-control" placeholder="{{ __('end_date') }}">
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-lg-4">
                                    <div class="summary-card summary-total">
                                        <div class="summary-title">{{ __('total_value_invoices') }}</div>
                                        <div class="summary-value" id="summaryTotal">-</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="summary-card summary-final">
                                        <div class="summary-header">
                                            <div class="summary-title">{{ __('finalized') }}</div>
                                            <span class="summary-chip" id="summaryFinalCount">0 {{ __('invoice') }}</span>
                                        </div>
                                        <div class="summary-value" id="summaryFinal">-</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="summary-card summary-draft">
                                        <div class="summary-header">
                                            <div class="summary-title">{{ __('draft') }}</div>
                                            <span class="summary-chip" id="summaryDraftCount">0 {{ __('invoice') }}</span>
                                        </div>
                                        <div class="summary-value" id="summaryDraft">-</div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive custom-scrollbar mb-4">
                                <table id="invoicesTable" class="display table table-hover table-bordered"
                                    style="width:100%">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('invoice_no') }}</th>
                                            <th>{{ __('item') }}</th>
                                            <th>{{ __('start_date') }}</th>
                                            <th>{{ __('total') }}</th>
                                            <th>{{ __('expiry_date') }}</th>
                                            <th>{{ __('status') }}</th>
                                            <th>{{ __('action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <div class="modal fade" id="invoicePreviewModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('invoice_preview') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body" id="invoicePreviewBody">
                                            <div class="text-center text-muted py-4">{{ __('loading') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="invoiceEmailModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('send_cancellation_email') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" id="invoiceEmailForm" action="{{ route('invoices.email.send') }}">
                                            @csrf
                                            <input type="hidden" name="type" id="invoiceEmailType">
                                            <input type="hidden" name="id" id="invoiceEmailId">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ __('subject') }}</label>
                                                    <input type="text" name="subject" id="invoiceEmailSubject" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ __('body') }}</label>
                                                    <textarea name="body" id="invoiceEmailBody" class="form-control" rows="6" required></textarea>
                                                </div>
                                                <div class="alert alert-light border">
                                                    <strong>{{ __('available_placeholders') }}</strong>
                                                    <div class="mt-2 text-muted">
                                                        {name}, {email}, {brand_name}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ __('send_email') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('styles')
    <style>
    .summary-card {
        border-radius: 16px;
        padding: 18px 20px;
        border: 1px solid #e7ecf3;
        background: #fff;
        box-shadow: 0 10px 24px rgba(18, 38, 63, 0.08);
    }
    .summary-total {
        border-color: rgba(59, 130, 246, 0.35);
        background: rgba(59, 130, 246, 0.08);
    }
    .summary-final {
        border-color: rgba(34, 197, 94, 0.35);
        background: rgba(34, 197, 94, 0.08);
    }
    .summary-draft {
        border-color: rgba(245, 158, 11, 0.35);
        background: rgba(245, 158, 11, 0.08);
    }
    .summary-title {
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 6px;
    }
    .summary-value {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1f2937;
    }
    .summary-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .summary-chip {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.8rem;
        color: #4b5563;
    }
    .invoice-status {
        min-width: 90px;
        width: 90px;
    }
    .invoice-preview {
        border: 1px dashed #cfd6e4;
        border-radius: 14px;
        padding: 24px;
        background: #fff;
        box-shadow: 0 10px 24px rgba(18, 38, 63, 0.08);
    }

    .invoice-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .invoice-row span:last-child {
        font-weight: 600;
    }

    .invoice-row.total {
        font-size: 1.05rem;
        font-weight: 700;
    }

    .invoice-footer {
        text-align: center;
        font-size: 0.9rem;
        color: #4b5563;
        white-space: pre-line;
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
    <script>
    $(document).ready(function() {
        const table = $('#invoicesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("invoices.manage") }}',
                data: function (d) {
                    d.invoice_type = $('#invoiceTypeFilter').val();
                    d.status = $('#invoiceStatusFilter').val();
                    d.start_date = $('#invoiceStartDate').val();
                    d.end_date = $('#invoiceEndDate').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'invoice_no',
                    name: 'invoice_no',
                    orderable: true
                },
                {
                    data: 'item',
                    name: 'item',
                    orderable: false
                },
                {
                    data: 'start_date',
                    name: 'start_date',
                    orderable: false
                },
                {
                    data: 'total_display',
                    name: 'total',
                    orderable: true
                },
                {
                    data: 'expiry',
                    name: 'expiry',
                    orderable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false
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
            dom: '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6">>tip',
        });

        $('#invoiceSearch').on('keyup', function () {
            table.search(this.value).draw();
        });

        $('#invoiceTypeFilter').on('change', function () {
            table.ajax.reload();
        });

        $('#invoiceStatusFilter').on('change', function () {
            table.ajax.reload();
        });

        $('#invoiceStartDate, #invoiceEndDate').on('change', function () {
            table.ajax.reload();
        });

        const updateSummary = (payload) => {
            if (!payload) return;
            $('#summaryTotal').text(payload.summary_total || '-');
            $('#summaryFinal').text(payload.summary_final || '-');
            $('#summaryDraft').text(payload.summary_draft || '-');
            $('#summaryFinalCount').text(`${payload.summary_final_count || 0} {{ __('invoice') }}`);
            $('#summaryDraftCount').text(`${payload.summary_draft_count || 0} {{ __('invoice') }}`);
        };

        table.on('xhr', function () {
            const json = table.ajax.json();
            if (json) {
                updateSummary({
                    summary_total: json.summary_total,
                    summary_final: json.summary_final,
                    summary_draft: json.summary_draft,
                    summary_final_count: json.summary_final_count,
                    summary_draft_count: json.summary_draft_count,
                });
            }
        });

        $('#invoicesTable').on('change', '.invoice-status', function () {
            const id = $(this).data('id');
            const type = $(this).data('type');
            const status = $(this).val();

            $.ajax({
                url: '{{ route("invoices.status.update") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id,
                    type,
                    status
                }
            });
        });

        $('#invoicesTable').on('click', '.js-invoice-view', function () {
            const id = $(this).data('id');
            const type = $(this).data('type');
            const modal = new bootstrap.Modal(document.getElementById('invoicePreviewModal'));
            const body = document.getElementById('invoicePreviewBody');
            if (body) {
                body.innerHTML = '<div class="text-center text-muted py-4">{{ __("loading") }}</div>';
            }

            $.get('{{ route("invoices.preview") }}', { id, type }, function (response) {
                if (body) {
                    body.innerHTML = response;
                }
                modal.show();
            }).fail(function () {
                if (body) {
                    body.innerHTML = '<div class="text-center text-danger py-4">Failed to load invoice.</div>';
                }
                modal.show();
            });
        });

        $('#invoicesTable').on('click', '.js-invoice-email', function () {
            const id = $(this).data('id');
            const type = $(this).data('type');
            const subjectInput = document.getElementById('invoiceEmailSubject');
            const bodyInput = document.getElementById('invoiceEmailBody');
            const typeInput = document.getElementById('invoiceEmailType');
            const idInput = document.getElementById('invoiceEmailId');

            if (typeInput) typeInput.value = type;
            if (idInput) idInput.value = id;

            if (subjectInput) subjectInput.value = '';
            if (bodyInput) bodyInput.value = '';

            $.get('{{ route("invoices.email.template") }}', { id, type }, function (response) {
                if (subjectInput) subjectInput.value = response.subject || '';
                if (bodyInput) bodyInput.value = response.body || '';
                const modal = new bootstrap.Modal(document.getElementById('invoiceEmailModal'));
                modal.show();
            }).fail(function () {
                const modal = new bootstrap.Modal(document.getElementById('invoiceEmailModal'));
                modal.show();
            });
        });
    });
    </script>
    @endpush
