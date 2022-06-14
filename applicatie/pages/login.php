<form class="login" method="post">
    <input required class="simple-input" placeholder="Username" type="text" id="username" name="username"><br><br>
    <input required class="simple-input" placeholder="Password" type="password" id="password" name="password"><br><br>
    <button class="simple-btn" type="submit">Log in</button>
</form>

<?php
include_once './php/connection.php';
function login()
{
    $username = $_POST['username'];
    try
    {
        $connection = new pdo_mssql();
        $sql = "SELECT TOP(1) password FROM Customer WHERE user_name = :username";
        $stmt = $connection->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetch();
    }
    catch (Exception $e)
    {

    }
}

if (isset($_POST['username'], $_POST['password'])) {
    login();
}
