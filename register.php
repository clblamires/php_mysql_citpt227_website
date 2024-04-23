<?php
$page_title = "Register";
include("includes/header.html");
require("mysqli_connect.php");


if( $_SERVER['REQUEST_METHOD'] == "POST"){
    $errors = [];

    // validate first name
    if( empty( $_POST['first_name'])){
        $errors[] = "You forgot to enter a first name";
    } else {
        $first_name = trim( $_POST['first_name']);
    }

    // validate last name
    if( empty( $_POST['last_name'])){
        $errors[] = "You forgot to enter a last name";
    } else {
        $last_name = trim( $_POST['last_name']);
    }

    // validate email address
    if( empty( $_POST['email'])){
        $errors[] = "You forgot to enter an email address";
    } else {
        $email = mysqli_real_escape_string(trim( $_POST['email']));
    }

    // validate passwords
    if( !empty( $_POST['password'] ) && $_POST['password'] == $_POST['password2'] ){
        $password = trim($_POST['password']);
    } else {
        $errors[] = "Your password did not match the confirmed password";
    }

    // print_r($errors); // testing

    if( empty($errors)){
        $query = "
            INSERT INTO users (first_name, last_name, email, password, registration_date) 
            VALUES ('$first_name', '$last_name', '$email', SHA1('$password'), NOW() )";
        $result = mysqli_query($dbc, $query);
        if( $result ){
            echo '
            <div class="alert alert-success">
            Thank you for registering!
            </div>
            ';
        } else {
            echo '
            <div class="alert alert-danger">
            Sorry! Something went wrong: '.mysqli_error($dbc).'
            </div>
            ';
        }
    } else {
        foreach( $errors as $error ){
            echo '
            <div class="alert alert-danger">
            '.$error.'
            </div>
            ';
        }
    }
} 
?>

<h1>Register</h1>
<form action="register.php" method="post" autocomplete="off">
    <p>
        First name: <input type="text" name="first_name" class="form-control">
    </p>
    <p>
        Last Name: <input type="text" name="last_name" class="form-control">
    </p>
    <p>
        Email: <input type="email" name="email" class="form-control" autocomplete="off">
    </p>
    <p>
        Password: <input type="password" name="password" class="form-control">
    </p>
    <p>
        Confirm: <input type="password" name="password2" class="form-control">
    </p>
    <p>
        <input type="submit" class="btn btn-primary" value="Register">
    </p>
</form>


<?php
include("includes/footer.html");
?>