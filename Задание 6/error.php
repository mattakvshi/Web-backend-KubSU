<?php
    header('Content-Type: text/html; charset=UTF-8');


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
              <form>
                <p>Введённые данные неверны!</p>
                <a href = "login.php" class = "btn">Вернутся</a>
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
    }
?>