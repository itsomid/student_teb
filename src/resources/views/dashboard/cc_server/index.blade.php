@extends('dashboard.layout.master')
@section('title', 'مدیریت سرور های cc')
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">لیست سرور های cc</h5>
                    <div class="card-title-elements ms-auto">
                        <a href="" class="btn btn-primary">
                            <i class="fa fa-plus mx-2"></i>
                            افزودن سرور
                        </a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>URL</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @for($i = 0; $i <= 10; $i++)
                            <tr>
                                <td>
                                    1
                                </td>

                                <td>
                                    8taei
                                </td>
                                <td>

                                </td>
                                <td class="d-flex align-items-center">
                                    <div class="dropdown mx-3">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                               href="#">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                ویرایش سرور
                                            </a>
                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal_{{$i}}"
                                               data-bs-whatever="@mdo"
                                               href="#">
                                                <i class="fa-solid fa-trash"></i>
                                                حذف سرور
                                            </a>
                                        </div>
                                        <div class="modal fade" id="exampleModal_{{$i}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-top">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">تایید حذف سرور cc</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        آیا از حذف این سرور مطمئن هستید؟
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
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
