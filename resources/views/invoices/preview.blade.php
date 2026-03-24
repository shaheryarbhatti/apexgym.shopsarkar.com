<div class="invoice-preview" id="invoicePreviewModal">
    <div class="text-center mb-3">
        <h4 class="mb-1">{{ $invoice->invoice_header ?? 'Sky Fitness' }}</h4>
        <small class="text-muted">
            @if($type === 'trainer')
                {{ __('trainer_invoice') }}
            @elseif($type === 'visit')
                {{ __('invoice_per_visit') }}
            @else
                {{ __('renew_invoice') }}
            @endif
        </small>
    </div>

    <div class="invoice-row">
        <span>{{ __('invoice_number') }}</span>
        <span>{{ $invoice->invoice_no }}</span>
    </div>
    <div class="invoice-row">
        <span>{{ __('date') }}</span>
        <span>{{ optional($invoice->created_at)->format('m/d/Y') }}</span>
    </div>
    <div class="invoice-row">
        <span>{{ __('member_name') }}</span>
        <span>{{ $invoice->member->full_name ?? '-' }}</span>
    </div>
    <div class="invoice-row">
        <span>{{ __('member_code') }}</span>
        <span>{{ $invoice->member->member_code ?? '-' }}</span>
    </div>
    <div class="invoice-row">
        <span>{{ __('phone') }}</span>
        <span>{{ $invoice->member->phone ?? '-' }}</span>
    </div>

    <hr>

    @if($type === 'trainer')
        <div class="invoice-row">
            <span>{{ __('trainer_type') }}</span>
            <span>{{ $invoice->trainer_type ?? '-' }}</span>
        </div>
        <div class="invoice-row">
            <span>{{ __('session_packages') }}</span>
            <span>{{ $invoice->session_title ?? '-' }}</span>
        </div>
        <div class="invoice-row">
            <span>{{ __('start_date') }}</span>
            <span>{{ optional($invoice->start_date)->format('m/d/Y') ?? '-' }}</span>
        </div>
        <div class="invoice-row">
            <span>{{ __('completion_date') }}</span>
            <span>{{ optional($invoice->end_date)->format('m/d/Y') ?? '-' }}</span>
        </div>
    @elseif($type === 'visit')
        <div class="invoice-row">
            <span>{{ __('price_per_visit') }}</span>
            <span>{{ $invoice->visit_title ?? '-' }}</span>
        </div>
        <div class="invoice-row">
            <span>{{ __('visit_date') }}</span>
            <span>{{ optional($invoice->visit_date)->format('m/d/Y') ?? '-' }}</span>
        </div>
    @else
        <div class="invoice-row">
            <span>{{ __('membership_types') }}</span>
            <span>{{ $invoice->membership_title ?? '-' }}</span>
        </div>
        <div class="invoice-row">
            <span>{{ __('duration') }}</span>
            <span>{{ $invoice->duration_title ?? '-' }}</span>
        </div>
        <div class="invoice-row">
            <span>{{ __('start_date') }}</span>
            <span>{{ optional($invoice->start_date)->format('m/d/Y') ?? '-' }}</span>
        </div>
        <div class="invoice-row">
            <span>{{ __('completion_date') }}</span>
            <span>{{ optional($invoice->end_date)->format('m/d/Y') ?? '-' }}</span>
        </div>
    @endif

    <hr>

    <div class="invoice-row">
        <span>{{ __('status') }}</span>
        <span>{{ ucfirst($invoice->status ?? 'draft') }}</span>
    </div>
    <div class="invoice-row">
        <span>{{ __('payment_methods') }}</span>
        <span>
            @if($type === 'trainer')
                {{ $invoice->paymentMethod->name ?? '-' }}
            @else
                {{ $invoice->payment_method ?? '-' }}
            @endif
        </span>
    </div>

    <div class="invoice-row">
        <span>{{ __('membership_fee') }}</span>
        <span>{{ $baseLabel }} {{ number_format((float) ($invoice->fee ?? 0), 2) }}</span>
    </div>
    <div class="invoice-row">
        <span>{{ number_format((float) ($invoice->discount_percent ?? 0), 0) }}% {{ __('discount') }}</span>
        <span>{{ $baseLabel }} {{ number_format((float) ($invoice->discount_amount ?? 0), 2) }}</span>
    </div>
    <div class="invoice-row total">
        <span>{{ __('total') }}</span>
        <span>{{ $baseLabel }} {{ number_format((float) ($invoice->total ?? 0), 2) }}</span>
    </div>

    <div class="invoice-footer mt-4">
        {!! nl2br(e($invoice->invoice_footer ?? '')) !!}
    </div>
</div>
