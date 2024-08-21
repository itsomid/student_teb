@extends('dashboard.layout.master')
@section('title', 'بلاک کاربر از کلاس')
@section('content')
    <section class="form-control-repeater">
        <div class="card">

            <div class="card-body">
                <h5 class="card-title">بلاک کاربر از کلاس</h5>
                <form class="row" method="post" action="{{route('admin.class-block.store')}}">
                    @csrf

                    <div class="col-md-6">
                        <label for="selectStudent" class="form-label mb-0">کلاس:
                        </label>
                        <class-selection-component input-name="product_id"></class-selection-component>
                    </div>
                    <div class="col-md-12">
                        <label for="selectStudent" class="form-label mb-0">لیست کاربران بلاکی:
                        </label>
                        <div class="form-group">
                            <textarea cols="50" rows="10" class="form-control" name="users_list" placeholder="در هر خط یک شماره موبایل یا یک آیدی وارد شود، مثال:
09361956080
09396731636
11589
7746
09196479518"></textarea>
                            @error('users_list')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="numeral-mask" class="form-label mb-0">توضیحات بلاک (اختیاری):</label>
                        <textarea name="description" cols="50" rows="10" class="form-control"></textarea>
                        @error('description')<small class="text-danger">{{$message}}</small>@enderror
                    </div>

                    <div class="col-md-6 user_role mt-3">
                        <label class="form-label" for="user_description">تا چه زمانی بلاک باشد؟:</label>
                        <input class="form-control" data-jdp id="expired_at" name="expired_at" placeholder="توضیحات...">
                        @error('expired_at')<small class="text-danger">{{$message}}</small>@enderror
                    </div>
                    <div class="row align-items-center g-2 mt-2">
                        <div class="col text-center">
                            <button type="submit" id="submitButton" class="btn btn-primary text-white">
                                <span class="fa fa-money-check-dollar ml-1"></span>
                                شارژ اکانت
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('vendor-script')
    @vite([
            'resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/vendor/libs/cleavejs/cleave.js',
            'resources/assets/js/jalalidatepicker.js',
            'resources/assets/vendor/js/forms-selects.js',
            'resources/assets/js/student.js',
            'resources/assets/js/forms-extras.js'
          ]);
@endsection
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

