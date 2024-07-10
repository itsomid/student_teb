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
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->user->name}}</td>
                                <td>{{$order->total_payable_price}}</td>
                                <td>{{$order->vat_tax}}</td>
                                <td>{{$order->installment_total_amount}}</td>
                                <td>{{$order->repayment_count}}</td>
                                <td>
                                    <span class="text text-success">
                                       {{\App\Enums\OrderStatusEnum::STATUS_LABEL[$order->status->value]}}
                                    </span>
                                </td>
                                <td>
                                    {{$order->created_at}}
                                </td>
                                <td>
                                    <button class="btn btn-primary text-white me-1" type="button" data-bs-toggle="collapse" data-bs-target="#order_detail_{{$order->id}}" aria-expanded="false" aria-controls="order_detail_{{$order->id}}">
                                        مشاهده جزئیات
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="12">
                                    <div class="collapse" id="order_detail_{{$order->id}}">
                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-hover table-secondary">
                                                <thead>
                                                <tr>
                                                    <td>محصول</td>
                                                    <td>قیمت محصول</td>
                                                    <td>پرداخت شده</td>
                                                    <td>میزان تخفیف</td>
                                                </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                @foreach($order->items as $item)
                                                    <tr>
                                                        <td>{{$item->product->name}}</td>
                                                        <td>{{$item->product_price}}</td>
                                                        <td>{{$item->final_price}}</td>
                                                        <td>{{$item->discount_price}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
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
