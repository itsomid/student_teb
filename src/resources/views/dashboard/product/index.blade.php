@extends('dashboard.layout.master')
@section('title', 'مدیریت محصولات')
@section('content')

    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">لیست محصولات</h5>
                    <div class="card-title-elements ms-auto">
                        <a href="" class="btn btn-primary">
                            <i class="fa fa-plus mx-2"></i>
                            افزودن محصول
                        </a>
                    </div>
                </div>

                <div class="table-responsive">


                    <form method="post" action="" id="sort_form">
                        <table class="table" id="menuItems-table">
                            <thead>
                            <tr>
                                <th>نام</th>
                                <th colspan="3">عملیات</th>
                            </tr>
                            </thead>
                            <tbody id="my_table" class="ui-sortable">
                                @for($i = 0; $i < 10; $i++)

                                    <tr class="ui-sortable-handle">
                                        <td>
                                            <span class="handle" style="cursor: move;">
                                                <i class="fa-solid fa-ellipsis-vertical "></i>
                                                <i class="fa-solid fa-ellipsis-vertical mx-1"></i>
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </span>
                                            <input class="sort_num" name="sort_num[{{$i}}]" type="hidden" value="{{$i}}">
                                        </td>
                                        <td>
                                            کلاس های ویژه کنکور ۱۴۰۱
                                        </td>
                                        <td>
                                            <div class="dropdown mx-3">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                       href="">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                        ویرایش محصول
                                                    </a>

                                                    @can('coupons.destroy')
                                                        <form action="" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal_{{$i}}" data-bs-whatever="@mdo">
                                                                <i class="fa-solid fa-trash"></i>
                                                                حذف محصول
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                                <div class="modal fade" id="exampleModal_{{$i}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-top">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">تایید حذف محصول</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                آیا از حذف این محصول مطمئن هستید؟
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">بستن</button>
                                                                <form action="" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger text-white" data-bs-dismiss="modal">بله</button>
                                                                </form>
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
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('/vendor/js/jquery.min.js')}}"></script>
    <script src="{{asset('/vendor/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('#my_table').sortable( {
                update: function( event, ui ) {
                    $(this).children().each(function(index) {
                        $(this).find('.sort_num').val(index + 1);
                        $('#sort_form').submit();
                    });
                }
            });
        });
    </script>
@endsection
