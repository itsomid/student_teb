@extends('dashboard.layout.master')
@section('title', 'افزودن آزمون جدید برای دوره')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">افزودن آزمون جدید برای دوره [نام دوره]</h5>
            <form action="{{route('admin.student.store')}}" method="post">
                <div class="row">

                    <div class="col-md-6  mb-1">
                        <div class="form-group">
                            <label for="name">نام:</label>
                            <input name="name"
                                   id="name"
                                   class="form-control"
                                   placeholder="نام را وارد کنید."
                                   required>

                        </div>
                    </div>

                    <div class="col-md-6  mb-1">
                        <div class="form-group">
                            <label for="name_english">قیمت (ریال):</label>
                            <input name="name_english" type="number" id="name_english" class="form-control"
                                   placeholder="قیمت را وارد کنید." required>
                        </div>
                    </div>
                    <div class="col-md-6  mb-1">
                        <div class="form-group mt-3">
                            <label for="mobile">قیمت حراجی با اعمال کد تخفیف (ریال):</label>
                            <input name="mobile" type="number" id="mobile" class="form-control" placeholder="قیمت حراجی را وارد کنید.">
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="province">نوع محصول:</label>
                            <select class="select2 form-select" id="province" name="province">
                                <option value="">انتخاب نشده</option>
                                <option value="">انتخاب اول</option>
                                <option value="">انتخاب دوم</option>
                                <option value="">انتخاب سوم</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="city">استاد:</label>
                            <dynamic-select></dynamic-select>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="key">input_img:</label>
                            <input class="form-control-file form-control" type="file" id="file">
                        </div>
                    </div>
                    <div class="col-md-12 mb-1">
                        <div class="form-group mt-3">
                            <div class="form-group mt-3">
                                <label for="description">توضیحات</label>
                                <textarea class="form-control" name="description" id="description" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="familiarity_way">دسته بندی:</label>
                            <select id="familiarity_way" class="form-select text-capitalize mb-md-0 " multiple>
                                <option value="">انتخاب نشده</option>
                                <option>dawdawd</option>
                                <option>dawdawd</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="password">fake price:</label>
                            <input type="text"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   placeholder="enter fake price"
                                   value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="password">Full Price (only for show in store list):</label>
                            <input type="text"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   placeholder="enter Full Price"
                                   value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="password">مدت زمان اشتراک ( به روز ):</label>
                            <input type="text"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   placeholder="مدت زمان اشتراک"
                                   value="">
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label">زمان شروع آزمون (اختیاری):</label>
                                <input name="mobile" type="number" id="mobile" class="form-control" placeholder="date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label">زمان اتمام آزمون‌ (اختیاری):</label>
                                <input name="mobile" type="number" id="mobile" class="form-control" placeholder="date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label">جمع امتیاز آزمون:</label>
                                <input name="mobile" type="number" id="mobile" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label">محدودیت زمانی (ثانیه):</label>
                                <input name="mobile" type="number" id="mobile" class="form-control">
                            </div>
                        </div>
                    </div>


                    <hr class="mt-3">
                    <h5 class="card-title">وضعیت آزمون</h5>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="single_buy">قابل خرید مجزا میباشد</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="single_buy">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="installment"> قابلیت قسط بندی دارد</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="installment">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="show_store"> نمایش در لیست محصولات</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="show_store">
                            </div>
                        </div>
                    </div>


                    <hr class="mt-3">
                    <h5 class="card-title">مدیریت اقساط آزمون</h5>

                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label">تعداد قسط ها با خود پرداخت اولیه:</label>
                                <input name="mobile" type="number" id="mobile" class="form-control" placeholder="پیش فرض: ۴">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label">میزان پرداختی اولیه (بصورت درصد):</label>
                                <input name="mobile" type="number" id="mobile" class="form-control" placeholder="پیش فرض ۳۳">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label">زمان سر رسید قسط آخر:</label>
                                <input name="mobile" type="number" id="mobile" class="form-control" placeholder="زمان سر رسید قسط آخر را وارد کنید.">
                            </div>
                        </div>
                    </div>
                    <hr class="mt-3">
                    <h5 class="card-title">موارد دیگر</h5>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="first_free">آزمون قابل شرکت مجدد میباشد؟</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="first_free">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="homework">به دانشجوان نمایش داده شود؟</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="homework">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="homework_sent">برگه ها بصورت آنی تصحیح شود؟</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="homework_sent">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="report">آزمون اجباری است؟</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="report">
                            </div>
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
