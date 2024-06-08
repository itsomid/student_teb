@extends('dashboard.layout.master')
@section('title', 'افزودن دسته بندی جدید')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">افزودن دسته بندی جدید</h5>
            <form action="{{route('admin.product_category.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6 my-2">
                        <div class="form-group">
                            <label class="form-label" for="product">عنوان دسته بندی:</label>
                            <input name="name"
                                   id="name"
                                   placeholder="نام دسته بندی را وارد کنید"
                                   class="form-control"
                                   value="{{old('name')}}"
                                   required>
                            @error('name')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 my-2">
                        <div class="form-group">
                            <label class="form-label" for="type">نوع محصولات دسته بندی:</label>
                            <select class="select2 form-select" id="type" name="type">
                                @foreach(\App\Enums\ProductCategoryType::cases() as $type)
                                    <option value="{{$type}}">
                                        {{$type}}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')<small class="text-danger">{{$message}}</small>@enderror
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
