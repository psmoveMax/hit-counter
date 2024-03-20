<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] == 'admin' && $_POST['password'] == 'password') {
        $_SESSION['logged_in'] = true;
        header('Location: stats.php');
        exit();
    } else {
        $error = "Неверные учетные данные!";
    }
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: stats.php');
    exit();
}
?>

<?php if(isset($error)): ?>
<p><?php echo $error; ?></p>
<?php endif; ?>

<form method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>