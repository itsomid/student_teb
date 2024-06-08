@extends('auth.layout.master')
@section('title','ورود به پنل ادمین')
@section('content')
    <div class="auth">
        <div class="auth-form">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-4 mt-2">
                <a href="" class="app-brand-link justify-content-center gap-2 ">
                    <img src="{{asset('assets/images/logos/logo_sec_horiz.png')}}" class="img-fluid w-50">
                </a>
            </div>
            <!-- /Logo -->
            <h4>
                ورود به قسمت ادمین کلاسینو
            </h4>
            @if (session('status'))
                <div class="alert alert-danger text-12" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <p class="login-guide">شماره موبایل و رمز عبور خود را وارد کنید</p>
            <form class="mb-3" action="{{route('login')}}" method="POST">
                @csrf
                <div>
                    <label for="username" class="form-label">شماره موبایل</label>
                    <input
                        type="text"
                        class="form-control"
                        id="username"
                        name="username"
                        placeholder="شماره موبایل"
                        autocomplete="username"
                        value="{{ $defaultUsername}}"
                        required
                        autofocus/>
                </div>
                {{--            @error('username')--}}
                {{--                <small class="text-danger">از درستی اطلاعات وارد شده مطمئن شده و دوباره امتحان کنید</small>--}}
                {{--            @enderror--}}
                <div class="my-3 form-password-toggle">
                    <label class="form-label" for="password" @class(['border-danger'=>$errors->has('password')])>
                        رمز عبور
                    </label>
                    <div class="input-group input-group-merge">

                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control"
                               value="{{ $defaultPassword}}"
                               placeholder="***********"
                               aria-describedby="password"/>
                        <span class="input-group-text cursor-pointer">
                             <i class="fa-light fa-eye-slash"></i>
                        </span>
                    </div>
                </div>

                <button class="btn btn-primary d-flex w-100 my-3 " type="submit">ورود</button>
            </form>
            <div class="forgot-pass">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me"/>
                    <label class="form-check-label" for="remember-me"> من رو به یاد داشته باش</label>
                </div>
            </div>
        </div>
    </div>
@endsection
