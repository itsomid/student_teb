@extends('dashboard.layout.master')
@section('title', 'ویرایش دوره' . $course->product->name)
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">  فرم ویرایش دوره {{$course->product->name}} </h5>

            <form action="{{route('admin.course.update', ['course' => $course->id] )}}"
                  method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">نام:</label>
                            <input name="name"
                                   id="name"
                                   class="form-control"
                                   placeholder="نام را وارد کنید."
                                   value="{{old('name') ?? $course->product->name}}"
                                   required>
                            @error('name')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="original_price">قیمت (ریال):</label>
                            <input name="original_price"
                                   type="number"
                                   id="original_price"
                                   class="form-control"
                                   value="{{old('original_price') ?? $course->product->original_price}}"
                                   placeholder="قیمت را وارد کنید." required>
                            @error('original_price')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="off_price">قیمت حراجی با اعمال کد تخفیف (ریال):</label>
                            <input name="off_price"
                                   type="number"
                                   id="off_price"
                                   class="form-control"
                                   value="{{old('off_price') ?? $course->product->off_price}}"
                                   placeholder="قیمت حراجی را وارد کنید.">
                            @error('off_price')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="product_type_id">نوع محصول:</label>
                            <select class="select2 form-select" id="product_type_id" name="product_type_id">

                                @foreach($types as $key => $value)
                                    <option value="{{$key}}" {{$course->product->product_type_id == $key ? 'selected' : null}}>{{$value}}</option>
                                @endforeach
                            </select>
                            @error('product_type_id')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="city">استاد:</label>
                            <x-admin-selection-component
                                input-name="user_id"
                                role="teacher"
                                default-value="{{$course->product->user_id}}"
                                placeholder-name="لطفا استاد را انتخاب کنید">
                            </x-admin-selection-component>
                        </div>
                    </div>

                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="img_filename">تصویر دوره:</label>
                            <input class="form-control-file form-control" type="file" id="img_filename" name="img_filename">
                            @error('img_filename')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-3">
                            <img src="{{$course->image()}}" class="img-fluid w-50">
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <div class="form-group mt-3">
                                <label for="description">توضیحات</label>
                                <textarea class="form-control" id="description" name="description" id="description" rows="5">{{old('description') ?? $course->product->description}}</textarea>
                                @error('description')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="about_course">درباره دوره:</label>
                            <input type="text"
                                   class="form-control"
                                   id="about_course"
                                   name="about_course"
                                   placeholder="اطلاعات دوره را وارد کنید"
                                   autocomplete="off"
                                   value="{{old('about_course') ?? $course->about_course}}">
                            @error('about_course')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>


                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="subscription_start_at">زمان شروع دوره اشتراکی:</label>
                            <input type="text"
                                   id="subscription_start_at"
                                   class="form-control"
                                   name="subscription_start_at"
                                   placeholder="زمان شروع دوره اشتراکی را وارد کنید"
                                   data-jdp
                                   value="{{old('subscription_start_at') ?? $course->subscription_start_at()}}">
                            @error('subscription_start_at')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="expiration_duration">مدت زمان اشتراک ( به روز ):</label>
                            <input type="text"
                                   name="expiration_duration"
                                   id="expiration_duration"
                                   class="form-control"
                                   placeholder="مدت زمان اشتراک"
                                   value="{{old('expiration_duration') ?? $course->product->expiration_duration}}">
                            @error('expiration_duration')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="categories">دسته بندی:</label>
                            <select id="categories" class="form-select text-capitalize mb-md-0 " name="categories[]" multiple>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"
                                        {{in_array($category->id, collect($course->product->product_categories)->pluck('id')->toArray()) ? 'selected' : null}}
                                    >{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('categories')<small class="text-danger">{{$message}}</small>@enderror

                        </div>
                    </div>
                    <hr class="mt-3">
                    <h5 class="card-title">وضعیت دوره</h5>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="is_purchasable">قابل خرید مجزا میباشد</label>
                                <input class="form-check-input"
                                       value="1"
                                       type="checkbox"
                                       role="switch"
                                       id="is_purchasable"
                                       name="is_purchasable"
                                    {{$course->product->is_purchasable == 1 ? 'checked' : '' }}>
                                @error('is_purchasable')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="has_installment"> قابلیت قسط بندی دارد</label>
                                <input class="form-check-input"
                                       value="1"
                                       type="checkbox"
                                       role="switch"
                                       id="has_installment"
                                       name="has_installment"
                                    {{$course->product->has_installment == 1 ? 'checked' : '' }}>
                                @error('has_installment')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="show_in_list"> نمایش در لیست محصولات</label>
                                <input class="form-check-input"
                                       type="checkbox"
                                       role="switch"
                                       id="show_in_list"
                                       name="show_in_list"
                                       value="1"
                                    {{$course->product->show_in_list == 1 ? 'checked' : '' }}>
                                @error('show_in_list')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="qa_status">پرسش پاسخ آفلاین</label>
                                <input class="form-check-input"
                                       type="checkbox"
                                       value="1"
                                       role="switch"
                                       id="qa_status"
                                       name="qa_status"
                                    {{$course->qa_status == 1 ? 'checked' : '' }}>
                                @error('show_in_list')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>

                    <hr class="mt-3">
                    <h5 class="card-title">مدیریت اقساط دوره</h5>

                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label" for="installment_count">تعداد قسط ها با خود پرداخت اولیه:</label>
                                <input class="form-control"
                                       type="number"
                                       value="{{$course->product->installment_count}}"
                                       id="installment_count"
                                       name="installment_count"
                                       placeholder="پیش فرض: ۴">
                                @error('installment_count')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label" for="first_installment_ratio">میزان پرداختی اولیه (بصورت درصد %):</label>
                                <input name="first_installment_ratio"
                                       type="number"
                                       id="first_installment_ratio"
                                       max="100"
                                       min="0"
                                       value="{{$course->product->first_installment_ratio}}"
                                       class="form-control"
                                       placeholder="پیش فرض ۳۳">
                                @error('first_installment_ratio')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label" for="final_installment_date">زمان سر رسید قسط آخر:</label>
                                <input name="final_installment_date"
                                       type="text"
                                       id="final_installment_date"
                                       class="form-control"
                                       data-jdp
                                       value="{{$course->final_installment_date()}}"
                                       autocomplete="off"
                                       placeholder="زمان سر رسید قسط آخر را وارد کنید.">
                                @error('final_installment_date')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <hr class="mt-3">
                    <h5 class="card-title">زمان برگزاری کلاس ها</h5>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="holding_days1">روز برگزاری جلسه اول در هفته:</label>
                            <select id="holding_days1" class="form-select text-capitalize mb-md-0 " name="options[holding_days1]">
                                <option value="0">انتخاب نشده</option>
                                <option {{$course->product->options['holding_days1'] == 1 ? 'selected' : null}} value="1">شنبه</option>
                                <option {{$course->product->options['holding_days1'] == 2 ? 'selected' : null}} value="2">یکشنبه</option>
                                <option {{$course->product->options['holding_days1'] == 3 ? 'selected' : null}} value="3">دوشنبه</option>
                                <option {{$course->product->options['holding_days1'] == 4 ? 'selected' : null}} value="4">سه‌شنبه</option>
                                <option {{$course->product->options['holding_days1'] == 5 ? 'selected' : null}} value="5">چهارشنبه</option>
                                <option {{$course->product->options['holding_days1'] == 6 ? 'selected' : null}} value="6">پنج‌شنبه</option>
                                <option {{$course->product->options['holding_days1'] == 7 ? 'selected' : null}} value="7">جمعه</option>
                            </select>
                            @error('options[holding_days1]')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="holding_hours1">ساعت برگزاری جلسه اول از:</label>
                            <input type="time"
                                   name="options[holding_hours1][]"
                                   class="form-control"
                                   id="holding_hours1"
                                   placeholder="ساعت برگزاری جلسه اول"
                                   value="{{$course->product->options['holding_hours1'][0]}}">
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="holding_hours1">ساعت برگزاری جلسه اول تا:</label>
                            <input type="time"
                                   name="options[holding_hours1][]"
                                   class="form-control"
                                   id="holding_hours1"
                                   placeholder="ساعت برگزاری جلسه اول"
                                   value="{{$course->product->options['holding_hours1'][1]}}">
                        </div>
                    </div>


                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="holding_days2">روز برگزاری جلسه دوم در هفته:</label>
                            <select id="holding_days2" class="form-select text-capitalize mb-md-0 " name="options[holding_days2]">
                                <option  value="0">انتخاب نشده</option>
                                <option  {{$course->product->options['holding_days2'] == 1 ? 'selected' : null}} value="1">شنبه</option>
                                <option  {{$course->product->options['holding_days2'] == 2 ? 'selected' : null}} value="2">یکشنبه</option>
                                <option  {{$course->product->options['holding_days2'] == 3 ? 'selected' : null}} value="3">دوشنبه</option>
                                <option  {{$course->product->options['holding_days2'] == 4 ? 'selected' : null}} value="4">سه‌شنبه</option>
                                <option  {{$course->product->options['holding_days2'] == 5 ? 'selected' : null}} value="5">چهارشنبه</option>
                                <option  {{$course->product->options['holding_days2'] == 6 ? 'selected' : null}} value="6">پنج‌شنبه</option>
                                <option  {{$course->product->options['holding_days2'] == 7 ? 'selected' : null}} value="7">جمعه</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="holding_hours2">ساعت برگزاری جلسه دوم از:</label>
                            <input type="time"
                                   name="options[holding_hours2][]"
                                   class="form-control"
                                   id="holding_hours2"
                                   placeholder="ساعت برگزاری جلسه دوم"
                                   value="{{$course->product->options['holding_hours2'][0]}}">
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="holding_hours2">ساعت برگزاری جلسه دوم تا:</label>
                            <input type="time"
                                   name="options[holding_hours2][]"
                                   class="form-control"
                                   id="holding_hours2"
                                   placeholder="ساعت برگزاری جلسه دوم"
                                   value="{{$course->product->options['holding_hours2'][1]}}">
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="holding_days3">روز برگزاری جلسه سوم در هفته:</label>
                            <select id="holding_days3" class="form-select text-capitalize mb-md-0 " name="options[holding_days3]">
                                <option value="0">انتخاب نشده</option>
                                <option {{$course->product->options['holding_days3'] == 1 ? 'selected' : null}} value="1">شنبه</option>
                                <option {{$course->product->options['holding_days3'] == 2 ? 'selected' : null}} value="2">یکشنبه</option>
                                <option {{$course->product->options['holding_days3'] == 3 ? 'selected' : null}} value="3">دوشنبه</option>
                                <option {{$course->product->options['holding_days3'] == 4 ? 'selected' : null}} value="4">سه‌شنبه</option>
                                <option {{$course->product->options['holding_days3'] == 5 ? 'selected' : null}} value="5">چهارشنبه</option>
                                <option {{$course->product->options['holding_days3'] == 6 ? 'selected' : null}} value="6">پنج‌شنبه</option>
                                <option {{$course->product->options['holding_days3'] == 7 ? 'selected' : null}} value="7">جمعه</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="holding_hours3">ساعت برگزاری جلسه سوم از:</label>
                            <input type="time"
                                   name="options[holding_hours3][]"
                                   class="form-control"
                                   id="holding_hours3"
                                   placeholder="ساعت برگزاری جلسه سوم"
                                   value="{{$course->product->options['holding_hours3'][0]}}">
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="holding_hours3">ساعت برگزاری جلسه سوم تا:</label>
                            <input type="time"
                                   name="options[holding_hours3][]"
                                   class="form-control"
                                   id="holding_hours3"
                                   placeholder="ساعت برگزاری جلسه سوم"
                                   value="{{$course->product->options['holding_hours3'][1]}}">
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="start_date">زمان شروع دوره:</label>
                            <input type="text"
                                   class="form-control"
                                   id="start_date"
                                   name="start_date"
                                   placeholder="زمان شروع دوره را وارد کنید"
                                   autocomplete="off"
                                   value="{{$course->start_date}}">
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
            'resources/assets/js/jalalidatepicker.js'
          ])

@endsection
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection
