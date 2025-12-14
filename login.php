<?php
session_start();
include "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) == 1){

        $row = mysqli_fetch_assoc($res);

        if(password_verify($password, $row['password'])){
            $_SESSION['username'] = $row['username'];
            header("Location: index.php");
            exit();
        }else{
            echo "Password galat hai";
        }

    }else{
        echo "Username galat hai";
    }
}
?>
<form method="post">
  <input type="text" name="username" required>
  <input type="password" name="password" required>
  <button type="submit">Login</button>
</form>