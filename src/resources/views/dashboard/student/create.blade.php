@extends('dashboard.layout.master')
@section('title', 'افزودن دانش آموز جدید')
@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">فرم افزودن دانش آموز</h5>
            <form action="{{route('admin.student.store')}}" method="post">
                @csrf
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">نام و نام خانوادگی</label>
                            <input name="name"
                                   id="name"
                                   class="form-control"
                                   placeholder="نام را وارد کنید."
                                   value="{{old('name')}}"
                                   required>

                            @error('name')
                            <small class="text-danger">danger</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name_english">نام و نام خانوادگی (انگلیسی) (در کلاس نمایش داده میشود):</label>
                            <input name="name_english" id="name_english" class="form-control"
                                   placeholder="نام انگلیسی را وارد کنید." required>
                            @error('name_english')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">

                            <label for="mobile" class="form-label">شماره تماس</label>
                            <input name="mobile" id="mobile"
                                   @class(['form-control','is-invalid' => $errors->has('mobile')])
                                   placeholder="شماره تماس را وارد کنید."
                                   value="{{old('mobile')}}">

                            @error('mobile')
                                <small class="text-danger">{{$message}}</small>
                            @enderror

                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="province">استان</label>
                            <select class="select2 form-select" name="province" id="province"
                                    onChange="iranwebsv(this.value);">
                                <option value="0">لطفا استان را انتخاب نمایید</option>
                                <option value="1">تهران</option>
                                <option value="2">گیلان</option>
                                <option value="3">آذربایجان شرقی</option>
                                <option value="4">خوزستان</option>
                                <option value="5">فارس</option>
                                <option value="6">اصفهان</option>
                                <option value="7">خراسان رضوی</option>
                                <option value="8">قزوین</option>
                                <option value="9">سمنان</option>
                                <option value="10">قم</option>
                                <option value="11">مرکزی</option>
                                <option value="12">زنجان</option>
                                <option value="13">مازندران</option>
                                <option value="14">گلستان</option>
                                <option value="15">اردبیل</option>
                                <option value="16">آذربایجان غربی</option>
                                <option value="17">همدان</option>
                                <option value="18">کردستان</option>
                                <option value="19">کرمانشاه</option>
                                <option value="20">لرستان</option>
                                <option value="21">بوشهر</option>
                                <option value="22">کرمان</option>
                                <option value="23">هرمزگان</option>
                                <option value="24">چهارمحال و بختیاری</option>
                                <option value="25">یزد</option>
                                <option value="26">سیستان و بلوچستان</option>
                                <option value="27">ایلام</option>
                                <option value="28">کهگلویه و بویراحمد</option>
                                <option value="29">خراسان شمالی</option>
                                <option value="30">خراسان جنوبی</option>
                                <option value="31">البرز</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="city">شهر</label>
                            <select class="select2 form-select" id="city" name="city">
                                <option value="0">لطفا شهر را انتخاب نمایید</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="field_of_study">رشته تحصیلی :</label>
                            <select id="field_of_study" name="field_of_study"
                                    class="form-select text-capitalize mb-md-0 ">
                                @foreach(\App\Data\FieldOfStudy::get() as $key=>$field_of_study)
                                    <option value="{{$key}}" {{old('field_of_study') == $key ? 'selected' : ''}}>
                                        {{$field_of_study}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="verified">وضعیت کاربری:</label>
                            <select id="verified" name="verified" class="form-select text-capitalize mb-md-0 ">
                                <option value="1" selected>تایید شده</option>
                                <option value="0">تایید نشود</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">

                            <label class="form-label" for="familiarity_way">نحوه آشنایی با کلاسینو :</label>
                            <select id="familiarity_way" class="form-select text-capitalize mb-md-0 ">
                                @foreach(\App\Data\FamiliarityWays::get() as $key=>$way)
                                    <option value="{{$key}}" {{old('familiarity_way') == $key ? 'selected' : null}}>
                                        {{$way}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="form-label" for="sale_support_id">پشتیبان</label>
                        <select id="sale_support_id" name="sale_support_id" class="select2 form-select form-select-lg" data-allow-clear="true" data-placeholder="لطفا پشتیبان اننتخاب کنید">
                            <option></option>
                            @foreach($sales_support as $admin)
                                <option value="{{$admin->id}}" {{auth()->user()->id == $admin->id ? 'selected' : null }}>
                                    {{$admin->fullname()}} | {{$admin->mobile}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="password">کلمه ی عبور</label>
                            <input type="text"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   placeholder="کلمه ی عبور"
                                   value="{{old('password') ?? 12345678}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="description">توضیحات</label>
                            <textarea class="form-control" name="description" id="description"
                                      rows="3">{{old('description')}}</textarea>
                        </div>
                    </div>


                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="block">وضعیت دسترسی به پنل:</label>
                            <select id="block" name="block" class="form-select text-capitalize mb-md-0 ">
                                <option {{ old('block') == 0 ? 'selected' : '' }} value="0" selected="selected">دسترسی
                                    باز است
                                </option>
                                <option {{ old('block') == 1 ? 'selected' : '' }} value="1">بلاک کاربر</option>
                                <option {{ old('block') == 2 ? 'selected' : '' }} value="2">آزاد با مشروطیت</option>
                                <option {{ old('block') == 4 ? 'selected' : '' }} value="4">حذف اکانت</option>
                                <option {{ old('block') == 5 ? 'selected' : '' }} value="5">عدم دسترسی به کلاس های
                                    زنده
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="gender">جنسیت:</label>
                            <select id="gender" name="gender" class="form-select text-capitalize mb-md-0 ">
                                <option  value="female">دختر</option>
                                <option  value="male" selected>پسر</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class=" d-flex justify-content-center mt-3">
                    <div class="col-md-1">
                        <button class="btn btn-primary w-100">
                            <i class="fa fa-save mx-2"></i>
                            ذخیره
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/vendor/js/forms-selects.js',
            'resources/assets/js/city.js'
          ])

@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            iranwebsv(0);
        });
    </script>
@endsection
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection
