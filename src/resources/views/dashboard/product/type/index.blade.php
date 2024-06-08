@extends('dashboard.layout.master')
@section('title', 'مدیریت نوع محصولات')
@section('content')
    @if(session()->has('status'))
        <div class="alert alert-success" role="alert">
            <div class="alert-body">
                <i class="fa-sharp fa-solid fa-circle-check"></i>
                عملیات با موفقیت انجام شد
            </div>
        </div>
    @endif
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">لیست انواع محصولات</h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>آیدی</th>
                            <th>نام</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($product_types as $id => $name)
                            <tr>
                                <td>
                                    {{$id}}
                                </td>
                                <td>
                                    {{$name}}
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
