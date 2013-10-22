<?php
include 'header.php';

if ($_POST) {

    if (isset($_POST['type']) == 'login') {
        if ($_POST['username'] != '' && $_POST['password'] != '') {
            tryLoginUser($_POST['username'], $_POST['password']);
        } else {
            echo '<div class="alert alert-danger">Username or password cannot be empty</div>';
        }
    }
}

?>

<?php
if (get_session('isLogin')) {
    header('Location: messages.php');
} else {
    if (isset($_GET['success_register'])) {
        echo '<div class="alert alert-success">Register success, please login</div>';
    }
    ?>
    <div class="row content">
        <form action="./" method="POST" class="form-signin">
            <h2 class="form-signin-heading">Please sign in</h2>
            <input type="text" class="form-control" name="username" placeholder="Username" autofocus>
            <input type="password" class="form-control" name="password" placeholder="Password">
            <input type="hidden" name="type" value="login" />
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
    </div>
<?php } ?>
<?php
include 'footer.php';
?>