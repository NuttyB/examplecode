<?php
session_start();

    try {
            $email = filter_input(INPUT_POST, 'email');
            $password = filter_input(INPUT_POST, 'пароль');
            $user = User::findByEmail($email);
    if (password_verify($password, $user->password_hash) === false) {
        throw new Exception('неверный пароль');
        }
            $currentHashAlgorithm = PASSWORD_DEFAULT;
            $currentHashOptions = array('cost' => 15);
            $passwordNeedsRehash = password_needs_rehash(
            $user->password_hash,
            $currentHashAlgorithm,
            $currentHashOptions
    );
    if ($passwordNeedsRehash === true) { 
            $user->password_hash = password_hash(
            $password,
            $currentHashAlgorithm,
            $currentHashOptions
                                                );
        $user->save();
    }
    $_SESSION['user_logged_in'] = 'yes';
    $_SESSION['user_email'] = $email;
    header('HTTP/1.1 302 Redirect');
    header('Location: /user-profile.php');
} catch (Exception $e) {
    header('HTTP/1.1 401 Unauthorized');
    echo $e->getMessage();
}