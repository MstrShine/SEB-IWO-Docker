<?php
require_once 'Entity.php';
class Payment extends Entity
{
    public ?string $payment_method;

    public function __construct(?string $method)
    {
        $this->payment_method = $method;
    }
}