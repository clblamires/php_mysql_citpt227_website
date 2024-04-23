<?php


if( !isset($_COOKIE['user_id'])){
    require("includes/login_functions.php");
    redirect_user();
} else {
    setcookie("user_id", "", time()-3600);
    setcookie("first_name", "", time()-3600);
}

$page_title = "Logged out!";
include("includes/header.html");
?>
<h1>Logged out!</h1>
<p>
    You are now logged out!
</p>
<p>
    <a href="login.php">Login</a>
</p>

<?php 
include("includes/footer.html");
?>