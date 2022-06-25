<?php
require_once '../php/formData.php';

$countries = array();
$contracts = array();
$payMethods = array();
fetchRegisterFormData($countries, $contracts, $payMethods);
?>

<div id="register" class="overlay">
    <div class="popup">
        <h2>Register</h2>
        <a class="close" href="pages/login.php#">&times;</a>
        <div class="content">
            <form action="../php/register.php" method="post">
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
                <input required class="simple-input" type="password" name="reg_password" placeholder="Password"
                    pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}">
                <small>Password needs to be at least 8 characters long, has one capital letter and one special
                    character</small>
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
                <?php
                if (isset($_SESSION['register-error'])) {
                    $error = $_SESSION['register-error'];
                    echo ("<p class=\"error\">$error</p>");
                }
                ?>
                <button class="simple-btn" type="submit">Register</button>
            </form>
        </div>
    </div>
</div>