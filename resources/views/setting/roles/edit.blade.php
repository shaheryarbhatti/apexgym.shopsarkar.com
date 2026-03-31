<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ __('edit_role') }}</title>

    @extends('layouts.app')

    @section('content')
    @php
        $user = auth()->user();
        $isSuper = $user && strtolower((string) $user->email) === 'test@example.com';
    @endphp
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
                                                @php
                                                    $basePermission = explode('.', $option->permission)[0] ?? $option->permission;
                                                @endphp
                                                 @if($user->email == 'test@example.com' && $option->permission == 'sidebar-management')
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
                                                <div class="d-flex flex-wrap gap-2 ms-4 mb-3">
                                                    <label class="form-check small d-flex align-items-center gap-2">
                                                        <input class="form-check-input action-checkbox" type="checkbox"
                                                            name="permissions[]" value="{{ $basePermission }}.view"
                                                            {{ in_array($basePermission . '.view', $rolePermissions) ? 'checked' : '' }}>
                                                        <span>{{ __('permission_view') }}</span>
                                                    </label>
                                                    <label class="form-check small d-flex align-items-center gap-2">
                                                        <input class="form-check-input action-checkbox" type="checkbox"
                                                            name="permissions[]" value="{{ $basePermission }}.add"
                                                            {{ in_array($basePermission . '.add', $rolePermissions) ? 'checked' : '' }}>
                                                        <span>{{ __('permission_add') }}</span>
                                                    </label>
                                                    <label class="form-check small d-flex align-items-center gap-2">
                                                        <input class="form-check-input action-checkbox" type="checkbox"
                                                            name="permissions[]" value="{{ $basePermission }}.edit"
                                                            {{ in_array($basePermission . '.edit', $rolePermissions) ? 'checked' : '' }}>
                                                        <span>{{ __('permission_edit') }}</span>
                                                    </label>
                                                    <label class="form-check small d-flex align-items-center gap-2">
                                                        <input class="form-check-input action-checkbox" type="checkbox"
                                                            name="permissions[]" value="{{ $basePermission }}.delete"
                                                            {{ in_array($basePermission . '.delete', $rolePermissions) ? 'checked' : '' }}>
                                                        <span>{{ __('permission_delete') }}</span>
                                                    </label>
                                                </div>
                                                @else
                                                @if($option->permission != 'sidebar-management')
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
                                                <div class="d-flex flex-wrap gap-2 ms-4 mb-3">
                                                    <label class="form-check small d-flex align-items-center gap-2">
                                                        <input class="form-check-input action-checkbox" type="checkbox"
                                                            name="permissions[]" value="{{ $basePermission }}.view"
                                                            {{ in_array($basePermission . '.view', $rolePermissions) ? 'checked' : '' }}>
                                                        <span>{{ __('permission_view') }}</span>
                                                    </label>
                                                    <label class="form-check small d-flex align-items-center gap-2">
                                                        <input class="form-check-input action-checkbox" type="checkbox"
                                                            name="permissions[]" value="{{ $basePermission }}.add"
                                                            {{ in_array($basePermission . '.add', $rolePermissions) ? 'checked' : '' }}>
                                                        <span>{{ __('permission_add') }}</span>
                                                    </label>
                                                    <label class="form-check small d-flex align-items-center gap-2">
                                                        <input class="form-check-input action-checkbox" type="checkbox"
                                                            name="permissions[]" value="{{ $basePermission }}.edit"
                                                            {{ in_array($basePermission . '.edit', $rolePermissions) ? 'checked' : '' }}>
                                                        <span>{{ __('permission_edit') }}</span>
                                                    </label>
                                                    <label class="form-check small d-flex align-items-center gap-2">
                                                        <input class="form-check-input action-checkbox" type="checkbox"
                                                            name="permissions[]" value="{{ $basePermission }}.delete"
                                                            {{ in_array($basePermission . '.delete', $rolePermissions) ? 'checked' : '' }}>
                                                        <span>{{ __('permission_delete') }}</span>
                                                    </label>
                                                </div>
                                                @endif
                                                @endif
                                                @endforeach
                                            </div>

                                            @if($module->permission === 'members')
                                                <div class="mt-3 pt-3 border-top">
                                                    <div class="text-muted small fw-semibold mb-2">{{ __('member_actions') }}</div>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <label class="form-check small d-flex align-items-center gap-2">
                                                            <input class="form-check-input action-checkbox" type="checkbox"
                                                                name="permissions[]" value="members.renew"
                                                                {{ in_array('members.renew', $rolePermissions) ? 'checked' : '' }}>
                                                            <span>{{ __('permission_renew_membership') }}</span>
                                                        </label>
                                                        <label class="form-check small d-flex align-items-center gap-2">
                                                            <input class="form-check-input action-checkbox" type="checkbox"
                                                                name="permissions[]" value="members.add_trainer_invoice"
                                                                {{ in_array('members.add_trainer_invoice', $rolePermissions) ? 'checked' : '' }}>
                                                            <span>{{ __('permission_add_trainer_invoice') }}</span>
                                                        </label>
                                                        <label class="form-check small d-flex align-items-center gap-2">
                                                            <input class="form-check-input action-checkbox" type="checkbox"
                                                                name="permissions[]" value="members.add_visit_invoice"
                                                                {{ in_array('members.add_visit_invoice', $rolePermissions) ? 'checked' : '' }}>
                                                            <span>{{ __('permission_add_visit_invoice') }}</span>
                                                        </label>
                                                        <label class="form-check small d-flex align-items-center gap-2">
                                                            <input class="form-check-input action-checkbox" type="checkbox"
                                                                name="permissions[]" value="members.send_expiry_email"
                                                                {{ in_array('members.send_expiry_email', $rolePermissions) ? 'checked' : '' }}>
                                                            <span>{{ __('permission_send_expiry_email') }}</span>
                                                        </label>
                                                        <label class="form-check small d-flex align-items-center gap-2">
                                                            <input class="form-check-input action-checkbox" type="checkbox"
                                                                name="permissions[]" value="members.download_card"
                                                                {{ in_array('members.download_card', $rolePermissions) ? 'checked' : '' }}>
                                                            <span>{{ __('permission_download_card') }}</span>
                                                        </label>
                                                        <label class="form-check small d-flex align-items-center gap-2">
                                                            <input class="form-check-input action-checkbox" type="checkbox"
                                                                name="permissions[]" value="members.freeze"
                                                                {{ in_array('members.freeze', $rolePermissions) ? 'checked' : '' }}>
                                                            <span>{{ __('permission_freeze_membership') }}</span>
                                                        </label>
                                                        <label class="form-check small d-flex align-items-center gap-2">
                                                            <input class="form-check-input action-checkbox" type="checkbox"
                                                                name="permissions[]" value="members.export"
                                                                {{ in_array('members.export', $rolePermissions) ? 'checked' : '' }}>
                                                            <span>{{ __('permission_export_members') }}</span>
                                                        </label>
                                                        <label class="form-check small d-flex align-items-center gap-2">
                                                            <input class="form-check-input action-checkbox" type="checkbox"
                                                                name="permissions[]" value="members.documentation"
                                                                {{ in_array('members.documentation', $rolePermissions) ? 'checked' : '' }}>
                                                            <span>{{ __('permission_system_documentation') }}</span>
                                                        </label>
                                                        <label class="form-check small d-flex align-items-center gap-2">
                                                            <input class="form-check-input action-checkbox" type="checkbox"
                                                                name="permissions[]" value="members.delete_all"
                                                                {{ in_array('members.delete_all', $rolePermissions) ? 'checked' : '' }}>
                                                            <span>{{ __('permission_delete_all_members') }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($module->permission === 'trainers')
                                                <div class="mt-3 pt-3 border-top">
                                                    <div class="text-muted small fw-semibold mb-2">{{ __('trainer_actions') }}</div>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <label class="form-check small d-flex align-items-center gap-2">
                                                            <input class="form-check-input action-checkbox" type="checkbox"
                                                                name="permissions[]" value="trainers.delete_all"
                                                                {{ in_array('trainers.delete_all', $rolePermissions) ? 'checked' : '' }}>
                                                            <span>{{ __('permission_delete_all_trainers') }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
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
            $(this).closest('.permission-block').find('.option-checkbox, .action-checkbox').prop('checked', $(this).is(
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
