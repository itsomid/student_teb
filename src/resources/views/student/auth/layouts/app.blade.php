<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>شفا‌آموز | ورود به پنل کاربری</title>
    <link rel="stylesheet" href="{{asset('css/panel/panel.min.css')}}">
    @vite(['resources/assets/scss/student/auth.scss'])
    <style>
        .auth-layout-wrap.area {
            background-color: #eaeaea;
        }
        h1.mb-3.text-18 {
            text-align: center;
        }
        .help-block {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        .has-error {
            border: red solid 1px;
        }
    </style>
    @yield('css')
</head>
<body>
<div class="auth-layout-wrap-mobile">
    <div class="auth-content mobile">
        <div class="card o-hidden">
            @if(session()->has('danger_message'))
                <div class="alert auth-form alert-danger mb-0">
                    {!!  session()->get('danger_message')!!}
                    {{ session()->forget('danger_message') }}
                </div>
            @endif


            @if(session()->has('warning_message'))
                <div class="alert auth-form alert-warning mb-0">
                    {{ session()->get('warning_message') }}
                    {{ session()->forget('warning_message') }}
                </div>
            @endif

            @if(session()->has('success_message'))
                <div class="alert auth-form alert-success mb-0">
                    {{ session()->get('success_message') }}
                    {{ session()->forget('success_message') }}
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</div>

@yield('script')
</body>
</html>

