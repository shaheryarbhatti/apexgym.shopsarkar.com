<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from admin.pixelstrap.net/zono/template/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 04 Aug 2025 09:06:17 GMT -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('manage_members') }}</title>

    @extends('layouts.app')
    @section('content')
@php
        $cardBg = \App\Models\Setting::get('card_bg_color', '#0b1d2c');
        $cardTextColor = \App\Models\Setting::get('card_text_color', '#ffffff');
        $cardTitle = \App\Models\Setting::get('card_title', 'Membership Card');
        $logoSource = \App\Models\Setting::get('card_logo_source', 'login');
        $cardLogoPath = $logoSource === 'admin'
            ? \App\Models\Setting::get('admin_logo', 'public/assets/images/logo/logo_dark.png')
            : \App\Models\Setting::get('login_logo', 'public/assets/images/logo/logo.png');
        $cardLogoUrl = asset('public/' . $cardLogoPath);
        $user = auth()->user();
        $legacyMemberBase = 'manage-' . \Illuminate\Support\Str::singular('members');
        $canMemberAdd = $user && $user->canAny(['members.add', $legacyMemberBase . '.add']);
        $canMemberExport = $user && $user->canAny(['members.view', $legacyMemberBase . '.view', 'members.manage', $legacyMemberBase . '.manage']);
        $canMemberRenew = $user && $user->canAny(['members.renew', $legacyMemberBase . '.renew']);
        $canMemberTrainer = $user && $user->canAny(['members.add_trainer_invoice', $legacyMemberBase . '.add_trainer_invoice']);
        $canMemberVisit = $user && $user->canAny(['members.add_visit_invoice', $legacyMemberBase . '.add_visit_invoice']);
        $canMemberExpiry = $user && $user->canAny(['members.send_expiry_email', $legacyMemberBase . '.send_expiry_email']);
        $canMemberDownload = $user && $user->canAny(['members.download_card', $legacyMemberBase . '.download_card']);
    @endphp

    <div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('manage_members') }}</h4>
                        <div class="d-flex align-items-center gap-2">
                        @if($canMemberExport)
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#memberExportModal">
                                <i class="fa fa-download me-2"></i> {{ __('download_excel') }}
                            </button>
                        @endif
                        @if($canMemberAdd)
                            <a href="{{ route('members.add') }}" class="btn btn-primary">
                                <i class="fa fa-plus me-2"></i> {{ __('add_new_member') }}
                            </a>
                        @endif
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <div class="table-responsive custom-scrollbar mb-4">
                            <table id="membersTable" class="display table table-hover table-bordered" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('photo') }}</th>
                                        <th>{{ __('member_code') }}</th>
                                        <th>{{ __('full_name') }}</th>
                                        <th>{{ __('email') }}</th>
                                        <th>{{ __('phone') }}</th>
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

