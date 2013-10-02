<?php
/**
 * Created by IntelliJ IDEA.
 * User: siropo-home
 * Date: 13-9-29
 * Time: 18:43
 */

include '_header.php';

if ($_POST) {
    checkLogin($_POST['username'], $_POST['password']);
}

if (isset($_GET['logout'])) {
    destroy_session();
    header('Location: index.php');
}

if ($_FILES) {
    if (count($_FILES) > 0) {
        uploadFiles($_FILES['upload_file']);
    }
}

?>

    <div class="wrapper">
        <?php
        if (isset($GLOBALS['message'])) {
            echo  $GLOBALS['message'] . '</span>';
        }

        if (get_session('isLogin') !== true) {
            ?>
            <form action="index.php" method="POST">
                <label for="username">User</label>
                <input type="text" name="username" id="username" /><br />
                <label for="password">Password</label>
                <input type="password" name="password" id="password" /><br />
                <input type="submit" class="btn btn-primary btn-login" value="submit" />
            </form>
        <?php
        } else {
            echo '<p class="login-info text-right">Здравей <span>' . get_session('username') . '</span>!</p>';
            ?>

            <form action="index.php" method="POST" enctype="multipart/form-data" class="text-right">
                <input type="file"  name="upload_file" />
                <input type="submit" class="btn btn-primary" value="submit" />
            </form>
            <table class="table list-file">
                <?php
                listDirectory(__UPLOAD_DIR__);
                ?>
            </table>
            <div class="menu">
                <a href="index.php?logout=1" class="btn btn-danger">logout</a>
            </div>
        <?php
        }
        ?>

    </div>

<?php
include 'footer.php';
?>