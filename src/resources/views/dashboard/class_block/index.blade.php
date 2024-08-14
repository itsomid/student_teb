@extends('dashboard.layout.master')
@section('title', 'مدیریت کاربران بلاک شده')
@section('content')
    <div class="row">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">جست و جو</h5>
                <form class="row mt-3 d-flex align-items-end justify-content-between"
                      action="{{route('admin.class-block.index')}}"
                      method="get">
                    <div class="col-md-10 user_role">
                        <label class="form-label" for="key">نام دوره</label>
                        <input type="text" class="form-control" name="name"  placeholder="نام دوره را وارد کنید" value="{{ request('name') }}">
                    </div>
                    <div class="col-md-2 mt-2 text-center">
                        <button class="btn btn-success">
                            <i class="fa-solid fa-magnifying-glass mx-2"></i>
                            جست و جو
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">لیست انواع محصولات</h5>
                    @can('class-block.create')
                        <div class="card-title-elements ms-auto">
                            <a href="{{route('admin.class-block.create')}}" class="btn btn-primary">
                                <i class="fa fa-plus mx-2"></i>
                                بلاک کاربر جدید
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>کاربر</th>
                            <th>محصول</th>
                            <th>توضیحات</th>
                            <th>انقضا</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($classBlocks as $block)

                            <tr>
                                <td>
                                    {{ $block->student->name }} - {{$block->student->mobile}}
                                </td>
                                <td>
                                    {{ $block->product->name }}
                                </td>
                                <td>
                                    {{ $block->description }}
                                </td>
                                <td>
                                    {{ $block->expired_at }}
                                </td>
                                <td >
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @can('class-block.edit')
                                                <a class="dropdown-item"  href="{{route('admin.course.edit', ['course' => 1])}}">
                                                    <i class="fa-regular fa-pen mx-1"></i>
                                                    ویرایش
                                                </a>
                                            @endcan

                                            <a class="dropdown-item" href="">
                                                <i class="fa-regular fa-remove mx-1"></i>
                                                حذف
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
