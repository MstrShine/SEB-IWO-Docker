<?php
class Country extends Entity
{
    public string $country_name;

    public function __construct(?string $name)
    {
        $this->country_name = $name;
    }
}