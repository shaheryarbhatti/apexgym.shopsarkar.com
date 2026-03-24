<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sky Fitness Gym – premium gym portal.">
    <meta name="author" content="skyfitnessgym.com">

    <title>{{ __('edit_member') }}</title>

    @extends('layouts.app')

    @section('content')

    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __('edit_member') }}</h4>
                            <a href="{{ route('members.manage') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-arrow-left me-2"></i> {{ __('back_to_list') }}
                            </a>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Whoops!</strong> There were some problems with your input.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <form method="POST" action="{{ route('members.update', $member->id) }}" enctype="multipart/form-data" class="theme-form">
                                @csrf
                                @method('PUT')

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="member_code">{{ __('member_code') }}</label>
                                        <input type="text" id="member_code" class="form-control" value="{{ $member->member_code }}" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="border rounded-3 p-2 d-inline-block bg-white">
                                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(120)->margin(1)->generate($member->barcode ?? $member->member_code) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="full_name">{{ __('full_name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="full_name" id="full_name"
                                            class="form-control @error('full_name') is-invalid @enderror"
                                            value="{{ old('full_name', $member->full_name) }}" placeholder="{{ __('full_name') }}" required>
                                        @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="nik">{{ __('nik') }}</label>
                                        <input type="text" name="nik" id="nik"
                                            class="form-control @error('nik') is-invalid @enderror"
                                            value="{{ old('nik', $member->nik) }}" placeholder="NIK / ID number">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="place_of_birth">{{ __('place_of_birth') }}</label>
                                        <input type="text" name="place_of_birth" id="place_of_birth"
                                            class="form-control @error('place_of_birth') is-invalid @enderror"
                                            value="{{ old('place_of_birth', $member->place_of_birth) }}" placeholder="City / Place">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="date_of_birth">{{ __('date_of_birth') }}</label>
                                        <input class="form-control" id="date_of_birth" name="date_of_birth" type="date"
                                            value="{{ old('date_of_birth', $member->date_of_birth ? \Carbon\Carbon::parse($member->date_of_birth)->format('Y-m-d') : '') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="gender">{{ __('gender') }}</label>
                                        <select name="gender" id="gender" class="form-select">
                                            <option value="">Select</option>
                                            <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="blood_type">{{ __('blood_type') }}</label>
                                        <select name="blood_type" id="blood_type" class="form-select">
                                            <option value="">Select</option>
                                            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                                                <option value="{{ $type }}" {{ old('blood_type', $member->blood_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="religion">{{ __('religion') }}</label>
                                        <input type="text" name="religion" id="religion" class="form-control" value="{{ old('religion', $member->religion) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="marital_status">{{ __('marital_status') }}</label>
                                        <select name="marital_status" id="marital_status" class="form-select">
                                            <option value="single" {{ old('marital_status', $member->marital_status) == 'single' ? 'selected' : '' }}>Single</option>
                                            <option value="married" {{ old('marital_status', $member->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                                            <option value="divorced" {{ old('marital_status', $member->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="occupation">{{ __('occupation') }}</label>
                                        <input type="text" name="occupation" id="occupation" class="form-control" value="{{ old('occupation', $member->occupation) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="citizenship">{{ __('citizenship') }}</label>
                                        <input type="text" name="citizenship" id="citizenship" class="form-control" value="{{ old('citizenship', $member->citizenship ?? 'Indonesian') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="email">{{ __('email') }}</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $member->email) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="phone">{{ __('phone') }}</label>
                                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $member->phone) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="address">{{ __('address') }}</label>
                                        <textarea name="address" id="address" rows="3" class="form-control">{{ old('address', $member->address) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="photo">{{ __('member_photo') }}</label>
                                        <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                                        <div class="mt-2">
                                            {{-- Shows existing photo or preview of new one --}}
                                            <img id="preview"
                                                 src="{{ $member->photo ? asset('public/storage/'.$member->photo) : '#' }}"
                                                 alt="Preview"
                                                 style="max-height: 180px; {{ $member->photo ? '' : 'display: none;' }} border-radius: 8px;">
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="form-check form-switch form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', $member->status) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status">{{ __('active_member') }}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="password">{{ __('password') }}</label>
                                        <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="" placeholder="{{ __('leave_blank_to_keep_existing_password') }}">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Leave blank to keep the existing password.</small>
                                    </div>
                                    <div class="col-12 text-end mt-4">
                                        <button type="submit" class="btn btn-primary px-5 py-2">
                                            <i class="fa fa-save me-2"></i> {{ __('update_member') }}
                                        </button>
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

    @push('scripts')
    <script>
    document.getElementById('photo').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // Password is optional; only update if user enters a value.

    const memberForm = document.querySelector('form.theme-form');
    if (memberForm) {
        const submitBtn = memberForm.querySelector('button[type="submit"]');
        memberForm.addEventListener('submit', () => {
            if (submitBtn) {
                submitBtn.disabled = true;
            }
        });
        memberForm.addEventListener('invalid', () => {
            if (submitBtn) {
                submitBtn.disabled = false;
            }
        }, true);
    }
    </script>
    @endpush
