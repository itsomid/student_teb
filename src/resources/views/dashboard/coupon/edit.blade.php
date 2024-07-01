@extends('dashboard.layout.master')
@section('title', 'ویرایش کد تخفیف')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">فرم ویرایش کد تخفیف</h5>
            <form action="{{route('admin.coupons.update', ['coupon' => $coupon->id])}}" method="post">
                @method('PATCH')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="coupon">کد تخفیف:</label>
                            <input name="coupon" type="text" id="coupon" class="form-control" placeholder="کد تخفیف را وارد کنید." required value="{{old('coupon') ?? $coupon->coupon}}">
                            @error('coupon')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="description">توضیحات :</label>
                            <input name="description" type="text" id="description" class="form-control" placeholder="توضیحات" value="{{old('description') ?? $coupon->description}}">
                            @error('description')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="mobile">کاربر مصرف کننده :</label>
                            <select name="consumer_user_id"
                                    id="selectStudent"
                                    class="select2 form-control"
                                    src="{{route('admin.students.select.index')}}"
                                    data-selected="{{$coupon->consumer_user_id}}"
                            >
                            </select>
                            @error('consumer_user_id')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="specificProductId">مخصوص محصول :</label>
                            <select name="specific_product_id"
                                    id="specificProductId"
                                    class="select2 form-control">
                                <option value="0">دوره ی مورد نظر خود را انتخاب کنید</option>
                                @foreach($courses as $course)
                                    <option value="{{$course->product->id}}">
                                        {{$course->product->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('specific_product_id')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-2 text-right">
                            <label class="form-label" for="conditions_profile[grade]">پایه تحصیلی :</label>
                            <select class="select2 form-select" id="conditions_profile[grade]" name="conditions_profile[grade]">
                                @foreach(\App\Data\Grades::get() as $key=> $grade)
                                    <option value="{{$key}}" {{$coupon->conditions->profile->grade == $key ? 'selected' : null}}>
                                        {{$grade}}
                                    </option>
                                @endforeach
                            </select>
                            @error('specific_product_id')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="discount_amount">مبلغ تخفیف (ریال):</label>
                            <input name="discount_amount" type="number" id="discount_amount" class="form-control" placeholder="مبلغ تخفیف  را وارد کنید." value="{{old('discount_amount') ?? $coupon->discount_amount}}">
                            @error('discount_amount')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="discount_percentage">درصد تخفیف 0 - 100:</label>
                            <input name="discount_percentage" type="number" id="discount_percentage" min="0" max="100" step="1" class="form-control" placeholder="مبلغ تخفیف  را وارد کنید." value="{{old('discount_percentage')?? $coupon->discount_percentage}}">
                            @error('discount_percentage')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="expired_at">زمان انقضا :</label>
                            <input name="expired_at" type="text" id="expired_at" class="form-control" placeholder="تاریخ انقضا" value="{{old('expired_at') ?? $coupon->expired_at()}}" data-jdp autocomplete="off">
                            @error('expired_at')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="is_disposable">هر کاربر فقط یکبار بتواند استفاده کند؟:</label>
                            <select class="select2 form-select" id="is_disposable" name="is_disposable">
                                <option value="1" {{ $coupon->is_disposable == 1 ? 'selected' : null }}>بله</option>
                                <option value="0" {{ $coupon->is_disposable == 0 ? 'selected' : null }}>خیر</option>
                            </select>
                            @error('is_disposable')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="is_multiuser">چند کاربر میتوانند از این کد استفاده کنند؟:</label>
                            <select class="select2 form-select" id="is_multiuser" name="is_multiuser">
                                <option value="1" {{ $coupon->is_multiuser == 1  ? 'selected' : null }}>بله</option>
                                <option value="0" {{ $coupon->is_multiuser == 0  ? 'selected' : null }}>خیر</option>
                            </select>
                            @error('is_multiuser')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="for_old_users">کد تخفیف مخصوص کاربران سال پیش است؟:</label>
                            <select class="select2 form-select" id="for_old_users" name="for_old_users">
                                <option value="1" {{$coupon->for_old_users == 1 ? 'selected' : null }}>بله</option>
                                <option value="0" {{$coupon->for_old_users == 0 ? 'selected' : null }}>خیر</option>
                            </select>
                            @error('for_old_users')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="for_old_users_min_pay">حداقل مبلغی که پارسال خرید کرده باشد(ریال):</label>
                            <input type="number"
                                   id="for_old_users_min_pay"
                                   class="form-control"
                                   name="for_old_users_min_pay"
                                   placeholder="اطلاعات دوره را وارد کنید"
                                   value="{{old('for_old_users_min_pay') ?? $coupon->for_old_users_min_pay }}">
                            @error('for_old_users_min_pay')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="has_purchased">کد تخفیف مخصوص چه کسانی میباشد :</label>
                            <select class="select2 form-select" id="has_purchased" name="has_purchased">
                                <option value="0" {{$coupon->has_purchased== 0 ? 'selected' : null }}>خرید نداشته اند</option>
                                <option value="1" {{$coupon->has_purchased== 1 ? 'selected' : null }}>خرید داشته اند</option>
                                <option value="2" {{$coupon->has_purchased== 2 ? 'selected' : null }}>هر دو گروه</option>
                            </select>
                            @error('has_purchased')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <hr class="mt-3">

                    <div class="col-md-6  mb-1">
                        <h5 class="card-title">شرایط خاص :</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-2 text-right">
                                    <label class="form-label" for="product_atleast_one">فقط کسانی که حداقل یک دوره را برداشته اند:</label>
                                    <select class="select2 form-select" id="product_atleast_one" name="product_atleast_one">
                                        <option value="1" {{$coupon->conditions->product_atleast_one == 1 ? 'selected' : ''}}>
                                            بله
                                        </option>
                                        <option value="0" {{$coupon->conditions->product_atleast_one == 0 ? 'selected' : ''}}>
                                            خیر
                                        </option>
                                    </select>
                                    @error('product_atleast_one')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-2 text-right">
                                    <label class="form-label" for="product_atleast_count">حداقل محصولات زیر باید در سبد خرید باشد :</label>
                                    <input class="form-control"
                                           name="product_atleast_count"
                                           type="text"
                                           id="product_atleast_count"
                                           placeholder="برای استفاده از این شرط **اجباری** میباشد"
                                           value="{{old('product_atleast_count') ?? $coupon->conditions->product_atleast_count}}">
                                    @error('product_atleast_count')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                @foreach($courses as $course)
                                    <div class="form-check form-check-primary mt-3">
                                        <input class="form-check-input" name="conditions_products_ids[]" type="checkbox" value="{{$course->product_id}}" id="checkbox{{$course->product_id}}" {{in_array($course->id,  $coupon->conditions->product ?? []) ? 'checked' : null }} />
                                        <label class="form-check-label" for="checkbox{{$course->product_id}}">{{$course->product->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <h5 class="card-title">شرایط خریدهای قبلی کاربر :</h5>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mt-2 text-right">
                                    <label class="form-label" for="product_bought_atleast_count">حداقل تعداد انتخابی از محصولات زیر باید در سبد خرید باشد :</label>
                                    <input class="form-control"
                                           name="product_bought_atleast_count"
                                           type="text"
                                           id="product_bought_atleast_count"
                                           placeholder="برای استفاده از این شرط **اجباری** میباشد"
                                           value="{{old('product_bought_atleast_count') ?? $coupon->conditions?->product_bought_atleast_count}}">
                                    @error('product_bought_atleast_count')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                @foreach($courses as $course)
                                    <div class="form-check form-check-primary mt-3">
                                        <input class="form-check-input" name="conditions_products_bought_ids[]" type="checkbox" value="{{$course->product_id}}" id="checkbox_conditions_products_bought_ids_{{$course->product_id}}" {{in_array($course->id,  $coupon->conditions->product_bought ?? [] ) ? 'checked' : null }}/>
                                        <label class="form-check-label" for="checkbox_conditions_products_bought_ids_{{$course->product_id}}">{{$course->product->name}}</label>
                                    </div>
                                @endforeach
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
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/js/jalalidatepicker.js',
            'resources/assets/vendor/js/forms-selects.js',
            'resources/assets/js/select2/student.js',
            'resources/assets/js/select2/admin.js',
            'resources/assets/js/coupon.js',
          ])
@endsection
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection
