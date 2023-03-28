<?php
	try{

		$user = 'u52862'; 
		$password = '5476105';
		$database = new PDO('mysql:host=localhost;dbname=u52862', $user, $password, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    if(empty($_POST['name']) == false) 
    {
      $userName = $_POST['name']; 
      if((!preg_match('/^[а-яёА-ЯЁ]+$/u', $userName) && !preg_match('/^[a-zA-Z]+$/u', $userName))) exit ("Имя должно быть написано в одно слово, без пробелов, и содержать только буквы русского или латинского алфавита!");
      else if (strlen($userName) < 5) exit ("Имя должно состоять минимум из 5 букв!");
    }
    else exit ("Поле \"Имя\" не должно быть пустым!");

    //!preg_match("/^[а-яА-Я]+[а-яА-Я]+[а-яА-Я]*$/u", $name)
		//if (empty($_POST['name'])) exit ("Поле \"Имя\" не должно быть пустым!");

    if (empty($_POST['email']) == false) //не пусто 
    {
      if(!preg_match('/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i', $_POST['email'])) exit("Введите коректную почту в формате: email12345@example.org");
    }
    else exit ("Поле \"Почта\" не должно быть пустым!");

    //дата
    if(empty($_POST['date']) == false) //не пусто
    {
      function validateDate($date, $format = 'Y-m-d')
      {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d -> format($format) == $date;
      }
      if (var_dump(validateDate($_POST['date'])) == false)
      {
        $dateErr = "Введите корректную Дату!";
      }
    }
    else exit("Выбирите дату рождения!");

    //пол
    if (empty($_POST['gender']) == false) //не пусто
    {
      if ($_POST['gender'] == 'male'||'female' || 'other')
      {
        $gender = ($_POST['gender']);
      }
      else exit ("Выберите коректный Пол!!");
    }
    else exit ("Выберите Пол!!");
    
      
    //конечности
    if (empty($_POST['limbCount']) == false) //не пусто
    { 
      if ($_POST['limbCount'] == '1' || '2' || '3' || '4')
      {
        $limbCount = ($_POST['limbCount']);
      }
      else exit ("Выберите коректное кол-во Конечностей!!");
    }
    else exit ("Выберите кол-во конечностей!!");
    

		//Цвета
    if (empty($_POST['Colors']) == false){
      $colors = (int) $_POST['Colors'];
      if ($colors < 1 || $colors > 5)
      {
        exit("Выберите ваш(и) любимый(е) цвет(а)!");
      }  
    }
    else exit("Выберите ваш(и) любимый(е) цвет(а)!");

		//биография
    if (empty($_POST['biography'])) exit ("Поле \"Расскажите о себе\" не должно быть пустым!");

		//Чекбокс
    if (empty($_POST['contract'])) exit ("Ознакомтесь с контрактом!");


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


	}
	catch(PD0Exception $e){
		print('Error: ' .$e -> getMassage());
		exit();
	}
?>