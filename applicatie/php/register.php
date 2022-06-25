<?php
require_once '../php/connection.php';

session_start();

if (isset(
    $_POST["reg_username"],
    $_POST["reg_password"],
    $_POST["mail"],
    $_POST["firstname"],
    $_POST["lastname"],
    $_POST["birthdate"],
    $_POST["gender"],
    $_POST["country"],
    $_POST["card_number"],
    $_POST["payment_method"],
    $_POST["contract_type"]
)) {
    register();
} else {
    header('Location: /pages/login.php#register', true, 302);
    exit();
}

function register()
{
    unset($_SESSION["register-error"]);

    $pass = (string)$_POST["reg_password"];
    if (preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $pass) == 0) {
        $_SESSION['register-error'] = 'Password not corresponding with restrictions';
        header('Location: /pages/login.php#register', true, 302);
        exit();
    }

    $mail = $_POST["mail"];

    $connection = new pdo_mssql();
    $sql = "SELECT COUNT(*) as 'count' FROM Customer where customer_mail_address = :mail";
    $stmt = $connection->conn->prepare($sql);
    $stmt->execute([':mail' => $mail]);
    $count = $stmt->fetch();

    if ($count['count'] > 0) {
        $_SESSION['register-error'] = 'Email is allready in use';
        header('Location: /pages/login.php#register', true, 302);
        exit();
    }

    $username = $_POST["reg_username"];
    $password = password_hash($pass, PASSWORD_DEFAULT);
    unset($pass);
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $birthdate = $_POST["birthdate"];
    $gender = $_POST["gender"];
    $country = $_POST["country"];
    $card_number = $_POST["card_number"];
    $payment_method = $_POST["payment_method"];
    $contract_type = $_POST["contract_type"];
    $startDate = new DateTime();

    $newUser = new Customer();
    $newUser->user_name = $username;
    $newUser->password = $password;
    $newUser->customer_mail_address = $mail;
    $newUser->firstname = $firstname;
    $newUser->lastname = $lastname;
    $newUser->birth_date = $birthdate;
    $newUser->gender = $gender;
    $newUser->country_name = $country;
    $newUser->payment_card_number = $card_number;
    $newUser->payment_method = $payment_method;
    $newUser->contract_type = $contract_type;
    $newUser->subscription_start = $startDate->format("Y-m-d");

    try {
        $connection->insert($newUser);
    } catch (Exception $e) {
        $_SESSION['register-error'] = 'Something went wrong saving user';
        header('Location: /pages/login.php#register', true, 302);
        exit();
    }
}