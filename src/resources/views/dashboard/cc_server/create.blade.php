@extends('dashboard.layout.master')
@section('title', 'افزودن سرور جدید')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">افزودن سرور جدید</h5>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-6 my-2">
                        <div class="form-group">
                            <label for="product" class="mb-3">Name:</label>
                            <input name="name"
                                   id="name"
                                   class="form-control"
                                   value="{{old('name')}}"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-6 my-2">
                        <div class="form-group">
                            <label for="user" class="mb-3">URL:</label>
                            <input name="url"
                                   id="url"
                                   class="form-control"
                                   value="{{old('name')}}"
                                   required>
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
