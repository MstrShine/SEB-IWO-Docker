<form class="login" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>
    <button type="submit">Log in</button>
</form>

<?php
function login()
{
    try
    {
        session_start();
        $connection = new pdo_mssql();
        $sql = "SELECT password FROM Customer WHERE user_name = :username";
        $res = $connection->conn->prepare($sql)->fetch();
    }
    catch (Exception $e)
    {
        session_destroy();
    }
}

if (isset($_POST['username'], $_POST['password'])) {
    login();
}
