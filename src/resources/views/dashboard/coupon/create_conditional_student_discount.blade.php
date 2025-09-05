
@extends('dashboard.layout.master')
@section('title', 'افزودن کد تخفیف جدید')
@section('content')

    <form  action="{{route('admin.coupons.store-conditional-student-discount')}}" method="post">
        @csrf

        <div class="card my-4 my-3">
            <div class="card-body">
                <h5 class="card-title"> افزودن کد تخفیف شرطی</h5>
                <div class="row">
                    <div class="col-md-12 mt-3" id="coupon-code-field-group">
                        <div class="form-group ">
                            <label for="coupon">کد تخفیف:</label>
                            <input name="coupon" type="text" id="coupon" class="form-control" placeholder="کد تخفیف را وارد کنید." value="{{old('coupon')}}" autocomplete="off">
                            @error('coupon')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card my-4 my-3">
            <div class="card-body">
                <h5 class="card-title">اطلاعات کد</h5>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <label for="description">توضیحات :</label>
                            <textarea name="description" id="description" class="form-control"  placeholder="توضیحات" >{{old('description')}}</textarea>
                            @error('description')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="specificProductId">مخصوص محصول :</label>
                            <select name="product_ids[]"
                                    multiple
                                    id="specificProductId"
                                    class="select2 form-control">
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">
                                        {{$product->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_ids')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mt-3">
                            <label class="form-label" for="expired_at">زمان انقضا :</label>
                            <input name="expired_at" type="text" id="expired_at" class="form-control" placeholder="تاریخ انقضا" value="{{old('expired_at')}}" data-jdp autocomplete="off">
                            @error('expired_at')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="is_one_time">یکبار مصرف باشد؟</label>
                            <select class="select2 form-select" id="is_one_time" name="is_one_time">
                                <option value="0" {{old('is_one_time') == 0 ? 'selected' : null }}>خیر</option>
                                <option value="1" {{old('is_one_time') == 1 ? 'selected' : null }}>بله</option>
                            </select>
                            @error('is_one_time')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label class="form-label" for="discount_amount">مبلغ تخفیف (ریال):</label>
                            <input name="discount_amount" type="text" id="discount_amount" class="form-control" placeholder="مبلغ تخفیف  را وارد کنید." value="{{old('discount_amount')}}" number-separator="true" autocomplete="off">
                            @error('discount_amount')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label class="form-label" for="discount_percentage">درصد تخفیف 0 - 100:</label>
                            <input name="discount_percentage" type="number" id="discount_percentage" min="0" max="100" step="1" class="form-control" placeholder="مبلغ تخفیف  را وارد کنید."  value="{{old('discount_percentage')}}">
                            @error('discount_percentage')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card my-4 my-3">
            <div class="card-body">
                <h5 class="card-title">شرایط برای دانشجوان قدیمی</h5>
                <div class="row">

                    <div class="col-md-3 p-6">
                        <div class="text-light small fw-medium mb-4">مخصوص کاربران سال گذشته</div>
                        <label class="switch">
                            <input type="checkbox" class="switch-input" name="for_last_year_students" {{old('for_last_year_students') ? 'checked' : ''}} />
                            <span class="switch-toggle-slider">
                        <span class="switch-on">
                          <i class="ti ti-check"></i>
                        </span>
                        <span class="switch-off">
                          <i class="ti ti-x"></i>
                        </span>
                        </span>
                            <span class="switch-label">مخصوص کاربران سال گذشته</span>
                        </label>
                    </div>

                    <div class="col-md-9">
                        <div class="form-group ">
                            <label for="last_year_minimum_purchase">حداقل خرید سال گذشته:</label>
                            <input name="last_year_minimum_purchase" type="number" id="last_year_minimum_purchase" class="form-control" placeholder="حداقل  تعداد خرید سال گذشته" value="{{old('last_year_minimum_purchase')}}" autocomplete="off">
                            @error('last_year_minimum_purchase')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card my-4 my-3">
            <div class="card-body">
                <h5 class="card-title">شرایط برای دانشجوان فعلی</h5>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="purchases_status">افرادی که خرید کردند</label>
                            <select class="select2 form-select" id="purchases_status" name="purchases_status">
                                <option value="all"              {{old('purchases_status') == 0 ? 'selected' : null }}>همه</option>
                                <option value="once_or_more"     {{old('purchases_status') == 1 ? 'selected' : null }}>حداقل یک خرید داشته اند</option>
                                <option value="with_no_purchase" {{old('purchases_status') == 1 ? 'selected' : null }}>تاکنون خریدی نداشته اند</option>
                            </select>
                            @error('purchases_status')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="form-group">
                            <label>مخصوص محصول :</label>
                            <select name="purchased_items[]"
                                    multiple
                                    class="select2 form-control">
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">
                                        {{$product->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('purchased_items')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card my-4 my-3">
            <div class="card-body">
                <h5 class="card-title">شرایط سبد خرید دانشجوان</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label for="cart_items_count">حداقل تعداد درس داخل سبد خرید:</label>
                            <input name="cart_items_count" type="number" id="cart_items_count" class="form-control" placeholder="حداقل تعداد درس داخل سبد خرید" value="{{old('cart_items_count')}}" autocomplete="off">
                            @error('cart_items_count')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label>دروس داخل سبد خرید:</label>
                            <select name="specified_cart_items[]"
                                    multiple
                                    class="select2 form-control">
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">
                                        {{$product->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('specified_cart_item')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card my-4 my-3">
            <div class="card-body">
                <h5 class="card-title">گروه خاصی از دانشجوان</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>پایه ی تحصیلی:</label>
                            <select name="grade[]"
                                    multiple
                                    class="select2 form-control">
                                <optgroup class="divider"></optgroup>
                                @foreach(\App\Data\Grades::get() as $key=>$grade)
                                    <option value="{{$key}}">
                                        {{$grade}}
                                    </option>
                                @endforeach
                            </select>
                            @error('grade')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>رشته تحصیلی:</label>
                            <select name="field_of_study[]"
                                    multiple
                                    class="select2 form-control">
                                @foreach(\App\Data\FieldOfStudy::get() as $key=>$field)
                                    <option value="{{$key}}">
                                        {{$field}}
                                    </option>
                                @endforeach
                            </select>
                            @error('field_of_study')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-primary">
                <i class="fa fa-save mx-3"></i>
                ذخیره ی کد تخفیف
            </button>
        </div>

    </form>
@endsection
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/vendor/js/forms-selects.js',
            'resources/assets/js/jalalidatepicker.js',
            'resources/assets/js/student.js',
          ])
@endsection

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

