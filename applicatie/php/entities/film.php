<?php
include 'entity.php';

class Film extends Entity {
    public string $Name;

    public function __construct(int $id, string $name)
    {
        $this->Id = $id;
        $this->Name = $name;
    }
}