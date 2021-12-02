<?

use classes\User;

require_once __DIR__ . '/vendor/autoload.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE);

if (isset($_POST["remember"])) {
    if ($_POST["remember"] == true) {
        session_set_cookie_params(360000);
    } else {
        session_set_cookie_params(10800);
    }
} else {
    session_set_cookie_params(10800);
}
session_start();

$badPassMessage = '';

if (isset($_POST['go'])) {
    User::setLogin($_REQUEST['login']);

    if (User::Signin($_REQUEST['password'])) {
        $_SESSION['enter'] = "1";
        $_SESSION['us_id'] = User::$user_id;
        echo '<script type="text/javascript">
                location="index.php" 
            </script>';
    } else {
        $badPassMessage = '<div class="clean-gray">Неверное сочетание логина и пароля</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Claire | stat</title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>CLAIRE</b> STAT</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Войдите, для работы</p>

            <form action="" method="post">
                <div class="input-group mb-3">
                    <input name="login" type="text" class="form-control" placeholder="Логин">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input name="password" type="password" class="form-control" placeholder="Пароль">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <?= $badPassMessage ?>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">
                                Запомнить меня
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" name="go" class="btn btn-primary btn-block">Войти</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
