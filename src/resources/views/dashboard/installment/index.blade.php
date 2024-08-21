@extends('dashboard.layout.master')
@section('title', 'مدیریت اقساط')
@section('content')
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">مدیریت اقساط</h5>
                </div>
               <form class="row">
                   <div class="col-md-3">
                       <div class="form-group">
                            
                       </div>
                   </div>
                   <div class="col-md-3">
                       <div class="form-group">
                       </div>
                   </div>
                   <div class="col-md-3">
                       <div class="form-group">

                       </div>
                   </div>
                   <div class="col-md-3">
                       <div class="form-group">

                       </div>
                   </div>
               </form>
            </div>
        </div>
        <div class="card mt-5">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">مدیریت اقساط</h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>شناسه</th>
                            <th>کد سفارش</th>
                            <th>کاربر</th>
                            <th>محصول</th>
                            <th>مبلغ</th>
                            <th>وضعیت</th>
                            <th>تاریخ سررسید</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($installments as $installment)
                                <tr>
                                    <td>{{$installment->id}}</td>
                                    <td>{{$installment->order_item->order_id}}</td>
                                    <td>{{$installment->user->name}}</td>
                                    <td>{{$installment->order_item->product->name}}</td>
                                    <td>{{$installment->amount()}}</td>
                                    <td>
                                        <span class="badge bg-label-{{$installment->status_color()}}">
                                            {{$installment->status()}}
                                        </span>
                                    </td>
                                    <td>{{$installment->expire_at()}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
@section('vendor-script')
    @vite(['resources/assets/js/jalalidatepicker.js'])
@endsection

