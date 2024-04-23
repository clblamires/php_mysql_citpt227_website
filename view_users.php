<?php
$page_title = "List of Users";
include("includes/header.html");
require("mysqli_connect.php");


echo "<h1>Registered Users</h1>";

// sorting columns
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'date';
switch($sort){
    case 'lastname':
        $order_by = "last_name ASC";
        break;
    case 'firstname':
        $order_by = "first_name ASC";
        break;
    case 'date':
        $order_by = "registration_date ASC";
        break;
    case 'email':
        $order_by = "email ASC";
        break;
    default:
        $order_by = "registration_date ASC";
        break;
}

$q = "
    SELECT user_id, first_name, last_name, email, DATE_FORMAT(registration_date, '%M %d, %Y') as regdate 
    FROM users ORDER BY $order_by";
$r = mysqli_query($dbc, $q);
if($r){
    $num = mysqli_num_rows($r);
?>
<p>
    There are <?php echo $num;?> registered users.
</p>
<table class="table">
    <tr>
        <th><a href="view_users.php?sort=firstname">First Name</a></th>
        <th><a href="view_users.php?sort=lastname">Last Name</a></th>
        <th><a href="view_users.php?sort=email">Email</a></th>
        <th><a href="view_users.php?sort=date">Registration Date</a></th>
        <th>Edit</th>
    </tr>

<?php
// read table rows
while( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC ) ){
    echo '
    <tr>
        <td>'.$row['first_name'].'</td>
        <td>'.$row['last_name'].'</td>
        <td>'.$row['email'].'</td>
        <td>'.$row['regdate'].'</td>
        <td>
            <a href="edit_user.php?id='.$row['user_id'].'">Edit</a>
            |
            <a href="delete_user.php?id='.$row['user_id'].'">Delete</a>
        </td>
    </tr>
    ';
}
mysqli_free_result($r);
?>
</table>
<?php
} else {
    echo "Users could not be retrieved. We apologive for the inconvenience.";
    echo mysqli_error($dbc);
}

// close connection
mysqli_close($dbc);


include("includes/footer.html");
?>