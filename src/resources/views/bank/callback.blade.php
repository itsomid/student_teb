<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>بازگشت از درگاه</title>

    @vite(['resources/assets/scss/admin/app.scss'])
</head>
<body dir="rtl">

<div class="container mt-5 text-center ">
    @if(isset($error_message))
        <div class="alert alert-danger text-center">
            {{$error_message}}
        </div>

        <a href="{{config('gateway.redirect_cart_path').'?status=failed'}}"
           class="btn btn-info text-center">بازگشت به پنل کاربری</a>
    @else

        <div class="row">
            <div class="col-12 col-md-6 ms-auto">
                <div class="alert alert-success text-center rtl">
                    <h3>پرداخت با موفقیت انجام شد</h3>
                    <p>از پرداختتان متشکریم!</p>
                </div>
                <div class="table-responsive">
                    <table class="table card-table">
                        <tbody class="table-border-bottom-0">
                        <tr>
                            <td class="w-50 ps-0">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="me-2">
                                        <i class="ti ti-truck mt-n1"></i>
                                    </div>
                                    <h6 class="mb-0 fw-normal">مبلغ پرداخت شده</h6>
                                </div>
                            </td>
                            <td class="text-start pe-0 text-nowrap">
                                <h6 class="mb-0">{{formatNumberWithSlashes($transaction->price)}} ریال</h6>
                            </td>

                        </tr>
                        <tr>
                            <td class="w-50 ps-0">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="me-2">
                                        <i class="ti ti-circle-arrow-down mt-n1"></i>
                                    </div>
                                    <h6 class="mb-0 fw-normal">نوع پرداخت</h6>
                                </div>
                            </td>
                            <td class="text-start pe-0 text-nowrap">
                                <h6 class="mb-0">درگاه بانکی</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-50 ps-0">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="me-2">
                                        <i class="ti ti-circle-arrow-up mt-n1"></i>
                                    </div>
                                    <h6 class="mb-0 fw-normal">شماره ارجاع</h6>
                                </div>
                            </td>
                            <td class="text-start pe-0 text-nowrap">
                                <h6 class="mb-0">{{$transaction->ref_id}}</h6>
                            </td>

                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <a href="{{config('gateway.redirect_cart_path').'?status=success&receipt='.$order_id}}"
           class="btn btn-info text-center">بازگشت به پنل کاربری</a>
    @endif


</div>

</body>
</html>
