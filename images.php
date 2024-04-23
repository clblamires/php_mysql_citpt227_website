<?php
$page_title = "Upload Images";
include("includes/header.html");
require("mysqli_connect.php");

$dir = "uploads";
$files = scandir($dir);

?>

<h1>Images</h1>

<img class="img-fluid" src="" alt="" id="image" style="margin:0 auto; display:block; max-width: 400px;">


<ul id="images" class="list-group">
    <?php 

    foreach($files as $image):
        if( substr($image, 0, 1) != '.'):
            $image_name = urlencode($image);
            $image_size = filesize("$dir/$image");
            $image_time = filemtime("$dir/$image");
    ?>   
    <li class="list-group-item">
        <a href="#"><?php echo $image_name;?></a>
        <?php echo round( $image_size / 1024 ) . "kb";?>
        <?php echo date("F d, Y H:i:s", $image_time);?>
    </li>
    <?php 
        endif; 
    endforeach; 
    ?>
</ul>


<script>
    window.onload = () => {
        let links = document.querySelectorAll("#images a");
        for( let i = 0; i < links.length; i++ ){
            let link = links[i].addEventListener("click", () => {
                document.querySelector("#image").src = "uploads/" + links[i].innerHTML;
            })
        }
    }
</script>

<?php


mysqli_close($dbc);
include("includes/footer.html");
?>