<?php
session_start();

require_once './connection.php';
if (isset($_POST['username'], $_POST['password'])) {
    login();
} else {
    header('Location: /pages/login.php', true, 302);
    exit();
}

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
        if (($pass != null || $pass != '')) {
            if (password_verify($password, $pass)) {
                $_SESSION["loggedIn"] = true;
                $_SESSION["name"] = htmlspecialchars($res['firstname'] . ' ' . $res['lastname'], ENT_QUOTES, 'UTF-8');
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
                header('Location: pages/login.php', true, 302);
                exit();
            }
        } else {
            $_SESSION["login-error"] = 'Password not correct or Username not found';
            unset($pass, $password);
            header('Location: /pages/login.php', true, 302);
            exit();
        }
    } catch (Exception $e) {
    }
}