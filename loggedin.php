<?php

if( !isset($_COOKIE['user_id'])){
    require("includes/login_functions.php");
    redirect_user();
} 

$page_title = "Logged in!";
include("includes/header.html");
?>
<h1>Logged in!</h1>
<p>
    You are now logged in, <?php echo $_COOKIE['first_name'];?>!
</p>
<p>
    <a href="logout.php">Logout</a>
</p>

<?php 
include("includes/footer.html");
?>
