<?php
session_start();
include 'db.php';   // yaha tumhara DB connection hai

// Agar user login nahi hai
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

// Form submit hua ya nahi
if(isset($_POST['submit'])){

    // Data lena
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // ===== Server Side Validation =====
    if($title == "" || $content == ""){
        echo "Title aur Content empty nahi ho sakta";
        exit();
    }

    if(strlen($title) < 3){
        echo "Title kam se kam 3 characters ka hona chahiye";
        exit();
    }

    if(strlen($content) < 10){
        echo "Content kam se kam 10 characters ka hona chahiye";
        exit();
    }

    // ===== Image Upload =====
    $image_name = "";

    if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
        $image_name = time() . "_" . $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($image_tmp, "uploads/" . $image_name);
    }

    // ===== Insert Query =====
    $query = "INSERT INTO posts (title, content, image)
              VALUES ('$title', '$content', '$image_name')";

    mysqli_query($conn, $query);

    // Redirect
    header("Location: posts.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
</head>
<body>

<h2>Add New Post</h2>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Enter Title"><br><br>

    <textarea name="content" placeholder="Enter Content"></textarea><br><br>

    <input type="file" name="image"><br><br>

    <button type="submit" name="submit">Add Post</button>
</form>

<br>
<a href="posts.php">Back</a>

</body>
</html>