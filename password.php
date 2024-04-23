<?php
$page_title = "Register";
include("includes/header.html");
require("mysqli_connect.php");

if ( $_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors = [];
    if( empty( $_POST['email'])){
        $errors[] = "You forgot to enter an email address";
    } else {
        $email = trim( $_POST['email'] );
    }

    if( empty( $_POST['pass'])){
        $errors[] = "You forgot to enter an email address";
    } else {
        $pass = trim( $_POST['pass'] );
    }

    if( !empty($_POST['pass1']) && $_POST['pass1'] == $_POST['pass2']){
        $newpass = trim($_POST['pass1']);
    } else {
        $errors[] = "Your new passwords need to match";
    }

    if( empty($errors)){
        // echo "No errors";
        $query = "SELECT user_id FROM users WHERE email='$email' && password=SHA1('$pass')";
        $result = mysqli_query($dbc, $query);
        $num = mysqli_num_rows($result);
        if( $num == 1 ){
            // echo "Got a match for the email and password!";
            $row = mysqli_fetch_array( $result, MYSQLI_NUM );
            $query = "UPDATE users SET password=SHA1('$newpass') WHERE user_id = $row[0]";
            // echo "<br>".$query;
            $result = mysqli_query($dbc, $query);
            if( mysqli_affected_rows($dbc) == 1 ){
                echo '
                <div class="alert alert-success">
                Thank you! Your password has been updated
                </div>
                ';
            } else {
                echo '
                <div class="alert alert-danger">
                Error! Something went wrong. '.
                mysqli_error($dbc)
                .'
                </div>
                ';
            }
        } else {
            echo '
            <div class="alert alert-danger">
            Sorry, the email and password did not match.
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

<h1>Change password</h1>
<form action="password.php" method="post">
    <p>
        Email address:
        <input type="text" name="email" class="form-control">
    </p>
    <p>
        Current password:
        <input type="password" name="pass" class="form-control">
    </p>
    <p>
        New password:
        <input type="password" name="pass1" class="form-control">
    </p>
    <p>
        Confirm password:
        <input type="password" name="pass2" class="form-control">
    </p>
    <input type="submit" value="Change password" class="btn btn-primary">
</form>

<?php
mysqli_close($dbc);
include("includes/footer.html");
?>