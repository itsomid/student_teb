@extends('dashboard.layout.master')
@section('title', 'مدیریت دسته بندی محصولات')
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">لیست دسته بندی محصولات</h5>
                    <div class="card-title-elements ms-auto">
                        <a href="{{route('admin.product_category.create')}}" class="btn btn-primary">
                            <i class="fa fa-plus mx-2"></i>
                            افزودن دسته بندی
                        </a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Archive</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($product_categories as $i => $product_category)
                            <tr>
                                <td>
                                    {{$product_category->id}}
                                </td>

                                <td>
                                    {{$product_category->name}}
                                </td>
                                <td>
                                    <a href="" class="btn btn-warning btn-block">آرشیو شود</a>
                                </td>
                                <td>
                                    <div class="dropdown mx-3">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{route('admin.product_category.edit', ['product_category' => $product_category->id])}}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                ویرایش دسته بندی
                                            </a>
                                            <a class="dropdown-item" data-bs-toggle="modal"
                                               data-bs-target="#exampleModal_{{$i}}"
                                               data-bs-whatever="@mdo"
                                               href="#">
                                                <i class="fa-solid fa-trash"></i>
                                                حذف دسته بندی
                                            </a>
                                        </div>
                                        <div class="modal fade" id="exampleModal_{{$i}}" tabindex="-1"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-top">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">تایید حذف دسته
                                                            بندی
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        آیا از حذف این دسته بندی مطمئن هستید؟
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary text-white"
                                                                data-bs-dismiss="modal">بستن
                                                        </button>
                                                        <form action="{{route('admin.product_category.destroy' , ['product_category' => $product_category->id])}}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"  class="btn btn-danger text-white">بله
                                                            </button>
                                                        </form>

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
