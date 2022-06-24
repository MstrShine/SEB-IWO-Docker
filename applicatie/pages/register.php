<?php
require_once '../php/connection.php';
require_once '../models/Country.php';
require_once '../models/Contract.php';
require_once '../models/Payment.php';
require_once '../models/Customer.php';

$connection = new pdo_mssql();
$countries = $connection->selectAll(new Country(null));
$contracts = $connection->selectAll(new Contract(null, null, null));
$payMethods = $connection->selectAll(new Payment(null));
$connection->close();
unset($connection);
?>

<div id="register" class="overlay">
    <div class="popup">
        <h2>Register</h2>
        <a class="close" href="pages/login.php#">&times;</a>
        <div class="content">
            <form method="post">
                <input required class="simple-input" type="text" name="mail" placeholder="E-mail">
                <input required class="simple-input" type="text" name="firstname" placeholder="Firstname">
                <input required class="simple-input" type="text" name="lastname" placeholder="Lastname">
                <input required class="simple-input" type="date" name="birthdate">
                <label>Gender:</label>
                <input required type="radio" name="gender" value="M">M
                <input required type="radio" name="gender" value="V">V
                <select required class="simple-input" name="country">
                    <option selected disabled value="">Select your country:</option>
                    <?php
                    foreach ($countries as $country) {
                        $countryName = $country["country_name"];
                        echo ("<option value=\"$countryName\">$countryName</option>");
                    }
                    ?>
                </select>
                <input required class="simple-input" type="text" name="reg_username" placeholder="Username">
                <input required class="simple-input" type="password" name="reg_password" placeholder="Password">
                <input required class="simple-input" type="text" name="card_number" placeholder="Card number">
                <select required class="simple-input" name="payment_method">
                    <option selected disabled value="">Select your payment method:</option>
                    <?php
                    foreach ($payMethods as $method) {
                        $m = $method["payment_method"];
                        echo ("<option value=\"$m\">$m</option>");
                    }
                    ?>
                </select>
                <select required class="simple-input" name="contract_type">
                    <option selected disabled value="">Select your contract:</option>
                    <?php
                    foreach ($contracts as $contract) {
                        $type = $contract["contract_type"];
                        $cost = $contract["price_per_month"];
                        echo ("<option value=\"$type\">$type - €$cost p/m</option>");
                    }
                    ?>
                </select>
                <button class="simple-btn" type="submit">Register</button>
            </form>
        </div>
    </div>
</div>

<?php
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
}

function register()
{
    $username = $_POST["reg_username"];
    $password = password_hash((string)$_POST["reg_password"], PASSWORD_DEFAULT);
    $mail = $_POST["mail"];
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

    $connection = new pdo_mssql();
    $connection->insert($newUser);
}
?>