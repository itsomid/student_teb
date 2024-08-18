@extends('dashboard.layout.master')
@section('title', 'آمار فروش براساس دسته بندی')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title header-elements">
                            <h5 class="m-0 me-2"> آمار فروش براساس دسته بندی </h5>
                        </div>
                        <form action="{{route('admin.sales-report-by-category.form')}}" method="get"  class="row mt-5" >
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="created_at">از تاریخ</label>
                                        <input required
                                               type="text"
                                               name="from_date"
                                               class="form-control"
                                               autocomplete="off"
                                               data-jdp
                                               placeholder="جهت درج تاریخ کلیک کنید">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="created_at">تا تاریخ</label>
                                        <input required
                                               type="text"
                                               name="to_date"
                                               class="form-control"
                                               autocomplete="off"
                                               data-jdp
                                               placeholder="جهت درج تاریخ کلیک کنید">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for=""> </label>
                                    <button class="btn btn-success w-100 ">دریافت گزارش</button>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($categories as $category)
                                    <div class="col-md-4">
                                        <div class="form-check my-3 d-block">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{$category->id}}">
                                                {{$category->name}}
                                                <span class="form-check-sign">
                                        <span class="check">
                                        </span>
                                    </span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>
                @if(request()->has('categories'))
                <div class="card">
                    <div class="card-body">
                        <div class="card-title header-elements">
                            <h5 class="m-0 me-2"> آمار فروش براساس دسته بندی </h5>
                        </div>
                        <div class="row">
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <th>شناسه محصول</th>
                                        <th>نام محصول</th>
                                        <th>مجموع مبلغ فروش</th>
                                    </thead>
                                    <tbody>
                                    @foreach($totalPaidAmountByProduct as $amount)
                                        <tr>
                                            <th>{{$amount->product_id}}</th>
                                            <th>{{$products->where('id', $amount->product_id)->first()->name}}</th>
                                            <th>
                                                {{$amount->total_price}}
                                                تومان
                                            </th>
                                        </tr>
                                    @endforeach()

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                 @endif
            </div>
        </div>
    </div>
@endsection
@section('vendor-script')
    @vite(['resources/assets/js/jalalidatepicker.js'])
@endsection
