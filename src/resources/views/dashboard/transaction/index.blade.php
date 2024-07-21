@extends('dashboard.layout.master')
@section('title', 'مدیریت تراکنش ها')
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">فیلتر</h5>
                </div>
                <form action="{{route('admin.transaction.index')}}" method="get">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group mt-3">
                                <label for="type">نوع تراکنش:</label>
                                <select name="type" class="form-control" id="type">
                                    <option value=" ">همه</option>
                                    @foreach(\App\Enums\TransactionTypeEnum::cases() as $case)
                                        <option value="{{$case->name}}" {{request()->has('type') && request()->input('type') == $case->name ? 'selected' : "" }}>
                                            {{\App\Enums\TransactionTypeEnum::TYPE_LABEL[$case->value]}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group mt-3">
                                <label for="selectStudent">کاربر مصرف کننده :</label>
                                <select name="user"
                                        id="selectStudent"
                                        class="select2 form-control"
                                        data-selected="[{{request()->has('user') ? request()->input('user') : '' }} ]"
                                        src="{{route('admin.students.select.index')}}">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mt-3"><br>
                                <button class="btn btn-success text-white" type="submit">
                                    <span>فیلتر</span><i class="fas fa-filter mx-3"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-5">
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
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/vendor/js/forms-selects.js',
            'resources/assets/js/student.js',
          ])
@endsection
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection
