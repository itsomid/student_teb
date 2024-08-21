@extends('dashboard.layout.master')
@section('title', 'مدیریت اقساط')
@section('content')
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">مدیریت اقساط</h5>
                </div>
               <form class="row" action="{{route('admin.installment.index')}}">
                   <div class="col-md-5">
                       <div class="form-group">
                           <x-course-list-component
                               name="product_id[]"
                               multiple="1"
                               selected="{{request()->has('product_id') ? json_encode(request()->input('product_id'),JSON_NUMERIC_CHECK) : '[]' }}"
                           >
                           </x-course-list-component>
                       </div>
                   </div>

                   <div class="col-md-3">
                       <div class="form-group">
                           <x-student-selection-component
                               name="user_id[]"
                               multiple="1"
                               selected="{{request()->has('user_id') ? json_encode(request()->input('user_id'),JSON_NUMERIC_CHECK) : '[]' }}">
                           </x-student-selection-component>
                       </div>
                   </div>
                   <div class="col-md-2">
                       <div class="form-group">
                           <label for="statusSelect" class="text-muted">انتخاب وضعیت</label>
                           <select name="status" class="form-control" id="statusSelect">
                               <option {{request()->input('status') == 'paid'     ? 'selected' : ''}} value="paid"   >پرداخت شده</option>
                               <option {{request()->input('status') == 'pending'  ? 'selected' : ''}} value="pending">در انتظار پرداخت</option>
                           </select>
                       </div>
                   </div>
                   <div class="col-md-2 align-content-end">
                       <div class="form-group">
                           <button type="submit" class="btn btn-primary text-white w-100">جست و جو</button>
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

