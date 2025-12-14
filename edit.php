<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

// Old data fetch
$result = mysqli_query($conn, "SELECT * FROM posts WHERE id=$id");
$post = mysqli_fetch_assoc($result);

// Update logic
if(isset($_POST['update'])){
    $title = $_POST['title'];
    $content = $_POST['content'];

    mysqli_query($conn, "UPDATE posts SET title='$title', content='$content' WHERE id=$id");
    header("Location: posts.php");
    exit();
}
?>

<h2>Edit Post</h2>

<form method="post">
    <input type="text" name="title" value="<?php echo $post['title']; ?>" required><br><br>
    <textarea name="content" required><?php echo $post['content']; ?></textarea><br><br>
    <button name="update">Update</button>
</form>

<br>
<a href="posts.php">⬅ Back</a>