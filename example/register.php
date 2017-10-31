<?php
    try {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            if (!$email) {
            throw new Exception('Неверный email');
        }
        $password = filter_input(INPUT_POST, 'password');
    if (!$password || mb_strlen($password) < 8) {
        throw new Exception('Пароль должен быть больше 8 символов');
        }
        $passwordHash = password_hash(
       $password,
       PASSWORD_DEFAULT,
       ['cost' => 12]
                                     );
    if ($passwordHash === false) {
        throw new Exception('Ошибка хэша');
        }
    header('HTTP/1.1 302 Redirect');
    header('Location: /login.php');
        } catch (Exception $e) {
    header('HTTP/1.1 400 Bad request');
    echo $e->getMessage();
}