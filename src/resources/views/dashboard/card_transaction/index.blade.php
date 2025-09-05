@extends('dashboard.layout.master')
@section('title', 'تراکنش های کارت به کارت دانشجو')
@section('content')
    <div class="row">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">جست و جو</h5>
                <form class="row" action="{{route('admin.card-transaction.index')}}" method="get">
                    <div class="col-md-6 user_role">
                        <label class="form-label" for="id">شناسه یکتا :</label>
                        <input type="text" class="form-control" name="id" id="id"  placeholder="شناسه یکتا را وارد کنید" value="{{request()->input('id') ?? '' }}">
                    </div>
                    <div class="col-md-6 user_role">
                        <label for="selectStudent">کاربر:</label>
                        <x-student-selection-component
                            name="user_id"
                            multiple="0"
                            selected="{{ request()->input('user_id', null)}}">
                        </x-student-selection-component>
                    </div>
                    <div class="col-md-6 user_role">
                        <label class="form-label" for="statusSelect">وضعیت تراکنش :</label>
                        <select class="form-select" name="status" id="statusSelect">
                            <option value="1" {{request()->input('status') == \App\Enums\CardTransactionStatusEnum::Pending->value ?'selected': ''}}>در حال بررسی</option>
                            <option value="2" {{request()->input('status') == \App\Enums\CardTransactionStatusEnum::Approved->value ?'selected': ''}}>تایید شده</option>
                            <option value="3" {{request()->input('status') == \App\Enums\CardTransactionStatusEnum::Rejected->value ?'selected': ''}}>تایید نشده</option>
                            <option value="4" {{request()->input('status') == \App\Enums\CardTransactionStatusEnum::ManagementReview->value ?'selected': ''}}>پردازش مدیریت</option>
                        </select>
                    </div>
                    <div class="col-md-6 user_role">
                        <label class="form-label" for="amount">مبلغ :</label>
                        <input type="number" class="form-control" name="amount" id="amount"  placeholder="مبلغ را وارد کنید" value="{{request()->input('amount') ?? '' }}">
                    </div>
                    <div class="col-md-6 mt-2 user_role">
                        <label class="form-label" for="created_at">از تاریخ:</label>
                        <input type="text" class="form-control" name="created_at"  placeholder="از تاریخ" data-jdp>
                    </div>
                    <div class="col-md-6 mt-2 user_role">
                        <label class="form-label" for="created_at">تا تاریخ:</label>
                        <input type="text" class="form-control" name="created_at"  placeholder="تا تاریخ" data-jdp>
                    </div>

                    <div class="col-md-12 mt-2">
                        <button class="btn btn-success">
                            <i class="fa-solid fa-magnifying-glass mx-2"></i>
                            جست و جو
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">لیست کارت به کارت ها</h5>
                        <div class="card-title-elements ms-auto">
                            <a class="btn btn-primary text-white" href="{{route('admin.card-transaction.create')}}">
                                <i class="fa fa-plus mx-2"></i>
                                افزودن تراکنش جدید
                            </a>
                        </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>شناسه یکتا</th>
                            <th>دانشجو</th>
                            <th>کد رهگیری</th>
                            <th>مبلغ</th>
                            <th>وضعیت</th>
                            <th>فایل رسید</th>
                            <th>یادداشت</th>
                            <th>تاریخ پرداخت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($cardTransactions as $transaction)
                            <tr>
                                <td>
                                    {{$transaction->id}}
                                </td>

                                <td>
                                    {{$transaction->student->name}}
                                </td>
                                <td>
                                    {{$transaction->tracking_code}}
                                </td>
                                <td>
                                    {{number_format($transaction->amount)}}
                                    ریال
                                </td>
                                <td>
                                    <card-transaction-select
                                        url="{{ route('admin.card-transaction.change-status', $transaction->id) }}"
                                        selected_option="{{$transaction->status}}"
                                    ></card-transaction-select>
                                </td>
                                <td>
                                    <a href="{{$transaction->getImageUrl()}}" target="_blank">
                                        <img src="{{$transaction->getImageUrl()}}" class="img-fluid" width="50">
                                    </a>

                                </td>

                                <td>
                                    <a class="btn  btn-warning btn-block p-2 dropdown-item text-white"
                                       href="#"  data-bs-toggle="modal" data-bs-target="#modal-{{ $transaction->id }}" data-bs-whatever="@mdo">
                                        <i class="fa-sharp fa-regular fa-book"></i>
                                    </a>

                                    <note-modal id="modal-{{ $transaction->id }}" sales_description="{{ $transaction->description }}" url="{{ route('admin.card-transaction.update-description', $transaction->id) }}"></note-modal>
                                </td>
                                <td>
                                    {{$transaction->paid_date()}}
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"  href="{{route('admin.card-transaction.edit', [$transaction->id])}}">
                                                <i class="fa-regular fa-user-pen mx-1"></i>
                                                ویرایش تراکنش
                                            </a>


                                                <button class="dropdown-item"  type="button" data-bs-toggle="modal" data-bs-target="#exampleModal_{{$transaction->id}}" data-bs-whatever="@mdo">
                                                    <i class="fa-regular fa-trash mx-1"></i>
                                                    حذف تراکنش
                                                </button>


                                        </div>
                                        <div class="modal fade" id="exampleModal_{{$transaction->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-top">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">تایید حذف تراکنش</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        آیا از حذف این تراکنش مطمئن هستید؟
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">بستن</button>
                                                        <form action="{{route('admin.card-transaction.destroy' , [$transaction->id])}}" method="post">
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
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            {{$cardTransactions->render()}}
        </div>
    </div>
@endsection
