<?php
require_once 'Entity.php';
class Person extends Entity
{
    public int $person_id;
    public string $firstname;
    public string $lastname;
    public string $gender;
}
