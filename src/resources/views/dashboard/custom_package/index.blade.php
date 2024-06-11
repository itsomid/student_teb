@extends('dashboard.layout.master')
@section('title', 'مدیریت پکیج های سفارشی')
@section('content')
    <div class="row">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">جست و جو</h5>
                <form class="row mt-3 d-flex align-items-end justify-content-between"
                      action="{{route('admin.custom-package.index')}}"
                      method="get">
                    <div class="col-md-10 user_role">
                        <label class="form-label" for="key">نام پکیج</label>
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
                    <h5 class="m-0 me-2">لیست پکیج های سفارشی</h5>
                    <div class="card-title-elements ms-auto">
                        <a href="{{ route('admin.custom-package.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus mx-2"></i>
                            افزودن پکیج
                        </a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>قیمت</th>
                            <th>تاریخ برگزاری</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($packages as $package)
                            <tr>
                                <td>
                                    {{$package->id}}
                                </td>
                                <td>
                                    {{$package->name}}
                                </td>
                                <td>
                                    {{ $package->holding_date }}
                                </td>
                                <td>
                                    {{ number_format($package->original_price) }}
                                </td>
                                <td class="d-flex align-items-center">
                                    <div class="dropdown mx-3">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                               href="{{ route('admin.custom-package.edit', [$package->id]) }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                ویرایش پکیج
                                            </a>
                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal_{{$package->id}}"
                                               data-bs-whatever="@mdo"
                                               href="#">
                                                <i class="fa-solid fa-trash"></i>
                                                حذف پکیج
                                            </a>
                                        </div>
                                        <div class="modal fade" id="exampleModal_{{$package->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-top">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">تایید حذف پکیج</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        آیا از حذف این پکیج مطمئن هستید؟
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">بستن</button>
                                                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">بله</button>
                                                    </div>
                                                </div>
                                            </div>
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
