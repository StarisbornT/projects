<?php include 'server.php'; ?>
<?php include 'includes/header.php'; ?>

<?php 
if (isset($_GET['create_task'])) {
    include 'includes/create_task.php';
}elseif (isset($_GET['signup'])) {
    include 'includes/signup.php';
}
elseif (isset($_GET['login'])) {
    include 'includes/login.php';
}
else {
    include 'includes/home.php';
}

include 'includes/footer.php';
?>

