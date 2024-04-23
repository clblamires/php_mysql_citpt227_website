<?php

function redirect_user( $page = 'index.php' ){
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $url =rtrim($url, '/\\');
    $url .= '/' . $page;
    header("Location: $url");
    exit();
}

function check_login( $dbc, $email = '', $pass = '' ) {
    $errors = [];

    if( empty($email) ){
        $errors[] = "Please enter an email address";
    } else {
        $email = mysqli_real_escape_string($dbc, trim($email));
    }

    if( empty($pass)){
        $errors[] = "Please enter a password";
    } else {
        $pass = mysqli_real_escape_string($dbc, trim($pass));
    }

    if( empty($errors)){
        $query = "SELECT user_id, first_name FROM users WHERE email='$email' AND password=SHA1('$pass')";
        $result = mysqli_query($dbc, $query);
        if( mysqli_num_rows($result) == 1 ){
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return [true, $row];
        } else {
            $errors[] = "Email address and password do not match";
        }
    }

    return [false, $errors];
}
