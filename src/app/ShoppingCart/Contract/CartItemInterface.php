<?php

namespace App\ShoppingCart\Contract;

use App\ShoppingCart\Installment;
use Illuminate\Database\Eloquent\Model;

interface CartItemInterface
{
    public function save(): void;
    public function getModel(): Model;
    public function addModel(Model $model): void;
    public function update(): self;
    public function remove(): void;
    public function getCalcPrice(): int;
    public function getPrice(): int;
    public function getTax(): float|int;
    public function getPriceWithDiscount(): int;
    public function getOriginalPrice(): int;
    public function getVatPercentage(): float;
}
