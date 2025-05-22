<?php
include('koneksi.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE user_id=$id"));
}

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    mysqli_query($koneksi, "UPDATE user SET username='$username', password='$password', role='$role' WHERE user_id=$id");
    header('Location: superadmin.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body
    <h2>Edit User</h2>
    <form method="post">
        <input type="text" name="username" value="<?= $user['username'] ?>" required>
        <input type="text" name="password" value="<?= $user['password'] ?>" required>
 
        <select name="role">
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>user</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>admin</option>
            <option value="superadmin" <?= $user['role'] == 'superadmin' ? 'selected' : '' ?>>superadmin</option>
        </select>
        <input type="submit" name="update" value="UPDATE">
    </form>
</body>
</html>