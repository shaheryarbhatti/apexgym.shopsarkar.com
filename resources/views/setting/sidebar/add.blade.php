<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ __('add_new_module') }}</title>

    @extends('layouts.app')

    @section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __('add_new_module') }}</h4>
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

                            <form method="POST" action="{{ route('sidebar.module.store') }}" class="theme-form">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <label class="col-form-label"
                                            for="mod_title">{{ __('module_title_key') }}</label>
                                        <input type="text" name="title" id="mod_title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="{{ __('module_title_key') }}" value="{{ old('title') }}"
                                            required>
                                        @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="icon">{{ __('icon_class') }}</label>
                                        <input type="text" name="icon" id="icon"
                                            class="form-control @error('icon') is-invalid @enderror"
                                            placeholder="{{ __('icon_class') }}" value="{{ old('icon') }}" required>
                                        @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label"
                                            for="mod_permission">{{ __('master_permission') }}</label>
                                        <input type="text" name="permission" id="mod_permission"
                                            class="form-control @error('permission') is-invalid @enderror"
                                            placeholder="{{ __('master_permission') }}" value="{{ old('permission') }}"
                                            required>
                                        @error('permission')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 text-end mt-4">
                                        <button type="submit" class="btn btn-primary px-5 py-2">
                                            <i class="fa fa-save me-2"></i> {{ __('save_module') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __('add_module_option') }}</h4>
                        </div>

                        <div class="card-body">
                            @if (session('option_success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('option_success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <form method="POST" action="{{ route('sidebar.option.store') }}" class="theme-form">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <label class="col-form-label">{{ __('select_parent_module') }}</label>
                                        <select name="sidebar_module_id" class="form-select" required>
                                            <option value="" selected disabled>Select</option>
                                            @if($modules)
                                            @foreach($modules as $mod)
                                            <option value="{{ $mod->id }}">{{ __($mod->title) }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="opt_title">{{ __('option_title') }}</label>
                                        <input type="text" name="title" id="opt_title" class="form-control"
                                            placeholder="{{ __('option_title') }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label" for="route">{{ __('route_name') }}</label>
                                        <input type="text" name="route" id="route" class="form-control"
                                            placeholder="{{ __('route_name') }}" required>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="col-form-label"
                                            for="opt_permission">{{ __('specific_permission') }}</label>
                                        <input type="text" name="permission" id="opt_permission" class="form-control"
                                            placeholder="member-list" required>
                                    </div>

                                    <div class="col-12 text-end mt-4">
                                        <button type="submit" class="btn btn-secondary px-5 py-2">
                                            <i class="fa fa-plus me-2"></i> {{ __('add_option') }}
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
