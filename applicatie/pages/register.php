<?php 
    require_once('connection.php');
    $connection = new pdo_mssql();
    $countries = $connection->selectAll(new Country(null));
?>

<form class="register" method="POST">
    <input type="text" name="mail">
    <input type="text" name="firstname">
    <input type="text" name="lastname">
    <input type="text" name="payment_method">
    <input type="text" name="card_number">
    <input type="text" name="contract_type">
    <input type="date" name="start">
    <input type="date" name="end">
    <input type="text" name="username">
    <input type="text" name="password">
    <select name="country">
        <?php
            foreach($countries as $value)
            {
                echo("<option value=\"$value\">$value</option>");
            }
        ?>
    </select>
    <input type="radio" name="gender" value="M">M
    <input type="radio" name="gender" value="V">V
    <input type="date" name="birthdate">
    <button class="simple-btn" type="submit">
</form>