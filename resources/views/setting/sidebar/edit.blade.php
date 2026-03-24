@extends('layouts.app')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="row">

            <div class="col-xl-12">
                <div class="card" style="margin-top: 20px; {{ isset($editOption) ? 'opacity: 0.5;' : '' }}">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('edit_sidebar_module') }}</h4>
                        <a href="{{ route('sidebar.index') }}" class="btn btn-light btn-sm">{{ __('back_to_list') }}</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ isset($editModule) ? route('sidebar.module.update', $editModule->id) : '#' }}" class="theme-form">
                            @csrf
                            @method('PUT')
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="mod_title">{{ __('module_title_key') }}</label>
                                    <input type="text" name="title" id="mod_title" class="form-control" 
                                        value="{{ old('title', $editModule->title ?? '') }}" {{ isset($editOption) ? 'disabled' : 'required' }}>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label" for="icon">{{ __('icon_class') }}</label>
                                    <input type="text" name="icon" id="icon" class="form-control" 
                                        value="{{ old('icon', $editModule->icon ?? '') }}" {{ isset($editOption) ? 'disabled' : 'required' }}>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label" for="mod_permission">{{ __('master_permission') }}</label>
                                    <input type="text" name="permission" id="mod_permission" class="form-control" 
                                        value="{{ old('permission', $editModule->permission ?? '') }}" {{ isset($editOption) ? 'disabled' : 'required' }}>
                                </div>

                                <div class="col-12 text-end mt-4">
                                    <button type="submit" class="btn btn-primary px-5 py-2" {{ isset($editOption) ? 'disabled' : '' }}>
                                        <i class="fa fa-save me-2"></i> {{ __('update_module') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card" style="margin-top: 20px; {{ isset($editModule) ? 'opacity: 0.5;' : '' }}">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('edit_module_option') }}</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ isset($editOption) ? route('sidebar.option.update', $editOption->id) : '#' }}" class="theme-form">
                            @csrf
                            @method('PUT')
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="col-form-label">{{ __('select_parent_module') }}</label>
                                    <select name="sidebar_module_id" class="form-select" {{ isset($editModule) ? 'disabled' : 'required' }}>
                                        @foreach($modules as $mod)
                                            <option value="{{ $mod->id }}" {{ (isset($editOption) && $editOption->sidebar_module_id == $mod->id) ? 'selected' : '' }}>
                                                {{ __($mod->title) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label" for="opt_title">{{ __('option_title') }}</label>
                                    <input type="text" name="title" id="opt_title" class="form-control" 
                                        value="{{ old('title', $editOption->title ?? '') }}" {{ isset($editModule) ? 'disabled' : 'required' }}>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label" for="route">{{ __('route_name') }}</label>
                                    <input type="text" name="route" id="route" class="form-control" 
                                        value="{{ old('route', $editOption->route ?? '') }}" {{ isset($editModule) ? 'disabled' : 'required' }}>
                                </div>

                                <div class="col-md-12">
                                    <label class="col-form-label" for="opt_permission">{{ __('specific_permission') }}</label>
                                    <input type="text" name="permission" id="opt_permission" class="form-control" 
                                        value="{{ old('permission', $editOption->permission ?? '') }}" {{ isset($editModule) ? 'disabled' : 'required' }}>
                                </div>

                                <div class="col-12 text-end mt-4">
                                    <button type="submit" class="btn btn-secondary px-5 py-2" {{ isset($editModule) ? 'disabled' : '' }}>
                                        <i class="fa fa-save me-2"></i> {{ __('update_option') }}
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