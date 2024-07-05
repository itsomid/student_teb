<?php

use Illuminate\Support\Arr;

function generatePhone() : string
{
    return '09' . Arr::random(['02', '10', '38', '35', '90', '22', '12', '15', '19']) . rand(1000000, 9999999);
}

function generatePassword() : string
{
    return  Arr::random([11, 22 , 33 , 44 , 55 , '00']).
            Arr::random([11, 22 , 33 , 44 , 55 , '00']).
            Arr::random([11, 22 , 33 , 44 , 55 , '00']).
            Arr::random([11, 22 , 33 , 44 , 55 , '00']).
            Arr::random([11, 22 , 33 , 44 , 55 , '00']);
}

function verificationToken() : string
{
    return  rand(10000, 99999);
}

function generateMemorableVerificationCode() : string
{
    $firstNumber=  rand(1,9);
    $secondNumber= rand(0,9);
    $thirdNumber=  rand(1,9);

    return  Arr::random([$firstNumber,$secondNumber,$thirdNumber]).
            Arr::random([$firstNumber,$secondNumber,$thirdNumber]).
            Arr::random([$firstNumber,$secondNumber,$thirdNumber]).
            Arr::random([$firstNumber,$secondNumber,$thirdNumber]).
            Arr::random([$firstNumber,$secondNumber,$thirdNumber]);
}
if (!function_exists('formatNumberWithSlashes')) {
    /**
     * Format the number with slashes.
     *
     * @param float $number
     * @return string
     */
    function formatNumberWithSlashes($number)
    {
        $number = number_format($number, 0, '', ','); // Format the number with commas
        return str_replace(',', '/', $number); // Replace commas with slashes
    }
}
