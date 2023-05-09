<?php
  try{
    // Отправляем браузеру правильную кодировку,
    // файл index.php должен быть в кодировке UTF-8 без BOM.
    header('Content-Type: text/html; charset=UTF-8');

    // В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
    // и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

      // Массив для временного хранения сообщений пользователю.
      $messages = array();

      // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
      // Выдаем сообщение об успешном сохранении.
      if (!empty($_COOKIE['save'])) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('save', '', 100000);
        setcookie('login', '', time() + 60 * 60 * 24);
        setcookie('password', '', time() + 60 * 60 * 24);
        // Если есть параметр save, то выводим сообщение пользователю.
        $messages[] = '<div class="error_message"> Спасибо, результаты сохранены.</div>';
        if (!empty($_COOKIE['password']))
        {
          $messages[] = sprintf('<div class="error_message"> Вы можете войти с логином и паролем для изменения данных:</div>
          <div class="error_message">Логин: <strong>%s</strong>.</div>
          <div class="error_message">Пароль: <strong>%s</strong>.</div>
          <div class="avt_bl3"><a href = "login.php" class = "btn">Войти</a></div>',
          strip_tags($_COOKIE['login']),
          strip_tags($_COOKIE['password'])
          );
        }
      }

      // Складываем признак ошибок в массив.
      $errors = array();
      $errors['name'] = !empty($_COOKIE['name_error']);
      $errors['email'] = !empty($_COOKIE['email_error']);
      $errors['date'] = !empty($_COOKIE['date_error']);
      $errors['gender'] = !empty($_COOKIE['gender_error']);
      $errors['limbCount'] = !empty($_COOKIE['limbCount_error']);
      $errors['Colors'] = !empty($_COOKIE['Colors_error']);
      $errors['biography'] = !empty($_COOKIE['biography_error']);
      $errors['contract'] = !empty($_COOKIE['contract_error']);

      // Выдаем сообщения об ошибках.
      //Ошибка в имени
      if ($errors['name']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('name_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error_message"> Заполните имя коректно (А-я) или (A-z) в одно слово.</div>';
      }

      //Ошибка в почте
      if ($errors['email']) {
        setcookie('email_error', '', 100000);
        $messages[] = '<div class="error_message"> Заполните почту в формате: exemple@exem.org!</div>';
      }

      //Ошибка в дате
      if ($errors['date']) {
        setcookie('date_error', '', 100000);
        $messages[] = '<div class="error_message"> Выбирите дату рождения!</div>';
      }

      //Ошибка в гендере
      if ($errors['gender']) {
        setcookie('gender_error', '', 100000);
        $messages[] = '<div class="error_message"> Выберите пол!</div>';
      }

      //Ошибка в конечностях
      if ($errors['limbCount']) {
        setcookie('limbCount_error', '', 100000);
        $messages[] = '<div class="error_message"> Выбирите кол-во конечностей!</div>';
      }

      //Ошибка в Цветах
      if ($errors['Colors']) {
        setcookie('Colors_error', '', 100000);
        $messages[] = '<div class="error_message"> Выбирите цвет(а)!</div>';
      }

      //Ошибка в биографии
      if ($errors['biography']) {
        setcookie('biography_error', '', 100000);
        $messages[] = '<div class="error_message"> Расскажите о себе!</div>';
      }

      //Ошибка в чекбоксе
      if ($errors['contract']) {
        setcookie('contract_error', '', 100000);
        $messages[] = '<div class="error_message"> Ознакомтесь с контрактом!</div>';
      }


      if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login']))
      {
        $user = 'u52862'; 
        $password = '5476105';
        $database = new PDO('mysql:host=localhost;dbname=u52862', $user, $password, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $statement = $database -> prepare("SELECT * FROM User WHERE user_id = ?");
        $statement -> execute([$_SESSION['uid']]);
        $line = $statement -> fetch(PDO::FETCH_ASSOC);

        $values['name'] = $line['name'];
        $values['email'] = $line['email'];
        $values['date'] = $line['date'];
        $values['gender'] = $line['gender'];
        $values['limbCount'] = $line['limbCount'];
        $values['Colors'] = $line['Colors'];
        $values['biography'] = $line['biography'];
        $values['contract'] = $line['contract'];
        $messages[] = 'Вход с логином %s, uid %d';
      }
      else {
        // Складываем предыдущие значения полей в массив, если есть.
        $values = array();
        $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
        $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
        $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
        $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
        $values['limbCount'] = empty($_COOKIE['limbCount_value']) ? '' : $_COOKIE['limbCount_value'];
        $values['Colors'] = empty($_COOKIE['Colors_value']) ? '' : $_COOKIE['Colors_value'];
        $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
        $values['contract'] = empty($_COOKIE['contract_value']) ? '' : $_COOKIE['contract_value'];
      }

      // Включаем содержимое файла form.php.
      // В нем будут доступны переменные $messages, $errors и $values для вывода 
      // сообщений, полей с ранее заполненными данными и признаками ошибок.
      include('form.php');

    }
    // Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
    else {
      // Проверяем ошибки.
      $errors = FALSE; 
      //Проверка имени
      if(empty($_POST['name']) == false) 
      {
        $userName = $_POST['name'];
        if((!preg_match('/^[а-яёА-ЯЁ]+$/u', $userName) && !preg_match('/^[a-zA-Z]+$/u', $userName)))
        {
          // Выдаем куку на день с флажком об ошибке в поле fio.
          setcookie('name_error', '1', time() + 24 * 60 * 60);
          $errors = TRUE;
        }
        else 
        {
          // Сохраняем ранее введенное в форму значение на месяц.
          setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
        }
      }
      else 
      {
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }
      
      //Разобраться с этими вариантами валидации имени
      //!preg_match("/^[а-яА-Я]+[а-яА-Я]+[а-яА-Я]*$/u", $name)
      //if (empty($_POST['name'])) exit ("Поле \"Имя\" не должно быть пустым!");

      //Проверка почты
      if (empty($_POST['email']) == false) //не пусто 
      {
        if(!preg_match('/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i', $_POST['email'])) 
        {
          setcookie('email_error', '1', time() + 24 * 60 * 60);
          $errors = TRUE;
        }
        else
        {
          setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
        }
      }
      else 
      {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }

      //Проверка даты
      if(empty($_POST['date']) == false) //не пусто
      {
        function validateDate($date, $format = 'Y-m-d')
        {
          $d = DateTime::createFromFormat($format, $date);
          return $d && $d -> format($format) == $date;
        }
        if (!preg_match('/^[1-2][0|9|8][0-9][0-9]-[0-1][0-9]-[0-3][0-9]+$/', $_POST['date'])) 
        {
          setcookie('date_error', '1', time() + 24 * 60 * 60);
          $errors = TRUE;
        }
        else
        {
          setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);
        }
      }
      else
      {
        setcookie('date_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }

      //Проверка пола
      if (empty($_POST['gender']) == false) //не пусто
      {
        $gender = ($_POST['gender']);
        if ($gender == 'male'||'female' || 'other')
        {
          setcookie('gender_value', $gender, time() + 30 * 24 * 60 * 60);
        }
        else 
        {
          setcookie('gender_error', '1', time() + 24 * 60 * 60);
          $errors = TRUE;
        }
      }
      else
      {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }   
          
      //Проверка конечностей
      if (empty($_POST['limbCount']) == false) //не пусто
      { 
        $limbCount = ($_POST['limbCount']);
        if ($limbCount == '1' || '2' || '3' || '4')
        {
          setcookie('limbCount_value', $limbCount, time() + 30 * 24 * 60 * 60);
        }
        else 
        {
          setcookie('limbCount_error', '1', time() + 24 * 60 * 60);
          $errors = TRUE;
        }
      }
      else 
      {
        setcookie('limbCount_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }

        

      //Проверка цветов
      if (empty($_POST['Colors']) == false){
        $colors = (int) $_POST['Colors'];
        if ($colors < 1 || $colors > 5)
        {
          setcookie('Colors_error', '1', time() + 24 * 60 * 60);
          $errors = TRUE;
        }  
        else
        {
          setcookie('Colors_value', $_POST['Colors'], time() + 30 * 24 * 60 * 60);
          setcookie("1","",1000000);
          setcookie("2","",1000000);
          setcookie("3","",1000000);
          setcookie("4","",1000000);
          setcookie("5","",1000000);
          $color=$_POST["Colors"];
          foreach($color as $cout){
            if($cout =="1"){
              setcookie("1","true");
            }
            if($cout =="2"){
              setcookie("2","true");
            }
            if($cout =="3"){
              setcookie("3","true");
            }if($cout =="4"){
              setcookie("4","true");
            }
            if($cout =="5"){
              setcookie("5","true");
            }
          }
        }
      }
      else 
      {
        setcookie('Colors_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }

     //Проверка биографии
      if (empty($_POST['biography'])) {
        setcookie('biography_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }
      else {
        setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);
      }

      //Проверка чекбокса
      if (empty($_POST['contract'])) {
        setcookie('contract_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }
      else {
        setcookie('contract_value', $_POST['contract'], time() + 30 * 24 * 60 * 60);
      }

      //Фиксируем наличие ошибок
      if ($errors) {
        // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
        header('Location: index.php');
        exit();
      }
      else {
        // Удаляем Cookies с признаками ошибок.
        setcookie('name_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('date_error', '', 100000);
        setcookie('gender_error', '', 100000);
        setcookie('limbCount_error', '', 100000);
        setcookie('Colors_error', '', 100000);
        setcookie('biography_error', '', 100000);
        setcookie('contract_error', '', 100000);
      }

      //Связь с БД
      $user = 'u52862'; 
      $password = '5476105';
      $database = new PDO('mysql:host=localhost;dbname=u52862', $user, $password, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

      if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login']))
      {
        $statement = $database -> prepare("UPDATE User SET name = ?, email = ?, date = ?, gender = ?, limbCount = ?, biography = ? WHERE user_id = ?");
        $statement -> execute([$_POST['name']], [$_POST['email']], [$_POST['date']], [$_POST['gender']], [$_POST['limbCount']], [$_POST['biography']], $_SESSION['uid']);
        $statement_sup = $database -> prepare("INSERT INTO Connecter SET user_id = ?, color_id = ?");
        foreach($_POST['Colors'] as $colors)
        $statement_sup -> execute($_SESSION['uid'], $colors);
      }
      else
      {
        $user_login = uniqid('', true);
        $user_password = rand(1, 1000);
        setcookie('login', $user_login);
        setcookie('password', $user_password);

        // Сохранение в БД.
        $statement = $database -> prepare("INSERT INTO User (name, email, date, gender, limbCount, biography) VALUES(:name, :email, :date, :gender, :limbCount, :biography)");
        $statement -> execute(['name'=>$_POST['name'], 'email'=>$_POST['email'], 'date'=>$_POST['date'], 'gender'=>$_POST['gender'], 'limbCount'=>$_POST['limbCount'], 'biography'=>$_POST['biography']]);
        $conect_id = $database->lastInsertId();
        $statement = $database -> prepare("INSERT INTO Connecter (user_id, color_id) VALUES (:user_id, :color_id)");
        foreach ($_POST['Colors'] as $colors)
        {
            if ($colors != false)
            {
              $statement -> execute(['user_id' => $conect_id, 'color_id' => $colors]);
            }
        }
        $statement = $database -> prepare("INSERT INTO Users_Logins SET user_log_id = ?, user_login = ?, user_passwords = ?");
        $statement -> execute([$conect_id, $user_login, md5($user_password)]);
      }
      

      // Сохраняем куку с признаком успешного сохранения.
      setcookie('save', '1');

      // Делаем перенаправление.
      header('Location: index.php');

    }
  }
  catch(PD0Exception $e){
    print('Error: ' .$e -> getMassage());
    exit();
  }
?>
