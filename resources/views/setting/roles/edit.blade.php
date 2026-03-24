<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sky Fitness Gym – premium gym portal.">
    <meta name="author" content="skyfitnessgym.com">

    <title>{{ __('edit_role') }}</title>

    @extends('layouts.app')

    @section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card" style="margin-top: 20px;">

                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __('edit_role') }}</h4>
                            <a href="{{ route('roles.manage') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-arrow-left me-2"></i> {{ __('back_to_list') }}
                            </a>
                        </div>

                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row mb-5 border-bottom pb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold" for="role_name">{{ __('role_name') }}</label>
                                        <input type="text" name="name" id="role_name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $role->name) }}" required>
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <h5 class="mb-4 text-secondary"><i
                                        class="fa fa-shield me-2"></i>{{ __('update_sidebar_permissions') }}</h5>

                                <div class="row g-4">
                                    @foreach($modules as $module)
                                    <div class="col-xl-4 col-lg-6">
                                        <div class="permission-block border rounded p-3 bg-light-subtle">
                                            <div
                                                class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                                <span class="fw-bold text-primary">
                                                    <i class="fa {{ $module->icon }} me-2"></i>{{ __($module->title) }}
                                                </span>
                                                <div class="form-check form-switch mb-0">
                                                    <input class="form-check-input check-all-module" type="checkbox"
                                                        name="permissions[]" value="{{ $module->permission }}"
                                                        {{ in_array($module->permission, $rolePermissions) ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="ps-3 mt-3">
                                                @foreach($module->options as $option)
                                                <div
                                                    class="form-check d-flex justify-content-between align-items-center mb-2">
                                                    <label class="form-check-label small" for="opt_{{ $option->id }}">
                                                        {{ __($option->title) }}
                                                    </label>
                                                    <input class="form-check-input option-checkbox" type="checkbox"
                                                        name="permissions[]" value="{{ $option->permission }}"
                                                        id="opt_{{ $option->id }}"
                                                        {{ in_array($option->permission, $rolePermissions) ? 'checked' : '' }}>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card-footer text-end bg-light">
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="fa fa-refresh me-2"></i> {{ __('update_role_permissions') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Toggle all sub-options when module header is clicked
        $('.check-all-module').on('change', function() {
            $(this).closest('.permission-block').find('.option-checkbox').prop('checked', $(this).is(
                ':checked'));
        });

        // Uncheck module header if any sub-option is unchecked
        $('.option-checkbox').on('change', function() {
            let block = $(this).closest('.permission-block');
            if (!$(this).is(':checked')) {
                block.find('.check-all-module').prop('checked', false);
            }
        });
    });
    </script>
    @endsection

