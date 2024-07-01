@extends('dashboard.layout.master')
@section('title', 'افزایش اعتبار')
@section('content')
    <section class="form-control-repeater">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-yellow-accent-4">
                    <span class="fa fa-dollar "></span>
                    افزایش اعتبار
                </h4>
            </div>
            <div class="card-body">
                <form id="creditForm" class="form form-horizontal" action="{{ route('admin.increase-credit') }}" method="post">
                    @csrf
                    <div class="row align-items-center g-1">
                        <div class="col-auto">
                            <label for="creditAmount" class="form-label mb-0">میزان اعتبار مورد نظر (به ریال وارد شود):
                            </label>
                        </div>
                        <div class="col">
                            <input type="text" id="creditAmount" name="amount" class="form-control" placeholder="مبلغ به ریال وارد شود" onkeyup="amountSplitter()">
                            @error('amount')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                        <div class="col-auto">
                            <button type="submit" id="submitButton" class="btn btn-primary text-white">
                                <span class="fa fa-money-check-dollar ml-1"></span>
                                پرداخت از طریق درگاه
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
