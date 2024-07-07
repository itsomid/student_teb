@extends('dashboard.layout.master')
@section('title', 'لیست سفارشها')
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">لیست سفارشها</h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>شماره سفارش</td>
                                <td>کاربر</td>
                                <td>قابل پرداخت</td>
                                <td>میزان تخفیف</td>
                                <td>مبلغ قسطی</td>
                                <td>تعداد قسط</td>
                                <td>وضعیت</td>
                                <td>تاریخ</td>
                                <td>جزئیات</td>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td>100</td>
                                <td>محمد کثیری</td>
                                <td>100,000</td>
                                <td>10,000</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <span class="text text-success">
                                        تکمیل شده
                                    </span>
                                </td>
                                <td>
                                    1403/6/4 10:12
                                </td>
                                <td>
                                    <button class="btn btn-primary text-white me-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                       مشاهده جزئیات
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="12">
                                    <div class="collapse" id="collapseExample">
                                        <div class="table-responsive text-nowrap">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <td>محصول</td>
                                                    <td>قیمت محصول</td>
                                                    <td>پرداخت شده</td>
                                                    <td>میزان تخفیف</td>
                                                </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                <tr>
                                                    <td>دوره ی حسابان آریان حیدی</td>
                                                    <td>100,000</td>
                                                    <td>90,000</td>
                                                    <td>10,000</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
