<?php

$page_title = "Login";
include('includes/header.html');

if( isset($errors) && !empty($errors)){
    foreach($errors as $error){
        echo '
        <div class="alert alert-danger">
        '.$error.'
        </div>
        ';
    }
}

?>

<h1>Login</h1>
<form action="login.php" method="post">
    <p>
        Email: 
        <input type="text" name="email" class="form-control">
    </p>
    <p>
        Password:
        <input type="password" name="pass" class="form-control">
    </p>
    <input type="submit" class="btn btn-primary" value="Login">
</form>