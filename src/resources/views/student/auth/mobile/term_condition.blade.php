@extends('student.auth.layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="p-3 p-md-4">

                <h1 class="mb-3 text-18">شرایط و قوانین</h1>
                <div class="term-condition">
                    @include('student.auth.policy_text')
                </div>
                <div class="term-condition-btns">
                    <button  class="btn btn-rounded btn-primary btn-block mt-4" id="agree">
                        <span>قبول دارم و ادامه</span>
                    </button>
                    <a type="submit" class="btn btn-rounded btn-gray btn-block mt-4 mr-2" href="{{route('student.auth.show-login-form')}}">قبول ندارم</a>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
        document.getElementById('agree').addEventListener('click',function (){
        const agreeBtn = $('#agree')
        var url = '{{route('student.auth.otp.termCondition.agree')}}';

        agreeBtn.addClass('btn-loading')
        agreeBtn.find('span').css('visibility','hidden')
        agreeBtn.prop('disabled', true);
        $.ajax({
            type: 'get',
            url: url,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                utm_ma: localStorage.getItem('utm_ma')
            },

            success: function (response) {
                console.log(response)
                localStorage.removeItem('utm_ma');
                location.href = response.redirect_url
            },
            error: function (e) {
                console.log(e?.responseText);
                location.href = '{{route('student.dashboard')}}'
            }
        });
    })


</script>


@endsection

