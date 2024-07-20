@extends('dashboard.layout.master')
@section('title', 'افزودن دوره جدید')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">فرم افزودن دوره</h5>

            <form action="{{route('admin.course.store')}}" method="post" enctype="multipart/form-data"> @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">نام:</label>
                            <input name="name"
                                   id="name"
                                   class="form-control"
                                   placeholder="نام را وارد کنید."
                                   value="{{old('name')}}"
                                   required>
                            @error('name')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="original_price">قیمت (ریال):</label>
                            <input name="original_price"
                                   type="text"
                                   id="original_price"
                                   class="form-control numeral-mask"
                                   value="{{old('original_price')}}"
                                   placeholder="قیمت را وارد کنید." required>
                            @error('original_price')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="off_price">قیمت حراجی با اعمال کد تخفیف (ریال):</label>
                            <input name="off_price"
                                   type="text"
                                   id="off_price"
                                   class="form-control numeral-mask"
                                   value="{{old('off_price')}}"
                                   placeholder="قیمت حراجی را وارد کنید.">
                            @error('off_price')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="product_type_id">نوع محصول:</label>
                            <select class="select2 form-select" id="product_type_id" name="product_type_id">
                                @foreach($types as $id => $type)
                                    <option
                                        value="{{$id}}" {{old('product_type_id') == $id ? 'selected' : null}}>{{$type}}</option>
                                @endforeach
                            </select>
                            @error('product_type_id')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="city">استاد:</label>
                            <x-admin-selection-component
                                default-value="{{(int)old('user_id',0)}}"
                                input-name="user_id"
                                role="teacher"
                                placeholder-name="لطفا استاد را انتخاب کنید">
                            </x-admin-selection-component>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="img_filename">تصویر دوره:</label>
                            <input class="form-control-file form-control" type="file" id="img_filename"
                                   name="img_filename">
                            @error('img_filename')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="categories">دسته بندی:</label>
                            <select id="categories" class="select2 form-select text-capitalize mb-md-0 "
                                    name="categories[]" data-placeholder="لطفا دسته بندی را انتخاب کنید." multiple>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('categories')<small class="text-danger">{{$message}}</small>@enderror

                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <div class="form-group mt-3">
                                <label for="description">توضیحات</label>

                                <x-tinymce-editor selector="description" :value="old('description')"/>
                                @error('description')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="about_course">درباره دوره:</label>
                            <x-tinymce-editor selector="about_course" :value="old('about_course')"/>
                            @error('about_course')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <hr class="mt-3">
                    <h5 class="card-title">وضعیت دوره</h5>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="is_purchasable">قابل خرید مجزا میباشد</label>
                                <input class="form-check-input"
                                       type="checkbox"
                                       role="switch"
                                       id="is_purchasable"
                                       name="is_purchasable">
                                @error('is_purchasable')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="has_installment"> قابلیت قسط بندی دارد</label>
                                <input class="form-check-input"
                                       type="checkbox"
                                       role="switch"
                                       id="has_installment"
                                       name="has_installment">
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
                                       name="show_in_list">
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
                                       role="switch"
                                       id="qa_status"
                                       name="qa_status">
                                @error('show_in_list')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>

                    <hr class="mt-3">
                    <h5 class="card-title">مدیریت اقساط دوره</h5>

                    <div class="col-md-2 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label" for="installment_count">تعداد قسط ها با خود پرداخت
                                    اولیه:</label>
                                <input class="form-control"
                                       type="number"
                                       value="{{old('installment_count')  ? old('installment_count')  : null }}"
                                       id="installment_count"
                                       name="installment_count"
                                       placeholder="پیش فرض: ۴">
                                @error('installment_count')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label" for="first_installment_ratio">میزان پرداختی اولیه (بصورت درصد
                                    %):</label>
                                <input name="first_installment_ratio"
                                       type="number"
                                       id="first_installment_ratio"
                                       max="100"
                                       min="0"
                                       value="{{old('first_installment_ratio')  ? old('first_installment_ratio')  : null}}"
                                       class="form-control"
                                       placeholder="پیش فرض ۳۳">
                                @error('first_installment_ratio')<small
                                    class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label" for="first_installment_amount">پرداختی اولیه (بصورت
                                    مبلغ):</label>
                                <input name="first_installment_amount"
                                       type="text"
                                       id="first_installment_amount"
                                       class="form-control numeral-mask"
                                       placeholder="پیش فرض: 1000000"
                                       value="{{ old('first_installment_amount') }}">
                                @error('first_installment_amount')<small
                                    class="text-danger">{{$message}}</small>@enderror
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
                                       value="{{old('final_installment_date')}}"
                                       autocomplete="off"
                                       placeholder="زمان سر رسید قسط آخر را وارد کنید.">
                                @error('final_installment_date')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <hr class="mt-3">
                    <h5 class="card-title">مدیریت اشتراک دوره</h5>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="subscription_start_at">زمان شروع دوره اشتراکی:</label>
                            <input type="text"
                                   id="subscription_start_at"
                                   class="form-control"
                                   name="subscription_start_at"
                                   placeholder="زمان شروع دوره اشتراکی را وارد کنید"
                                   data-jdp

                                   value="{{old('subscription_start_at')}}">
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
                                   value="{{old('expiration_duration')}}">
                            @error('expiration_duration')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <hr class="mt-3">
                    <h5 class="card-title">لینک برگزاری جلسه معرفی</h5>

                    <div class="col-md-12">
                        <div class="form-group mt-3"><label for="introduce_video">لینک ویديو آفلاین (iframe):</label>
                            <input type="text" name="introduce_video" id="introduce_video" class="form-control"
                                   placeholder="aparat,..." value="{{old('introduce_video')}}">
                        </div>
                    </div>
                    <hr class="mt-3">
                    <h5 class="card-title">زمان برگزاری کلاس ها</h5>
                    <div class="col-md-6  mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="start_date">زمان شروع دوره:</label>
                            <input type="text"
                                   class="form-control"
                                   id="start_date"
                                   name="start_date"
                                   placeholder="زمان شروع دوره را وارد کنید"
                                   autocomplete="off"
                                   value="{{old('start_date')}}">
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="holding_days1">روز برگزاری جلسه اول در هفته:</label>
                            <select id="holding_days1" class="form-select text-capitalize mb-md-0 "
                                    name="options[holding_days1]">
                                <option value="0">انتخاب نشده</option>
                                <option value="1">شنبه</option>
                                <option value="2">یکشنبه</option>
                                <option value="3">دوشنبه</option>
                                <option value="4">سه‌شنبه</option>
                                <option value="5">چهارشنبه</option>
                                <option value="6">پنج‌شنبه</option>
                                <option value="7">جمعه</option>
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
                                   value="{{old('options[holding_hours1][]')}}">
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
                                   value="{{old('options[holding_hours1][]')}}">
                        </div>
                    </div>


                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="holding_days2">روز برگزاری جلسه دوم در هفته:</label>
                            <select id="holding_days2" class="form-select text-capitalize mb-md-0 "
                                    name="options[holding_days2]">
                                <option value="0">انتخاب نشده</option>
                                <option value="1">شنبه</option>
                                <option value="2">یکشنبه</option>
                                <option value="3">دوشنبه</option>
                                <option value="4">سه‌شنبه</option>
                                <option value="5">چهارشنبه</option>
                                <option value="6">پنج‌شنبه</option>
                                <option value="7">جمعه</option>
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
                                   value="">
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
                                   value="">
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="holding_days3">روز برگزاری جلسه سوم در هفته:</label>
                            <select id="holding_days3" class="form-select text-capitalize mb-md-0 "
                                    name="options[holding_days3]">
                                <option value="0">انتخاب نشده</option>
                                <option value="1">شنبه</option>
                                <option value="2">یکشنبه</option>
                                <option value="3">دوشنبه</option>
                                <option value="4">سه‌شنبه</option>
                                <option value="5">چهارشنبه</option>
                                <option value="6">پنج‌شنبه</option>
                                <option value="7">جمعه</option>
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
                                   value="">
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
                                   value="">
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
            'resources/assets/js/jalalidatepicker.js',
            'resources/assets/vendor/libs/cleavejs/cleave.js',
            'resources/assets/js/forms-extras.js',
            'resources/assets/vendor/libs/tinymce/tinymce.js'
          ])
@endsection
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection


