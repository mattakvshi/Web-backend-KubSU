<!DOCTYPE html>
<html lang="ru">
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

<?php
if (!empty($messages)) {
  print('<div class="message" id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
else if (!empty($warnings)){
	print('<div class="warning" id="messages">');
  // Выводим все сообщения.
  foreach ($warnings as $warning) {
    print($warning);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>
<div class = "avt_bl1">
	<div class ="avt_bl2">
		<a href = "login.php" class = "btn">Авторизоваться</a>
			<?php
				if (!empty($messages))
				{
					if (!empty($_SESSION['login']))
						printf($_SESSION['login'], $_SESSION['uid']);
				}
			?>
	</div>
</div>

		<div class="container">
			<form action="" method="POST">
				<p>Форма</p>
				<label> <input type="name" name="name"  placeholder="Имя" 
				<?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>"/> </label
				><br />

				<label> <input type="email" name="email" placeholder="Почта" 
				<?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>"/> </label
				><br />

				<label>
					<input
						name="date"
						type="date"
						placeholder="Дата рождения"
						<?php if ($errors['date']) {print 'class="error"';} ?> value="<?php print $values['date']; ?>"
					/> </label
				><br />

				<div>
					<div <?php if ($errors['gender']) {print 'class="form_radio_btn_error"';} else {print 'class="form_radio_btn"';} ?> >
						<input id="radio-1" type="radio" name="gender" value="male"
						<?php if ($errors['gender']) {print 'class="error"';} ?> <?php if ($values['gender'] == 'male') {print "checked";} ?>/>
						<label for="radio-1">Мужчина</label>
					</div>

					<div <?php if ($errors['gender']) {print 'class="form_radio_btn_error"';} else {print 'class="form_radio_btn"';} ?> >
						<input id="radio-2" type="radio" name="gender" value="female" 
						<?php if ($errors['gender']) {print 'class="error"';} ?> <?php if ($values['gender'] == 'female') {print "checked";} ?>/>
						<label for="radio-2">Женщина</label>
					</div>

					<div <?php if ($errors['gender']) {print 'class="form_radio_btn_error"';} else {print 'class="form_radio_btn"';} ?> >
						<input id="radio-3" type="radio" name="gender" value="other" 
						<?php if ($errors['gender']) {print 'class="error"';} ?> <?php if ($values['gender'] == 'other') {print "checked";} ?>/>
						<label for="radio-3">Трансформер</label>
					</div>
				</div>

				<div>
					<h4>Сколько у вас конечностей?</h4>
					<div <?php if ($errors['limbCount']) {print 'class="form_radio_btn_error"';} else {print 'class="form_radio_btn"';} ?> >
						<input id="radio-11" type="radio" name="limbCount" value="1"
						<?php if ($values['limbCount'] == '1') {print "checked";} ?>/>
						<label for="radio-11">1</label>
					</div>

					<div <?php if ($errors['limbCount']) {print 'class="form_radio_btn_error"';} else {print 'class="form_radio_btn"';} ?> >
						<input id="radio-22" type="radio" name="limbCount" value="2" 
						<?php if ($errors['limbCount']) {print 'class="error"';} ?> <?php if ($values['limbCount'] == '2') {print "checked";} ?>/>
						<label for="radio-22">2</label>
					</div>

					<div <?php if ($errors['limbCount']) {print 'class="form_radio_btn_error"';} else {print 'class="form_radio_btn"';} ?> >
						<input id="radio-33" type="radio" name="limbCount" value="3" 
						<?php if ($errors['limbCount']) {print 'class="error"';} ?> <?php if ($values['limbCount'] == '3') {print "checked";} ?>/>
						<label for="radio-33">3</label>
					</div>

					<div <?php if ($errors['limbCount']) {print 'class="form_radio_btn_error"';} else {print 'class="form_radio_btn"';} ?> >
						<input id="radio-44" type="radio" name="limbCount" value="4" 
						<?php if ($errors['limbCount']) {print 'class="error"';} ?> <?php if ($values['limbCount'] == '4') {print "checked";} ?>/>
						<label for="radio-44">4</label>
					</div>
				</div>

				<label for="standard-select"><h4>Выберите ваш любимый цвет</h4></label>
				<div <?php if ($errors['Colors']){print 'class="select_error"';} else {print 'class="select"';}?> >
					<select
						id="standard-select"
						name="Colors[]"
						multiple="multiple"
						size="5"
					>
						<option value="1" <?php if (isset($_COOKIE["1"])) if ($_COOKIE["1"]=="true") echo "selected" ?> >Фиолетовый</option>
						<option value="2" <?php if (isset($_COOKIE["2"])) if ($_COOKIE["2"]=="true") echo "selected" ?> >Зелёный</option>
						<option value="3" <?php if (isset($_COOKIE["3"])) if ($_COOKIE["3"]=="true") echo "selected" ?> >Голубой</option>
						<option value="4" <?php if (isset($_COOKIE["4"])) if ($_COOKIE["4"]=="true") echo "selected" ?> >Коричневый</option>
						<option value="5" <?php if (isset($_COOKIE["5"])) if ($_COOKIE["5"]=="true") echo "selected" ?> >Бежевый</option>
					</select>
				</div>
				<br />

				<label>
					<textarea
						name="biography"
						style="margin: 0px; height: 120px; width: 250px"
						placeholder="Расскажите о себе..."
						<?php if ($errors['biography']) {print 'class="error"';} ?> <?php print $values['biography']; ?>
					></textarea></label
				><br />

				<label  <?php if ($errors['contract']) {print 'class="txtb_error"';} else {print 'class="txtb"';} ?>
					><input name="contract" type="checkbox" <?php if ($values['contract'] == 'checked') {print "checked";} ?>/>С контрактом
					ознакомлен(а)</label
				><br />

				<label> <input type="submit" name="submit" value="Отправить" /> </label
				><br />
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
</html>
