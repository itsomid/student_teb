@extends('dashboard.layout.master')
@section('title', 'افزودن کد تخفیف جدید')
@section('content')

    <form  action="{{route('admin.coupons.store-specified-students-coupon')}}" method="post">
        @csrf

    <div class="card my-4 my-3">
        <div class="card-body">
            <h5 class="card-title"> افزودن کد تخفیف برای یک دانشجو</h5>
            <div class="row">
                <div class="col-md-6 mt-3" id="coupon-code-field-group">
                    <div class="form-group ">
                        <label for="coupon">کد تخفیف:</label>
                        <input name="coupon" type="text" id="coupon" class="form-control" placeholder="کد تخفیف را وارد کنید." value="{{old('coupon')}}">
                        @error('coupon')<small class="text-danger">{{$message}}</small>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mt-3">
                        <label for="mobile">کاربر مصرف کننده :</label>
                        <select name="consumer_ids[]"
                                id="selectStudent"
                                class="select2 form-control"
                                multiple
                                src="{{route('admin.students.select.index')}}">
                        </select>
                        @error('consumer_ids')<small class="text-danger">{{$message}}</small>@enderror
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
                        <label for="productIds">مخصوص محصول :</label>
                        <select name="product_ids[]"
                                multiple
                                id="productIds"
                                class="select2 form-control">
                            <option value="0">دوره ی مورد نظر خود را انتخاب کنید</option>
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

