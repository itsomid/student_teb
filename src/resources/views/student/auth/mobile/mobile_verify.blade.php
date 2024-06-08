@extends('student.auth.layouts.app')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="px-3 py-4 p-md-4">
                <a href="{{ route('student.auth.show-login-form') }}" class="edit-phone-number">
                    <i class="fa-regular fa-arrow-right"></i>
                </a>
                <h2 class="mt-1 text-center text-25 mb-4">
                    <img src="{{asset('assets/images/logos/logo_main_horiz.png')}}" class="img-fluid w-40">
                </h2>
                <h2 class="my-3  text-right text-18">کد تایید را وارد کنید.</h2>

                <p class="sub-heading text-right">کد تایید برای شماره<span> {{ $mobile }} </span> ارسال شد.</p>


                <form action="{{route('student.auth.otp.verify.post')}}" id="otp-form" method="POST" class="digit-group" autocomplete="off">
                    @csrf
                    <input type="hidden" name="mobile" value="{{ $mobile }}">

                    <input type="tel" maxlength="5" name="otp" id="otp" required autofocus>
{{--                    <input type="tel" maxlength="5" name="otp" id="otp" required autofocus>--}}
                    @if(session('error'))
                        <div class="error">{{session('error')}}</div>
                    @endif

                    <button id="mobile-verify-btn" class="btn btn-rounded btn-primary btn-block mt-4">
                        <span>ورود</span>
                    </button>
                </form>
                <div id="timerContainer" class="timer-container">
                    <span id="timer"></span>
                    <span>تا درخواست ارسال مجدد کد</span>
                </div>
                <div id="sendSmsAgain" class="send-sms-again" style="display: none">
                        <span>
                               کد فعال‌سازی را دریافت نکرده‌‌اید؟
                        </span>

                    <a href="{{route('student.auth.otp.verify', ['mobile' => $mobile])}}">
                        ارسال مجدد
                        <svg width="16" height="16" color="inherit" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0 12.008v-.027c0-.167.06-.414.178-.742a1.714 1.714 0 013.16.21c.061.242.091.422.09.54v.034a8.503 8.503 0 002.511 6.053c3.347 3.339 8.775 3.339 12.122 0a8.534 8.534 0 000-12.091C15.107 3.039 10.534 2.692 7.2 4.945l1.942 1.938a.853.853 0 01-.606 1.46h-6.65a.856.856 0 01-.857-.856V.855A.856.856 0 012.493.25l2.25 2.245C9.447-1.075 16.19-.718 20.485 3.567c4.687 4.674 4.687 12.253 0 16.927-4.686 4.675-12.284 4.675-16.97 0A11.917 11.917 0 010 12.008z"
                                fill="currentColor" fill-rule="nonzero"></path>
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        document.getElementById('otp').addEventListener('input', function() {
            if (this.value.length === 5) {
                const verifyBtn = document.getElementById('mobile-verify-btn');
                verifyBtn.setAttribute('disabled', 'disabled');
                verifyBtn.classList.add('btn-loading');
                verifyBtn.querySelector('span').style.visibility = 'hidden';
                document.getElementById('otp-form').submit();
            }
        });
    </script>

    <script type="text/javascript">
        // Set the date we're counting down to


        var my_date = new Date();
        my_date.setSeconds(my_date.getSeconds() + {!! $wait_seconds_to_send_sms !!});
        var countDownDate = my_date.getTime();

        // Update the count down every 1 second
        var x = setInterval(function () {

            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now an the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            // var text_result_timer = " زمان انتظار ";
            var text_result_timer = "";
            if (days > 0) {
                text_result_timer += days + " روز ";
            }
            if (hours > 0) {
                text_result_timer += hours + ":";
            }
            if (minutes > 0) {
                text_result_timer += minutes + ":";
                text_result_timer += seconds + " ثانیه";
            } else {
                if (seconds > 0) {
                    text_result_timer += seconds + " ثانیه";
                }
            }


            document.getElementById("timer").innerHTML = text_result_timer; // changes tne button text
            // If the count down is finished, write some text

            if (distance < 0) {

                clearInterval(x);
                document.getElementById("timerContainer").style.display = "none";
                document.getElementById("sendSmsAgain").removeAttribute('style');
            }
        }, 1000);


    </script>

@endsection

