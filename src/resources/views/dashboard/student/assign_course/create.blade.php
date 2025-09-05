@extends('dashboard.layout.master')
@section('title', 'افزودن دانشجو جدید')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">تخصیص رایگان درس برای کاربر</h5>
            <form action="{{route('admin.admin.store')}}" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product" class="mb-3">محصول :</label>
                            <dynamic-select></dynamic-select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user" class="mb-3">کاربر :</label>
                            <dynamic-select></dynamic-select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
