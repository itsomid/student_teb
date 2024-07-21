<?php

namespace App\ShoppingCart\Exceptions;

use Exception;

class ProductNotCustomPackageException extends Exception
{
    protected $message = 'محصول پکیج نیست';
}
