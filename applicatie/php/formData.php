<?php
require_once '../php/data/connection.php';

require_once '../models/Country.php';
require_once '../models/Contract.php';
require_once '../models/Payment.php';
require_once '../models/Customer.php';

function fetchRegisterFormData(&$countries, &$contracts, &$payMethods)
{
    $pdo = new pdo_mssql();
    $countries = $pdo->selectAll(new Country(null));
    $contracts = $pdo->selectAll(new Contract(null, null, null));
    $payMethods = $pdo->selectAll(new Payment(null));
}