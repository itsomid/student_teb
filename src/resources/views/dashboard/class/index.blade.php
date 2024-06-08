@extends('dashboard.layout.master')
@section('title', 'مدیریت جلسات کلاس های دوره')
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">مدیریت جلسات کلاس های دوره {{$course->product->name}}</h5>
                    <div class="card-title-elements ms-auto">
                        <a href="{{route('admin.classes.create', ['course' => $course->id])}}" class="btn btn-primary">
                            <i class="fa fa-plus mx-2"></i>
                            افزودن جلسه جدید
                        </a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان</th>
                            <th>تاریخ برگزاری</th>
                            <th>آزمون</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($classes as $class)
                            <tr>
                                <td>
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v mx-1"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </td>
                                <td>
                                    {{$class->product->name}}
                                </td>

                                <td>
                                    {{$class->holding_date}}
                                </td>
                                <td>
                                    <a href="" class="btn btn-primary btn-block btn-sm">آزمون</a>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"  href="{{route('admin.classes.edit', ['course' => $course->id, 'classes'=>$class->id])}}">
                                                <i class="fa-regular fa-pen mx-1"></i>
                                                ویرایش کلاس
                                            </a>
                                            <a class="dropdown-item" href="">
                                                <i class="fa-regular fa-eye mx-1"></i>
                                                مشاهده کلاس
                                            </a>
                                            <a class="dropdown-item" href="">
                                                <i class="fa-regular fa-copy mx-1"></i>
                                                duplicate
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
