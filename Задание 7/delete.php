<?php
$user_id = $_GET['rn'];
    $user = 'u52862';
    $password = '5476105';
    $database = new PDO('mysql:host=localhost;dbname=u52862', $user, $password, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $result = $database -> exec("delete from User where user_id = '$user_id'");
    $resultComporator = $database -> exec("delete from Connecter where user_id = '$user_id'");
    header('Location: ./admin.php');
?>