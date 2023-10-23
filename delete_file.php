<?php
if(isset($_GET['file_name'])){
    $filename=$_GET['file_name'];
    $filepath='./data/' .$filename;
if(unlink($filepath)){

    echo '<script>window.location.href = "index.php";</script>';
}
}
?>