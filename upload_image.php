<?php
$page_title = "Upload Images";
include("includes/header.html");
require("mysqli_connect.php");

if($_SERVER['REQUEST_METHOD'] == "POST" ){
    // check for uploaded file
    if( isset($_FILES['upload'])){
        // validate JPG or PNG
        $allowed = ['image/pjpg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png' ];
        if( in_array( $_FILES['upload']['type'], $allowed  ) ){
            if( move_uploaded_file( $_FILES['upload']['tmp_name'], "uploads/{$_FILES['upload']['name']}" )){
                echo '
                <div class="alert alert-success">
                The file has successfully been uploaded.
                </div>
                ';
            }
        } else {
            echo '
            <div class="alert alert-danger">
            Sorry, you must upload only a JPG or PNG file.
            </div>
            ';
        }
    }

    if( $_FILES['upload']['error'] > 0 ){
        echo '
        <div class="alert alert-danger">
        Sorry, your file could not be uploaded because:<br>
        ';
        switch ($_FILES['upload']['error']){
            case 1: 
                print 'File exceeds the maximum file size on the server';
                break;
            case 2:
                print 'File exceeds the maximum file size in the form';
                break;
            case 3:
                print 'The file upload was interrupted';
                break;
            case 4: 
                print 'The file was not uploaded';
                break;
            case 6:
                print 'The temporary folder was not available';
                break;
            case 7:
                print 'Unable to write to the folder';
                break;
            case 8:
                print "The file upload was stopped";
                break;
            default:
                print "A system error occured";
                break;
        }
        echo '</div>';
    }

    if( file_exists($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name'])){
        unlink( $_FILES['upload']['tmp_name']);
    }
}


?>

<h1>Upload an Image</h1>

<form action="upload_image.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="524288"> <!-- max file size 512 kb -->
    <p>
        Image (JPG or PNG):
        <input type="file" name="upload" class="form-control-file">
    </p>
    <input type="submit" class="btn btn-primary" value="Upload image">
</form>

<?php

mysqli_close($dbc);
include("includes/footer.html");
?>