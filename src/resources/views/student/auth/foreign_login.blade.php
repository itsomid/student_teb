@extends('website.auth.layouts.app')
@section('content')

            <div class="row">
                @if(!$errors->has('403'))
                    <div class="col-lg-6">
                        <div class="p-3 p-md-4">
                            <div class="auth-logo text-center mb-4">
                                <a href="{{url('/')}}">
                                    <img src="" alt="">
                                </a>
                            </div>
                            <h1 class="mb-3 text-18">ورود کاربران</h1>

                            <form method="post" action="{{ route('foreignLoginPost') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="mobile">شماره موبایل (یا نام کاربری)</label>
                                    <input id="mobile"
                                           class="form-control form-control-rounded {{ $errors->has('mobile') ? ' has-error' : 'm-b-20'}}"
                                           type="text" name="mobile" value="{{ old('mobile') }}" placeholder="شماره موبایل">
                                </div>
                                @if ($errors->has('mobile'))
                                    <div class="help-block m-b-20">
                                        {{ $errors->first('mobile') }}
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="password">رمزعبور</label>
                                    <input id="password"
                                           class="form-control form-control-rounded {{ $errors->has('password') ? ' has-error' : 'm-b-20'}}"
                                           name="password" type="password" placeholder="رمز عبور">
                                </div>
                                @if ($errors->has('password'))
                                    <div class="help-block m-b-20">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif

                                <div class="form-group">
                                    <div class="mb-2 mt-3" style="text-align: center;">{{captcha_img()}}</div>
                                    <input id="captcha"
                                           class="form-control form-control-rounded {{ $errors->has('captcha') ? ' has-error' : 'm-b-20'}}"
                                           name="captcha" type="captcha" placeholder="متن درون تصویر را وارد کنید">
                                </div>
                                @if ($errors->has('captcha'))
                                    <div class="help-block m-b-20">
                                        {{ $errors->first('captcha') }}
                                    </div>
                                @endif


                                <div class="form-group">
                                    <label for="2fa">
                                        کد تایید دو مرحله ای دارید؟
                                        <br>
                                        <small >
                                            (درصورت فعال نبودن تایید دو مرحله ای، فیلد زیر را خالی بگذارید.)
                                        </small>
                                    </label>
                                    <input id="2fa"
                                           class="form-control form-control-rounded {{ $errors->has('2fa') ? ' has-error' : 'm-b-20'}}"
                                           name="2fa" type="text" placeholder="کد تایید دو مرحله ای">
                                </div>

                                @if ($errors->has('2fa'))
                                    <div class="help-block m-b-20">
                                        {{ $errors->first('2fa') }}
                                    </div>
                                @endif


                                <button class="btn btn-rounded btn-primary btn-block mt-4">ورود</button>
                            </form>
                            <div class="text-center mt-3">
                                <a href="{{route('otp.login')}}" class="change-login-method"> ورود با رمز یک‌بار مصرف</a>
                            </div>

                        </div>
                    </div>
                @else
                    <div class="col-lg-6">
                        <div class="p-3 p-md-4">
                            <div class="auth-logo text-center mb-4">
                                <a href="{{url('/')}}">
                                    <img src="" alt="">
                                </a>
                            </div>
                            <h1 class="mb-3 text-18">ورود کاربران</h1>
                            <br><br>
                            <div class="alert alert-danger text-center">
                                <a>
                                    {{ $errors->first('403') }}
                                </a>
                                <br>
                                <a  href="https://student.com">
                                    جهت ورود از مسیر
                                    <span class="border-bottom border-dark">student.com</span>
                                    اقدام کنید
                                </a>
                            </div>
                            <br><br><br><br>
                            <div class="text-center mt-3">
                                <a href="{{route('otp.login')}}" class="change-login-method"> ورود با رمز یک‌بار مصرف</a>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-lg-6 text-center"
                     style="background-size: cover;background-image: url({{asset('/images/website/background/Login-Back.jpg')}})">
                    <div class="pr-3 auth-right">
                        <div class="alert alert-danger rounded text-right" role="alert">
                            در صورتیکه رمز عبور ندارید ، ابتدا از طریق "ورود با رمز یکبار مصرف" (ورود با SMS) وارد پنل کاربری خود شوید سپس به قسمت "ویرایش پروفایل" بروید و در انجا میتوانید برای خود رمز عبور تعیین کنید.
                        </div>
                        <a href="tel:45435345"
                           class="btn  btn-outline-primary btn-block btn-icon-text btn-outline-facebook">
                        </a>

                    </div>
                </div>
            </div>
@endsection

