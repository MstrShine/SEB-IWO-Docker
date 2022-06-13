<?php
class Customer extends Entity
{

    public string $customer_mail_address;
    public string $lastname;
    public string $firstname;
    public string $payment_method;
    public string $payment_card_number;
    public string $contract_type;
    public string $subscription_start;
    public string $subscription_end;
    public string $user_name;
    public string $password;
    public string $country_name;
    public string $gender;
    public string $birth_date;

    public function __construct()
    {
        
    }
}