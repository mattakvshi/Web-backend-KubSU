<?php
    header('Content-Type: text/html; charset=UTF-8');

    session_start();

    if (!empty($_SESSION['login']))
    {
        session_destroy();
        header('Location: ./');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        ?>

        <head>
          <meta charset="UTF-8" />
          <meta http-equiv="X-UA-Compatible" content="IE=edge" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <link href="style.css" rel="stylesheet" type="text/css" />
          <link rel="preconnect" href="https://fonts.gstatic.com" />
          <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap"
            rel="stylesheet"
          />
          <title>mattakvshi</title>
        </head>
        <body>
            <div class="container">
              <form action = "" method = "POST">
                <p>Авторизация</p>
                <input name = "user_login" type = "text" placeholder = "Логин"><br>
                <input name = "user_passwords" type = "text" placeholder = "Пароль"><br>
                <input type = "submit" value = "Войти"><br>
              </form>

              <div class="drops">
                <div class="drop drop-1"></div>
                <div class="drop drop-2"></div>
                <div class="drop drop-3"></div>
                <div class="drop drop-4"></div>
                <div class="drop drop-5"></div>
              </div>
            </div>
        </body>

        <?php
        if (!empty($_GET['none']))
        {
          $message = "Неверные данные!";
          print($message);
        }
    }

    else
    {
      $user = 'u52862'; 
      $password = '5476105';
      $database = new PDO('mysql:host=localhost;dbname=u52862', $user, $password, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $user_login = $_POST['user_login'];
        $user_password = md5($_POST['user_passwords']);
        $statement = $database -> prepare("SELECT user_log_id FROM Users_Logins WHERE user_login = ? AND user_passwords = ?");
        $statement -> execute([$user_login, $user_password]);
        $user_id = $statement -> fetch(PDO::FETCH_COLUMN);

        if ($user_id)
        {
            $_SESSION['login'] = $_POST['user_login'];
            $_SESSION['uid'] = $user_id;
            $_COOKIE['debug_' . session_name()] = "session_true";
            header('Location: ./');
        }

        else
        {
          header('Location: error.php');
        }
    }
?>