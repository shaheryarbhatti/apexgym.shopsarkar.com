<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('system_documentation') }}</title>

    @extends('layouts.app')
    @section('content')
    <style>
        .doc-hero {
            background: linear-gradient(120deg, rgba(115, 103, 240, 0.12), rgba(0, 207, 232, 0.16));
            border-radius: 20px;
            padding: 26px 28px;
            box-shadow: 0 16px 40px rgba(18, 38, 63, 0.1);
        }

        .doc-card {
            border-radius: 18px;
            box-shadow: 0 12px 28px rgba(18, 38, 63, 0.08);
            border: 1px solid #eef2f7;
        }

        .doc-card h5 {
            font-weight: 700;
            color: #1f2a37;
        }

        .doc-step {
            background: #f8fafc;
            border-radius: 12px;
            padding: 12px 14px;
            border: 1px solid #e5e7eb;
        }

        .doc-step + .doc-step {
            margin-top: 10px;
        }

        .doc-badge {
            background: rgba(79, 70, 229, 0.15);
            color: #4338ca;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
    </style>

    <div class="page-body">
        <div class="container-fluid">
            <div class="doc-hero d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-bold mb-1 text-dark">{{ __('system_documentation') }}</h3>
                    <p class="text-muted mb-0">{{ __('system_documentation_desc') }}</p>
                </div>
                <span class="badge bg-primary text-white px-3 py-2" style="border-radius: 999px;">
                    {{ __('quick_guide') }}
                </span>
            </div>

            <div class="row g-4">
                <div class="col-xl-6">
                    <div class="card doc-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="mb-0">{{ __('members_module') }}</h5>
                                <span class="doc-badge">Members</span>
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('add_member') }}:</strong>
                                {{ __('add_member_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('update_member') }}:</strong>
                                {{ __('update_member_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('delete_member') }}:</strong>
                                {{ __('delete_member_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('member_card') }}:</strong>
                                {{ __('member_card_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('member_invoices') }}:</strong>
                                {{ __('member_invoices_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('barcode_login') }}:</strong>
                                {{ __('barcode_login_desc') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card doc-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="mb-0">{{ __('invoice_module') }}</h5>
                                <span class="doc-badge">Invoices</span>
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('generate_invoice') }}:</strong>
                                {{ __('generate_invoice_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('invoice_types') }}:</strong>
                                {{ __('invoice_types_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('download_invoice') }}:</strong>
                                {{ __('download_invoice_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('invoice_status') }}:</strong>
                                {{ __('invoice_status_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('invoice_filters') }}:</strong>
                                {{ __('invoice_filters_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('invoice_email') }}:</strong>
                                {{ __('invoice_email_desc') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card doc-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="mb-0">{{ __('trainer_module') }}</h5>
                                <span class="doc-badge">Trainers</span>
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('add_trainer') }}:</strong>
                                {{ __('add_trainer_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('trainer_pricing') }}:</strong>
                                {{ __('trainer_pricing_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('trainer_invoice') }}:</strong>
                                {{ __('trainer_invoice_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('trainer_packages') }}:</strong>
                                {{ __('trainer_packages_desc') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card doc-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="mb-0">{{ __('attendance_module') }}</h5>
                                <span class="doc-badge">Attendance</span>
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('check_in_out') }}:</strong>
                                {{ __('check_in_out_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('attendance_report') }}:</strong>
                                {{ __('attendance_report_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('attendance_search') }}:</strong>
                                {{ __('attendance_search_desc') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card doc-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="mb-0">{{ __('settings_module') }}</h5>
                                <span class="doc-badge">Settings</span>
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('theme_settings') }}:</strong>
                                {{ __('theme_settings_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('login_page_settings') }}:</strong>
                                {{ __('login_page_settings_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('email_settings') }}:</strong>
                                {{ __('email_settings_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('pricing_settings') }}:</strong>
                                {{ __('pricing_settings_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('card_design_settings') }}:</strong>
                                {{ __('card_design_settings_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('currency_settings') }}:</strong>
                                {{ __('currency_settings_desc') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card doc-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="mb-0">{{ __('reports_module') }}</h5>
                                <span class="doc-badge">Reports</span>
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('invoice_reports') }}:</strong>
                                {{ __('invoice_reports_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('attendance_reports') }}:</strong>
                                {{ __('attendance_reports_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('export_members') }}:</strong>
                                {{ __('export_members_desc') }}
                            </div>
                            <div class="doc-step">
                                <strong>{{ __('visitor_analytics') }}:</strong>
                                {{ __('visitor_analytics_desc') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
