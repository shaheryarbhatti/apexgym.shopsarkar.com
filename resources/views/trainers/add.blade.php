<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sky Fitness Gym – premium gym portal.">
    <meta name="author" content="skyfitnessgym.com">

    <title>{{ __('add_new_trainer') }}</title>

    @extends('layouts.app')
    @section('content')

    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __('add_new_trainer') }}</h4>
                            <a href="{{ route('trainers.manage') }}" class="btn btn-outline-secondary btn-sm">
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

                            <form method="POST" action="{{ route('trainers.store') }}" enctype="multipart/form-data"
                                class="theme-form">
                                @csrf

                                <div class="row g-4">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">

                                        <div class="mb-3">
                                            <label class="col-form-label" for="full_name">{{ __('full_name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="full_name" id="full_name"
                                                class="form-control @error('full_name') is-invalid @enderror"
                                                value="{{ old('full_name') }}" placeholder="{{ __('full_name') }}"
                                                required autofocus>
                                            @error('full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label" for="email">{{ __('email') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" placeholder="{{ __('email') }}" required>
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label"
                                                for="phone_number">{{ __('phone_number') }}</label>
                                            <input type="text" name="phone_number" id="phone_number"
                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                value="{{ old('phone_number') }}"
                                                placeholder="{{ __('phone_number') }}">
                                            @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label"
                                                for="trainer_type">{{ __('trainer_type') }}</label>
                                            <select name="trainer_type" id="trainer_type"
                                                class="form-select @error('trainer_type') is-invalid @enderror">
                                                <option value="">{{ __('select_trainer_type') }}</option>
                                                @forelse($trainerTypes as $type)
                                                    <option value="{{ $type }}" {{ old('trainer_type') == $type ? 'selected' : '' }}>
                                                        {{ $type }}
                                                    </option>
                                                @empty
                                                    <option value="">{{ __('no_trainer_types') }}</option>
                                                @endforelse
                                            </select>
                                            @error('trainer_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">

                                        <div class="mb-3">
                                            <label class="col-form-label" for="gender">{{ __('gender') }}</label>
                                            <select name="gender" id="gender"
                                                class="form-select @error('gender') is-invalid @enderror">
                                                <option value="">Select</option>
                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                    Female</option>
                                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>
                                                    Other</option>
                                            </select>
                                            @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label" for="status">{{ __('status') }}</label>
                                            <select name="status" id="status"
                                                class="form-select @error('status') is-invalid @enderror">
                                                <option value="active"
                                                    {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive"
                                                    {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                                </option>
                                                <option value="pending"
                                                    {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label"
                                                for="specialization">{{ __('specialization') }}</label>
                                            <textarea name="specialization" id="specialization"
                                                class="form-control @error('specialization') is-invalid @enderror"
                                                placeholder="{{ __('specialization') }}">{{ old('specialization') }}</textarea>
                                            @error('specialization')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label" for="photo">{{ __('photo') }}</label>
                                            <input type="file" name="photo" id="photo"
                                                class="form-control @error('photo') is-invalid @enderror"
                                                accept="image/*">
                                            @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary px-5">
                                        <i class="fa fa-save me-2"></i> {{ __('save_trainer') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection

