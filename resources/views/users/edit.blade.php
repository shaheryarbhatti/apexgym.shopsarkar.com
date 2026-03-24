<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ __('edit_user') }}</title>

    @extends('layouts.app')
    @section('content')

    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __('edit_user') }}</h4>
                            <a href="{{ route('users.manage') }}" class="btn btn-outline-secondary btn-sm">
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

                            <form method="POST" action="{{ route('users.update', $user->id) }}"
                                enctype="multipart/form-data" class="theme-form">
                                @csrf
                                @method('PUT')

                                <div class="row g-4">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">

                                        <div class="mb-3">
                                            <label class="col-form-label" for="name">{{ __('name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name', $user->name) }}" placeholder="{{ __('name') }}"
                                                required autofocus>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label" for="email">{{ __('email') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', $user->email) }}" placeholder="{{ __('email') }}"
                                                required>
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">

                                        <div class="mb-3">
                                            <label class="col-form-label" for="password">{{ __('password') }} (leave
                                                blank to keep current)</label>
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="{{ __('password') }}">
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label"
                                                for="password_confirmation">{{ __('confirm_password') }}</label>
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation" class="form-control"
                                                placeholder="{{ __('confirm_password') }}">
                                        </div>

                                    </div>

                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">

                                        <div class="mb-3">
                                            <label class="col-form-label" for="role_id">{{ __('role') }}</label>
                                            <select name="role_id" id="role_id" class="form-select">
                                                <option value="">Select Role</option>
                                                @foreach($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id', $user->roles->first()->id ?? '') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-switch form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="status"
                                                    id="status" value="1"
                                                    {{ old('status', $user->status) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status">{{ __('status') }}</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                        <div class="mb-3">
                                            <label class="col-form-label" for="image">{{ __('user_image') }}</label>
                                            <input type="file" name="image" id="image"
                                                class="form-control @error('image') is-invalid @enderror">
                                            @if(isset($user) && $user->image)
                                            <img id="preview"
                                                src="{{ $user->image ? asset('public/storage/'.$user->image) : '#' }}"
                                                alt="Preview"
                                                style="max-height: 100px; {{ $user->image ? '' : 'display: none;' }} border-radius: 8px;">
                                            @endif
                                            @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary px-5">
                                        <i class="fa fa-refresh me-2"></i> {{ __('update_user') }}
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

