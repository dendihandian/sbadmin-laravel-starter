@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Roles Management') }}</h1>
        <a class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" href="{{ route('admin.roles.index') }}">{{ __('Back to List') }}</a>
    </div>

    @include('admin._components.flash')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Create Role') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                @include('admin.roles._partials.form')
                @include('admin.roles._partials.form-permissions')
                <div class="row">
                    <div class="form-group col-lg-12 d-flex justify-content-end">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary text-white ml-1">{{ __('Back') }}</a>
                        <button class="btn btn-primary ml-1">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection