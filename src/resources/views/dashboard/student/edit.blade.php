@extends('dashboard.layout.master')
@section('title', 'ویرایش دانش آموز ')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">فرم ویرایش دانش آموز</h5>
            <form action="{{route('admin.student.update',['student' => $student->id])}}" method="post">
                @csrf
                @method('PATCH')
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">نام و نام خانوادگی</label>
                            <input name="name"
                                   id="name"
                                   class="form-control"
                                   placeholder="نام را وارد کنید."
                                   value="{{$student->name}}"
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
                                   value="{{$student->name_english}}"
                                   placeholder="نام انگلیسی را وارد کنید." required>
                            @error('name_english')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="mobile">شماره تماس</label>
                            <input name="mobile"
                                   id="mobile"
                                   class="form-control"
                                   placeholder="شماره تماس را وارد کنید."
                                   value="{{$student->mobile}}"
                                   disabled
                            >
                            @error('mobile')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="province">استان</label>
                            <select class="select2 form-select" name="province" id="province"
                                    onChange="iranwebsv(this.value);">
                                <option {{$student->province == 0  ? 'selected' : null}} value="0">لطفا استان را انتخاب
                                    نمایید
                                </option>
                                <option {{$student->province == 1  ? 'selected' : null}} value="1">تهران</option>
                                <option {{$student->province == 2  ? 'selected' : null}} value="2">گیلان</option>
                                <option {{$student->province == 3  ? 'selected' : null}} value="3">آذربایجان شرقی
                                </option>
                                <option {{$student->province == 4  ? 'selected' : null}} value="4">خوزستان</option>
                                <option {{$student->province == 5  ? 'selected' : null}} value="5">فارس</option>
                                <option {{$student->province == 6  ? 'selected' : null}} value="6">اصفهان</option>
                                <option {{$student->province == 7  ? 'selected' : null}} value="7">خراسان رضوی</option>
                                <option {{$student->province == 8  ? 'selected' : null}} value="8">قزوین</option>
                                <option {{$student->province == 9  ? 'selected' : null}} value="9">سمنان</option>
                                <option {{$student->province == 10 ? 'selected' : null}} value="10">قم</option>
                                <option {{$student->province == 11 ? 'selected' : null}} value="11">مرکزی</option>
                                <option {{$student->province == 12 ? 'selected' : null}} value="12">زنجان</option>
                                <option {{$student->province == 13 ? 'selected' : null}} value="13">مازندران</option>
                                <option {{$student->province == 14 ? 'selected' : null}} value="14">گلستان</option>
                                <option {{$student->province == 15 ? 'selected' : null}} value="15">اردبیل</option>
                                <option {{$student->province == 16 ? 'selected' : null}} value="16">آذربایجان غربی
                                </option>
                                <option {{$student->province == 17 ? 'selected' : null}} value="17">همدان</option>
                                <option {{$student->province == 18 ? 'selected' : null}} value="18">کردستان</option>
                                <option {{$student->province == 19 ? 'selected' : null}} value="19">کرمانشاه</option>
                                <option {{$student->province == 20 ? 'selected' : null}} value="20">لرستان</option>
                                <option {{$student->province == 21 ? 'selected' : null}} value="21">بوشهر</option>
                                <option {{$student->province == 22 ? 'selected' : null}} value="22">کرمان</option>
                                <option {{$student->province == 23 ? 'selected' : null}} value="23">هرمزگان</option>
                                <option {{$student->province == 24 ? 'selected' : null}} value="24">چهارمحال و بختیاری
                                </option>
                                <option {{$student->province == 25 ? 'selected' : null}} value="25">یزد</option>
                                <option {{$student->province == 26 ? 'selected' : null}} value="26">سیستان و بلوچستان
                                </option>
                                <option {{$student->province == 27 ? 'selected' : null}} value="27">ایلام</option>
                                <option {{$student->province == 28 ? 'selected' : null}} value="28">کهگلویه و بویراحمد
                                </option>
                                <option {{$student->province == 29 ? 'selected' : null}} value="29">خراسان شمالی
                                </option>
                                <option {{$student->province == 30 ? 'selected' : null}} value="30">خراسان جنوبی
                                </option>
                                <option {{$student->province == 31 ? 'selected' : null}} value="31">البرز</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="city">شهر</label>
                            <select class="select2 form-select" id="city" name="city">
                                <option value="0">لطفا استان را انتخاب نمایید</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="field_of_study">رشته تحصیلی :</label>
                            <select id="field_of_study" name="field_of_study"
                                    class="form-select text-capitalize mb-md-0 ">
                                @foreach(\App\Data\FieldOfStudy::get() as $key=>$field_of_study)
                                    <option value="{{$key}}" {{$student->field_of_study == $key ? 'selected' : ''}}>
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
                                <option value="0" {{$student->verified == 0 ? 'selected' : ''}}>تایید نشود</option>
                                <option value="1" {{$student->verified == 1 ? 'selected' : ''}}>تایید شده</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="familiarity_way">نحوه آشنایی با کلاسینو :</label>
                            <select id="familiarity_way" class="form-select text-capitalize mb-md-0 "
                                    name="familiarity_way">
                                @foreach(\App\Data\FamiliarityWays::get() as $key=>$way)
                                    <option value="{{$key}}" {{$student->familiarity_way == $key ? 'selected' : null}}>
                                        {{$way}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="form-label" for="sale_support_id">پشتیبان</label>
                        <select id="sale_support_id" name="sale_support_id" class="select2 form-select form-select-lg"
                                data-allow-clear="true" data-placeholder="لطفا پشتیبان اننتخاب کنید">
                            <option></option>
                            @foreach($sales_support as $admin)
                                <option
                                    value="{{$admin->id}}" {{$student->sale_support_id == $admin->id ? 'selected' : null }}>
                                    {{$admin->fullname()}} | {{$admin->mobile}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6  mt-4">
                        <div class="form-group">
                            <label for="password">کلمه ی عبور</label>
                            <input type="text"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   placeholder="کلمه ی عبور"
                            >
                        </div>
                    </div>

                    <div class="col-md-6 mt-4">
                        <div class="form-group">
                            <label for="description">توضیحات</label>
                            <textarea class="form-control" name="description" id="description"
                                      rows="3">{{$student->description}}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6 mt-4">
                        <div class="form-group">
                            <label for="sales_description">توضیحات پشتیبان</label>
                            <textarea class="form-control" name="sales_description" id="sales_description"
                                      rows="3">{{$student->sales_description}}</textarea>
                        </div>
                    </div>


                    <hr class="mt-3">
                    <h5 class="card-title">دسترسی دانش آموز</h5>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="block">وضعیت دسترسی به پنل:</label>
                            <select id="block" name="block" class="form-select text-capitalize mb-md-0 ">
                                <option {{ $student->block == 0 ? 'selected' : '' }} value="0">دسترسی باز است</option>
                                <option {{ $student->block == 1 ? 'selected' : '' }} value="1">بلاک کاربر</option>
                                <option {{ $student->block == 2 ? 'selected' : '' }} value="2">آزاد با مشروطیت</option>
                                <option {{ $student->block == 4 ? 'selected' : '' }} value="4">حذف اکانت</option>
                                <option {{ $student->block == 5 ? 'selected' : '' }} value="5">عدم دسترسی به کلاس های
                                    زنده
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="block_reason_description">دلیل بلاک شدن:</label>
                            <textarea class="form-control" name="block_reason_description" id="block_reason_description"
                                      rows="3">{{$student->block_reason_description}}</textarea>
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
            @if($student->province )
            iranwebsv("{{$student->province}}");
            document.getElementById('city').value = "{{$student->city }}"
            @else
            iranwebsv(0);
            @endif
        });
    </script>
@endsection
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection
