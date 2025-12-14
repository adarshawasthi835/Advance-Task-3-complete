<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['username']; ?></h2>

<p>You are successfully logged in ✅</p>

<a href="logout.php">Logout</a>
<br><br>
<a href="posts.php">Manage Posts</a>

</body>
</html>