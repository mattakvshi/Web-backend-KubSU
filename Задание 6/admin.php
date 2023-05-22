<?php
  header('Content-Type: text/html; charset=UTF-8');

  session_start();

  if (!empty($_SESSION['login']))
  {
    session_destroy();
    header('Location: ./');
  }

  $user = 'u52862'; 
  $password = '5476105';
  $database = new PDO('mysql:host=localhost;dbname=u52862', $user, $password, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Пример HTTP-аутентификации.
    // PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
    if (empty($_SERVER['PHP_AUTH_USER']) ||
        empty($_SERVER['PHP_AUTH_PW']) ||
        $_SERVER['PHP_AUTH_USER'] != 'admin' ||
        md5($_SERVER['PHP_AUTH_PW']) != md5('123')) {
      header('HTTP/1.1 401 Unanthorized');
      header('WWW-Authenticate: Basic realm="mattakvshi"');
      print('<h1>401 Требуется авторизация</h1>');
      exit();
    }
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
            <div class="container" style = "width: 80%">
              <form action = "" method = "POST">
                <p>Администрирование базы данных</p>
                <div class ="slideBlok" style = "width: 100%;height: 600px;overflow-y: auto;" >
                <?php
                  $result = $database -> query("SELECT * FROM User");
                  echo '<p style ="margin-bottom: 20px">Данные пользователей</p>';
                  echo '<p style ="margin-bottom: 20px">o o o</p>';
                  while ($row = $result -> fetch())
                  {
                    echo '<p style = "margin-bottom: 5px;">'.$row['user_id'].' | '.$row['name'].' | '.$row['email'].' | '.$row['date'].' | '.$row['gender'].' | '.$row['limbCount'].' | '.$row['biography'].'</p>';
                  }
                  echo '<p style ="margin-bottom: 20px margin-top: 60px">Статистика</p>';
                  echo '<p style ="margin-bottom: 20px">о о о</p>';
                  $result1 = $database -> query("SELECT COUNT(*) FROM Connecter WHERE color_id = 1");
                  $result2 = $database -> query("SELECT COUNT(*) FROM Connecter WHERE color_id = 2");
                  $result3 = $database -> query("SELECT COUNT(*) FROM Connecter WHERE color_id = 3");
                  $result4 = $database -> query("SELECT COUNT(*) FROM Connecter WHERE color_id = 4");
                  $result5 = $database -> query("SELECT COUNT(*) FROM Connecter WHERE color_id = 5");
                  $result6 = $database -> query("SELECT COUNT(*) FROM Connecter");
                  $row1 = $result1 -> rowCount();
                  $row2 = $result2 -> rowCount();
                  $row3 = $result3 -> rowCount();
                  $row4 = $result4 -> rowCount();
                  $row5 = $result4 -> rowCount();
                  $row6 = $result6 -> rowCount();
                  echo '<p style = "margin-bottom: 5px;">Всего пользователей с любимыми цветами - '.$row6.'<p>';
                  echo '<p style = "margin-bottom: 5px;">Фиолетовый - '.$row1.'</p>';
                  echo '<p style = "margin-bottom: 5px;">Зелёный - '.$row2.'<p>';
                  echo '<p style = "margin-bottom: 5px;">Голубой - '.$row3.'<p>';
                  echo '<p style = "margin-bottom: 5px;">Коричневый - '.$row4.'<p>';
                  echo '<p style = "margin-bottom: 5px;">Бежевый - '.$row5.'<p>';
                  
                ?>
                </div>
                <input name = "User_Record" type = "text" placeholder = "Введите номер пользователя" style = "width: 70%"><br />
                <input type = "submit" name = "submit" value = "Редактировать">
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
    $user_record = $_POST['User_Record'];
    $_SESSION['login'] = 'Admin';
    $_SESSION['uid'] = $user_record;
    header('Location: ./');
  }
?>