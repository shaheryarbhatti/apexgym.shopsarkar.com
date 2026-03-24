<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sky Fitness Gym â€“ premium gym portal.">
    <meta name="author" content="skyfitnessgym.com">

    <title>{{ __('trainer_invoice') }}</title>

    @extends('layouts.app')
    @section('content')

    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __('trainer_invoice') }}</h4>
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
                                <button type="submit" form="trainerInvoiceForm" class="btn btn-primary">
                                    <i class="fa fa-save me-2"></i> {{ __('save_invoice') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="printTrainerInvoiceBtn">
                                    <i class="fa fa-print me-2"></i> {{ __('print_download_pdf') }}
                                </button>
                            </div>

                            <form method="POST" action="{{ route('members.trainer-invoice.store', $member) }}" class="theme-form" id="trainerInvoiceForm">
                                @csrf

                                <input type="hidden" name="invoice_no" value="{{ $invoiceNo }}">
                                <input type="hidden" name="trainer_type" id="trainer_type_value">
                                <input type="hidden" name="session_title" id="session_title">
                                <input type="hidden" name="session_days" id="session_days">
                                <input type="hidden" name="fee" id="trainer_fee">
                                <input type="hidden" name="discount_amount" id="trainer_discount_amount">
                                <input type="hidden" name="total" id="trainer_total">
                                <input type="hidden" name="invoice_header" id="trainer_invoice_header">

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
                                                <label class="col-form-label fw-bold">{{ __('trainer_type') }}</label>
                                                <select id="trainer_type_select" class="form-select">
                                                    <option value="">{{ __('select_trainer_type') }}</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('trainer_name') }}</label>
                                                <select name="trainer_id" id="trainer_select" class="form-select">
                                                    <option value="">{{ __('select_trainer') }}</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('session_packages') }}</label>
                                                <select id="session_select" class="form-select">
                                                    <option value="">{{ __('select_session_package') }}</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('start_date') }}</label>
                                                <input type="date" class="form-control" name="start_date" id="trainer_start_date" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('completion_date') }}</label>
                                                <input type="date" class="form-control" name="end_date" id="trainer_end_date" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('payment_methods') }}</label>
                                                <select name="payment_method_id" id="payment_method_id" class="form-select">
                                                    <option value="">{{ __('select_payment_method') }}</option>
                                                    @foreach($paymentMethods as $method)
                                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('discount') }} (%)</label>
                                                <input type="number" class="form-control" name="discount_percent" id="trainer_discount" value="0" min="0" max="100">
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('status') }}</label>
                                                <select name="status" id="trainer_invoice_status" class="form-select">
                                                    <option value="draft">Draft</option>
                                                    <option value="final">Final</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('invoice_header') }}</label>
                                                <input type="text" class="form-control" id="trainer_header_input" value="{{ old('invoice_header', $headerDefault) }}">
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
                                        <div class="invoice-preview" id="trainerInvoicePreview">
                                            <div class="text-center mb-3">
                                                <h4 class="mb-1" id="trainerPreviewHeader">{{ $headerDefault }}</h4>
                                                <small class="text-muted">{{ __('invoice_trainer') }}</small>
                                            </div>

                                            <div class="invoice-row">
                                                <span>{{ __('invoice_number') }}</span>
                                                <span>{{ $invoiceNo }}</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('date') }}</span>
                                                <span>{{ now()->format('m/d/Y') }}</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('member_name') }}</span>
                                                <span>{{ $member->full_name }}</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('member_code') }}</span>
                                                <span>{{ $member->member_code }}</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('phone') }}</span>
                                                <span>{{ $member->phone ?? '-' }}</span>
                                            </div>

                                            <hr>

                                            <div class="invoice-row">
                                                <span>{{ __('trainer_type') }}</span>
                                                <span id="previewTrainerType">-</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('session_packages') }}</span>
                                                <span id="previewSession">-</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('start_date') }}</span>
                                                <span id="previewTrainerStart">-</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('completion_date') }}</span>
                                                <span id="previewTrainerEnd">-</span>
                                            </div>

                                            <hr>

                                            <div class="invoice-row">
                                                <span>{{ __('status') }}</span>
                                                <span id="previewTrainerStatus">Draft</span>
                                            </div>

                                            <div class="invoice-row">
                                                <span>{{ __('payment_methods') }}</span>
                                                <span id="previewTrainerPayment">-</span>
                                            </div>

                                            <div class="invoice-row">
                                                <span>{{ __('trainer_fees') }}</span>
                                                <span id="previewTrainerFee">-</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span id="previewTrainerDiscountLabel">0% {{ __('discount') }}</span>
                                                <span id="previewTrainerDiscountAmount">-</span>
                                            </div>
                                            <div class="invoice-row total">
                                                <span>{{ __('total') }}</span>
                                                <span id="previewTrainerTotal">-</span>
                                            </div>

                                            <div class="invoice-footer mt-4" id="trainerPreviewFooter">
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
    </style>
    @endpush

    @push('scripts')
    <script>
    const trainerPricing = @json($trainerPricing);
    const trainers = @json($trainers);
    const baseLabel = @json($baseLabel);
    const activeLabel = @json($activeLabel ?? $baseLabel);
    const activeRate = Number(@json($activeRate ?? 1)) || 1;

    const trainerTypeSelect = document.getElementById('trainer_type_select');
    const trainerSelect = document.getElementById('trainer_select');
    const sessionSelect = document.getElementById('session_select');
    const startDateInput = document.getElementById('trainer_start_date');
    const endDateInput = document.getElementById('trainer_end_date');
    const discountInput = document.getElementById('trainer_discount');

    const trainerTypeValue = document.getElementById('trainer_type_value');
    const sessionTitleInput = document.getElementById('session_title');
    const sessionDaysInput = document.getElementById('session_days');
    const feeInput = document.getElementById('trainer_fee');
    const discountAmountInput = document.getElementById('trainer_discount_amount');
    const totalInput = document.getElementById('trainer_total');

    const previewTrainerType = document.getElementById('previewTrainerType');
    const previewSession = document.getElementById('previewSession');
    const previewStart = document.getElementById('previewTrainerStart');
    const previewEnd = document.getElementById('previewTrainerEnd');
    const previewFee = document.getElementById('previewTrainerFee');
    const previewDiscountLabel = document.getElementById('previewTrainerDiscountLabel');
    const previewDiscountAmount = document.getElementById('previewTrainerDiscountAmount');
    const previewTotal = document.getElementById('previewTrainerTotal');
    const previewFooter = document.getElementById('trainerPreviewFooter');
    const previewHeader = document.getElementById('trainerPreviewHeader');
    const previewTrainerPayment = document.getElementById('previewTrainerPayment');
    const paymentMethodSelect = document.getElementById('payment_method_id');
    const statusSelect = document.getElementById('trainer_invoice_status');
    const previewTrainerStatus = document.getElementById('previewTrainerStatus');

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

    const getTrainerTypes = () => {
        return (trainerPricing || []).map(item => item.title).filter(Boolean);
    };

    const populateTrainerTypes = () => {
        trainerTypeSelect.innerHTML = `<option value="">{{ __('select_trainer_type') }}</option>`;
        getTrainerTypes().forEach((type) => {
            const option = document.createElement('option');
            option.value = type;
            option.textContent = type;
            trainerTypeSelect.appendChild(option);
        });
    };

    const populateTrainers = (type) => {
        trainerSelect.innerHTML = `<option value="">{{ __('select_trainer') }}</option>`;
        (trainers || []).filter(trainer => trainer.trainer_type === type).forEach(trainer => {
            const option = document.createElement('option');
            option.value = trainer.id;
            option.textContent = trainer.full_name;
            trainerSelect.appendChild(option);
        });
    };

    const populateSessions = (type) => {
        sessionSelect.innerHTML = `<option value="">{{ __('select_session_package') }}</option>`;
        const trainerType = (trainerPricing || []).find(item => item.title === type);
        if (!trainerType || !trainerType.sessions) {
            return;
        }
        trainerType.sessions.forEach((session, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = session.title || `Session ${index + 1}`;
            option.dataset.price = session.price || '0';
            option.dataset.days = session.days || '0';
            sessionSelect.appendChild(option);
        });
    };

    const updateTotals = () => {
        const selectedSession = sessionSelect.options[sessionSelect.selectedIndex];
        const price = selectedSession ? Number(selectedSession.dataset.price || 0) : 0;
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
        previewStart.textContent = startDateInput.value;

        const days = Number(sessionDaysInput.value || 0);
        if (!days) {
            return;
        }
        const endDate = new Date(startDate);
        endDate.setDate(endDate.getDate() + days);
        endDateInput.value = endDate.toISOString().split('T')[0];
        previewEnd.textContent = endDateInput.value;
    };

    trainerTypeSelect.addEventListener('change', () => {
        const type = trainerTypeSelect.value;
        trainerTypeValue.value = type;
        previewTrainerType.textContent = type || '-';
        populateTrainers(type);
        populateSessions(type);
        sessionTitleInput.value = '';
        sessionDaysInput.value = '';
        previewSession.textContent = '-';
        updateTotals();
    });

    sessionSelect.addEventListener('change', () => {
        const selected = sessionSelect.options[sessionSelect.selectedIndex];
        if (!selected || !selected.value) {
            previewSession.textContent = '-';
            return;
        }
        sessionTitleInput.value = selected.textContent;
        sessionDaysInput.value = selected.dataset.days || 0;
        previewSession.textContent = selected.textContent;
        updateTotals();
        updateDates();
    });

    discountInput.addEventListener('input', updateTotals);
    startDateInput.addEventListener('change', updateDates);

    if (paymentMethodSelect && previewTrainerPayment) {
        paymentMethodSelect.addEventListener('change', () => {
            const selected = paymentMethodSelect.options[paymentMethodSelect.selectedIndex];
            previewTrainerPayment.textContent = selected && selected.value ? selected.textContent : '-';
        });
    }

    if (statusSelect && previewTrainerStatus) {
        const syncStatus = () => {
            const selected = statusSelect.options[statusSelect.selectedIndex];
            previewTrainerStatus.textContent = selected && selected.value ? selected.textContent : 'Draft';
        };
        statusSelect.addEventListener('change', syncStatus);
        syncStatus();
    }

    const footerField = document.querySelector('textarea[name="invoice_footer"]');
    if (footerField) {
        footerField.addEventListener('input', () => {
            previewFooter.textContent = footerField.value;
        });
    }

    const headerField = document.getElementById('trainer_header_input');
    if (headerField) {
        const headerHidden = document.getElementById('trainer_invoice_header');
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

    document.getElementById('printTrainerInvoiceBtn').addEventListener('click', () => {
        const invoiceHtml = document.getElementById('trainerInvoicePreview')?.outerHTML;
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

    const today = new Date().toISOString().split('T')[0];
    startDateInput.value = today;
    previewStart.textContent = today;
    populateTrainerTypes();
    updateTotals();
    </script>
    @endpush
