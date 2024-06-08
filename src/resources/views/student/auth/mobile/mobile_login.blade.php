@extends('student.auth.layouts.app')
@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <div class="py-5 px-4">
                        <h1 class="mb-4 text-center text-25">
                            <img  src="{{asset('assets/images/logos/logo_main_horiz.png')}}" class="img-fluid w-40" >
                        </h1>
                        <h2 class="mb-3 text-right text-20 font-weight-700">
                            ورود | ثبت نام
                        </h2>
                        <p class="sub-heading text-right mb-2">سلام!</p>
                        <p class="sub-heading text-right">لطفا شماره موبایل خود را وارد کنید</p>
                        <form method="post" class="mb-3" action="{{route('student.auth.otp.login.post')}}">
                            @csrf
                            @if(!$errors->has('403'))
                                <div class="form-group">
                                    <input id="mobile"
                                           class="form-control form-control {{ $errors->has('mobile') ? ' has-error' : 'm-b-20'}} mb-4"
                                           type="text"
                                           name="mobile"
                                           value=""
                                           onkeypress="validate(event)"
                                           autofocus>
                                </div>
                                @if(isset($referrer))
                                    <p class="text-center text-success">
                                        معرف شما :
                                        {{$referrer->admin->fullname()}}
                                    </p>
                                    <input type="hidden" name="referrer" value="{{$referrer->id}}">
                                @endif
                                @if ($errors->has('mobile'))
                                    <div class="help-block m-b-20">
                                        {{ $errors->first('mobile') }}
                                    </div>
                               @endif
                                <button class="btn btn-continue btn-primary btn-block mt-4">
                                    <img src="{{asset('images/panel/icon/arrow-left-solid.svg')}}">
                                    ادامه
                                </button>
                            @endif
                        </form>
                        <p class="text-10 text-center mb-0">ورود شما به معنای پذیرش شرایط کلاسینو وقوانین حریم‌خصوصی است</p>
{{--                        @if(! $errors->has('403'))--}}
{{--                            <div class="text-center mt-3">--}}
{{--                                <a href="{{route('login.with_password')}}" class="change-login-method">ورود با رمز عبور</a>--}}
{{--                            </div>--}}
{{--                        @endif--}}

                        @if(session()->has('message'))
                            <p class="mt-3 form-error text-center">{!! session('message') !!}</p>
                        @endif
                    </div>
                </div>

            </div>
@endsection
@section('script')
    @if ($errors->has('403'))
        <script>
            setTimeout(() => {
                window.location = ""
            }, 3000);
        </script>

    @endif
    <script>
        function validate(evt) {
            var theEvent = evt || window.event;

            if (evt.which === 13)
            {
                var mobileInputValue = document.getElementById("mobile").value;
                if (mobileInputValue && mobileInputValue.length === 11){
                   // console.log(mobileInputValue)
                    $('form').submit();
                    return false
                }
                else {
                    alert('شماره موبایل ۱۱ رقم باید باشد')
                }
            }
            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
                // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    </script>
@endsection

