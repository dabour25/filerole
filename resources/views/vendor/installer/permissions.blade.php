@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('roles') }}
@endsection

@section('title')
    {{ trans('roles') }}
@endsection

@section('container')

    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
    </div>
    <br>
    <ul class="list-group">
        @foreach($permissions['roles'] as $permission)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $permission['folder'] }}
            <span>
                <i class="far fa-{{ $permission['isSet'] ? 'check-circle text-success' : 'times-circle text-danger' }}"></i>
                {{ $permission['permission'] }}
            </span>
        </li>
        @endforeach
    </ul>

    @if ( ! isset($permissions['errors']))
        <br>
        <div class="text-center">
            <a href="{{ route('LaravelInstaller::verifyPurchase') }}" class="btn btn-primary btn-lg">
                {{ trans('roles') }}
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
        </div>
    @endif

@endsection
