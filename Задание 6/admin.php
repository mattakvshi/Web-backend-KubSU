<?php
  header('Content-Type: text/html; charset=UTF-8');

  session_start();

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Пример HTTP-аутентификации.
    // PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
    if (empty($_SERVER['PHP_AUTH_USER']) ||
        empty($_SERVER['PHP_AUTH_PW']) ||
        $_SERVER['PHP_AUTH_USER'] != 'admin' ||
        md5($_SERVER['PHP_AUTH_PW']) != md5('123')) {
      header('HTTP/1.1 401 Unanthorized');
      header('WWW-Authenticate: Basic realm="mattakvshi"';
      print('<h1>401 Требуется авторизация</h1>');
      exit();
    }

    print('Вы успешно авторизовались и видите защищенные паролем данные.');

    // *********
    // Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
    // Реализовать просмотр и удаление всех данных.
    // *********
  }
?>