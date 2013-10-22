<?php
include 'header.php';

if (isset($_POST['type']) == 'register') {
    if ($_POST['username'] != '' && $_POST['password'] != '' && $_POST['retype-password'] != '') {
        if ($_POST['password'] == $_POST['retype-password']) {
            tryRegisterUser($_POST['username'], $_POST['password']);
        } else {
            echo '<div class="alert alert-danger">Password fields not match</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Username or password cannot be empty</div>';
    }
}
?>

    <div class="row content">
        <form method="POST" action="register.php" class="form-signin">
            <h2 class="form-signin-heading">Register new user</h2>
            <input type="text" class="form-control" name="username" placeholder="Username" autofocus>
            <input type="password" class="form-control remove-radius" name="password" placeholder="Password">
            <input type="password" class="form-control" name="retype-password" placeholder="Password">
            <input type="hidden" name="type" value="register" />
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
    </div>

<?php
include 'footer.php';
?>