<?php
namespace App\SMS\Operators;

use Illuminate\Support\Facades\Http;

class Kavenegar
{
    private $address;
    private $lookup_address;
    private $receptor;

    private function __construct()
    {
        $this->address         = config("sms.services.kavenegar.address");
        $this->lookup_address  = config("sms.services.kavenegar.lookup_address");
    }

    public static function to($receptor)
    {
        $object= new static();
        $object->receptor = $receptor;
        return $object;
    }

    public function send($receptor , $message)
    {
        $body = [
            "receptor" => $receptor,
            "message"  => $message ,
        ];
        $response = Http::get( $this->address,$body);
        return  $this->hasSucceed($response) ? true : false;
    }

    public function sendLookUp($template, $token1= null, $token2= null , $token3= null)
    {
        $body = [
            "receptor"  => $this->receptor,
            "token"     => $this->refactor($token1),
            "token2	"   => $this->refactor($token2),
            "token3	"   => $this->refactor($token3),
            "template"  => $template,
        ];

        $response = Http::get( $this->lookup_address,$body);
        return  $this->hasSucceed($response) ? true : false;
    }

    private function hasSucceed($response): bool
    {
        return $response->status() == 200 && json_decode($response->body())->entries[0]->status == 5;
    }
    private function refactor($token)
    {
        $token = str_replace(" " , " ", $token);
        $token = str_replace("-" , " ", $token);
        $token = str_replace("_" , " ", $token);
        $token = str_replace("\n", ".",    $token);
        return $token;
    }
}
