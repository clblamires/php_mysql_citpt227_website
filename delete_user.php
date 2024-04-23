<?php


// get the user ID from the URL
if( isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];
} else if ( isset($_POST['id']) && is_numeric($_POST['id']) ){
    $id = $_POST['id'];
} else {
    header('Location: ./view_users.php'); //redirect
    exit();
}


$page_title = "Delete User";
include("includes/header.html");
require("mysqli_connect.php");

echo '<h1>Delete a user</h1>';

if( $_SERVER['REQUEST_METHOD'] == "POST"){
    if( $_POST['sure'] == "Yes"){
        $query = "DELETE FROM users WHERE user_id=$id LIMIT 1";
        $result = mysqli_query($dbc, $query);
        if( mysqli_affected_rows($dbc) == 1 ){
            echo '
                <p>
                    The user has been deleted<br>
                    <a href="view_users.php">Back to user list</a>
                </p>
            ';
        } else {
            echo mysqli_error($dbc);
        }
    } else {
        echo '<a href="view_users.php">Back to user list</a>';
    }
} else {
    $query = "SELECT CONCAT(last_name, ',', first_name) as name FROM users WHERE user_id=$id";
    $result = mysqli_query($dbc, $query);
    if( mysqli_num_rows($result) == 1 ){
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        echo '<h3>Name: '.$row[0].'</h3>';
        echo '<p>Are you sure you want to delete this user?</p>';

?>
    <form action="delete_user.php" method="post">
        <input type="radio" name="sure" value="Yes"> Yes &nbsp;&nbsp;&nbsp;
        <input type="radio" name="sure" value="No" checked> No &nbsp;&nbsp;&nbsp;
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="submit" value="Submit">
    </form>

<?php
    }
}
mysqli_close($dbc);
include("includes/footer.html");
?>