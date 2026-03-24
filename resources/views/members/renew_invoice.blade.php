<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ __('renew_membership_invoice') }}</title>

    @extends('layouts.app')
    @section('content')

    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __('renew_membership_invoice') }}</h4>
                            <a href="{{ route('members.manage') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-arrow-left me-2"></i> {{ __('back_to_list') }}
                            </a>
                        </div>

                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Whoops!</strong> There were some problems with your input.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <div class="d-flex flex-wrap justify-content-end gap-2 mb-4">
                                <button type="submit" form="renewInvoiceForm" class="btn btn-primary">
                                    <i class="fa fa-save me-2"></i> {{ __('save_invoice') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="printInvoiceBtn">
                                    <i class="fa fa-print me-2"></i> {{ __('print_download_pdf') }}
                                </button>
                            </div>

                            <form method="POST" action="{{ route('members.renew-invoice.store', $member) }}" class="theme-form" id="renewInvoiceForm">
                                @csrf

                                <input type="hidden" name="invoice_no" value="{{ $invoiceNo }}">
                                <input type="hidden" name="membership_title" id="membership_title">
                                <input type="hidden" name="duration_title" id="duration_title">
                                <input type="hidden" name="duration_months" id="duration_months">
                                <input type="hidden" name="fee" id="fee">
                                <input type="hidden" name="discount_amount" id="discount_amount">
                                <input type="hidden" name="total" id="total">
                                <input type="hidden" name="invoice_header" id="invoice_header">

                                <div class="row g-4">
                                    <div class="col-lg-5">
                                        <div class="border rounded-4 p-4 bg-white shadow-sm">
                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('invoice_number') }}</label>
                                                <input type="text" class="form-control" value="{{ $invoiceNo }}" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('member_name') }}</label>
                                                <input type="text" class="form-control" value="{{ $member->full_name }}" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('member_code') }}</label>
                                                <input type="text" class="form-control" value="{{ $member->member_code }}" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('phone') }}</label>
                                                <input type="text" class="form-control" value="{{ $member->phone ?? '-' }}" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('membership_types') }}</label>
                                                <select name="membership_type_select" id="membership_type_select" class="form-select" required>
                                                    <option value="">{{ __('select_membership_type') }}</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('duration') }}</label>
                                                <select name="duration_select" id="duration_select" class="form-select" required>
                                                    <option value="">{{ __('select_duration') }}</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('start_date') }}</label>
                                                <input type="date" class="form-control" name="start_date" id="start_date" required>
                                                <small class="text-muted d-block mt-1">{{ __('start_date_note') }}</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('completion_date') }}</label>
                                                <input type="date" class="form-control" name="end_date" id="end_date" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('payment_methods') }}</label>
                                                <select name="payment_method" class="form-select">
                                                    <option value="">{{ __('select_payment_method') }}</option>
                                                    @foreach($paymentMethods as $method)
                                                        <option value="{{ $method->name }}">{{ $method->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('discount') }} (%)</label>
                                                <input type="number" class="form-control" name="discount_percent" id="discount_percent" value="0" min="0" max="100">
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('status') }}</label>
                                                <select name="status" id="invoice_status" class="form-select">
                                                    <option value="draft">Draft</option>
                                                    <option value="final">Final</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('invoice_header') }}</label>
                                                <input type="text" class="form-control" id="invoice_header_input" value="{{ old('invoice_header', $headerDefault) }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('invoice_footer') }}</label>
                                                <textarea name="invoice_footer" class="form-control" rows="3">{{ old('invoice_footer', $footerDefault) }}</textarea>
                                            </div>

                                            <div class="border-top pt-3 mt-3">
                                                <label class="col-form-label fw-bold">{{ __('add_payment_method') }}</label>
                                                <div class="d-flex gap-2">
                                                    <input type="text" class="form-control" name="payment_method_name" id="payment_method_name" placeholder="{{ __('payment_method_placeholder') }}">
                                                    <button type="button" class="btn btn-outline-primary" id="addPaymentMethodBtn">{{ __('add') }}</button>
                                                </div>
                                                <small class="text-muted d-block mt-2">{{ __('payment_method_note') }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-7">
                                        <div class="invoice-preview" id="invoicePreview">
                                            <div class="text-center mb-3">
                                                <h4 class="mb-1" id="previewHeader">{{ $headerDefault }}</h4>
                                                <small class="text-muted">{{ __('membership_invoice') }}</small>
                                            </div>

                                            <div class="invoice-row">
                                                <span>{{ __('invoice_number') }}</span>
                                                <span id="previewInvoiceNo">{{ $invoiceNo }}</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('date') }}</span>
                                                <span id="previewDate">{{ now()->format('m/d/Y') }}</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('member_name') }}</span>
                                                <span id="previewMemberName">{{ $member->full_name }}</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('member_code') }}</span>
                                                <span id="previewMemberCode">{{ $member->member_code }}</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('phone') }}</span>
                                                <span id="previewMemberPhone">{{ $member->phone ?? '-' }}</span>
                                            </div>

                                            <hr>

                                            <div class="invoice-row">
                                                <span>{{ __('membership_types') }}</span>
                                                <span id="previewMembership">-</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('duration') }}</span>
                                                <span id="previewDuration">-</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('start_date') }}</span>
                                                <span id="previewStartDate">-</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('completion_date') }}</span>
                                                <span id="previewEndDate">-</span>
                                            </div>

                                            <hr>

                                            <div class="invoice-row">
                                                <span>{{ __('status') }}</span>
                                                <span id="previewStatus">Draft</span>
                                            </div>

                                            <div class="invoice-row">
                                                <span>{{ __('payment_methods') }}</span>
                                                <span id="previewPaymentMethod">-</span>
                                            </div>

                                            <div class="invoice-row">
                                                <span>{{ __('membership_fee') }}</span>
                                                <span id="previewFee">-</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span id="previewDiscountLabel">0% {{ __('discount') }}</span>
                                                <span id="previewDiscountAmount">-</span>
                                            </div>
                                            <div class="invoice-row total">
                                                <span>{{ __('total') }}</span>
                                                <span id="previewTotal">-</span>
                                            </div>

                                            <div class="invoice-footer mt-4" id="previewFooter">
                                                {!! nl2br(e($footerDefault)) !!}
                                            </div>
                                        </div>
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

    @push('styles')
    <style>
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

    @media print {
        @page {
            size: A4;
            margin: 0;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: auto;
        }

        body * {
            visibility: hidden;
        }
        #invoicePreview, #invoicePreview * {
            visibility: visible;
        }
        #invoicePreview {
            position: relative;
            left: 0;
            top: 0;
            width: 100%;
            max-width: 720px;
            margin: 0 auto;
            padding: 24px;
            box-shadow: none;
            border: none;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        #invoicePreview {
            break-before: avoid-page;
            break-after: avoid-page;
            break-inside: avoid;
        }
    }
    </style>
    @endpush

    @push('scripts')
    <script>
    const pricingData = @json($membershipPricing);
    const baseLabel = @json($baseLabel);
    const activeLabel = @json($activeLabel ?? $baseLabel);
    const activeRate = Number(@json($activeRate ?? 1)) || 1;

    const membershipSelect = document.getElementById('membership_type_select');
    const durationSelect = document.getElementById('duration_select');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const discountInput = document.getElementById('discount_percent');

    const feeInput = document.getElementById('fee');
    const discountAmountInput = document.getElementById('discount_amount');
    const totalInput = document.getElementById('total');
    const membershipTitleInput = document.getElementById('membership_title');
    const durationTitleInput = document.getElementById('duration_title');
    const durationMonthsInput = document.getElementById('duration_months');

    const previewMembership = document.getElementById('previewMembership');
    const previewDuration = document.getElementById('previewDuration');
    const previewStartDate = document.getElementById('previewStartDate');
    const previewEndDate = document.getElementById('previewEndDate');
    const previewFee = document.getElementById('previewFee');
    const previewDiscountLabel = document.getElementById('previewDiscountLabel');
    const previewDiscountAmount = document.getElementById('previewDiscountAmount');
    const previewTotal = document.getElementById('previewTotal');
    const previewFooter = document.getElementById('previewFooter');
    const previewHeader = document.getElementById('previewHeader');
    const previewPaymentMethod = document.getElementById('previewPaymentMethod');
    const paymentMethodSelect = document.querySelector('select[name="payment_method"]');
    const statusSelect = document.getElementById('invoice_status');
    const previewStatus = document.getElementById('previewStatus');

    const numberFormat = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    const convertToActive = (value) => {
        const num = Number(value || 0);
        return num / (activeRate || 1);
    };

    const formatCurrency = (value) => {
        const num = Number(value || 0);
        return `${activeLabel} ${numberFormat.format(convertToActive(num))}`;
    };

    const parseMonths = (title) => {
        const match = String(title || '').match(/(\d+)/);
        return match ? parseInt(match[1], 10) : 0;
    };

    const populateMemberships = () => {
        membershipSelect.innerHTML = `<option value="">{{ __('select_membership_type') }}</option>`;
        (pricingData || []).forEach((item, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = item.title || `Membership ${index + 1}`;
            membershipSelect.appendChild(option);
        });
    };

    const populateDurations = (membershipIndex) => {
        durationSelect.innerHTML = `<option value="">{{ __('select_duration') }}</option>`;
        const membership = pricingData[membershipIndex];
        if (!membership || !membership.durations) {
            return;
        }
        membership.durations.forEach((duration, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = duration.title || `Duration ${index + 1}`;
            option.dataset.price = duration.price || '0';
            option.dataset.months = parseMonths(duration.title);
            durationSelect.appendChild(option);
        });
    };

    const updateTotals = () => {
        const selectedDuration = durationSelect.options[durationSelect.selectedIndex];
        const price = selectedDuration ? Number(selectedDuration.dataset.price || 0) : 0;
        const discountPercent = Math.min(Math.max(Number(discountInput.value || 0), 0), 100);
        const discountAmount = price * (discountPercent / 100);
        const total = price - discountAmount;

        feeInput.value = price.toFixed(2);
        discountAmountInput.value = discountAmount.toFixed(2);
        totalInput.value = total.toFixed(2);

        previewFee.textContent = formatCurrency(price);
        previewDiscountLabel.textContent = `${discountPercent}% {{ __('discount') }}`;
        previewDiscountAmount.textContent = formatCurrency(discountAmount);
        previewTotal.textContent = formatCurrency(total);
    };

    const updateDates = () => {
        if (!startDateInput.value) {
            return;
        }
        const startDate = new Date(startDateInput.value);
        if (Number.isNaN(startDate.getTime())) {
            return;
        }
        previewStartDate.textContent = startDateInput.value;

        const months = Number(durationMonthsInput.value || 0);
        if (!months) {
            return;
        }
        const endDate = new Date(startDate);
        endDate.setMonth(endDate.getMonth() + months);
        endDateInput.value = endDate.toISOString().split('T')[0];
        previewEndDate.textContent = endDateInput.value;
    };

    membershipSelect.addEventListener('change', () => {
        const index = membershipSelect.value;
        if (index === '') {
            previewMembership.textContent = '-';
            durationSelect.innerHTML = `<option value="">{{ __('select_duration') }}</option>`;
            durationTitleInput.value = '';
            durationMonthsInput.value = '';
            return;
        }
        const membership = pricingData[index];
        membershipTitleInput.value = membership?.title || '';
        previewMembership.textContent = membership?.title || '-';
        populateDurations(index);
    });

    durationSelect.addEventListener('change', () => {
        const selected = durationSelect.options[durationSelect.selectedIndex];
        if (!selected || !selected.value) {
            previewDuration.textContent = '-';
            return;
        }
        durationTitleInput.value = selected.textContent;
        durationMonthsInput.value = selected.dataset.months || 0;
        previewDuration.textContent = selected.textContent;
        updateTotals();
        updateDates();
    });

    discountInput.addEventListener('input', updateTotals);

    if (paymentMethodSelect && previewPaymentMethod) {
        paymentMethodSelect.addEventListener('change', () => {
            const selected = paymentMethodSelect.options[paymentMethodSelect.selectedIndex];
            previewPaymentMethod.textContent = selected && selected.value ? selected.textContent : '-';
        });
    }

    if (statusSelect && previewStatus) {
        const syncStatus = () => {
            const selected = statusSelect.options[statusSelect.selectedIndex];
            previewStatus.textContent = selected && selected.value ? selected.textContent : 'Draft';
        };
        statusSelect.addEventListener('change', syncStatus);
        syncStatus();
    }

    startDateInput.addEventListener('change', () => {
        updateDates();
    });

    document.getElementById('printInvoiceBtn').addEventListener('click', () => {
        const invoiceHtml = document.getElementById('invoicePreview')?.outerHTML;
        if (!invoiceHtml) {
            return;
        }

        const printWindow = window.open('', '_blank', 'width=900,height=650');
        if (!printWindow) {
            return;
        }

        const styles = `
            <style>
                @page { size: A4; margin: 0; }
                html, body { margin: 0; padding: 0; }
                body { font-family: Arial, sans-serif; color: #111827; }
                .invoice-preview {
                    border: none;
                    border-radius: 0;
                    padding: 24px;
                    width: 720px;
                    margin: 0 auto;
                    box-shadow: none;
                }
                .invoice-row {
                    display: flex;
                    justify-content: space-between;
                    gap: 12px;
                    margin-bottom: 8px;
                    font-size: 0.95rem;
                }
                .invoice-row span:last-child { font-weight: 600; }
                .invoice-row.total { font-size: 1.05rem; font-weight: 700; }
                .invoice-footer { text-align: center; font-size: 0.9rem; color: #4b5563; white-space: pre-line; }
            </style>
        `;

        printWindow.document.open();
        printWindow.document.write(`<!doctype html><html><head><title>Invoice</title>${styles}</head><body>${invoiceHtml}</body></html>`);
        printWindow.document.close();
        printWindow.focus();
        printWindow.onload = () => {
            printWindow.print();
            printWindow.close();
        };
    });

    const footerField = document.querySelector('textarea[name="invoice_footer"]');
    if (footerField) {
        footerField.addEventListener('input', () => {
            previewFooter.textContent = footerField.value;
        });
    }

    const headerField = document.getElementById('invoice_header_input');
    if (headerField) {
        const headerHidden = document.getElementById('invoice_header');
        const syncHeader = () => {
            const value = headerField.value || '';
            if (previewHeader) {
                previewHeader.textContent = value || '{{ $headerDefault }}';
            }
            if (headerHidden) {
                headerHidden.value = value;
            }
        };
        headerField.addEventListener('input', syncHeader);
        syncHeader();
    }

    const today = new Date().toISOString().split('T')[0];
    startDateInput.value = today;
    previewStartDate.textContent = today;
    populateMemberships();
    updateTotals();

    document.getElementById('addPaymentMethodBtn').addEventListener('click', () => {
        const nameField = document.getElementById('payment_method_name');
        const name = nameField.value.trim();
        if (!name) {
            return;
        }
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('members.payment-methods.store') }}";

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);

        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = 'name';
        nameInput.value = name;
        form.appendChild(nameInput);

        document.body.appendChild(form);
        form.submit();
    });
    </script>
    @endpush
