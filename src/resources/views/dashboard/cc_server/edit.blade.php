@extends('dashboard.layout.master')
@section('title', 'ویرایش سرور')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"> ویرایش سرور </h5>
            <form action="{{ route('admin.cc_servers.update', $cc_server->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-5">
                        <div class="form-group">
                            <strong>عنوان:</strong>
                            <input type="text" name="name" value="{{ $cc_server->name }}" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5">
                        <div class="form-group">
                            <strong>آدرس:</strong>
                            <input type="text" name="url" value="{{ $cc_server->url }}" class="form-control" placeholder="URL">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 text-center text-white">
                        <br>
                        <button type="submit" class="btn btn-primary">ثبت تغییرات</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
