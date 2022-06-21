<?php
require_once 'Entity.php';

class Contract extends Entity
{
    public ?string $contract_type;
    public ?float $price_per_month;
    public ?float $discount_percentage;

    public function __construct(?string $contract_type, ?float $price, ?float $discount)
    {
        $this->contract_type = $contract_type;
        $this->price_per_month = $price;
        $this->discount_percentage = $discount;
    }
}