<div class="modal fade" id="memberProfileModal" tabindex="-1" aria-labelledby="memberProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberProfileModalLabel">{{ __('member_details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap justify-content-end gap-2 mb-4">
                    <!-- <button type="button" class="btn btn-primary">
                        <i class="fa fa-snowflake-o me-2"></i> {{ __('freeze_membership') }}
                    </button> -->
                    @if($canMemberRenew)
                        <a href="#" class="btn btn-primary" id="renewMembershipBtn">
                            <i class="fa fa-refresh me-2"></i> {{ __('renew_membership') }}
                        </a>
                    @endif
                    @if($canMemberTrainer)
                        <a href="#" class="btn btn-primary" id="addTrainerBtn">
                            <i class="fa fa-user-plus me-2"></i> {{ __('add_trainer') }}
                        </a>
                    @endif
                    @if($canMemberVisit)
                        <a href="#" class="btn btn-primary" id="visitInvoiceBtn">
                            <i class="fa fa-file-text-o me-2"></i> {{ __('invoice_per_visit') }}
                        </a>
                    @endif
                    @if($canMemberExpiry)
                        <button type="button" class="btn btn-primary" id="expiryEmailBtn">
                            <i class="fa fa-envelope me-2"></i> {{ __('send_expiry_email') }}
                        </button>
                    @endif
                    @if($canMemberDownload)
                        <button type="button" class="btn btn-primary" id="downloadCardBtn">
                            <i class="fa fa-download me-2"></i> {{ __('download_card') }}
                        </button>
                    @endif
                </div>

                <div class="row g-4 align-items-start">
                    <div class="col-lg-5">
                        <div class="d-flex flex-column align-items-center">
                            <div class="member-card-preview" style="background: {{ $cardBg }}; color: {{ $cardTextColor }};">
                                <img src="{{ $cardLogoUrl }}" alt="Logo" class="member-card-logo">
                                <div class="member-card-title" id="memberCardTitle">{{ $cardTitle }}</div>
                                <div class="member-card-name" id="memberCardName">-</div>
                                <div class="member-card-code" id="memberCardCode">-</div>
                                <div class="member-card-barcode" id="memberCardBarcode"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="member-detail-card">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="detail-label">{{ __('email') }}</div>
                                    <div class="detail-value" id="memberDetailEmail">-</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">{{ __('phone') }}</div>
                                    <div class="detail-value" id="memberDetailPhone">-</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">{{ __('nik') }}</div>
                                    <div class="detail-value" id="memberDetailNik">-</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">{{ __('date_of_birth') }}</div>
                                    <div class="detail-value" id="memberDetailDob">-</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">{{ __('gender') }}</div>
                                    <div class="detail-value" id="memberDetailGender">-</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">{{ __('blood_type') }}</div>
                                    <div class="detail-value" id="memberDetailBlood">-</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">{{ __('address') }}</div>
                                    <div class="detail-value" id="memberDetailAddress">-</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">{{ __('religion') }}</div>
                                    <div class="detail-value" id="memberDetailReligion">-</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">{{ __('marital_status') }}</div>
                                    <div class="detail-value" id="memberDetailMarital">-</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">{{ __('occupation') }}</div>
                                    <div class="detail-value" id="memberDetailOccupation">-</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">{{ __('citizenship') }}</div>
                                    <div class="detail-value" id="memberDetailCitizenship">-</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">{{ __('registration_date') }}</div>
                                    <div class="detail-value" id="memberDetailCreated">-</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">{{ __('last_update') }}</div>
                                    <div class="detail-value" id="memberDetailUpdated">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="memberExportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('export_members') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="GET" action="{{ route('members.export') }}">
                <div class="modal-body">
                    <p class="text-muted mb-3">{{ __('select_columns_export') }}</p>
                    <div class="row g-3">
                        @php
                            $exportColumns = [
                                'member_code' => __('member_code'),
                                'full_name' => __('full_name'),
                                'email' => __('email'),
                                'phone' => __('phone'),
                                'status' => __('status'),
                                'gender' => __('gender'),
                                'nik' => __('nik'),
                                'place_of_birth' => __('place_of_birth'),
                                'date_of_birth' => __('date_of_birth'),
                                'blood_type' => __('blood_type'),
                                'religion' => __('religion'),
                                'marital_status' => __('marital_status'),
                                'occupation' => __('occupation'),
                                'citizenship' => __('citizenship'),
                                'address' => __('address'),
                                'created_at' => __('registration_date'),
                                'updated_at' => __('last_update'),
                            ];
                            $defaultCols = ['member_code', 'full_name', 'email', 'phone', 'status'];
                        @endphp
                        @foreach($exportColumns as $key => $label)
                            <div class="col-md-4">
                                <label class="form-check d-flex align-items-center gap-2">
                                    <input class="form-check-input" type="checkbox" name="columns[]" value="{{ $key }}"
                                           {{ in_array($key, $defaultCols, true) ? 'checked' : '' }}>
                                    <span>{{ $label }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('download_excel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="expiryEmailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('membership_expiry_email') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="expiryEmailForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('subject') }}</label>
                        <input type="text" name="subject" id="expiryEmailSubject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('body') }}</label>
                        <textarea name="body" id="expiryEmailBody" class="form-control" rows="6" required></textarea>
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
        $('#membersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('members.manage') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'photo',
                    name: 'photo',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'member_code',
                    name: 'member_code',
                    defaultContent: '-'
                },
                {
                    data: 'full_name',
                    name: 'full_name',
                    defaultContent: '-'
                },
                {
                    data: 'email',
                    name: 'email',
                    defaultContent: '-'
                },
                {
                    data: 'phone',
                    name: 'phone',
                    defaultContent: '-'
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
                [2, 'asc']
            ],
            language: {
                processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
            },
            responsive: true,
            dom: '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>tip',
            // dom option adds space between search/filter and table
        });
    });

    $(document).on('click', '.js-member-view', function() {
        const payload = this.dataset.member ? JSON.parse(this.dataset.member) : {};
        const renewBtn = document.getElementById('renewMembershipBtn');
        if (renewBtn && payload.id) {
            renewBtn.href = `{{ url('/members') }}/${payload.id}/renew-invoice`;
        }
        const addTrainerBtn = document.getElementById('addTrainerBtn');
        if (addTrainerBtn && payload.id) {
            addTrainerBtn.href = `{{ url('/members') }}/${payload.id}/trainer-invoice`;
        }
        const visitInvoiceBtn = document.getElementById('visitInvoiceBtn');
        if (visitInvoiceBtn && payload.id) {
            visitInvoiceBtn.href = `{{ url('/members') }}/${payload.id}/visit-invoice`;
        }
        const expiryEmailBtn = document.getElementById('expiryEmailBtn');
        if (expiryEmailBtn) {
            expiryEmailBtn.dataset.memberId = payload.id || '';
        }
        const downloadBtn = document.getElementById('downloadCardBtn');
        if (downloadBtn) {
            downloadBtn.dataset.memberCode = payload.member_code || 'member';
        }

        const setText = (id, value) => {
            const node = document.getElementById(id);
            if (!node) return;
            node.textContent = value && String(value).trim() ? value : '-';
        };

        const formatDob = (place, date) => {
            if (!place && !date) return '-';
            let formattedDate = date;
            if (date) {
                const parsed = new Date(date);
                if (!Number.isNaN(parsed.getTime())) {
                    formattedDate = parsed.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                }
            }
            if (place && formattedDate) return `${place}, ${formattedDate}`;
            return place || formattedDate || '-';
        };

        setText('memberCardName', payload.full_name);
        setText('memberCardCode', payload.member_code);
        const barcodeNode = document.getElementById('memberCardBarcode');
        if (barcodeNode) {
            let decoded = '';
            if (payload.barcode_html) {
                try {
                    decoded = atob(payload.barcode_html);
                } catch (e) {
                    decoded = '';
                }
            }
            barcodeNode.innerHTML = decoded;
        }

        setText('memberDetailEmail', payload.email);
        setText('memberDetailPhone', payload.phone);
        setText('memberDetailNik', payload.nik);
        setText('memberDetailGender', payload.gender);
        setText('memberDetailBlood', payload.blood_type);
        setText('memberDetailAddress', payload.address);
        setText('memberDetailReligion', payload.religion);
        setText('memberDetailMarital', payload.marital_status);
        setText('memberDetailOccupation', payload.occupation);
        setText('memberDetailCitizenship', payload.citizenship);
        setText('memberDetailCreated', payload.created_at);
        setText('memberDetailUpdated', payload.updated_at);
        setText('memberDetailDob', formatDob(payload.place_of_birth, payload.date_of_birth));

        const modalEl = document.getElementById('memberProfileModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    });

    const downloadCardBtn = document.getElementById('downloadCardBtn');
    if (downloadCardBtn) {
        downloadCardBtn.addEventListener('click', async () => {
            const card = document.querySelector('.member-card-preview');
            if (!card) return;

            const ensureHtml2Canvas = async () => {
                if (window.html2canvas) return true;
                const scriptId = 'html2canvas-script';
                if (!document.getElementById(scriptId)) {
                    const script = document.createElement('script');
                    script.id = scriptId;
                    script.src = "{{ asset('public/assets/js/vendors/html2canvas.min.js') }}";
                    script.async = true;
                    document.head.appendChild(script);
                    await new Promise((resolve) => {
                        script.onload = resolve;
                        script.onerror = resolve;
                    });
                }
                return !!window.html2canvas;
            };

            const ready = await ensureHtml2Canvas();
            if (!ready) return;

            const canvas = await window.html2canvas(card, {
                backgroundColor: null,
                scale: 2
            });
            const link = document.createElement('a');
            const code = downloadCardBtn.dataset.memberCode || 'member';
            link.download = `${code}_card.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
        });
    }

    const expiryEmailBtn = document.getElementById('expiryEmailBtn');
    if (expiryEmailBtn) {
        expiryEmailBtn.addEventListener('click', async () => {
            const memberId = expiryEmailBtn.dataset.memberId;
            if (!memberId) return;

            const subjectInput = document.getElementById('expiryEmailSubject');
            const bodyInput = document.getElementById('expiryEmailBody');
            const form = document.getElementById('expiryEmailForm');

            if (form) {
                form.action = `{{ url('/members') }}/${memberId}/expiry-email`;
            }

            try {
                const response = await fetch(`{{ url('/members') }}/${memberId}/expiry-email`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                if (subjectInput) subjectInput.value = data.subject || '';
                if (bodyInput) bodyInput.value = data.body || '';
            } catch (e) {
                if (subjectInput) subjectInput.value = '';
                if (bodyInput) bodyInput.value = '';
            }

            const modalEl = document.getElementById('expiryEmailModal');
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        });
    }
    </script>
    @endpush
