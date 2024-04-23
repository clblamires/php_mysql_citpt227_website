<?php


// URL: edit_user.php?id=1

// get the user ID from the URL
if( isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];
} else if ( isset($_POST['id']) && is_numeric($_POST['id']) ){
    $id = $_POST['id'];
} else {
    header('Location: ./view_users.php'); //redirect
    exit();
}


$page_title = "Edit User";
include("includes/header.html");
require("mysqli_connect.php");

if( $_SERVER['REQUEST_METHOD'] == "POST"){ // you clicked the submit button!
    $errors = [];

    if( empty($_POST['first_name'])){
        $errors[] = "You need to enter a first name";
    } else {
        $first_name = trim($_POST['first_name']);
    }

    if( empty($_POST['last_name'])){
        $errors[] = "You need to enter a last name";
    } else {
        $last_name = trim($_POST['last_name']);
    }

    if( empty($_POST['email'])){
        $errors[] = "You need to enter an email address";
    } else {
        $email = trim($_POST['email']);
    }

    if( empty($errors)){
        $query = "SELECT user_id FROM users WHERE email='$email' AND user_id != $id"; // make sure the email has not already been used in this system!
        $result = mysqli_query($dbc, $query);
        if( mysqli_num_rows($result) == 0 ){
            $query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email='$email' WHERE user_id = $id LIMIT 1";
            $result = mysqli_query($dbc, $query);
            if( mysqli_affected_rows($dbc) == 1){
                echo '
                <div class="alert alert-success">
                The user has been updated.
                </div>
                ';
            } else {
                echo '
                <div class="alert alert-danger">
                The user could not be edited.<br>
                '.mysqli_error($dbc).'
                </div>
                ';
            }
        } else {
            echo '
            <div class="alert alert-danger">
            Sorry, that email address is already registered.
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

$query = "SELECT first_name, last_name, email FROM users WHERE user_id = $id";
$result = mysqli_query($dbc, $query);
if( mysqli_num_rows($result) == 1 ){
    $row = mysqli_fetch_array($result, MYSQLI_NUM);
?>
    <form action="edit_user.php" method="post">
        <p>
            First name:
            <input class="form-control" type="text" name="first_name" value="<?php echo $row[0];?>">
        </p>
        <p>
            Last name:
            <input class="form-control" type="text" name="last_name" value="<?php echo $row[1];?>">
        </p>
        <p>
            Email:
            <input class="form-control" type="text" name="email" value="<?php echo $row[2];?>">
        </p>
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="submit" class="btn btn-primary" value="Edit user">
    </form>

<?php
}

mysqli_close($dbc);
include("includes/footer.html");
?>