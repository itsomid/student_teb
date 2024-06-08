@extends('dashboard.layout.master')
@section('title', 'انتقال کاربران پشتیبان')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">فرم انتقال کاربران پشتیبان به پشتیبان دیگر</h5>
            <form action="{{route('admin.admin.store')}}" method="post">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="product" class="mb-3">پشتیبان قدیم: </label>
                            <dynamic-select></dynamic-select>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex justify-content-center align-items-center">
                        <i class="fa-solid fa-left fa-4x text-success"></i>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="user" class="mb-3">پشتیبان جدید: </label>
                            <dynamic-select></dynamic-select>
                        </div>
                    </div>
                </div>
                <div class=" d-flex justify-content-center mt-3">
                    <div class="col-md-1">
                        <button class="btn btn-primary w-100">
                            <i class="fa-solid fa-repeat mx-2"></i>
                            انتقال
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">فرم انتقال کاربران پشتیبان به صورت رندوم</h5>
            <form action="{{route('admin.admin.store')}}" method="post">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="product" class="mb-3">پشتیبان:  </label>
                            <dynamic-select></dynamic-select>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex align-items-center justify-content-center mt-2">
                        <button class="btn btn-primary w-50 ">
                            <i class="fa-solid fa-repeat mx-2"></i>
                            انتقال
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
