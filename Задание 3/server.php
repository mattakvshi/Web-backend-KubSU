<?php
	try{

		$user = 'u52862';
		$password = '5476105';
		$database = new PDO('mysql:host=localhost;dbname=u52862', $user, $password, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

		if (empty($_POST['name'])) exit ("Поле \"Имя\" не должно быть пустым!");

    //дата
    function validateDate($date, $format = 'Y-m-d')
    {
      $d = DateTime::createFromFormat($format, $date);
      return $d && $d -> format($format) == $date;
    }
    if (var_dump(validateDate($_POST['date'])) == false)
    {
      $dateErr = "Введите корректную Дату!";
    }

    //пол
    if ($_POST['gender'] == 'male'||'female' || 'other')
    {
      $gender = ($_POST['gender']);
    }
    else if ($_POST['gender'] == null)
    {
      $genderErr = "Выберите Пол!";
    }

    //конечности
    if ($_POST['limbCount'] == '1' || '2' || '3' || '4')
    {
      $limb = ($_POST['limbCount']);
    }
    else if ($_POST['limbCount'] == null)
    {
      $limbErr = "Выберите Кол-во Конечностей!";
    }

		//Цвета
    $colors = (int) $_POST['Colors'];
    if ($colors < 1 || $colors > 5)
    {
      $colorsErr = "Выберите ваш(и) любимый(е) цвет(а)!";
    }
    if ($colors == null)
    {
      exit("Выберите ваш(и) любимый(е) цвет(а)!");
    }

		//биография
    if (empty($_POST['biography'])) exit ("Поле \"Расскажите о себе\" не должно быть пустым!");

		//Чекбокс
    if ($_POST['contract'] == null) exit ("Ознакомтесь с контрактом!");


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