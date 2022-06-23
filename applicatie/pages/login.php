<!DOCTYPE html>
<html lang="en">
<?php
$title = 'Fletnix - Login';
require_once './modules/head.php';
if (isset($_SESSION['loggedIn'])) {
    header("Location: /");
    exit();
}
?>

<body>
    <?php require_once './modules/navbar.php'; ?>
    <main>
        <div class="login">
            <form method="post">
                <input required class="simple-input" placeholder="Username" type="text" id="username" name="username">
                <input required class="simple-input" placeholder="Password" type="password" id="password"
                    name="password">
                <button class="simple-btn" type="submit">Log in</button>
            </form>
            <?php if (isset($_SESSION["login-error"])) echo ("<p class=\"error\">" . (string)$_SESSION["errors"] . "</p>"); ?>
            <a href="pages/login.php#register"><button class="simple-btn">Register</button></a>
        </div>
    </main>
    <?php require_once './register.php'; ?>
</body>

</html>

<?php
unset($_SESSION["login-error"]);
require_once '../php/connection.php';
function login()
{
    unset($_SESSION["login-error"]);

    $username = $_POST["username"];
    $password = $_POST["password"];
    try {
        $connection = new pdo_mssql();
        $sql = "SELECT TOP(1) password, firstname, lastname FROM Customer WHERE user_name = :username";
        $stmt = $connection->conn->prepare($sql);
        $stmt->execute([':username' => $username]);
        $res = $stmt->fetch();
        $pass = $res["password"] ?? null;
        if ($pass != null || $pass != '') {
            if (password_verify($password, $pass)) {
                $_SESSION["loggedIn"] = true;
                $_SESSION["name"] = htmlspecialchars($res['firstname'] . ' ' . $res['lastname']);
                unset($pass, $password);

                $redirect = $_SESSION['prevPage'];
                if (str_contains($redirect, 'fid=')) {
                    $_SESSION['prevPage'] = null;
                    header("Location: $redirect", true, 302);
                    exit();
                }

                header('Location: /', true, 302);
                exit();
            } else {
                $_SESSION["login-error"] = 'Password not correct or Username not found';
                unset($pass, $password);
            }
        } else {
            $_SESSION["login-error"] = 'Password not correct or Username not found';
            unset($pass, $password);
        }
    } catch (Exception $e) {
    }
}

if (isset($_POST['username'], $_POST['password'])) {
    login();
}
?>