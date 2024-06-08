@extends('student.auth.layouts.app')
@section('content')
    <style>
        .font_size_18{
            font-size: 18px !important;
        }
        .font_size_16{
            font-size: 16px !important;
        }
        .font_size_14{
            font-size: 14px !important;
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="p-3 p-md-4">

                <h1 class="mb-3 text-18">ثبت نام</h1>
                <p class="text-center">نام و نام خانوادگی رو وارد کنید</p>
                <form method="post" action="{{route('student.auth.otp.register.post')}}">
                    @csrf
                    <div class="form-group text-center">
                        <input
                               class="form-control rtl form-control-rounded font_size_18"
                               type="text" name="name" value="" placeholder="نام و نام خوانوادگی">
                        @if($errors->has("name"))<small class="text-danger">{{$errors->first('name')}}</small>@endif
                    </div>


                    <p class="text-center mt-4">پایه ی تحصیلی خود را وارد کنید</p>
                    <div class="form-group text-center">
                        <select name="grade" class="form-control form-control-rounded font_size_18"  >
                            <option style="font-size: 14px" value="">انتخاب کنید</option>
                            <option {{old('grade') == '12'     ? 'selected' : ''}}  class="font_size_14"   value="12">دوازدهم</option>
                            <option {{old('grade') == '11'     ? 'selected' : ''}}  class="font_size_14"   value="11">یازدهم</option>
                            <option {{old('grade') == '10'     ? 'selected' : ''}}  class="font_size_14"   value="10">دهم</option>
                            <option {{old('grade') == '9'      ? 'selected' : ''}}  class="font_size_14"   value="9">نهم</option>
                            <option {{old('grade') == '8'      ? 'selected' : ''}}  class="font_size_14"   value="8">هشتم</option>
                            <option {{old('grade') == '7'      ? 'selected' : ''}}  class="font_size_14"   value="7">هفتم</option>
                            <option {{old('grade') == '6'      ? 'selected' : ''}}  class="font_size_14"   value="6">ششم</option>
                            <option {{old('grade') == '5'      ? 'selected' : ''}}  class="font_size_14"   value="5">پنجم</option>
                            <option {{old('grade') == '4'      ? 'selected' : ''}}  class="font_size_14"   value="4">چهارم</option>
                            <option {{old('grade') == '3'      ? 'selected' : ''}}  class="font_size_14"   value="3">سوم</option>
                            <option {{old('grade') == '2'      ? 'selected' : ''}}  class="font_size_14"   value="2">دوم</option>
                            <option {{old('grade') == '1'      ? 'selected' : ''}}  class="font_size_14"   value="1">اول</option>
                            <option {{old('grade') == '13'     ? 'selected' : ''}}  class="font_size_14"   value="13">فارغ التحصیل</option>
                        </select>
                        @if($errors->has("grade"))<small class="text-danger">{{$errors->first('grade')}}</small>@endif
                    </div>

                    <p class="text-center mt-4">رشته ی تحصیلی خود را وارد کنید</p>
                    <div class="form-group text-center">
                        <select name="field_of_study" class="form-control form-control-rounded mb-4 font_size_18" >
                            <option  class="font_size_14" value="">انتخاب کنید</option>
                            <option {{old('grade') == '5'     ? 'selected' : ''}}   class="font_size_14" value="5">هنوز رشته انتخاب نکردم</option>
                            <option {{old('grade') == '1'     ? 'selected' : ''}}   class="font_size_14" value="1">تجربی</option>
                            <option {{old('grade') == '2'     ? 'selected' : ''}}   class="font_size_14" value="2">ریاضی</option>
                            <option {{old('grade') == '3'     ? 'selected' : ''}}   class="font_size_14" value="3"> انسانی</option>
                            <option {{old('grade') == '4'     ? 'selected' : ''}}   class="font_size_14" value="4"> هنر</option>
                        </select>
                        @if($errors->has("field_of_study"))<small class="text-danger">{{$errors->first('field_of_study')}}</small>@endif
                    </div>

                    <button type="submit" class="btn btn-rounded btn-primary btn-block mt-4">ادامه</button>
                </form>

            </div>
        </div>

    </div>
@endsection

