<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>بریم برای تست بانک</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    @if(isset($error_message))
        <div class="alert alert-danger text-center">
            {{$error_message}}
        </div>
    @endif


    <form action="/go_to_gateway" method="get">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <input type="number" value="1000" name="price"  class="form-control my-3" placeholder="Enter Price (RIAL)">
            </div>

            <div class="col-md-6">
                <button type="submit" class="w-100 btn btn-primary">برو تو درگاه</button>
            </div>
        </div>

    </form>

</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
