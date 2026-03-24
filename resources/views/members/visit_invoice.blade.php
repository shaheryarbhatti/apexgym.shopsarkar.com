<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ __('invoice_per_visit') }}</title>

    @extends('layouts.app')
    @section('content')

    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __('invoice_per_visit') }}</h4>
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
                                <button type="submit" form="visitInvoiceForm" class="btn btn-primary">
                                    <i class="fa fa-save me-2"></i> {{ __('save_invoice') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="printVisitInvoiceBtn">
                                    <i class="fa fa-print me-2"></i> {{ __('print_download_pdf') }}
                                </button>
                            </div>

                            <form method="POST" action="{{ route('members.visit-invoice.store', $member) }}" class="theme-form" id="visitInvoiceForm">
                                @csrf

                                <input type="hidden" name="invoice_no" value="{{ $invoiceNo }}">
                                <input type="hidden" name="visit_title" id="visit_title">
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
                                                <label class="col-form-label fw-bold">{{ __('price_per_visit') }}</label>
                                                <select name="visit_select" id="visit_select" class="form-select" required>
                                                    <option value="">{{ __('select_price_per_visit') }}</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label fw-bold">{{ __('visit_date') }}</label>
                                                <input type="date" class="form-control" name="visit_date" id="visit_date" required>
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
                                                <select name="status" id="visit_status" class="form-select">
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
                                        </div>
                                    </div>

                                    <div class="col-lg-7">
                                        <div class="invoice-preview" id="visitInvoicePreview">
                                            <div class="text-center mb-3">
                                                <h4 class="mb-1" id="previewHeader">{{ $headerDefault }}</h4>
                                                <small class="text-muted">{{ __('invoice_per_visit') }}</small>
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
                                                <span>{{ __('price_per_visit') }}</span>
                                                <span id="previewVisitTitle">-</span>
                                            </div>
                                            <div class="invoice-row">
                                                <span>{{ __('visit_date') }}</span>
                                                <span id="previewVisitDate">-</span>
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
        #visitInvoicePreview, #visitInvoicePreview * {
            visibility: visible;
        }
        #visitInvoicePreview {
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
    }
    </style>
    @endpush

    @push('scripts')
    <script>
    const visitPricing = @json($priceVisit);
    const baseLabel = @json($baseLabel);
    const activeLabel = @json($activeLabel ?? $baseLabel);
    const activeRate = Number(@json($activeRate ?? 1)) || 1;

    const visitSelect = document.getElementById('visit_select');
    const visitDateInput = document.getElementById('visit_date');
    const discountInput = document.getElementById('discount_percent');

    const feeInput = document.getElementById('fee');
    const discountAmountInput = document.getElementById('discount_amount');
    const totalInput = document.getElementById('total');
    const visitTitleInput = document.getElementById('visit_title');

    const previewVisitTitle = document.getElementById('previewVisitTitle');
    const previewVisitDate = document.getElementById('previewVisitDate');
    const previewFee = document.getElementById('previewFee');
    const previewDiscountLabel = document.getElementById('previewDiscountLabel');
    const previewDiscountAmount = document.getElementById('previewDiscountAmount');
    const previewTotal = document.getElementById('previewTotal');
    const previewFooter = document.getElementById('previewFooter');
    const previewHeader = document.getElementById('previewHeader');
    const previewPaymentMethod = document.getElementById('previewPaymentMethod');
    const paymentMethodSelect = document.querySelector('select[name="payment_method"]');
    const statusSelect = document.getElementById('visit_status');
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

    const populateVisitOptions = () => {
        visitSelect.innerHTML = `<option value="">{{ __('select_price_per_visit') }}</option>`;
        (visitPricing || []).forEach((item, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = item.title || `Visit ${index + 1}`;
            option.dataset.price = item.price || '0';
            visitSelect.appendChild(option);
        });
    };

    const updateTotals = () => {
        const selected = visitSelect.options[visitSelect.selectedIndex];
        const price = selected ? Number(selected.dataset.price || 0) : 0;
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

    visitSelect.addEventListener('change', () => {
        const selected = visitSelect.options[visitSelect.selectedIndex];
        if (!selected || !selected.value) {
            previewVisitTitle.textContent = '-';
            visitTitleInput.value = '';
            return;
        }
        visitTitleInput.value = selected.textContent;
        previewVisitTitle.textContent = selected.textContent;
        updateTotals();
    });

    discountInput.addEventListener('input', updateTotals);

    visitDateInput.addEventListener('change', () => {
        previewVisitDate.textContent = visitDateInput.value || '-';
    });

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

    document.getElementById('printVisitInvoiceBtn').addEventListener('click', () => {
        const invoiceHtml = document.getElementById('visitInvoicePreview')?.outerHTML;
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

    const today = new Date().toISOString().split('T')[0];
    visitDateInput.value = today;
    previewVisitDate.textContent = today;
    populateVisitOptions();
    updateTotals();
    </script>
    @endpush
