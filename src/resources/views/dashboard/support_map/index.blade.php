@extends('dashboard.layout.master')
@section('title', 'پایه بندیِ پشتیبان ها')
@section('content')
    <div class="row">
        <form class="card" action="{{route('admin.support_map.store')}}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-11">
                        <div class="form-group">
                            <label for="title">عنوان را وارد کنید</label>
                            <input type="text" id="title" class="form-control" name="title" value="{{old('title')}}" placeholder="عنوان را وارد کنید">
                        </div>
                    </div>
                    <div class="col-md-1 align-self-end">
                        <div class="form-group">
                            <button class="btn btn-primary w-100">
                                <i class="fa fa-plus ml-1"></i>
                                <span>افزودن</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row mt-3">
        <form class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">پایه بندی ها</h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>عنوان</th>
                            <th>تعداد پشتیبان ها</th>
                            <th>پایه ها</th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($maps as $map)
                            <tr>
                                <td>{{$map->title}}</td>
                                <td>{{$map->admins_count}}</td>
                                <td>
                                    @foreach($map->grades as $grade)
                                        <span class="badge bg-primary mx-1">
                                            {{\App\Data\Grades::get()[$grade]}}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{route('admin.support_map.edit', $map->id)}}" class="btn btn-sm btn-warning text-white">
                                        <small>ویرایش</small>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
@endsection
