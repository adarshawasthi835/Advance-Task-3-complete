<?php
session_start();
include 'db.php';

// Login check
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

// ===== SEARCH =====
$search = "";
if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

// ===== PAGINATION =====
$limit = 5; // posts per page

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if($page < 1){
    $page = 1;
}

$offset = ($page - 1) * $limit;

// Total posts count (with search)
$total_query = "SELECT COUNT(*) AS total 
                FROM posts 
                WHERE title LIKE '%$search%' 
                OR content LIKE '%$search%'";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_posts = $total_row['total'];

$total_pages = ceil($total_posts / $limit);

// Fetch posts
$query = "SELECT * FROM posts 
          WHERE title LIKE '%$search%' 
          OR content LIKE '%$search%' 
          ORDER BY id DESC 
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
</head>
<body>

<h2>All Posts</h2>

<a href="create.php">➕ Add New Post</a>
<br><br>

<!-- Search Form -->
<form method="get" action="posts.php">
    <input type="text" name="search" placeholder="Search post..." 
           value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Search</button>
</form>

<br>

<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
?>

    <h3><?php echo htmlspecialchars($row['title']); ?></h3>

    <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>

    <?php if($row['image'] != ""){ ?>
        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="200">
    <?php } ?>

    <br><br>

    <a href="edit.php?id=<?php echo $row['id']; ?>">✏ Edit</a> |
    <a href="delete.php?id=<?php echo $row['id']; ?>" 
       onclick="return confirm('Are you sure?')">🗑 Delete</a>

    <hr>

<?php
    }
}else{
    echo "No posts found";
}
?>

<!-- Pagination -->
<div>
<?php if($page > 1){ ?>
    <a href="posts.php?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">⬅ Prev</a>
<?php } ?>

<?php if($page < $total_pages){ ?>
    <a href="posts.php?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next ➡</a>
<?php } ?>
</div>

<br>
<a href="logout.php">Logout</a>

</body>
</html>