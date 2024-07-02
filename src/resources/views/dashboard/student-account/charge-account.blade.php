@extends('dashboard.layout.master')
@section('title', 'افزایش اعتبار')
@section('content')
    <section class="form-control-repeater">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-yellow-accent-4">
                    <span class="fa fa-dollar"></span>
                    افزایش اعتبار
                </h4>
            </div>
            <div class="card-body">
                <form id="creditForm" class="form form-horizontal" action="{{ route('admin.student-account.charge') }}" method="post">
                    @csrf
                    <div class="row align-items-center g-1">
                        <div class="col">
                            <label for="selectStudent" class="form-label mb-0">دانش آموز:
                            </label>
                            <div class="form-group">
                                <select name="user_id"
                                        id="selectStudent"
                                        class="select2 form-control"
                                        src="{{route('admin.students.select.index')}}">
                                </select>
                                @error('user_id')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                        <div class="col">
                            <label for="amount" class="form-label mb-0">میزان اعتبار مورد نظر (به ریال وارد شود):
                            </label>
                            <input type="text" id="amount" name="amount" class="form-control" placeholder="مبلغ به ریال وارد شود" onkeyup="amountSplitter()">
                            @error('amount')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <div class="row align-items-center g-4 mt-2">
                        <div class="col">
                            <div class="form-group">
                                <span class="switch-label ml-1" id="label_for_">اعتبار هدیه: </span>
                                <label class="switch switch-primary">
                                    <input type="checkbox"
                                           class="switch-input"
                                           data-input_id="allocation_rate_"
                                           data-label_id="label_for_"
                                           name="gift_credit"

                                    />
                                    <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                              <i class="ti ti-check"></i>
                                            </span>
                                            <span class="switch-off">
                                              <i class="ti ti-x"></i>
                                            </span>
                                        </span>
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="user_description" class="form-label mb-0">توضیحات:</label>
                                <textarea class="form-control" id="user_description" name="user_description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center g-2 mt-2">
                        <div class="col text-center">
                            <button type="submit" id="submitButton" class="btn btn-primary text-white">
                                <span class="fa fa-money-check-dollar ml-1"></span>
                                شارژ اکانت
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
        // Function to format number with commas
        function formatNumberWithCommas(number) {
            return number.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        function amountSplitter() {
            const creditAmountElement = document.getElementById('creditAmount')
            let value = creditAmountElement.value.replace(/,/g, ''); // Remove existing commas
            creditAmountElement.value = formatNumberWithCommas(value);
        }
    </script>
@endsection
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/vendor/js/forms-selects.js',
            'resources/assets/js/student.js',
          ])
@endsection
