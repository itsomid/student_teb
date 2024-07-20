@extends('dashboard.layout.master')
@section('title', 'مدیریت تراکنش ها')
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">لیست تراکنش ها</h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>کاربر</th>
                                <th>مبلغ</th>
                                <th>نوع</th>
                                <th>توضیحات کاربر</th>
                                <th>تاریخ ایجاد</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{$transaction->id}}</td>
                                    <td>{{$transaction->user->name}}</td>
                                    <td>{{$transaction->amount()}}</td>
                                    <td>
                                        <span class="text-{{\App\Enums\TransactionTypeEnum::TYPE_COLOR[$transaction->transaction_type->value]}}">
                                           {{\App\Enums\TransactionTypeEnum::TYPE_LABEL[$transaction->transaction_type->value]}}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{$transaction->user_description}}</small>
                                    </td>
                                    <td>{{$transaction->created_at()}}</td>
                                    <td>
                                        @if($transaction->deposit)
                                            <a href="" class="btn btn-{{\App\Enums\DepositTypeEnum::TYPE_COLOR[$transaction->deposit->deposit_type->value]}} btn-sm">
                                                {{\App\Enums\DepositTypeEnum::TYPE_LABEL[$transaction->deposit->deposit_type->value]}}
                                            </a>
                                         @endif

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
