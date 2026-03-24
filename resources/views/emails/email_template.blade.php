<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sky Fitness Gym – premium gym portal.">
    <meta name="author" content="skyfitnessgym.com">
    <title>{{ __('email_templates') }}</title>

    @extends('layouts.app')
    @section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-header pb-0">
                            <h4>{{ __('email_templates') }}</h4>
                            <p class="text-muted mb-0">{{ __('email_templates_desc') }}</p>
                        </div>
                        <form action="{{ route('email.update') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="border rounded-3 p-3 bg-light mb-4">
                                    <h6 class="fw-bold mb-2">{{ __('send_test_email') }}</h6>
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">{{ __('select_user') }}</label>
                                            <select class="form-select" name="test_user_id" id="test_user_id">
                                                <option value="">{{ __('select_user') }}</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">{{ __('template') }}</label>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-outline-primary" data-template="member_registration" id="sendRegistrationTest">
                                                    {{ __('test_registration_email') }}
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary" data-template="member_cancellation" id="sendCancellationTest">
                                                    {{ __('test_membership_cancellation') }}
                                                </button>
                                                <button type="button" class="btn btn-outline-dark" data-template="trainer_invoice_cancellation" id="sendTrainerCancellationTest">
                                                    {{ __('test_trainer_cancellation') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-2">{{ __('send_test_email_note') }}</small>
                                </div>

                                <ul class="nav nav-tabs" id="emailTemplateTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="registration-tab" data-bs-toggle="tab"
                                            data-bs-target="#registration" type="button" role="tab">
                                            {{ __('member_registration') }}
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="cancellation-tab" data-bs-toggle="tab"
                                            data-bs-target="#cancellation" type="button" role="tab">
                                            {{ __('membership_cancellation') }}
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="trainer-cancellation-tab" data-bs-toggle="tab"
                                            data-bs-target="#trainer-cancellation" type="button" role="tab">
                                            {{ __('trainer_invoice_cancellation') }}
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content pt-4" id="emailTemplateTabsContent">
                                    <div class="tab-pane fade show active" id="registration" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">{{ __('subject') }}</label>
                                            <input type="text" name="registration_subject" class="form-control"
                                                value="{{ old('registration_subject', $registration->subject) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">{{ __('body') }}</label>
                                            <textarea name="registration_body" class="form-control" rows="8">{{ old('registration_body', $registration->body) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="cancellation" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">{{ __('subject') }}</label>
                                            <input type="text" name="cancellation_subject" class="form-control"
                                                value="{{ old('cancellation_subject', $cancellation->subject) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">{{ __('body') }}</label>
                                            <textarea name="cancellation_body" class="form-control" rows="8">{{ old('cancellation_body', $cancellation->body) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="trainer-cancellation" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">{{ __('subject') }}</label>
                                            <input type="text" name="trainer_cancellation_subject" class="form-control"
                                                value="{{ old('trainer_cancellation_subject', $trainerCancellation->subject) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">{{ __('body') }}</label>
                                            <textarea name="trainer_cancellation_body" class="form-control" rows="8">{{ old('trainer_cancellation_body', $trainerCancellation->body) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-light border mt-3">
                                    <strong>{{ __('available_placeholders') }}</strong>
                                    <div class="mt-2 text-muted">
                                        {name}, {email}, {password}, {brand_name}
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save me-2"></i>{{ __('save_templates') }}
                                </button>
                            </div>
                        </form>

                        <form id="emailTestForm" method="POST" action="{{ route('email.test') }}">
                            @csrf
                            <input type="hidden" name="template_key" id="test_template_key">
                            <input type="hidden" name="user_id" id="test_user_id_hidden">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
        const userSelect = document.getElementById('test_user_id');
        const testForm = document.getElementById('emailTestForm');
        const templateKeyInput = document.getElementById('test_template_key');
        const userIdInput = document.getElementById('test_user_id_hidden');

        const sendTest = (templateKey) => {
            if (!userSelect || !testForm || !templateKeyInput || !userIdInput) return;
            const userId = userSelect.value;
            if (!userId) {
                alert('Please select a user first.');
                return;
            }
            templateKeyInput.value = templateKey;
            userIdInput.value = userId;
            testForm.submit();
        };

        document.getElementById('sendRegistrationTest')?.addEventListener('click', () => {
            sendTest('member_registration');
        });

        document.getElementById('sendCancellationTest')?.addEventListener('click', () => {
            sendTest('member_cancellation');
        });

        document.getElementById('sendTrainerCancellationTest')?.addEventListener('click', () => {
            sendTest('trainer_invoice_cancellation');
        });
    </script>
    @endpush
