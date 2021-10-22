{{--
    Login screen (non-API).
    Extends from `next.base`.
--}}

@extends('next.base', [
    'title' => 'Login'
])

@push('scripts')
    @vite('login.ts')
@endpush

@section('app')
    <div id="app_login">
        <div id="login_panel" class="light">
            <a href="/" title="{{ __('frame.GOTO_HOME_PAGE') }}">
                <img src="/files--static/media/logo.min.svg">
            </a>
            <hr>
            <div id="login_form_container">
            </div>
            <a id="login_create_account" href="/user-services/register">
                {{ __("account_panel.CREATE_ACCOUNT") }}
            </a>
        </div>
    </div>
@endsection
