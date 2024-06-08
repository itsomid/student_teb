@extends('dashboard.layout.master')
@section('title', 'افزودن نوع محصول')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">فرم افزودن نوع محصول</h5>
            <form action="{{route('admin.product_type.store')}}" method="post"> @csrf
                @csrf
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="name">نام</label>
                            <input name="name"
                                   id="name"
                                   class="form-control"
                                   placeholder="نام را وارد کنید."
                                   value="{{old('name')}}"
                                   required>
                        </div>
                        @error('name')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="table_name">نام جدول در دیتابیس </label>
                            <input name="table_name" id="table_name" class="form-control"  placeholder="نام جدول در دیتابیس را وارد کنید." value="{{old('table_name')}}" required>
                        </div>
                        @error('table_name')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
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
