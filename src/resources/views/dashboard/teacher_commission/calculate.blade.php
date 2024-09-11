@extends('dashboard.layout.master')
@section('title', 'افزودن دانش آموز جدید')
@section('content')
    <div class="content" style="min-height: auto;">

        <div class="row">
            <div class="col-lg-4 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>آمار دوره های استاد</span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2">{{ $teacher->fullname() }}</h4>
                                </div>
                            </div>
                            <span class="badge bg-label-warning rounded p-2">
                                <i class="fa-solid fa-users"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>مجموع بلاک شده برای مالیات (30% نقدینگی کل)</span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2" id="sum_blocked_amount">0</h4>
                                </div>
                            </div>
                            <span class="badge bg-label-success rounded p-2">
                                <i class="fa-solid fa-dollar"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>مجموع نقدینگی خرید محصولات</span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2 sum_cash_amount">0</h4>
                                </div>
                            </div>
                            <span class="badge bg-label-primary rounded p-2">
                                <i class="fa-solid fa-dollar"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-3">

            <div class="col-lg-4 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>تراز مالی استاد</span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2" id="taraz_maali">0</h4>
                                </div>
                            </div>
                            <span class="badge bg-label-secondary rounded p-2">
                                <i class="fa-solid fa-dollar"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-4 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>مجموع پرداختی به استاد</span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2 sum_payments">0</h4>
                                </div>
                            </div>
                            <span class="badge bg-label-dark rounded p-2">
                                <i class="fa-solid fa-dollar"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span> <small style="display: inline;">(با احتساب بلاک مالیات به نسبت)</small></span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2" id="sum_needs_to_be_paid">0</h4>
                                </div>
                            </div>
                            <span class="badge bg-label-danger rounded p-2">
                                <i class="fa-solid fa-dollar"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="content-header mt-2">
        <h1>
            محصولات استاد {{ $teacher->name }}
        </h1>
    </section>
    <div class="content">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.teacher-commission.save-percentage', $teacher->id) }}">
                    @csrf
                <table class="table table-responsive table-striped table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <th>درصد استاد</th>
                        <th>درصد بلاک مالیات</th>
                        <th>نام محصول</th>
                        <th>تعداد دانش آموزان</th>
                        <th>مجموع خرید</th>
                        <th>مجموع نقدینگی</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($products as $product)
                        <tr>
                            <td>
                                <input type="hidden" value="{{$teacher->id}}" name="teacher_id">
                                <input type="checkbox" name="product_checked[{{$product->id}}]" value="{{$product->id}}" class="sum_checkbox"
                                       @if(in_array($product->id, $teacherPaymentsSettings['product_checked']))
                                           checked
                                    @endif
                                >
                                <input type="hidden" name="product_checkbox_all[{{$product->id}}]" value="{{$product->id}}">
                            </td>
                            <td>
                                <input type="text"
                                       class="calcSum border"
                                       value="{{ $product->teacher_commission->product_percentage ?? 50 }}"
                                       style="width: 35px;text-align: center"
                                       name="product_percentage[{{$product->id}}]"
                                       id="product_percentage_{{$product->id}}">
                                %
                            </td>
                            <td>
                                <input type="text"
                                       class="calcSum border"
                                       style="width: 35px;text-align: center"
                                       value=" {{ $product->teacher_commission->tax_block_percentage ?? 30 }} "
                                       name="tax_percentage[{{$product->id}}]"
                                       id="tax_percentage_{{$product->id}}">
                                %
                            </td>
                            <td>
                                @if($product->product_type_id === \App\Enums\ProductTypeEnum::COURSE)
                                <a href="{{ route('admin.course.edit', $product->course->id) }}" class="text-warning">{{ $product->name }}</a>
                                @elseif($product->product_type_id === \App\Enums\ProductTypeEnum::CUSTOM_PACKAGE)
                                    <a href="{{ route('admin.custom-package.edit', $product->id) }}" class="text-success">{{ $product->name }}</a>
                                @else
                                    {{ $product->name }} {{ $product->product_type_id }}
                                @endif
                            </td>
                            <td>{{ $product->order_items_count }} نفر</td>
                            <td>{{ number_format((int)$product->order_items_sum_final_price) }} ریال </td>
                            <td>{{ number_format((int)$product->cash_amounts_sum_cash_amount) }} ریال </td>
                        </tr>
                    @endforeach

                    <tr style="font-weight: bold;">
                        <td colspan="4">
                            <button class="btn btn-primary text-white" type="submit">ذخیره درصدها و انتخاب ها</button>
                        </td>
                        <td><div id="sum_students"></div></td>
                        <td><div id="sum_buy_amount"></div></td>
                        <td><div class="sum_cash_amount"></div></td>
                    </tr>
                    </tbody>
                </table>
                </form>
            </div>
        </div>
    </div>

    <section class="content-header mt-3">
        <h1>
            پرداختی های استاد {{ $teacher->fullname() }}
        </h1>
    </section>
    <div class="content">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-striped table-hover">
                    <thead>
                    <tr>
                        <th>آیدی محصول</th>
                        <th>نام محصول</th>
                        <th>مجموع پرداختی</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $payment)
                        <tr id="payment_{{$payment->product_id}}">
                            <td>{{ $payment->product_id }}</td>
                            <td>
                                @if(!$payment->product)
                                    <span class="text-danger">درس دستخوش تغییراتی همچون حذف یا آرشیو شده است</span>
                                @else
                                    {{ $payment->product->name }}
                                @endif
                            </td>
                            <td>{{ number_format($payment->sum_amount) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>


    <section class="content-header mt-3">
        <h1>
            تاریخچه تغییر کمیسیون {{ $teacher->fullname() }}
        </h1>
    </section>
    <div class="content mt-3">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-striped table-hover">
                    <thead>
                    <tr>
                        <th>نام محصول</th>
                        <th>درصد استاد</th>
                        <th>درصد بلاک مالیات</th>
                        <th>تغییر توسط</th>
                        <th>تاریخ</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($historyChanged as $changed)
                        <tr>
                            <td>
                                @if($changed->product)
                                    {{ $changed->product->name }}
                                @else
                                    <span class="text-danger">درس دستخوش تغییراتی همچون حذف یا آرشیو شده است</span>
                                @endif
                            </td>
                            <td>{{ $changed->product_percentage }}</td>
                            <td>{{ $changed->tax_block_percentage }}</td>
                            <td>{{ $changed->admin_changed_by->fullname() }}</td>
                            <td>{{ $changed->created_at() }}</td>

                        </tr>
                    @endforeach


                    </tbody>
                </table>

            </div>
        </div>

    </div>


@endsection
@section('scripts')
    <script src="{{ asset('/js/calculate-teacher-commission.js') }}"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            const mySumArr = JSON.parse('@json($teacherSoldProducts)'); // Replace with the actual data if you have it
            calculateSum(mySumArr);

            document.querySelectorAll('.sum_checkbox, .calcSum').forEach((element) => {
                element.addEventListener('change', () => calculateSum(mySumArr));
            });
        });
    </script>
@endsection
@section('vendor-script')
    @vite([
    'resources/assets/vendor/libs/jquery/jquery.js',
    ])
@endsection
