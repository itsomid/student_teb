<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>بریم برای تست بانک</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5 text-center">
    @if(isset($error_message))
        <div class="alert alert-danger text-center">
            {{$error_message}}
        </div>

        <a href="/bank" class="btn btn-info text-center">صفحه ی درگاه</a>
    @else
        <div class="alert alert-danger text-center">
            فک کنم پرداخته انجام شدش، چون اگه ارور میداد باید الان یه چی میداشتم که نشون بدم.
        </div>
    @endif


</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
